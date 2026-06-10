<?php

/**
 * @var View $this
 * @var BookForm $model
 * @var array<int, string> $authors
 */

use app\Infrastructure\Http\Form\BookForm;
use yii\helpers\Html;
use yii\web\View;

$this->title = 'Create Book';
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'authors' => $authors,
    ]) ?>
</div>
