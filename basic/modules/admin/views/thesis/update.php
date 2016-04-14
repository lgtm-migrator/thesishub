<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Thesis */

$this->title = 'Update Thesis: ' . $model->thesis_id;
$this->params['breadcrumbs'][] = ['label' => 'Theses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->thesis_id, 'url' => ['view', 'id' => $model->thesis_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="thesis-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
