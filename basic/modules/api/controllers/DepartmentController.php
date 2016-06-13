<?php

namespace app\modules\api\controllers;

use app\models\Department;

class DepartmentController extends \app\modules\api\ApiController
{
    public function actionIndex($id = null)
    {
    	if ($id) 
    		return (new \yii\db\Query())
                  ->select('u.name,tm.type, t.*,a.name as filename')
                  ->from('Thesis t')
                  ->join('inner join','ThesisMapping tm','t.thesis_id = tm.thesis_id')
                  ->join('inner join','User u','tm.user_id = u.user_id')
                  ->join('inner join','Attachment a','a.thesis_id = t.thesis_id')
                  ->where([
                  	'`tm`.`type`' => 'upload',
                  			't.department_id'=> $id])
                  ->all();
    	else 
    		return Department::find()->all();
    }
  
}
