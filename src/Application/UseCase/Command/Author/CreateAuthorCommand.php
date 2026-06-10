<?php

declare(strict_types=1);

namespace app\Application\UseCase\Command\Author;

final readonly class CreateAuthorCommand
{
    public function __construct(public string $name)
    {
    }
}

