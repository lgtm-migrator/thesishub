<?php

namespace app\modules\api\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use app\models\Department;
use app\models\Thesis;
use app\models\ThesisMapping;
use app\models\User;


class ThesisController extends \app\modules\api\ApiController
{
    public function actionIndex()
    {
        return [
            'query' => Thesis::find()->all(),
        ];
    }

    public function actionThesis($id = null)
    {
        if ($id != null) {
            return [
                'detail'=> Thesis::find()->where(['thesis_id' => $id])->one(),
                'map' => (new \yii\db\Query())
                    ->select('u.name')
                    ->from('ThesisMapping tm')
                    ->join('inner join','User u','tm.user_id = u.user_id')
                    ->where(['type' => 'creator','`tm`.`thesis_id`' => $id])
                    ->one(),
                'tags' => (new \yii\db\Query())
                    ->select('b.name')
                    ->from('ThesisTag a')
                    ->join('inner join','Tag b','a.tag_id = b.tag_id')
                    ->where(['`a`.`thesis_id`' => $id])
                    ->all(),    
            ];
        }

        return new ActiveDataProvider([
            'query' => Thesis::find(),
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
