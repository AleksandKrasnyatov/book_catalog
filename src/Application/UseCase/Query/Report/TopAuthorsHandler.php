<?php

declare(strict_types=1);

namespace app\Application\UseCase\Query\Report;

use app\Application\UseCase\Query\Report\Model\TopAuthorRow;
use app\Domain\Query\ReportQueryInterface;

final readonly class TopAuthorsHandler
{
    public function __construct(private ReportQueryInterface $reports)
    {
    }

    /**
     * @return TopAuthorRow[]
     */
    public function handle(TopAuthorsQuery $query): array
    {
        return $this->reports->topAuthorsByYear($query->year, $query->limit);
    }
}

