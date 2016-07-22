<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\translator\models\Message */

$this->title = Yii::t('app', 'Edit {modelClass}: ', [
    'modelClass' => 'Message',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Edit');
?>
<div class="message-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
