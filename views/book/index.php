<?php

use app\forms\BookSearchForm;
use app\models\Book;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 * @var BookSearchForm $searchModel
 * @var array<int, string> $authors
 */

$this->title = 'Books';
$this->params['breadcrumbs'][] = $this->title;
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
                'value' => static function (Book $model) {
                    if (!$photoUrl = $model->getPhotoUrl()) {
                        return Html::tag('span', '—', ['class' => 'text-muted']);
                    }
                    return Html::img($photoUrl, [
                        'alt' => $model->title,
                        'style' => 'max-width: 80px; height: auto;',
                    ]);
                },
            ],
            [
                'label' => 'Авторы',
                'value' => static function (Book $model) {
                    $names = array_map(static fn($author) => $author->name, $model->authors);
                    return implode(', ', $names);
                },
            ],
        ],
    ]) ?>
</div>
