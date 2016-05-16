<?php

namespace app\modules\api\controllers;

class ThesisController extends \app\modules\api\ApiController
{
    public function actionIndex()
    {
        return new \yii\data\ActiveDataProvider([
            'query' => \app\models\Thesis::find(),
        ]);
    }
  
}
