<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\translator\models\Message */

$this->title = $model->key;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-view">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?=
    Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
            'method' => 'post',
        ],
    ])
    ?>
  </p>

  <?php
  $attributes = [
      'id',
      //'lang',
      'category',
      'key',
          //'value:ntext',
  ];
  foreach ($model->values as $a => $b) {
    $attributes[] = ['label' => $model->params->languages[$a], 'value' => $b];
  }
  echo DetailView::widget([
      'model' => $model,
      'attributes' => $attributes,
  ]);
  ?>

</div>
