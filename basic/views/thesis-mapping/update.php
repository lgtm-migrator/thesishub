<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ThesisMapping */

$this->title = 'Update Thesis Mapping: ' . $model->thesis_id;
$this->params['breadcrumbs'][] = ['label' => 'Thesis Mappings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->thesis_id, 'url' => ['view', 'thesis_id' => $model->thesis_id, 'user_id' => $model->user_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="thesis-mapping-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
