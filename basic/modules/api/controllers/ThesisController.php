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
              'tags' => (new \yii\db\Query())
                  ->select('b.name')
                  ->from('ThesisTag a')
                  ->join('inner join','Tag b','a.tag_id = b.tag_id')
                  ->where(['`a`.`thesis_id`' => $id])
                  ->all(),
              'comments' => (new \yii\db\Query())
                  ->select('c.*,u.name')
                  ->from('Comment c')
                  ->join('inner join','User u', 'u.user_id = c.user_id')
                  ->where(['`c`.`thesis_id`' => $id])
                  ->all(),
              'refs' => (new \yii\db\Query())
                  ->select('r.*')
                  ->from('ThesisReference tr')
                  ->join('inner join','Reference r','tr.ref_id = r.ref_id')
                  ->where(['`tr`.`thesis_id`' => $id])
                  ->all(),
              'maps' => (new \yii\db\Query())
                  ->select('u.name,tm.type')
                  ->from('ThesisMapping tm')
                  ->join('inner join','User u','tm.user_id = u.user_id')
                  ->where(['`tm`.`thesis_id`' => $id])
                  ->all(),
              'reccs' => (new \yii\db\Query())
                  ->select('t.thesis_id, t.thesis_name')->distinct()->limit(3)
                  ->from('Thesis t')
                  ->join('inner join','ThesisTag tt','t.thesis_id = tt.thesis_id')
                  ->where('tag_id in (select tag_id 
                                  from ThesisTag
                                  where thesis_id= :id)
                          and t.thesis_id != :id',[':id' => $id])
                  ->orderBy(['t.score_total' => SORT_DESC])
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
