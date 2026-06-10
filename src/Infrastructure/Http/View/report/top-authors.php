<?php

declare(strict_types=1);

/**
 * @var View $this
 * @var TopAuthorsReportForm $searchModel
 * @var TopAuthorRow[] $rows
 */

use app\Application\UseCase\Query\Report\Model\TopAuthorRow;
use app\Infrastructure\Http\Form\TopAuthorsReportForm;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

$this->title = 'Отчет: Топ-10 авторов';
$this->params['breadcrumbs'][] = $this->title;

$dataProvider = new ArrayDataProvider([
    'allModels' => $rows,
    'pagination' => false,
]);
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
