<?php

declare(strict_types=1);

namespace app\Infrastructure\Persistence\ActiveRecord;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $book_id
 * @property int $author_id
 */
final class BookAuthorRecord extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%book_author}}';
    }
}
