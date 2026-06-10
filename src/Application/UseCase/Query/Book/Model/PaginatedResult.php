<?php

declare(strict_types=1);

namespace app\Application\UseCase\Query\Book\Model;

final readonly class PaginatedResult
{
    /**
     * @param array<int, mixed> $items
     */
    public function __construct(
        public array $items,
        public int $totalCount,
        public int $page,
        public int $pageSize,
    ) {
    }
}
