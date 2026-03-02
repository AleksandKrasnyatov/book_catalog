<?php

declare(strict_types=1);

namespace tests\unit\services;

use app\forms\BookForm;
use app\models\Book;
use app\models\BookAuthor;
use app\services\BookService;
use app\services\TransactionManager;
use app\tests\fixtures\AuthorFixture;
use app\tests\fixtures\BookAuthorFixture;
use app\tests\fixtures\BookFixture;
use Codeception\Test\Unit;

class BookServiceTest extends Unit
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
        $service = new BookService(new TransactionManager());
        $form = new BookForm();
        $form->title = 'New Book';
        $form->year = 2024;
        $form->description = 'New description';
        $form->isbn = 'ISBN-NEW';
        $form->photo = 'new.jpg';
        $form->authorIds = [1, 2];

        $book = $service->create($form);

        verify($book->id)->notEmpty();
        verify(Book::findOne($book->id))->notEmpty();
        $authorIds = BookAuthor::find()->select('author_id')->where(['book_id' => $book->id])->column();
        sort($authorIds);
        verify($authorIds)->equals([1, 2]);
    }

    public function testUpdate(): void
    {
        $service = new BookService(new TransactionManager());
        $book = Book::findOne(10);
        $form = new BookForm($book);
        $form->title = 'Updated Book';
        $form->year = 2010;
        $form->authorIds = [2];

        $updated = $service->update($book, $form);

        verify($updated->title)->equals('Updated Book');
        $authorIds = BookAuthor::find()->select('author_id')->where(['book_id' => 10])->column();
        verify($authorIds)->equals([2]);
    }

    public function testDeleteBook(): void
    {
        $service = new BookService(new TransactionManager());

        $service->deleteBook(11);

        verify(Book::findOne(11))->empty();
        verify(BookAuthor::find()->where(['book_id' => 11])->count())->equals(0);
    }
}
