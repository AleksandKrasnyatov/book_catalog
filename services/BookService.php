<?php

declare(strict_types=1);

namespace app\services;

use app\forms\BookForm;
use app\models\Book;
use app\models\BookAuthor;
use Exception;
use Throwable;

/**
 * @template-extends CrudService<Book>
 */
class BookService extends CrudService
{
    public function __construct(
        private readonly TransactionManager $transactionManager,
    ) {
    }

    public function find(int $id): Book
    {
        return Book::findOne($id);
    }

    /**
     * @throws Throwable
     */
    public function create(BookForm $form): Book
    {
        $form->applyPhotoUpload();
        $dto = $form->toDto();
        $model = Book::create($dto);

        return $this->transactionManager->wrap(function () use ($model, $form) {
            $this->save($model);
            $this->syncAuthors($model, $form->authorIds);
            return $model;
        });
    }

    /**
     * @throws Throwable
     */
    public function update(Book $model, BookForm $form): Book
    {
        $form->applyPhotoUpload();
        $dto = $form->toDto();
        $model->edit($dto);

        return $this->transactionManager->wrap(function () use ($model, $form) {
            $this->save($model);
            $this->syncAuthors($model, $form->authorIds);
            return $model;
        });
    }

    /**
     * @throws Throwable
     */
    public function deleteBook(int $id): void
    {
        $model = $this->get($id);
        $this->transactionManager->wrap(function () use ($model) {
            $bookAuthorsIds = $model->getBookAuthors()->select('author_id')->column();
            $this->deleteAuthorsBooks($model->id, $bookAuthorsIds);
            $this->delete($model);
        });
    }

    /**
     * @throws Exception
     */
    private function syncAuthors(Book $book, array $authorIds): void
    {
        $existsAuthorsIds = $book->getBookAuthors()->select('author_id')->column();
        $toDeleteIds = array_diff($existsAuthorsIds, $authorIds);
        $toCreateIds = array_diff($authorIds, $existsAuthorsIds);
        $this->createAuthorsBooks($book->id, $toCreateIds);
        $this->deleteAuthorsBooks($book->id, $toDeleteIds);
    }

    /**
     * @throws Exception
     */
    private function createAuthorsBooks(int $bookId, array $authorIds): void
    {
        foreach ($authorIds as $authorId) {
            $bookAuthor = new BookAuthor(['book_id' => $bookId, 'author_id' => (int) $authorId]);
            if (!$bookAuthor->save()) {
                throw new Exception('Ошибка сохранения автора для книги');
            }
        }
    }

    /**
     * @throws Exception
     */
    private function deleteAuthorsBooks(int $bookId, array $authorIds): void
    {
        BookAuthor::deleteAll(['book_id' => $bookId, 'author_id' => $authorIds]);
    }
}
