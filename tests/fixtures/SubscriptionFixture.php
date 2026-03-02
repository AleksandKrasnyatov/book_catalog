<?php

declare(strict_types=1);

namespace app\tests\fixtures;

use app\models\Subscription;
use yii\test\ActiveFixture;

class SubscriptionFixture extends ActiveFixture
{
    public $modelClass = Subscription::class;
    public $dataFile = '@tests/_data/subscription.php';
}
