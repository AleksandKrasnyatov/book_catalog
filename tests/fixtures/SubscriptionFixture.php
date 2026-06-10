<?php

declare(strict_types=1);

namespace tests\fixtures;

use app\Infrastructure\Persistence\ActiveRecord\SubscriptionRecord;
use yii\test\ActiveFixture;

final class SubscriptionFixture extends ActiveFixture
{
    public $modelClass = SubscriptionRecord::class;
    public $dataFile = '@tests/_data/subscription.php';
}
