<?php

declare(strict_types=1);

namespace app\Application\UseCase\Query\Author\Model;

final readonly class AuthorView
{
    public function __construct(
        public int $id,
        public string $name,
    ) {
    }
}

