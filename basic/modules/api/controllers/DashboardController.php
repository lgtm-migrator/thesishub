<?php

namespace app\modules\api\controllers;

use Yii;
use yii\filters\auth\HttpBearerAuth;
use app\modules\api\ApiController;
use app\models\ThesisMapping;

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
				$thesis = ThesisMapping::find()->where(['user_id'=>Yii::$app->user->identity->id])->with('thesis')->all();

				$response = [
						'user' => Yii::$app->user->identity,
						'thesis' => $thesis,
            'username' => Yii::$app->user->identity->username,
            'access_token' => Yii::$app->user->identity->getAuthKey(),
        ];

        return $response;
    }

}
