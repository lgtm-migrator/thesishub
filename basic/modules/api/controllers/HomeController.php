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

        $recent_thesis = Thesis::find()
                            ->select('thesis_name, created')
                            ->orderBy('created desc')
                            ->limit(5)
                            ->all();

        $score_thesis = Thesis::find()
                            ->select('thesis_name, created')
                            ->orderBy('score_total desc')
                            ->limit(5)
                            ->all();                    


        return [
        	'departments' => $departments,
            'recent_thesis' => $recent_thesis,
            'score_thesis' => $score_thesis,
        ];
    }

    public function actionThesis()
    {
    	return new ActiveDataProvider([
            'query' => Department::find(),
        ]);
    }
}
