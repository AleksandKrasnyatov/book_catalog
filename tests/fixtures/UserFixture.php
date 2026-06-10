<?php

declare(strict_types=1);

namespace tests\fixtures;

use app\Infrastructure\Persistence\ActiveRecord\User;
use yii\test\ActiveFixture;

final class UserFixture extends ActiveFixture
{
    public $modelClass = User::class;
    public $dataFile = '@tests/_data/user.php';
}
