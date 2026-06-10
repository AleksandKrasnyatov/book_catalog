<?php

declare(strict_types=1);

namespace app\Domain\Repository;

use app\Domain\Entity\Author;
use app\Domain\ValueObject\Id;
use app\Domain\ValueObject\AuthorName;

interface AuthorRepositoryInterface
{
    public function get(Id $id): Author;

    public function save(Author $author): void;

    public function delete(Author $author): void;

    public function existsByName(AuthorName $name): bool;

    public function hasBooks(Id $id): bool;

    /**
     * @return array<int, string>
     */
    public function listOptions(): array;
}
