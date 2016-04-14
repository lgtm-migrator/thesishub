<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Thesis */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="thesis-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'thesis_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'intro')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'score_instructor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'score_reviewer')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'score_council')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'score_total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'have_disk')->textInput() ?>

    <?= $form->field($model, 'counter')->textInput() ?>

    <?= $form->field($model, 'created')->textInput() ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
