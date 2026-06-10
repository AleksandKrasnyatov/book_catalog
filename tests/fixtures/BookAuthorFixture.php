<?php

declare(strict_types=1);

namespace tests\fixtures;

use app\Infrastructure\Persistence\ActiveRecord\BookAuthorRecord;
use yii\test\ActiveFixture;

final class BookAuthorFixture extends ActiveFixture
{
    public $modelClass = BookAuthorRecord::class;
    public $dataFile = '@tests/_data/book_author.php';
}
