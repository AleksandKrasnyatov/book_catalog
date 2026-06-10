<?php

declare(strict_types=1);

namespace app\Infrastructure\Persistence\Repository;

use app\Domain\Entity\BookAuthor;
use app\Domain\Repository\BookAuthorRepositoryInterface;
use app\Domain\ValueObject\Id;
use app\Infrastructure\Persistence\ActiveRecord\BookAuthorRecord;
use RuntimeException;

final class BookAuthorRepository implements BookAuthorRepositoryInterface
{
    public function findIdsById(Id $bookId): array
    {
        return array_map(
            'intval',
            BookAuthorRecord::find()->select('author_id')->where(['book_id' => $bookId->value])->column(),
        );
    }

    public function add(BookAuthor $bookAuthor): void
    {
        $record = new BookAuthorRecord();
        $record->book_id = $bookAuthor->bookId->value;
        $record->author_id = $bookAuthor->authorId->value;

        if (!$record->save(false)) {
            throw new RuntimeException('Book author save failed.');
        }
    }

    public function remove(Id $bookId, Id $authorId): void
    {
        BookAuthorRecord::deleteAll(['book_id' => $bookId->value, 'author_id' => $authorId->value]);
    }

    public function removeAllById(Id $bookId): void
    {
        BookAuthorRecord::deleteAll(['book_id' => $bookId->value]);
    }
}
