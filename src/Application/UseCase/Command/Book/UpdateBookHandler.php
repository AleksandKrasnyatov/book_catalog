<?php

declare(strict_types=1);

namespace app\Application\UseCase\Command\Book;

use app\Application\Gateway\Db\TransactionManagerInterface;
use app\Application\Gateway\File\FileStorageInterface;
use app\Application\Gateway\Notification\NewBookNotifierInterface;
use app\Domain\Entity\Book;
use app\Domain\Entity\BookAuthor;
use app\Domain\Repository\BookAuthorRepositoryInterface;
use app\Domain\Repository\BookRepositoryInterface;
use app\Domain\ValueObject\BookTitle;
use app\Domain\ValueObject\BookYear;
use app\Domain\ValueObject\Id;
use app\Domain\ValueObject\Isbn;
use app\Domain\ValueObject\PhotoName;

final class UpdateBookHandler
{
    /** @var Id[] */
    private array $toNotifyAuthorsIds = [];

    public function __construct(
        private readonly BookRepositoryInterface $books,
        private readonly BookAuthorRepositoryInterface $bookAuthors,
        private readonly FileStorageInterface $files,
        private readonly NewBookNotifierInterface $notifier,
        private readonly TransactionManagerInterface $transactions,
    ) {
    }

    public function handle(UpdateBookCommand $command): Book
    {
        $bookId = new Id($command->id);
        $book = $this->books->get($bookId);
        $oldPhoto = $book->photo();
        $newPhoto = $this->resolvePhoto($command, $oldPhoto);

        $book->edit(
            new BookTitle($command->title),
            new BookYear($command->year),
            $command->description,
            $command->isbn ? new Isbn($command->isbn) : null,
            $newPhoto,
        );

        $this->transactions->wrap(function () use ($book, $bookId, $command, $newPhoto): void {
            $this->books->save($book);
            $this->syncAuthors($bookId, $command->authorIds);
        });

        $hasNewPhotoOrNeedToRemoveOld = $command->newPhotoFile !== null || $command->removePhoto;
        if ($oldPhoto !== null && $oldPhoto !== $newPhoto && $hasNewPhotoOrNeedToRemoveOld) {
            $this->files->delete($oldPhoto);
        }

        $this->notifier->notify($bookId, $this->toNotifyAuthorsIds);

        return $book;
    }

    private function resolvePhoto(UpdateBookCommand $command, ?PhotoName $oldPhoto): ?PhotoName
    {
        if ($command->newPhotoFile !== null) {
            return $this->files->saveUploaded($command->newPhotoFile);
        }

        if ($command->removePhoto) {
            return null;
        }

        return $oldPhoto;
    }

    /**
     * @param int[] $requestedIds
     */
    private function syncAuthors(Id $bookId, array $requestedIds): void
    {
        $existingIds = $this->bookAuthors->findIdsById($bookId);
        $toCreate = array_diff($requestedIds, $existingIds);
        $toDelete = array_diff($existingIds, $requestedIds);

        foreach ($toCreate as $authorId) {
            $authorId = new Id($authorId);
            $this->bookAuthors->add(new BookAuthor($bookId, $authorId));
            $this->toNotifyAuthorsIds[] = $authorId;
        }

        foreach ($toDelete as $authorId) {
            $this->bookAuthors->remove($bookId, new Id($authorId));
        }
    }
}
