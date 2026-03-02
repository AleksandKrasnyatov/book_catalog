<?php

declare(strict_types=1);

namespace tests\unit\services;

use app\forms\AuthorForm;
use app\models\Author;
use app\services\AuthorService;
use app\tests\fixtures\AuthorFixture;
use app\tests\fixtures\BookAuthorFixture;
use app\tests\fixtures\BookFixture;
use Codeception\Test\Unit;
use LogicException;

class AuthorServiceTest extends Unit
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
        $service = new AuthorService();
        $form = new AuthorForm();
        $form->name = 'New Author';

        $author = $service->create($form);

        verify($author->id)->notEmpty();
        verify($author->name)->equals('New Author');
        verify(Author::findOne($author->id))->notEmpty();
    }

    public function testUpdate(): void
    {
        $service = new AuthorService();
        $author = Author::findOne(1);
        $form = new AuthorForm($author);
        $form->name = 'Updated Author';

        $updated = $service->update($author, $form);

        verify($updated->name)->equals('Updated Author');
        verify(Author::findOne(1)->name)->equals('Updated Author');
    }

    public function testDeleteAuthorWithBooks(): void
    {
        $service = new AuthorService();

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Нельзя удалить автора, у которого есть книги');

        $service->deleteAuthor(1);
    }

    public function testDeleteAuthorWithoutBooks(): void
    {
        $service = new AuthorService();

        $service->deleteAuthor(3);

        verify(Author::findOne(3))->empty();
    }
}
