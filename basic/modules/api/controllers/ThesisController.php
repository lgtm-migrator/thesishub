<?php

namespace app\modules\api\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use app\models\Department;
use app\models\Thesis;

class ThesisController extends \app\modules\api\ApiController
{
    public function actionIndex()
    {
        // $departments = Department::find()->joinWith('theses')->all();
        return new \yii\data\ActiveDataProvider([
            'query' => \app\models\Thesis::find(),
            // 'departments' => $departments,
        ]);
    }

    public function actionThesis()
    {
        return new ActiveDataProvider([
            'query' => Department::find(),
        ]);
    }
    public function actionCreate()
    {
        $model = new Thesis();

        $data = Yii::$app->request->post();
        foreach ($data as $key => $value) {
            $model->$key = $value;
        }

        if ($model->save())
            return ['message' => 'ok', 'data' => $model];

        return [
            'message' => 'error', 
            'error' => $model->getErrors(),
            'data' => Yii::$app->request->post()
            ];
    }
}
