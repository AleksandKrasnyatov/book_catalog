<?php

declare(strict_types=1);

namespace app\Application\UseCase\Query\Report\Model;

final readonly class TopAuthorRow
{
    public function __construct(
        public int $id,
        public string $name,
        public int $booksCount,
    ) {
    }
}

