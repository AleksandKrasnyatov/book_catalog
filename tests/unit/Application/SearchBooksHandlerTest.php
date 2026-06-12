<?php

declare(strict_types=1);

namespace tests\unit\Application;

use app\Application\UseCase\Query\Book\Model\BookView;
use app\Application\UseCase\Query\Book\SearchBooksHandler;
use app\Application\UseCase\Query\Book\SearchBooksQuery;
use Codeception\Test\Unit;
use PHPUnit\Framework\Attributes\Test;
use tests\unit\Support\InMemoryBookQuery;

final class SearchBooksHandlerTest extends Unit
{
    #[Test]
    public function givenQueryToSearchBooksWhenYearFilterMatchesThenReturnsFilteredBooks(): void
    {
        $query = new InMemoryBookQuery();
        $query->add(new BookView(1, 'Идиот', 1869, null, null, null, []));
        $query->add(new BookView(2, 'Война и мир', 1869, null, null, null, []));
        $query->add(new BookView(3, 'Преступление и наказание', 1866, null, null, null, []));
        $handler = new SearchBooksHandler($query);

        $result = $handler->handle(new SearchBooksQuery(null, 1869, null));

        verify($result->items)->arrayCount(2);
    }
}
