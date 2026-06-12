<?php

declare(strict_types=1);

namespace tests\unit\Application;

use app\Application\UseCase\Query\Book\GetBookHandler;
use app\Application\UseCase\Query\Book\GetBookQuery;
use app\Application\UseCase\Query\Book\Model\BookView;
use Codeception\Test\Unit;
use PHPUnit\Framework\Attributes\Test;
use tests\unit\Support\InMemoryBookQuery;

final class GetBookHandlerTest extends Unit
{
    #[Test]
    public function givenQueryToGetBookWhenBookExistsThenReturnsBookView(): void
    {
        $query = new InMemoryBookQuery();
        $query->add(new BookView(1, 'Идиот', 1869, null, null, null, [1 => 'Фёдор Достоевский']));
        $handler = new GetBookHandler($query);

        $view = $handler->handle(new GetBookQuery(1));

        verify($view->id)->equals(1);
        verify($view->title)->equals('Идиот');
        verify($view->authors[1])->equals('Фёдор Достоевский');
    }
}
