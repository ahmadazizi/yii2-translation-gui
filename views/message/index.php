<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\translator\models\MessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Messages');
$this->params['breadcrumbs'][] = $this->title;


//print_r($dataProvider->getKeys()); 
//exit; 
?>
<div class="message-index">

  <h1><?= Html::encode($this->title) ?></h1>
  <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

  <p>
    <?= Html::a(Yii::t('app', 'New Message'), ['create'], ['class' => 'btn btn-success']) ?> 
    <?= Html::a(Yii::t('app', 'Generate Output Files'), ['action', 'id'=>'gr'], ['class' => 'btn btn-primary']) ?>
  </p>
  <?php Pjax::begin(); ?>    <?=
  GridView::widget([
      'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
      'columns' => [
          ['class' => 'yii\grid\SerialColumn'],
          //'id',
          //'lang',
          'category',
          'key',
          //'lang1',
          //'lang2',
          'value:ntext',
          ['class' => 'yii\grid\ActionColumn'],
      ],
  ]);
  ?>
  <?php Pjax::end(); ?></div>
