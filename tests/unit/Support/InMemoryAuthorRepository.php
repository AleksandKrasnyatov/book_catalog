<?php

declare(strict_types=1);

namespace tests\unit\Support;

use app\Domain\Entity\Author;
use app\Domain\Exception\EntityNotFound;
use app\Domain\Repository\AuthorRepositoryInterface;
use app\Domain\ValueObject\AuthorName;
use app\Domain\ValueObject\Id;

final class InMemoryAuthorRepository implements AuthorRepositoryInterface
{
    /** @var array<int, Author> */
    private array $authors = [];

    /** @var array<int, true> */
    private array $authorsWithBooks = [];

    private int $nextId = 1;

    public function get(Id $id): Author
    {
        return $this->authors[$id->value] ?? throw new EntityNotFound('Author not found.');
    }

    public function save(Author $author): void
    {
        if ($author->id() === null) {
            $author->assignId(new Id($this->nextId++));
        }

        $id = $author->id();
        if ($id !== null) {
            $this->authors[$id->value] = $author;
        }
    }

    public function delete(Author $author): void
    {
        $id = $author->id();
        if ($id !== null) {
            unset($this->authors[$id->value]);
        }
    }

    public function existsByName(AuthorName $name): bool
    {
        return array_any($this->authors, fn($author) => $author->name()->value === $name->value);
    }

    public function hasBooks(Id $id): bool
    {
        return isset($this->authorsWithBooks[$id->value]);
    }

    /**
     * @return array<int, string>
     */
    public function listOptions(): array
    {
        $options = [];
        foreach ($this->authors as $author) {
            $id = $author->id();
            if ($id !== null) {
                $options[$id->value] = $author->name()->value;
            }
        }

        return $options;
    }

    public function count(): int
    {
        return count($this->authors);
    }
}
