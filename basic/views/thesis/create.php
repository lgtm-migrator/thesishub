<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Thesis */

$this->title = 'Create Thesis';
$this->params['breadcrumbs'][] = ['label' => 'Theses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="thesis-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
