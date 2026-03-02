<?php

use app\models\Book;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/**
 * @var View $this
 * @var Book $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$authors = array_map(static fn($author) => $author->name, $model->authors);
?>
<div class="book-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'year',
            'isbn',
            [
                'attribute' => 'photo',
                'format' => 'raw',
                'value' => static function (Book $model) {
                    if (!$model->photo) {
                        return Html::tag('span', '—', ['class' => 'text-muted']);
                    }
                    return Html::img('@web/photos/' . $model->photo, [
                        'alt' => $model->title,
                        'style' => 'max-width: 260px; height: auto;',
                    ]);
                },
            ],
            'description:ntext',
            [
                'label' => 'Authors',
                'value' => implode(', ', $authors),
            ],
        ],
    ]) ?>
</div>
