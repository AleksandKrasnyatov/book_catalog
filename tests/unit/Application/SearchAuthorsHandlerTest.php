<?php

declare(strict_types=1);

namespace tests\unit\Application;

use app\Application\UseCase\Query\Author\Model\AuthorView;
use app\Application\UseCase\Query\Author\SearchAuthorsHandler;
use app\Application\UseCase\Query\Author\SearchAuthorsQuery;
use Codeception\Test\Unit;
use PHPUnit\Framework\Attributes\Test;
use tests\unit\Support\InMemoryAuthorQuery;

final class SearchAuthorsHandlerTest extends Unit
{
    #[Test]
    public function givenQueryToSearchAuthorsWhenNameFilterMatchesThenReturnsFilteredAuthors(): void
    {
        $query = new InMemoryAuthorQuery();
        $query->add(new AuthorView(1, 'Лев Толстой'));
        $query->add(new AuthorView(2, 'Фёдор Достоевский'));
        $handler = new SearchAuthorsHandler($query);

        $result = $handler->handle(new SearchAuthorsQuery('Толстой'));

        verify($result->items)->arrayCount(1);
        verify($result->items[0]->name)->equals('Лев Толстой');
    }
}
