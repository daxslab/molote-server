<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Pothole */

$this->title = 'Create Pothole';
$this->params['breadcrumbs'][] = ['label' => 'Potholes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pothole-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
