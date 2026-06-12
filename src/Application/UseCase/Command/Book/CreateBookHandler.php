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
use RuntimeException;
use Throwable;

final class CreateBookHandler
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

    public function handle(CreateBookCommand $command): Book
    {
        $photo = $command->photoFile ? $this->files->saveUploaded($command->photoFile) : null;
        $book = Book::create(
            new BookTitle($command->title),
            new BookYear($command->year),
            $command->description,
            $command->isbn ? new Isbn($command->isbn) : null,
            $photo,
        );

        try {
            $this->transactions->wrap(fn() => $this->createBookAndAddAuthors($book, $command->authorIds));
        } catch (Throwable $e) {
            if ($photo !== null) {
                $this->files->delete($photo);
            }
            throw new RuntimeException($e->getMessage());
        }

        $this->notifier->notify($book->id(), $this->toNotifyAuthorsIds);

        return $book;
    }

    /**
     * @param int[] $authorIds
     */
    private function createBookAndAddAuthors(Book $book, array $authorIds): void
    {
        $this->books->save($book);
        $bookId = $book->id();

        foreach ($authorIds as $authorId) {
            $authorId = new Id($authorId);
            $this->bookAuthors->add(new BookAuthor($bookId, $authorId));
            $this->toNotifyAuthorsIds[] = $authorId;
        }
    }
}
