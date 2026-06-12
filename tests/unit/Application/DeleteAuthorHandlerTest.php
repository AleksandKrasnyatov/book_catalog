<?php

declare(strict_types=1);

namespace tests\unit\Application;

use app\Application\UseCase\Command\Author\DeleteAuthorCommand;
use app\Application\UseCase\Command\Author\DeleteAuthorHandler;
use app\Domain\Entity\Author;
use app\Domain\Exception\DomainRuleException;
use app\Domain\ValueObject\AuthorName;
use app\Domain\ValueObject\Id;
use Codeception\Test\Unit;
use PHPUnit\Framework\Attributes\Test;
use tests\unit\Support\InMemoryAuthorRepository;
use Throwable;

final class DeleteAuthorHandlerTest extends Unit
{
    #[Test]
    public function givenCommandToDeleteAuthorWhenAuthorHasNoBooksThenAuthorDeletes(): void
    {
        $authors = new InMemoryAuthorRepository();
        $authors->save(Author::create(new AuthorName('Лев Толстой')));
        $handler = new DeleteAuthorHandler($authors);

        $handler->handle(new DeleteAuthorCommand(1));

        verify($authors->count())->equals(0);
    }

    #[Test]
    public function givenCommandToDeleteAuthorWhenAuthorHasBooksThenExceptionThrowsAndAuthorStays(): void
    {
        $authors = new InMemoryAuthorRepository();
        $authors->save(Author::create(new AuthorName('Лев Толстой')));
        $authors->markHasBooks(new Id(1));
        $handler = new DeleteAuthorHandler($authors);

        $this->expectException(DomainRuleException::class);

        try {
            $handler->handle(new DeleteAuthorCommand(1));
        } catch (Throwable $e) {
            verify($authors->count())->equals(1);
            throw $e;
        }
    }
}
