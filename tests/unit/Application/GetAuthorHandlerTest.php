<?php

declare(strict_types=1);

namespace tests\unit\Application;

use app\Application\UseCase\Query\Author\GetAuthorHandler;
use app\Application\UseCase\Query\Author\GetAuthorQuery;
use app\Application\UseCase\Query\Author\Model\AuthorView;
use Codeception\Test\Unit;
use PHPUnit\Framework\Attributes\Test;
use tests\unit\Support\InMemoryAuthorQuery;

final class GetAuthorHandlerTest extends Unit
{
    #[Test]
    public function givenQueryToGetAuthorWhenAuthorExistsThenReturnsAuthorView(): void
    {
        $query = new InMemoryAuthorQuery();
        $query->add(new AuthorView(1, 'Лев Толстой'));
        $handler = new GetAuthorHandler($query);

        $view = $handler->handle(new GetAuthorQuery(1));

        verify($view->id)->equals(1);
        verify($view->name)->equals('Лев Толстой');
    }
}
