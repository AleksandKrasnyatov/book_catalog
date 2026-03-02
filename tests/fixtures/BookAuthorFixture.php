<?php

declare(strict_types=1);

namespace app\tests\fixtures;

use app\models\BookAuthor;
use yii\test\ActiveFixture;

class BookAuthorFixture extends ActiveFixture
{
    public $modelClass = BookAuthor::class;
    public $dataFile = '@tests/_data/book_author.php';
}
