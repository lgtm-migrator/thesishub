<?php

namespace app\controllers;

use Yii;
use app\models\Department;
use app\models\Thesis;
use app\models\DepartmentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * HomeController implements the CRUD actions for Department model.
 */
class HomeController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Department models.
     * @return mixed
     */
    public function GetThesisByDepartment(){
        return Thesis::find()
                        ->select('thesis_name')
                        ->joinWith('department', '`department`.`department_id` = `thesis`.`department_id`')
                        ->orderBy('`thesis_id` desc')
                        ->all();

    }
    
    public function actionIndex()
    {

        return $this->renderContent(null);

        // $department = Department::find()->all();
        // $mostIDthesis = $this->GetThesisByDepartment();

        // return $this->render('index',['department'=>$department,'mostIDthesis'=>$mostIDthesis]);
    }

}
