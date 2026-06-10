<?php

declare(strict_types=1);

namespace app\Domain\Query;

use app\Application\UseCase\Query\Author\Model\AuthorView;
use app\Application\UseCase\Query\Book\Model\PaginatedResult;
use app\Domain\ValueObject\Id;

interface AuthorQueryInterface
{
    public function getView(Id $id): AuthorView;

    /**
     * @param array{name?: string|null} $filter
     */
    public function search(array $filter): PaginatedResult;
}

