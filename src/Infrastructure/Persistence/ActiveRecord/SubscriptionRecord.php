<?php

declare(strict_types=1);

namespace app\Infrastructure\Persistence\ActiveRecord;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $author_id
 * @property string $phone
 * @property int $created_at
 */
final class SubscriptionRecord extends ActiveRecord
{
    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false,
            ],
        ];
    }

    public static function tableName(): string
    {
        return '{{%subscriptions}}';
    }
}

