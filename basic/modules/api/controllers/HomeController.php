<?php

namespace app\modules\api\controllers;

use yii\data\ActiveDataProvider;
use app\models\Department;
use app\models\Thesis;

class HomeController extends \app\modules\api\ApiController
{
    public function actionIndex()
    {
    	$departments = Department::find()->joinWith('theses')->all();

        return [
        	'departments' => $departments,
        ];
    }

    public function actionThesis()
    {
    	return new ActiveDataProvider([
            'query' => Department::find(),
        ]);
    }
}
