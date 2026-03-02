<?php

declare(strict_types=1);

use app\forms\TopAuthorsReportSearchForm;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var TopAuthorsReportSearchForm $searchModel
 * @var ActiveDataProvider $dataProvider
 */

$this->title = 'Отчет: Топ-10 авторов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-top-authors">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="mb-3">
        <?php $form = ActiveForm::begin([
            'method' => 'get',
        ]); ?>

        <?= $form->field($searchModel, 'year')
            ->textInput(['placeholder' => 'Год', 'type' => 'number'])
            ->label(false) ?>

        <div class="form-group">
            <?= Html::submitButton('Показать', ['class' => 'btn btn-secondary']) ?>
            <?= Html::a('Сбросить', ['top-authors'], ['class' => 'btn btn-outline-secondary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'name',
            [
                'attribute' => 'booksCount',
                'label' => 'Количество книг',
            ],
        ],
    ]) ?>
</div>
