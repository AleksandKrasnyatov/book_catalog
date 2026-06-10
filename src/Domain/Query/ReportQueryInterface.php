<?php

declare(strict_types=1);

namespace app\Domain\Query;

use app\Application\UseCase\Query\Report\Model\TopAuthorRow;

interface ReportQueryInterface
{
    /**
     * @return TopAuthorRow[]
     */
    public function topAuthorsByYear(int $year, int $limit): array;
}
