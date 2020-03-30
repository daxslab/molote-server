<?php

namespace api\modules\v1\controllers;


use common\models\Crowd;
use Yii;

class CrowdController extends BaseActiveController
{

    public $modelClass = 'common\models\Crowd';

    public function actions()
    {
        $actions = parent::actions();

        //allow only read actions
        unset($actions['create']);
        unset($actions['update']);
        unset($actions['delete']);

        return $actions;
    }

    public function actionGetTrusties()
    {

        $crowds_ids = Yii::$app->db
            ->createCommand(
                'SELECT crowd_id from report WHERE created_at >= DATE_SUB(NOW(), INTERVAL :reports_life_time HOUR) GROUP BY crowd_id',
                ['reports_life_time' => Crowd::$REPORTS_LIFE_TIME]
            )->queryColumn();

        $crowds = Crowd::find()
            ->andwhere(['in', 'id', $crowds_ids])
            ->andWhere(['>=', 'reports_count', Crowd::$REPORTS_TRUST_NUMBER])
            ->all();

        return $crowds;
    }

}