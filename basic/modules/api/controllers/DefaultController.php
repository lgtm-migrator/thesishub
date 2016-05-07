<?php

namespace app\modules\api\controllers;

use yii\web\Controller;
use app\modules\api\ApiController;

/**
 * Default controller for the `api` module
 */
class DefaultController extends ApiController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return ['message' => 'thesishub api.'];
    }
}
