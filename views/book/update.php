<?php

use app\forms\BookForm;
use app\models\Book;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var BookForm $model
 * @var Book $book
 * @var array<int, string> $authors
 */

$this->title = "Редактирование: {$book->title}";
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $book->title, 'url' => ['view', 'id' => $book->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="book-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'authors' => $authors,
    ]) ?>
</div>
