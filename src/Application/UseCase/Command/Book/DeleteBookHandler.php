<?php

declare(strict_types=1);

namespace app\Application\UseCase\Command\Book;

use app\Application\Gateway\Db\TransactionManagerInterface;
use app\Application\Gateway\File\FileStorageInterface;
use app\Domain\Repository\BookAuthorRepositoryInterface;
use app\Domain\Repository\BookRepositoryInterface;
use app\Domain\ValueObject\Id;

final readonly class DeleteBookHandler
{
    public function __construct(
        private BookRepositoryInterface $books,
        private BookAuthorRepositoryInterface $bookAuthors,
        private FileStorageInterface $files,
        private TransactionManagerInterface $transactions,
    ) {
    }

    public function handle(DeleteBookCommand $command): void
    {
        $bookId = new Id($command->id);
        $book = $this->books->get($bookId);
        $photo = $book->photo();

        $this->transactions->wrap(function () use ($book, $bookId): void {
            $this->bookAuthors->removeAllById($bookId);
            $this->books->delete($book);
        });

        if ($photo !== null) {
            $this->files->delete($photo);
        }
    }
}
