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
            // 'query' => (new \yii\db\Query())
            //       ->select('u.name,tm.type, t.*')
            //       ->from('Thesis t')
            //       ->join('inner join','ThesisMapping tm','t.thesis_id = tm.thesis_id')
            //       ->join('inner join','User u','tm.user_id = u.user_id')
            //       ->where(['`tm`.`type`' => 'upload'])
            //       ->all(),
        ];
    }

    public function actionThesis($id = null)
    {
        if ($id != null) {
          $thesis = Thesis::find()->where(['thesis_id'=>$id])->one();
          if($thesis)
          {
            $thesis->counter+=1;
            $thesis->save();
          }
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
                  ->select('r.name, r.url, r.author, r.year, r.detail')
                  ->from('ThesisReference tr')
                  ->join('inner join','Reference r','tr.ref_id = r.ref_id')
                  ->where(['`tr`.`thesis_id`' => $id])
                  ->all(),
              'maps' => (new \yii\db\Query())
                  ->select('u.name,tm.type,u.user_id')
                  ->from('ThesisMapping tm')
                  ->join('inner join','User u','tm.user_id = u.user_id')
                  ->where(['`tm`.`thesis_id`' => $id])
                  ->all(),
              'users' => (new \yii\db\Query())
                  ->select('tm.type,tm.user_id')
                  ->from('ThesisMapping tm')
                  ->where(['`tm`.`thesis_id`' => $id])
                  ->all(),
              'files' => (new \yii\db\Query())
                  ->select('at.name, at.description, at.type, at.url, at.limitation, at.visible')
                  ->from('Attachment at')
                  ->where(['`at`.`thesis_id`' => $id])
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
                    $ref_find = Reference::find()->where(['name' => $ref->name,
                                                            'url' => $ref->url,
                                                            'author' => $ref->author,
                                                            'year' => $ref->year])->one();
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
                'data' => $model,
                'thesis_id' => $model->thesis_id
                ];

        }
        return [
            'message' => 'error', 
            'error' => $model->getErrors(),
            'data' => Yii::$app->request->post()['thesis']
            ];
    }

    public function actionUpdate($id)
    {
        $model = Thesis::find()->where(['thesis_id' => $id])->one();
        $data = Yii::$app->request->post()['thesis'];
        foreach ($data as $key => $value) {
            $model->$key = $value;
        }


        if ($model->save()){
            $thesis_tag_del = ThesisTag::find()->where(['thesis_id' => $model->thesis_id])->all();
            if($thesis_tag_del){
                foreach ($thesis_tag_del as $del) {
                    $del->delete();
                }
            }
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
        
            $thesis_map_del = ThesisMapping::find()->where(['thesis_id' => $model->thesis_id])->all();
            if($thesis_map_del){
                foreach ($thesis_map_del as $del) {
                    $del->delete();
                }
            }
            $users = Yii::$app->request->post()['users'];
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
           
            $thesis_reference_del = ThesisReference::find()->where(['thesis_id' => $model->thesis_id])->all();
            if($thesis_reference_del){
                foreach ($thesis_reference_del as $del) {
                    $del->delete();
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
                    $ref_find = Reference::find()->where(['name' => $ref->name,
                                                            'url' => $ref->url,
                                                            'author' => $ref->author,
                                                            'year' => $ref->year])->one();
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

            $files_del = Attachment::find()->where(['thesis_id' => $model->thesis_id])->all();
            if($files_del){
                foreach ($files_del as $del) {
                    $del->delete();
                }
            }
            $files = Yii::$app->request->post()['files'];
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
                'data' => Yii::$app->request->post()['thesis'],
                'thesis_id' => $model->thesis_id
                ];

        }
        return [
            'message' => 'error', 
            'error' => $model->getErrors(),
            'data' => Yii::$app->request->post()['thesis']
            ];
    }

    public function actionDelete($id)
    {
        $ref = ThesisReference::find()->where(['thesis_id' => $id])->all();
        if($ref){
            foreach ($ref as $key) {
                $key->delete();
            }
        }
        $atts = Attachment::find()->where(['thesis_id' => $id])->all();
        if($atts){
            foreach ($atts as $key) {
                $key->delete();
            }
        }
        $maps = ThesisMapping::find()->where(['thesis_id' => $id])->all();
        if($maps){
            foreach ($maps as $key) {
                $key->delete();
            }
        }

        $tags = ThesisTag::find()->where(['thesis_id' => $id])->all();
        if($tags){
            foreach ($tags as $key) {
                $key->delete();
            }
        }
        $thesis = Thesis::find()->where(['thesis_id' => $id])->one()->delete();
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
      $data = Yii::$app->request->post();

      $rating = Rating::find()->where(['thesis_id' => $data['thesis_id'],
                                      'user_id' => $data['user_id']])
                                      ->one();
      $isNew = 0;
      if($rating == null)
      {
        $rating = new Rating();
        $rating->thesis_id = $data['thesis_id'];
        $rating->user_id = $data['user_id'];
        $isNew=1;
      }

      $rating->star = $data['rate_now'];

      if ($rating->save())
      {
        $thesis=Thesis::find()->where(['thesis_id'=>$data['thesis_id']])->one();
        if($isNew==1)
          $thesis->star_rate_count +=1;
        $thesis->star_rate = end((new \yii\db\Query())
                        ->select('sum(star)/count(star)')
                        ->from('Rating')
                        ->where(['thesis_id' => $data['thesis_id']])
                        ->one());
        $thesis->save();
          return ['message' => 'ok', 'data' => $rating];
      }

      return [
          'message' => 'error', 
          'error' => $rating->getErrors(),
          'data' => Yii::$app->request->post()
          ];
    }

    public function actionSearch($skey)
    {
      $skey = json_decode($skey);
      $tags = (new \yii\db\Query())
                  ->select('t.*')
                  ->from('ThesisTag a')
                  ->join('inner join','Tag b','a.tag_id = b.tag_id')
                  ->join('inner join','Thesis t','t.thesis_id = a.thesis_id')
                  ->where(
                      ['or like', 'name', $skey]
                  );

      $thesis = (new \yii\db\Query())
                  ->select('*')
                  ->from('Thesis')
                  ->where(
                      ['or like', 'thesis_name', $skey]
                  );

      return $tags->union($thesis)->all();
    }

    public function actionTag()
    {
      $deps = (new \yii\db\Query())
              ->select('department_id')
              ->from('Department')
              ->all();

      $tag = null;
      
      foreach ($deps as $dep) {
        $new = (new \yii\db\Query())
                  ->select('t.department_id,ta.* , count(ta.tag_id) as count')->limit(14)
                  ->from('Thesis t')
                  ->join('inner join','ThesisTag tt','t.thesis_id = tt.thesis_id')
                  ->join('inner join','Tag ta','tt.tag_id = ta.tag_id')
                  ->where(['t.department_id'=> $dep])
                  ->groupBy('ta.tag_id')
                  ->orderBy(['count' => SORT_DESC]);
        if($tag == null)
          $tag = $new;   
        else
          $tag->union($new)->all();
      }

      return $tag->all();
    }

    public function actionByme($uid)
    {
      return (new \yii\db\Query())
                  ->select('t.thesis_name,t.created,t.counter')
                  ->from('Thesis t')
                  ->join('inner join','ThesisMapping tm','tm.thesis_id = t.thesis_id')
                  ->where(['`tm`.`user_id`' => $uid,
                            'tm.type' => 'upload'])
                  ->all();
    }




}
