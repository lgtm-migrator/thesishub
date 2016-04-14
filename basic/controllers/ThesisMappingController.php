<?php

namespace app\controllers;

use Yii;
use app\models\ThesisMapping;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ThesisMappingController implements the CRUD actions for ThesisMapping model.
 */
class ThesisMappingController extends Controller
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
     * Lists all ThesisMapping models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ThesisMapping::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ThesisMapping model.
     * @param integer $thesis_id
     * @param integer $user_id
     * @return mixed
     */
    public function actionView($thesis_id, $user_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($thesis_id, $user_id),
        ]);
    }

    /**
     * Creates a new ThesisMapping model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ThesisMapping();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'thesis_id' => $model->thesis_id, 'user_id' => $model->user_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ThesisMapping model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $thesis_id
     * @param integer $user_id
     * @return mixed
     */
    public function actionUpdate($thesis_id, $user_id)
    {
        $model = $this->findModel($thesis_id, $user_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'thesis_id' => $model->thesis_id, 'user_id' => $model->user_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ThesisMapping model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $thesis_id
     * @param integer $user_id
     * @return mixed
     */
    public function actionDelete($thesis_id, $user_id)
    {
        $this->findModel($thesis_id, $user_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ThesisMapping model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $thesis_id
     * @param integer $user_id
     * @return ThesisMapping the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($thesis_id, $user_id)
    {
        if (($model = ThesisMapping::findOne(['thesis_id' => $thesis_id, 'user_id' => $user_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
