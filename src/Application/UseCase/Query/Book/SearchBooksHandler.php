<?php

declare(strict_types=1);

namespace app\Application\UseCase\Query\Book;

use app\Application\UseCase\Query\Book\Model\PaginatedResult;
use app\Domain\Query\BookQueryInterface;

final readonly class SearchBooksHandler
{
    public function __construct(private BookQueryInterface $books)
    {
    }

    public function handle(SearchBooksQuery $query): PaginatedResult
    {
        return $this->books->search([
            'title' => $query->title,
            'year' => $query->year,
            'authorId' => $query->authorId,
        ]);
    }
}

