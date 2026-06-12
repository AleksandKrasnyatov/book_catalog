<?php

declare(strict_types=1);

namespace tests\unit\Support;

use app\Domain\Entity\BookAuthor;
use app\Domain\Repository\BookAuthorRepositoryInterface;
use app\Domain\ValueObject\Id;
use RuntimeException;

final class InMemoryBookAuthorRepository implements BookAuthorRepositoryInterface
{
    /** @var array<int, int[]> bookId => authorIds */
    private array $links = [];

    public bool $failOnAdd = false;

    /**
     * @return int[]
     */
    public function findIdsById(Id $bookId): array
    {
        return $this->links[$bookId->value] ?? [];
    }

    public function add(BookAuthor $bookAuthor): void
    {
        if ($this->failOnAdd) {
            throw new RuntimeException('Simulated persistence failure.');
        }

        $this->links[$bookAuthor->bookId->value][] = $bookAuthor->authorId->value;
    }

    public function remove(Id $bookId, Id $authorId): void
    {
        if (!isset($this->links[$bookId->value])) {
            return;
        }

        $this->links[$bookId->value] = array_values(array_filter(
            $this->links[$bookId->value],
            static fn(int $id): bool => $id !== $authorId->value,
        ));
    }

    public function removeAllById(Id $bookId): void
    {
        unset($this->links[$bookId->value]);
    }
}
