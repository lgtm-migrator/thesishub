<?php

namespace app\modules\api\controllers;

use Yii;
use yii\filters\auth\HttpBearerAuth;
use app\modules\api\ApiController;

class DashboardController extends ApiController
{
	public function behaviors() {
		$behaviors = parent::behaviors();

		$behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'only' => ['index'],
        ];

        return $behaviors;
	}

    public function actionIndex()
    {
        $response = [
            'username' => Yii::$app->user->identity->username,
            'access_token' => Yii::$app->user->identity->getAuthKey(),
        ];

        return $response;
    }

}
