<?php

/**
 * @var View $this
 * @var BookForm $model
 * @var BookView $book
 * @var array<int, string> $authors
 */

use app\Application\UseCase\Query\Book\Model\BookView;
use app\Infrastructure\Http\Form\BookForm;
use yii\helpers\Html;
use yii\web\View;

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
