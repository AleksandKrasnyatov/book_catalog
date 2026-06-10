<?php

declare(strict_types=1);

namespace app\Infrastructure\Persistence\ActiveRecord;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $title
 * @property int $year
 * @property string|null $description
 * @property string|null $isbn
 * @property string|null $photo
 * @property int $created_at
 * @property int $updated_at
 */
final class BookRecord extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%books}}';
    }
}

