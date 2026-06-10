<?php

declare(strict_types=1);

namespace app\Application\UseCase\Query\Author;

use app\Application\UseCase\Query\Book\Model\PaginatedResult;
use app\Domain\Query\AuthorQueryInterface;

final readonly class SearchAuthorsHandler
{
    public function __construct(private AuthorQueryInterface $authors)
    {
    }

    public function handle(SearchAuthorsQuery $query): PaginatedResult
    {
        return $this->authors->search(['name' => $query->name]);
    }
}

