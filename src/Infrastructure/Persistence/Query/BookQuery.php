<?php

declare(strict_types=1);

namespace app\Infrastructure\Persistence\Query;

use app\Application\UseCase\Query\Book\Model\BookView;
use app\Application\UseCase\Query\Book\Model\PaginatedResult;
use app\Domain\Exception\EntityNotFound;
use app\Domain\Query\BookQueryInterface;
use app\Domain\Query\PhotoUrlGeneratorInterface;
use app\Domain\ValueObject\Id;
use app\Domain\ValueObject\PhotoName;
use app\Infrastructure\Persistence\ActiveRecord\AuthorRecord;
use app\Infrastructure\Persistence\ActiveRecord\BookAuthorRecord;
use app\Infrastructure\Persistence\ActiveRecord\BookRecord;

final readonly class BookQuery implements BookQueryInterface
{
    public function __construct(private PhotoUrlGeneratorInterface $photos)
    {
    }

    public function getView(Id $id): BookView
    {
        $record = BookRecord::findOne($id->value);
        if (!$record instanceof BookRecord) {
            throw new EntityNotFound('Book not found.');
        }

        return $this->mapBook($record);
    }

    public function search(array $filter): PaginatedResult
    {
        $query = BookRecord::find()->alias('b')->orderBy(['b.title' => SORT_ASC]);

        if (!empty($filter['title'])) {
            $query->andWhere(['like', 'b.title', $filter['title']]);
        }

        if (!empty($filter['year'])) {
            $query->andWhere(['b.year' => (int) $filter['year']]);
        }

        if (!empty($filter['authorId'])) {
            $query->innerJoin(['ba' => BookAuthorRecord::tableName()], 'ba.book_id = b.id');
            $query->andWhere(['ba.author_id' => (int) $filter['authorId']]);
            $query->distinct();
        }

        $records = $query->all();
        $items = array_map(fn(BookRecord $record): BookView => $this->mapBook($record), $records);

        return new PaginatedResult($items, count($items), 1, count($items));
    }

    private function mapBook(BookRecord $record): BookView
    {
        $authors = AuthorRecord::find()
            ->alias('a')
            ->select(['a.name'])
            ->indexBy('a.id')
            ->innerJoin(['ba' => BookAuthorRecord::tableName()], 'ba.author_id = a.id')
            ->where(['ba.book_id' => (int) $record->id])
            ->column();

        $photo = $record->photo ? new PhotoName((string) $record->photo) : null;

        return new BookView(
            (int) $record->id,
            (string) $record->title,
            (int) $record->year,
            $record->description,
            $record->isbn,
            $this->photos->url($photo),
            $authors,
        );
    }
}

