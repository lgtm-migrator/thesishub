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
use app\models\Comment;
use app\models\Rating;

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
                  ->orderBy(['c.created' => SORT_DESC])
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
              'ratings' => (new \yii\db\Query())
                  ->select('r.user_id,r.star')
                  ->from('Rating r')
                  ->where(['`r`.`thesis_id`' => $id])
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

    public function actionComment()
    {
    $model = new Comment();

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

    public function actionRating()
    {
      // $data = Yii::$app->request->post()['thesis_id'];

      // $rating = Rating::find()->where(['name' => $v])->one();
      // $model = new Rating();

      
      // foreach ($data as $key => $value) {
      //     $model->$key = $value;
      // }

      // if ($model->save())
      //     return ['message' => 'ok', 'data' => $model];

      // $thesis = Thesis::find()->where(['thesis_id' => $id])->one();


      return [
          'message' => 'error', 
          'error' => $model->getErrors(),
          'data' => Yii::$app->request->post()
          ];
    }


}
