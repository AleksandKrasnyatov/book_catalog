<?php

declare(strict_types=1);

namespace app\Domain\Repository;

use app\Domain\Entity\BookAuthor;
use app\Domain\ValueObject\Id;

interface BookAuthorRepositoryInterface
{
    /**
     * @return int[]
     */
    public function findIdsById(Id $bookId): array;

    public function add(BookAuthor $bookAuthor): void;

    public function remove(Id $bookId, Id $authorId): void;

    public function removeAllById(Id $bookId): void;
}
