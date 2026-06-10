<?php

declare(strict_types=1);

namespace app\Application\UseCase\Query\Book;

final readonly class GetBookQuery
{
    public function __construct(public int $id)
    {
    }
}

