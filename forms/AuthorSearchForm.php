<?php

namespace app\forms;

use app\models\Author;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class AuthorSearchForm extends Model
{
    public $name;

    public function rules(): array
    {
        return [
            [['name'], 'string'],
            [['name'], 'trim'],
        ];
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = Author::find();

        $this->load($params);
        if (!$this->validate()) {
            $query->where('0=1');
        }

        $query->andFilterWhere(['like', 'name', $this->name]);

        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }
}
