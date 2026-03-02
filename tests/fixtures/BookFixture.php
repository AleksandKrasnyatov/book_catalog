<?php

declare(strict_types=1);

namespace app\tests\fixtures;

use app\models\Book;
use yii\test\ActiveFixture;

class BookFixture extends ActiveFixture
{
    public $modelClass = Book::class;
    public $dataFile = '@tests/_data/book.php';
}
