<?php
namespace app\controllers;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;


class HomeController extends Controller
{
    public function actionIndex()
    {
        $cat = \models\Cat()->find();
        
        return $this->render('index', 'cat' => $cat);
    }
    
    private function actionView() {
      
    }
}
