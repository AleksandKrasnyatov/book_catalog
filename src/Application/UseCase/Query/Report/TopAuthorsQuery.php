<?php

declare(strict_types=1);

namespace app\Application\UseCase\Query\Report;

final readonly class TopAuthorsQuery
{
    public function __construct(
        public int $year,
        public int $limit = 10,
    ) {
    }
}

