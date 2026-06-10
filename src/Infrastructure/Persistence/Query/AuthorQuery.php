<?php

declare(strict_types=1);

namespace app\Infrastructure\Persistence\Query;

use app\Application\UseCase\Query\Author\Model\AuthorView;
use app\Application\UseCase\Query\Book\Model\PaginatedResult;
use app\Domain\Exception\EntityNotFound;
use app\Domain\Query\AuthorQueryInterface;
use app\Domain\ValueObject\Id;
use app\Infrastructure\Persistence\ActiveRecord\AuthorRecord;

final class AuthorQuery implements AuthorQueryInterface
{
    public function getView(Id $id): AuthorView
    {
        $record = AuthorRecord::findOne($id->value);
        if (!$record instanceof AuthorRecord) {
            throw new EntityNotFound('Author not found.');
        }

        return new AuthorView((int) $record->id, (string) $record->name);
    }

    public function search(array $filter): PaginatedResult
    {
        $query = AuthorRecord::find()->orderBy(['name' => SORT_ASC]);

        if (!empty($filter['name'])) {
            $query->andWhere(['like', 'name', $filter['name']]);
        }

        $records = $query->all();
        $items = array_map(
            static fn(AuthorRecord $record): AuthorView => new AuthorView((int) $record->id, (string) $record->name),
            $records,
        );

        return new PaginatedResult($items, count($items), 1, count($items));
    }
}

