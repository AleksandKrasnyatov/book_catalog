<?php

/**
 * @var View $this
 * @var BookView $model
 */

use app\Application\UseCase\Query\Book\Model\BookView;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
                'label' => 'Фото',
                'format' => 'raw',
                'value' => static function ($model): string {
                    if ($model->photoUrl === null) {
                        return Html::tag('span', '—', ['class' => 'text-muted']);
                    }

                    return Html::img($model->photoUrl, [
                        'alt' => $model->title,
                        'style' => 'max-width: 260px; height: auto;',
                    ]);
                },
            ],
            'description:ntext',
            [
                'label' => 'Authors',
                'value' => static fn($model): string => implode(', ', $model->authors),
            ],
        ],
    ]) ?>
</div>
