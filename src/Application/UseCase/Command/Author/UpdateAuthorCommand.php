<?php

declare(strict_types=1);

namespace app\Application\UseCase\Command\Author;

final readonly class UpdateAuthorCommand
{
    public function __construct(
        public int $id,
        public string $name,
    ) {
    }
}
