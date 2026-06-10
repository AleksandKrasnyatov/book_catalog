<?php

declare(strict_types=1);

namespace app\Infrastructure\Persistence\Mapper;

use app\Domain\Entity\Book;
use app\Domain\ValueObject\Id;
use app\Domain\ValueObject\BookTitle;
use app\Domain\ValueObject\BookYear;
use app\Domain\ValueObject\Isbn;
use app\Domain\ValueObject\PhotoName;
use app\Infrastructure\Persistence\ActiveRecord\BookRecord;

final class BookMapper
{
    public function toDomain(BookRecord $record): Book
    {
        return Book::restore(
            new Id($record->id),
            new BookTitle($record->title),
            new BookYear($record->year),
            $record->description,
            $record->isbn ? new Isbn((string) $record->isbn) : null,
            $record->photo ? new PhotoName((string) $record->photo) : null,
        );
    }

    public function fillRecord(BookRecord $record, Book $book): void
    {
        $record->title = $book->title()->value;
        $record->year = $book->year()->value;
        $record->description = $book->description();
        $record->isbn = $book->isbn()?->value;
        $record->photo = $book->photo()?->value;
    }
}
