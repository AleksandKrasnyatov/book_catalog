<?php

declare(strict_types=1);

namespace tests\unit\Application;

use app\Application\UseCase\Command\Author\CreateAuthorCommand;
use app\Application\UseCase\Command\Author\CreateAuthorHandler;
use app\Domain\Entity\Author;
use app\Domain\Exception\DomainRuleException;
use app\Domain\ValueObject\AuthorName;
use Codeception\Test\Unit;
use PHPUnit\Framework\Attributes\Test;
use tests\unit\Support\InMemoryAuthorRepository;
use Throwable;

final class CreateAuthorHandlerTest extends Unit
{
    #[Test]
    public function givenCommandToCreateAuthorWhenNoMoreAuthorsThenAuthorCreates(): void
    {
        $authors = new InMemoryAuthorRepository();
        $handler = new CreateAuthorHandler($authors);

        $author = $handler->handle(new CreateAuthorCommand('Лев Толстой'));

        verify($author->id())->notEmpty();
        verify($author->name()->value)->equals('Лев Толстой');
        verify($authors->count())->equals(1);
    }

    #[Test]
    public function givenCommandToCreateAuthorWhenAuthorAlreadyExistsThenAuthorDoesNotCreateAndExceptionThrows(): void
    {
        $authors = new InMemoryAuthorRepository();
        $authors->save(Author::create(new AuthorName('Лев Толстой')));
        $handler = new CreateAuthorHandler($authors);

        $this->expectException(DomainRuleException::class);

        try {
            $handler->handle(new CreateAuthorCommand('Лев Толстой'));
        } catch (Throwable $e) {
            verify($authors->count())->equals(1);
            throw $e;
        }
    }
}
