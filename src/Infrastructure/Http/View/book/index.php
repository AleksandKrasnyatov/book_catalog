<?php

/**
 * @var View $this
 * @var BookSearchForm $searchModel
 * @var PaginatedResult $result
 * @var array<int, string> $authors
 */

use app\Application\UseCase\Query\Book\Model\BookView;
use app\Application\UseCase\Query\Book\Model\PaginatedResult;
use app\Infrastructure\Http\Form\BookSearchForm;
use yii\data\ArrayDataProvider;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

$this->title = 'Books';
$this->params['breadcrumbs'][] = $this->title;

$dataProvider = new ArrayDataProvider([
    'allModels' => $result->items,
    'pagination' => false,
    'key' => static fn(BookView $model): int => $model->id,
]);

?>
<div class="book-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Book', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="mb-3">
        <?php $form = ActiveForm::begin([
            'method' => 'get',
        ]); ?>

        <?= $form->field($searchModel, 'title')->textInput(['placeholder' => 'Title'])->label(false) ?>

        <?= $form->field($searchModel, 'year')->textInput(['placeholder' => 'Year'])->label(false) ?>

        <?= $form->field($searchModel, 'authorId')->dropDownList($authors, [
            'prompt' => 'Автор',
        ])->label(false) ?>

        <div class="form-group">
            <?= Html::submitButton('Search', ['class' => 'btn btn-secondary']) ?>
            <?= Html::a('Reset', ['index'], ['class' => 'btn btn-outline-secondary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => ActionColumn::class],
            'id',
            'title',
            'year',
            'isbn',
            [
                'label' => 'Фото',
                'format' => 'raw',
                'value' => static function (BookView $model): string {
                    if ($model->photoUrl === null) {
                        return Html::tag('span', '—', ['class' => 'text-muted']);
                    }

                    return Html::img($model->photoUrl, [
                        'alt' => $model->title,
                        'style' => 'max-width: 80px; height: auto;',
                    ]);
                },
            ],
            [
                'label' => 'Авторы',
                'value' => static fn(BookView $model): string => implode(', ', $model->authors),
            ],
        ],
    ]) ?>
</div>
