<?php

use app\forms\AuthorForm;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var AuthorForm $model
 */


$this->title = 'Create Author';
$this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
