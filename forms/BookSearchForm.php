<?php

namespace app\forms;

use app\models\Author;
use app\models\Book;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class BookSearchForm extends Model
{
    public $title;
    public $year;
    public $authorId;

    public function rules(): array
    {
        return [
            [['title'], 'string'],
            [['title'], 'trim'],
            [['year', 'authorId'], 'integer'],
        ];
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = Book::find();

        $this->load($params);
        if (!$this->validate()) {
            $query->where('0=1');
        }

        $query->andFilterWhere(['like', 'title', $this->title]);
        $query->andFilterWhere(['year' => $this->year]);

        if (!empty($this->authorId)) {
            $query->joinWith('authors');
            $query->andWhere([Author::tableName() . '.id' => $this->authorId]);
            $query->distinct();
        }

        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }
}
