<?php

declare(strict_types=1);

namespace app\Application\UseCase\Query\Book;

final readonly class SearchBooksQuery
{
    public function __construct(
        public ?string $title,
        public ?int $year,
        public ?int $authorId,
    ) {
    }
}
