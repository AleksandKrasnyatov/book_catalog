<?php

declare(strict_types=1);

namespace app\Domain\Repository;

use app\Domain\Entity\Book;
use app\Domain\ValueObject\Id;

interface BookRepositoryInterface
{
    public function get(Id $id): Book;

    public function save(Book $book): void;

    public function delete(Book $book): void;
}

