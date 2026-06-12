<?php

declare(strict_types=1);

namespace tests\unit\Support;

use app\Domain\Entity\Book;
use app\Domain\Exception\EntityNotFound;
use app\Domain\Repository\BookRepositoryInterface;
use app\Domain\ValueObject\Id;

final class InMemoryBookRepository implements BookRepositoryInterface
{
    /** @var array<int, Book> */
    private array $books = [];

    private int $nextId = 1;

    public function get(Id $id): Book
    {
        return $this->books[$id->value] ?? throw new EntityNotFound('Book not found.');
    }

    public function save(Book $book): void
    {
        if ($book->id() === null) {
            $book->assignId(new Id($this->nextId++));
        }

        $id = $book->id();
        if ($id !== null) {
            $this->books[$id->value] = $book;
        }
    }

    public function delete(Book $book): void
    {
        $id = $book->id();
        if ($id !== null) {
            unset($this->books[$id->value]);
        }
    }

    public function count(): int
    {
        return count($this->books);
    }
}
