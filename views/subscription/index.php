<?php

use app\forms\SubscriptionForm;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var SubscriptionForm $model
 * @var array<int, string> $authors
 */

$this->title = 'Подписка на автора';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subscription-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'authorId')->dropDownList($authors, [
        'prompt' => 'Выберите автора',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Подписаться', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
