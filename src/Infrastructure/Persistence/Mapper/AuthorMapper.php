<?php

declare(strict_types=1);

namespace app\Infrastructure\Persistence\Mapper;

use app\Domain\Entity\Author;
use app\Domain\ValueObject\Id;
use app\Domain\ValueObject\AuthorName;
use app\Infrastructure\Persistence\ActiveRecord\AuthorRecord;

final class AuthorMapper
{
    public function toDomain(AuthorRecord $record): Author
    {
        return Author::restore(new Id($record->id), new AuthorName($record->name));
    }

    public function fillRecord(AuthorRecord $record, Author $author): void
    {
        $record->name = $author->name()->value;
    }
}
