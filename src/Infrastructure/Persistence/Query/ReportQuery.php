<?php

declare(strict_types=1);

namespace app\Infrastructure\Persistence\Query;

use app\Application\UseCase\Query\Report\Model\TopAuthorRow;
use app\Domain\Query\ReportQueryInterface;
use app\Infrastructure\Persistence\ActiveRecord\AuthorRecord;
use yii\db\Expression;

final class ReportQuery implements ReportQueryInterface
{
    public function topAuthorsByYear(int $year, int $limit): array
    {
        $rows = AuthorRecord::find()
            ->alias('a')
            ->select([
                'id' => 'a.id',
                'name' => 'a.name',
                'booksCount' => new Expression('COUNT(DISTINCT b.id)'),
            ])
            ->innerJoin('{{%book_author}} ba', 'ba.author_id = a.id')
            ->innerJoin('{{%books}} b', 'b.id = ba.book_id')
            ->where(['b.year' => $year])
            ->groupBy(['a.id', 'a.name'])
            ->orderBy(['booksCount' => SORT_DESC, 'name' => SORT_ASC])
            ->limit($limit)
            ->asArray()
            ->all();

        return array_map(
            static fn(array $row): TopAuthorRow
                => new TopAuthorRow((int) $row['id'], (string) $row['name'], (int) $row['booksCount']),
            $rows,
        );
    }
}
