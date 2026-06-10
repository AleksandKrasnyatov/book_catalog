<?php

declare(strict_types=1);

namespace app\Infrastructure\Persistence\Repository;

use app\Domain\Entity\Author;
use app\Domain\Exception\EntityNotFound;
use app\Domain\Repository\AuthorRepositoryInterface;
use app\Domain\ValueObject\Id;
use app\Domain\ValueObject\AuthorName;
use app\Infrastructure\Persistence\ActiveRecord\AuthorRecord;
use app\Infrastructure\Persistence\ActiveRecord\BookAuthorRecord;
use app\Infrastructure\Persistence\Mapper\AuthorMapper;
use RuntimeException;

final readonly class AuthorRepository implements AuthorRepositoryInterface
{
    public function __construct(private AuthorMapper $mapper)
    {
    }

    public function get(Id $id): Author
    {
        $record = AuthorRecord::findOne($id->value);
        if (!$record instanceof AuthorRecord) {
            throw new EntityNotFound('Author not found.');
        }

        return $this->mapper->toDomain($record);
    }

    public function save(Author $author): void
    {
        $record = $author->id() ? AuthorRecord::findOne($author->id()->value) : new AuthorRecord();
        if (!$record instanceof AuthorRecord) {
            throw new EntityNotFound('Author not found.');
        }

        $this->mapper->fillRecord($record, $author);
        if (!$record->save(false)) {
            throw new RuntimeException('Author save failed.');
        }

        if ($author->id() === null) {
            $author->assignId(new Id((int) $record->id));
        }
    }

    public function delete(Author $author): void
    {
        if ($author->id() === null) {
            return;
        }

        AuthorRecord::deleteAll(['id' => $author->id()->value]);
    }

    public function existsByName(AuthorName $name): bool
    {
        return AuthorRecord::find()->where(['name' => $name->value])->exists();
    }

    public function hasBooks(Id $id): bool
    {
        return BookAuthorRecord::find()->where(['author_id' => $id->value])->exists();
    }

    public function listOptions(): array
    {
        return AuthorRecord::find()->select(['name'])->indexBy('id')->column();
    }
}
