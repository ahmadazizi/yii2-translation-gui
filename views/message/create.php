<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\translator\models\Message */

$this->title = Yii::t('app', 'New Message');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="message-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
