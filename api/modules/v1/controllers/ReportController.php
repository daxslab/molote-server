<?php

namespace api\modules\v1\controllers;


use common\models\Crowd;
use common\models\Report;
use Yii;
use yii\db\Expression;
use yii\web\BadRequestHttpException;
use yii\web\HttpException;

class ReportController extends BaseActiveController
{

    public $modelClass = 'common\models\Report';

    public function actions()
    {
        $actions = parent::actions();

        //allow only read actions
        unset($actions['create']);
        unset($actions['update']);
        unset($actions['delete']);

        return $actions;
    }

    /**
     * Creates a new Report model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     * @throws HttpException
     */
    public function actionCreate()
    {
        $reportModel = new Report();

        if (isset(Yii::$app->request->post()['lat']) && isset(Yii::$app->request->post()['lng']) && isset(Yii::$app->request->post()['uuid'])) {
            $lat = Yii::$app->request->post()['lat'];
            $lng = Yii::$app->request->post()['lng'];
            $reportModel->location = "{\"type\":\"Point\",\"coordinates\":[{$lat},{$lng}]}";
            $reportModel->device_uuid = Yii::$app->request->post()['uuid'];

            $sameReport = Report::find()
                ->where(['device_uuid' => $reportModel->device_uuid])
                ->where(['>=', 'created_at',
                    new Expression(
                        'DATE_SUB(NOW(), INTERVAL :reports_life_time HOUR)',
                        ['reports_life_time' => Crowd::$REPORTS_LIFE_TIME]
                    )])
                ->nearest($reportModel->location, 'location', Crowd::$CROWD_RADIUS)
                ->one();
            if (!empty($sameReport)){
                throw new HttpException(403, Yii::t('app', 'You can\'t create two reports of the same crowd'), 5);
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

            return ['message' => Yii::t('app', 'Report Created Successfully')];
        }

        throw new BadRequestHttpException(Yii::t('app', 'Bad Request'));
    }

}