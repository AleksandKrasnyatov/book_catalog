<?php

declare(strict_types=1);

namespace tests\unit\services;

use app\Application\UseCase\Command\Author\CreateAuthorCommand;
use app\Application\UseCase\Command\Author\CreateAuthorHandler;
use app\Application\UseCase\Command\Author\DeleteAuthorCommand;
use app\Application\UseCase\Command\Author\DeleteAuthorHandler;
use app\Application\UseCase\Command\Author\UpdateAuthorCommand;
use app\Application\UseCase\Command\Author\UpdateAuthorHandler;
use app\Domain\Exception\DomainRuleException;
use app\Infrastructure\Persistence\ActiveRecord\AuthorRecord;
use Codeception\Test\Unit;
use tests\fixtures\AuthorFixture;
use tests\fixtures\BookAuthorFixture;
use tests\fixtures\BookFixture;
use Yii;

final class AuthorServiceTest extends Unit
{
    public function _fixtures(): array
    {
        return [
            'authors' => AuthorFixture::class,
            'books' => BookFixture::class,
            'bookAuthors' => BookAuthorFixture::class,
        ];
    }

    public function testCreate(): void
    {
        $handler = Yii::$container->get(CreateAuthorHandler::class);
        $author = $handler->handle(new CreateAuthorCommand('New Author'));

        verify($author->id())->notEmpty();
        verify($author->name()->value)->equals('New Author');
        verify(AuthorRecord::findOne($author->id()?->value))->notEmpty();
    }

    public function testUpdate(): void
    {
        $handler = Yii::$container->get(UpdateAuthorHandler::class);
        $updated = $handler->handle(new UpdateAuthorCommand(1, 'Updated Author'));

        verify($updated->name()->value)->equals('Updated Author');
        verify(AuthorRecord::findOne(1)?->name)->equals('Updated Author');
    }

    public function testDeleteAuthorWithBooks(): void
    {
        $handler = Yii::$container->get(DeleteAuthorHandler::class);

        $this->expectException(DomainRuleException::class);
        $this->expectExceptionMessage('Cannot delete author with books.');

        $handler->handle(new DeleteAuthorCommand(1));
    }

    public function testDeleteAuthorWithoutBooks(): void
    {
        $handler = Yii::$container->get(DeleteAuthorHandler::class);
        $handler->handle(new DeleteAuthorCommand(3));

        verify(AuthorRecord::findOne(3))->empty();
    }
}
