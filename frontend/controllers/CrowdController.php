<?php

namespace frontend\controllers;

use Yii;
use common\models\Crowd;
use common\models\CrowdSearch;
use yii\db\Expression;
use yii\filters\Cors;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CrowdController implements the CRUD actions for Crowd model.
 */
class CrowdController extends Controller
{
    /**
     * {@inheritdoc}
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
            // For cross-domain AJAX request
            'cors' => [
                'class' => Cors::className(),
                'actions' => [
                    'get-trusties' => [
                        'Origin' => ['*'],
                        'Access-Control-Request-Method' => ['POST'],
                        'Access-Control-Request-Headers' => ['*'],
                        'Access-Control-Allow-Credentials' => null,
                        'Access-Control-Max-Age' => 86400,
                        'Access-Control-Expose-Headers' => [],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Crowd models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CrowdSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGetTrusties()
    {
        $crowds = Crowd::find()
            ->joinWith('reports')
            ->select(['crowd.*', 'report.created_at'])
            ->andWhere(['>=', 'reports_count', Crowd::$REPORTS_TRUST_NUMBER])
            ->andWhere(['>=', 'report.created_at', new Expression('DATE_SUB(NOW(), INTERVAL 12 HOUR)')])->all();
        return $this->asJson(['code' => 200, 'message' => 'OK', 'data' => $crowds]);
    }

    /**
     * Updates an existing Crowd model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    /**
     * Finds the Crowd model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Crowd the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Crowd::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
