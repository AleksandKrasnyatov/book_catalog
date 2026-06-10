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

final readonly class CreateBookHandler
{
    public function __construct(
        private BookRepositoryInterface $books,
        private BookAuthorRepositoryInterface $bookAuthors,
        private FileStorageInterface $files,
        private NewBookNotifierInterface $notifier,
        private TransactionManagerInterface $transactions,
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

        $this->transactions->wrap(function () use ($book, $command): void {
            $this->books->save($book);
            $bookId = $book->id();

            if ($bookId === null) {
                throw new RuntimeException('Book id must be assigned after save.');
            }

            foreach ($command->authorIds as $authorId) {
                $authorId = new Id($authorId);
                $this->bookAuthors->add(new BookAuthor($bookId, $authorId));
                $this->notifier->notify($bookId, $authorId);
            }
        });

        return $book;
    }
}

