<?php

use app\forms\BookForm;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var BookForm $model
 * @var array<int, string> $authors
 */

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
