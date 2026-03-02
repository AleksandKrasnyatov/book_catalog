<?php

declare(strict_types=1);

namespace app\forms;

use app\models\Author;
use app\models\Book;
use app\models\BookAuthor;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

class TopAuthorsReportSearchForm extends Model
{
    public $year;

    public function rules(): array
    {
        return [
            [['year'], 'required'],
            [['year'], 'integer', 'min' => 1000, 'max' => date('Y')],
        ];
    }

    public function afterValidate(): void
    {
        if (empty($this->year)) {
            $this->year = date('Y');
        }
        parent::afterValidate();
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = Author::find()
            ->alias('a')
            ->select([
                'a.id',
                'a.name',
                'booksCount' => new Expression('COUNT(DISTINCT b.id)'),
            ])
            ->innerJoinWith('books b');

        $this->load($params);
        if (!$this->validate()) {
            $query->where('0=1');
        }

        $query->andWhere(['b.year' => $this->year]);
        $query->groupBy(['a.id'])
            ->orderBy(['booksCount' => SORT_DESC])
            ->asArray()
            ->limit(10);

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort' => [
                'defaultOrder' => ['booksCount' => SORT_DESC, 'name' => SORT_ASC],
                'attributes' => [
                    'id',
                    'name',
                    'booksCount',
                ],
            ],
        ]);
    }
}
