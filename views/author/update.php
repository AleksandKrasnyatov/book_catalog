<?php

use app\forms\AuthorForm;
use app\models\Author;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var AuthorForm $model
 * @var Author $author
 */

$this->title = 'Update Author: ' . $author->name;
$this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $author->name, 'url' => ['view', 'id' => $author->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="author-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
