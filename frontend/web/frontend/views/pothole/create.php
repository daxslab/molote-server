<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Crowd */

$this->title = 'Create Crowd';
$this->params['breadcrumbs'][] = ['label' => 'Crowds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="crowd-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
