<?php

namespace app\modules\api\controllers;

use app\models\Department;

class DepartmentController extends \app\modules\api\ApiController
{
    public function actionIndex($id = null)
    {
    	if ($id) 
    		return Department::find()->where(['department_id' => $id])->one();
    	else 
    		return $query = Department::find()->all();
    }
  
}
