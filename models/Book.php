<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $title
 * @property int $year
 * @property string|null $description
 * @property int|null $isbn
 * @property int|null $photo
 * @property int $created_at
 * @property int $updated_at
 *
 * @property-read Author[] $authors
 */
class Book extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%books}}';
    }

    public function getBookAuthors(): ActiveQuery
    {
        return $this->hasMany(BookAuthor::class, ['book_id' => 'id']);
    }

    public function getAuthors(): ActiveQuery
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])
            ->via('bookAuthors');
    }
}
