<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ThesisMapping */

$this->title = 'Create Thesis Mapping';
$this->params['breadcrumbs'][] = ['label' => 'Thesis Mappings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="thesis-mapping-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
