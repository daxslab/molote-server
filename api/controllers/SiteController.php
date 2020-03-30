<?php

namespace api\controllers;



use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
                'only' => ['api', 'doc'],//List of actions to be applied
                'cors' =>
                    [
                        'Origin' => ['*'],
                    ]
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['confirm', 'confirm-new-email'],
                'rules' => [
                    [
                        'actions' => ['confirm', 'confirm-new-email'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
}
