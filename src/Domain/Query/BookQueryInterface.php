<?php

declare(strict_types=1);

namespace app\Domain\Query;

use app\Application\UseCase\Query\Book\Model\BookView;
use app\Application\UseCase\Query\Book\Model\PaginatedResult;
use app\Domain\ValueObject\Id;

interface BookQueryInterface
{
    public function getView(Id $id): BookView;

    /**
     * @param array{title?: string|null, year?: int|null, authorId?: int|null} $filter
     */
    public function search(array $filter): PaginatedResult;
}
