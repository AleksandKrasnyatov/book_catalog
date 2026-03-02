<?php

declare(strict_types=1);

namespace app\models;

use app\behaviors\NotifySubscribersBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $book_id
 * @property int $author_id
 *
 * @property-read Book $book
 * @property-read Author $author
 */
class BookAuthor extends ActiveRecord
{
    public function behaviors(): array
    {
        return [
            NotifySubscribersBehavior::class,
        ];
    }

    public static function tableName(): string
    {
        return '{{%book_author}}';
    }

    public function getBook(): ActiveQuery
    {
        return $this->hasOne(Book::class, ['id' => 'book_id']);
    }

    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(Author::class, ['id' => 'author_id']);
    }
}
