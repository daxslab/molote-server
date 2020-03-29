<?php

namespace frontend\controllers;

use common\models\Crowd;
use Yii;
use common\models\Report;
use common\models\CrowdSearch;
use yii\filters\Cors;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReportController implements the CRUD actions for Report model.
 */
class ReportController extends Controller
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
                    'create' => [
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
     * Creates a new Report model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCreate()
    {
        $reportModel = new Report();

        if (isset(Yii::$app->request->post()['lat']) && isset(Yii::$app->request->post()['lng']) && isset(Yii::$app->request->post()['uuid'])) {
            $lat = Yii::$app->request->post()['lat'];
            $lng = Yii::$app->request->post()['lng'];
            $reportModel->location = "{\"type\":\"Point\",\"coordinates\":[{$lat},{$lng}]}";
            $reportModel->device_uuid = Yii::$app->request->post()['uuid'];

            $sameReport = Report::find()->where(['device_uuid' => $reportModel->device_uuid])->nearest($reportModel->location, 'location', Crowd::$CROWD_RADIUS)->one();
            if (!empty($sameReport)){
                return $this->asJson(['status' => 403, 'errorCode' => 5, 'message' => 'You can\'t create two reports of the same crowd']);
            }

            $reportModel->additional_data = isset(Yii::$app->request->post()['additional_data']) ? Yii::$app->request->post()['additional_data'] : null;

            $nearestCrowd = Crowd::find()->nearest($reportModel->location, 'location', Crowd::$CROWD_RADIUS)->one();
            if (empty($nearestCrowd)) {
                $nearestCrowd = new Crowd();
                $nearestCrowd->location = $reportModel->location;
                $nearestCrowd->reports_count = 0;
                $nearestCrowd->save();
            }
            $reportModel->crowd_id = $nearestCrowd->id;
            $reportModel->save();

            $nearestCrowd->reports_count++;
            $nearestCrowd->save();

            return $this->asJson(['status' => 200, 'message' => 'Report Created Successfully']);
        }

        return $this->asJson(['status' => 400, 'message' => 'Bad Request', 'data' => Yii::$app->request]);
    }


    /**
     * Finds the Report model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Report the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Report::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if ($action->id == 'create') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }
}