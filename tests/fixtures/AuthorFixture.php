<?php

declare(strict_types=1);

namespace app\tests\fixtures;

use app\models\Author;
use yii\test\ActiveFixture;

class AuthorFixture extends ActiveFixture
{
    public $modelClass = Author::class;
    public $dataFile = '@tests/_data/author.php';
}
