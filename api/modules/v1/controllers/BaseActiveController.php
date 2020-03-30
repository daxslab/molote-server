<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 23/11/19
 * Time: 15:12
 */

namespace api\modules\v1\controllers;


use yii\filters\auth\CompositeAuth;
use yii\filters\Cors;
use yii\rest\ActiveController;

class BaseActiveController extends ActiveController
{

    public function actions()
    {
        $actions = parent::actions();

        $searchModel = "{$this->modelClass}Search";
        $actions ['index']['prepareDataProvider'] = function ($action) use ($searchModel){
            $a = \Yii::createObject([
                'class' => 'api\helpers\ListActionDataProviderHelper',
                'modelClass' => $this->modelClass,
                'dataFilter' => [
                    'class' => 'yii\data\ActiveDataFilter',
                    'searchModel' => $searchModel,
                ],
                'prepareQuery' => function($action){
                    return $this->modelClass::find();
                },
            ]);

            return $a->getDataProvider();
        };

        return $actions;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => Cors::className()
        ];

        return $behaviors;
    }

}