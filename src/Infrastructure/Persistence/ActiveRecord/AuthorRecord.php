<?php

declare(strict_types=1);

namespace app\Infrastructure\Persistence\ActiveRecord;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $name
 * @property int $created_at
 * @property int $updated_at
 */
final class AuthorRecord extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%authors}}';
    }
}

