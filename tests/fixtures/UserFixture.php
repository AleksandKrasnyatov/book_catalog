<?php

declare(strict_types=1);

namespace app\tests\fixtures;

use app\models\User;
use yii\test\ActiveFixture;

class UserFixture extends ActiveFixture
{
    public $modelClass = User::class;
    public $dataFile = '@tests/_data/user.php';
}
