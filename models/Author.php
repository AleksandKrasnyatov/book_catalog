<?php

declare(strict_types=1);

namespace app\models;

use app\dto\AuthorDto;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $name
 * @property int $created_at
 * @property int $updated_at
 *
 * @property-read Book[] $books
 */
class Author extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%authors}}';
    }

    public function behaviors(): array
    {
        return [
            TimestampBehavior::class
        ];
    }

    public static function create(AuthorDto $dto): self
    {
        $model = new self();
        $model->name = $dto->name;

        return $model;
    }

    public function edit(AuthorDto $dto): void
    {
        $this->name = $dto->name;
    }

    public function getBookAuthors(): ActiveQuery
    {
        return $this->hasMany(BookAuthor::class, ['author_id' => 'id']);
    }

    public function getBooks(): ActiveQuery
    {
        return $this->hasMany(Book::class, ['id' => 'book_id'])
            ->via('bookAuthors');
    }

    public static function getList(): array
    {
        return self::find()->select(['name'])->indexBy('id')->column();
    }
}
