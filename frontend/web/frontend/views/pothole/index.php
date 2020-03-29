<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CrowdSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Crowds';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="crowd-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Crowd', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'location',
            'created_at',
            'active',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
