<?php

declare(strict_types=1);

namespace tests\unit\services;

use app\Application\UseCase\Command\Book\CreateBookCommand;
use app\Application\UseCase\Command\Book\CreateBookHandler;
use app\Application\UseCase\Command\Book\DeleteBookCommand;
use app\Application\UseCase\Command\Book\DeleteBookHandler;
use app\Application\UseCase\Command\Book\UpdateBookCommand;
use app\Application\UseCase\Command\Book\UpdateBookHandler;
use app\Infrastructure\Persistence\ActiveRecord\BookAuthorRecord;
use app\Infrastructure\Persistence\ActiveRecord\BookRecord;
use Codeception\Test\Unit;
use tests\fixtures\AuthorFixture;
use tests\fixtures\BookAuthorFixture;
use tests\fixtures\BookFixture;
use Yii;

final class BookServiceTest extends Unit
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
        $handler = Yii::$container->get(CreateBookHandler::class);
        $book = $handler->handle(new CreateBookCommand(
            'New Book',
            2024,
            'New description',
            'ISBN-NEW',
            null,
            [1, 2],
        ));

        verify($book->id())->notEmpty();
        verify(BookRecord::findOne($book->id()?->value))->notEmpty();

        $authorIds = BookAuthorRecord::find()
            ->select('author_id')
            ->where(['book_id' => $book->id()?->value])
            ->column();
        sort($authorIds);
        verify($authorIds)->equals([1, 2]);
    }

    public function testUpdate(): void
    {
        $handler = Yii::$container->get(UpdateBookHandler::class);
        $updated = $handler->handle(new UpdateBookCommand(
            10,
            'Updated Book',
            2010,
            'First book',
            'ISBN-ONE',
            null,
            false,
            [2],
        ));

        verify($updated->title()->value)->equals('Updated Book');
        $authorIds = BookAuthorRecord::find()->select('author_id')->where(['book_id' => 10])->column();
        verify($authorIds)->equals([2]);
    }

    public function testDeleteBook(): void
    {
        $handler = Yii::$container->get(DeleteBookHandler::class);
        $handler->handle(new DeleteBookCommand(11));

        verify(BookRecord::findOne(11))->empty();
        verify(BookAuthorRecord::find()->where(['book_id' => 11])->count())->equals(0);
    }
}
