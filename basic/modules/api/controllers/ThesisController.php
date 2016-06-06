<?php

namespace app\modules\api\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use app\models\Department;
use app\models\Thesis;
use app\models\Tag;
use app\models\ThesisTag;
use app\models\Reference;
use app\models\ThesisReference;
use app\models\ThesisMapping;
use app\models\User;
use app\models\Attachment;

class ThesisController extends \app\modules\api\ApiController
{
    public function actionIndex()
    {
        return [
            'query' => Thesis::find()->all(),
            'users' => User::find()->all(),   
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

        $data = Yii::$app->request->post()['thesis'];
        foreach ($data as $key => $value) {
            $model->$key = $value;
        }

        // return ['save reference ' => 'Loi save','data' => $model];
        if ($model->save()){

            $data_thesis = Yii::$app->request->post()['thesis_tag'];
            if($data_thesis){
                foreach ($data_thesis as $ob) {
                 
                        foreach ($ob as $k => $v) {
                            $tag = Tag::find()->where(['name' => $v])->one();
                            if ($tag == null) {
                                $tag = new Tag();
                                $tag->$k = $v;
                                $tag->save();
                            }
                            $thesis_tag = new ThesisTag();
                            $thesis_tag->thesis_id = $model->thesis_id;
                            $thesis_tag->tag_id = $tag->tag_id;
                            $thesis_tag->save();
                    }
                     
                }
            }

            $users = Yii::$app->request->post()['users'];
            // return ['save reference ' => 'Loi','data' => $users];


            if($users){
                foreach ($users as $ob) {
                    $thesis_map = new ThesisMapping();
                    foreach ($ob as $k => $v) {                                
                                
                        $thesis_map->$k = $v;
                    }
                    $thesis_map->thesis_id = $model->thesis_id;
                    $thesis_map->save();                    
                }
                     
            }
           
            $reference = Yii::$app->request->post()['reference'];
            if($reference ){
            foreach ($reference as $ob) {
                $ref = new Reference();
                foreach ($ob as $k => $v) {
                    $ref->$k = $v;
                }
                $thesis_reference = new ThesisReference();
                    $ref_find = Reference::find()->where(['name' => $ref->name])->one();
                    if ($ref_find == null) {
                        $ref->save();
                        $thesis_reference->ref_id = $ref->ref_id;
                    }else{
                        $thesis_reference->ref_id = $ref_find->ref_id;
                    }
                    
                    $thesis_reference->thesis_id = $model->thesis_id;
                    
                    $thesis_reference->save();
                }
                
            }

            $files = Yii::$app->request->post()['files'];
            // return ['save reference ' => 'Loi','data' => $users];


            if($files){
                foreach ($files as $ob) {
                    $att = new Attachment();
                    foreach ($ob as $k => $v) {                                
                                
                        $att->$k = $v;
                    }
                    $att->thesis_id = $model->thesis_id;
                    $att->save();                    
                }
                     
            }

            return [
                'message' => 'ok', 
                'data' => Yii::$app->request->post()['thesis']
                ];

        }
        return [
            'message' => 'error', 
            'error' => $model->getErrors(),
            'data' => Yii::$app->request->post()['thesis']
            ];
    }
}
