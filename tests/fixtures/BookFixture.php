<?php

declare(strict_types=1);

namespace tests\fixtures;

use app\Infrastructure\Persistence\ActiveRecord\BookRecord;
use yii\test\ActiveFixture;

final class BookFixture extends ActiveFixture
{
    public $modelClass = BookRecord::class;
    public $dataFile = '@tests/_data/book.php';
}
