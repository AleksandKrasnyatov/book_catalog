<?php

declare(strict_types=1);

namespace tests\unit\Application;

use app\Application\UseCase\Query\Report\Model\TopAuthorRow;
use app\Application\UseCase\Query\Report\TopAuthorsHandler;
use app\Application\UseCase\Query\Report\TopAuthorsQuery;
use Codeception\Test\Unit;
use PHPUnit\Framework\Attributes\Test;
use tests\unit\Support\InMemoryReportQuery;

final class TopAuthorsHandlerTest extends Unit
{
    #[Test]
    public function givenQueryForTopAuthorsWhenYearHasAuthorsThenReturnsLimitedRows(): void
    {
        $query = new InMemoryReportQuery();
        $query->preset(1869, [
            new TopAuthorRow(1, 'Лев Толстой', 3),
            new TopAuthorRow(2, 'Фёдор Достоевский', 2),
            new TopAuthorRow(3, 'Иван Тургенев', 1),
        ]);
        $handler = new TopAuthorsHandler($query);

        $rows = $handler->handle(new TopAuthorsQuery(1869, 2));

        verify($rows)->arrayCount(2);
        verify($rows[0]->name)->equals('Лев Толстой');
        verify($rows[1]->name)->equals('Фёдор Достоевский');
    }
}
