<?php

declare(strict_types=1);

namespace tests\unit\Support;

use app\Application\UseCase\Query\Report\Model\TopAuthorRow;
use app\Domain\Query\ReportQueryInterface;

final class InMemoryReportQuery implements ReportQueryInterface
{
    /** @var array<int, TopAuthorRow[]> */
    private array $rowsByYear = [];

    /**
     * @param TopAuthorRow[] $rows
     */
    public function preset(int $year, array $rows): void
    {
        $this->rowsByYear[$year] = $rows;
    }

    public function topAuthorsByYear(int $year, int $limit): array
    {
        return array_slice($this->rowsByYear[$year] ?? [], 0, $limit);
    }
}
