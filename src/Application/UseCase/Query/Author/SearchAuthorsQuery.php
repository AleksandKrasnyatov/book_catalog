<?php

declare(strict_types=1);

namespace app\Application\UseCase\Query\Author;

final readonly class SearchAuthorsQuery
{
    public function __construct(
        public ?string $name,
    ) {
    }
}

