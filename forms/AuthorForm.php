<?php

namespace app\forms;

use app\dto\AuthorDto;
use app\models\Author;
use yii\base\Model;

class AuthorForm extends Model
{
    public $name;

    public function __construct(?Author $author = null, $config = [])
    {
        if ($author) {
            $this->name = $author->name;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function toDto(): AuthorDto
    {
        return new AuthorDto($this->name);
    }
}
