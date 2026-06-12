<?php

declare(strict_types=1);

namespace tests\unit\Application;

use app\Application\UseCase\Command\Author\UpdateAuthorCommand;
use app\Application\UseCase\Command\Author\UpdateAuthorHandler;
use app\Domain\Entity\Author;
use app\Domain\Exception\DomainRuleException;
use app\Domain\ValueObject\AuthorName;
use app\Domain\ValueObject\Id;
use Codeception\Test\Unit;
use PHPUnit\Framework\Attributes\Test;
use tests\unit\Support\InMemoryAuthorRepository;
use Throwable;

final class UpdateAuthorHandlerTest extends Unit
{
    #[Test]
    public function givenCommandToUpdateAuthorWhenNameIsUniqueThenAuthorRenames(): void
    {
        $authors = new InMemoryAuthorRepository();
        $authors->save(Author::create(new AuthorName('Лев Толстой')));
        $handler = new UpdateAuthorHandler($authors);

        $author = $handler->handle(new UpdateAuthorCommand(1, 'Лев Николаевич Толстой'));

        verify($author->name()->value)->equals('Лев Николаевич Толстой');
        verify($authors->get($author->id())->name()->value)->equals('Лев Николаевич Толстой');
    }

    #[Test]
    public function givenCommandToUpdateAuthorWhenNewNameAlreadyTakenThenExceptionThrows(): void
    {
        $authors = new InMemoryAuthorRepository();
        $authors->save(Author::create(new AuthorName('Лев Толстой')));
        $authors->save(Author::create(new AuthorName('Фёдор Достоевский')));
        $handler = new UpdateAuthorHandler($authors);

        $this->expectException(DomainRuleException::class);

        try {
            $handler->handle(new UpdateAuthorCommand(1, 'Фёдор Достоевский'));
        } catch (Throwable $e) {
            verify($authors->get(new Id(1))->name()->value)->equals('Лев Толстой');
            throw $e;
        }
    }
}
