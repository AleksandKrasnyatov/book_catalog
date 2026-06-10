<?php

/**
 * @var View $this
 * @var AuthorSearchForm $searchModel
 * @var PaginatedResult $result
 */

use app\Application\UseCase\Query\Author\Model\AuthorView;
use app\Application\UseCase\Query\Book\Model\PaginatedResult;
use app\Infrastructure\Http\Form\AuthorSearchForm;
use yii\data\ArrayDataProvider;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

$this->title = 'Authors';
$this->params['breadcrumbs'][] = $this->title;

$dataProvider = new ArrayDataProvider([
    'allModels' => $result->items,
    'pagination' => false,
    'key' => static fn(AuthorView $model): int => $model->id,
]);

?>
<div class="author-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Author', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="mb-3">
        <?php $form = ActiveForm::begin([
            'method' => 'get',
        ]); ?>

        <?= $form->field($searchModel, 'name')->textInput(['placeholder' => 'Search by name'])->label(false) ?>

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
            'name',
        ],
    ]) ?>
</div>
