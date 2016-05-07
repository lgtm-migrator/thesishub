<?php

namespace app\modules\api\controllers;

use Yii;
use app\models\LoginForm;
use app\modules\api\ApiController;

class AuthController extends ApiController
{
    public function actionIndex()
    {
        return ['message' => 'Auth api.'];
    }

    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->login()) {
            return ['access_token' => Yii::$app->user->identity->getAuthKey()];
        } else {
            $model->validate();
            return $model;
        }
    }

}
