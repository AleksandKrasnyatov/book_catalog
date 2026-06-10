<?php

declare(strict_types=1);

namespace app\Application\UseCase\Command\Book;

final readonly class DeleteBookCommand
{
    public function __construct(public int $id)
    {
    }
}

