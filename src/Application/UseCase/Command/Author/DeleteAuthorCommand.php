<?php

declare(strict_types=1);

namespace app\Application\UseCase\Command\Author;

final readonly class DeleteAuthorCommand
{
    public function __construct(public int $id)
    {
    }
}

