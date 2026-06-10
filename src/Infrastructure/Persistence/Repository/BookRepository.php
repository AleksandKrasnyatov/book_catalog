<?php

declare(strict_types=1);

namespace app\Infrastructure\Persistence\Repository;

use app\Domain\Entity\Book;
use app\Domain\Exception\EntityNotFound;
use app\Domain\Repository\BookRepositoryInterface;
use app\Domain\ValueObject\Id;
use app\Infrastructure\Persistence\ActiveRecord\BookRecord;
use app\Infrastructure\Persistence\Mapper\BookMapper;
use RuntimeException;

final readonly class BookRepository implements BookRepositoryInterface
{
    public function __construct(private BookMapper $mapper)
    {
    }

    public function get(Id $id): Book
    {
        $record = BookRecord::findOne($id->value);
        if (!$record instanceof BookRecord) {
            throw new EntityNotFound('Book not found.');
        }

        return $this->mapper->toDomain($record);
    }

    public function save(Book $book): void
    {
        $record = $book->id() ? BookRecord::findOne($book->id()->value) : new BookRecord();
        if (!$record instanceof BookRecord) {
            throw new EntityNotFound('Book not found.');
        }

        $this->mapper->fillRecord($record, $book);
        if (!$record->save(false)) {
            throw new RuntimeException('Book save failed.');
        }

        if ($book->id() === null) {
            $book->assignId(new Id((int) $record->id));
        }
    }

    public function delete(Book $book): void
    {
        if ($book->id() === null) {
            return;
        }

        BookRecord::deleteAll(['id' => $book->id()->value]);
    }
}
