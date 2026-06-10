<?php

declare(strict_types=1);

namespace tests\fixtures;

use app\Infrastructure\Persistence\ActiveRecord\AuthorRecord;
use yii\test\ActiveFixture;

final class AuthorFixture extends ActiveFixture
{
    public $modelClass = AuthorRecord::class;
    public $dataFile = '@tests/_data/author.php';
}
