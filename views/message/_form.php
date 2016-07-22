<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\translator\models\Message */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="message-form">

  <?php $form = ActiveForm::begin(); ?>

  <? $form->field($model, 'lang')->dropDownList($model->params->languages) ?>

  <?= $form->field($model, 'category')->dropDownList($model->params->categories) ?>

  <?= $form->field($model, 'key')->textInput(['maxlength' => true]) ?>




  <?php
  foreach ($model->params->languages as $la => $lb) {
    ?>
    <div class="form-group field-message-value">
      <label class="control-label" for="<?= $la ?>"><?= $lb ?></label>
      <?= \yii\bootstrap\Html::textarea('Message['.$la.']',$model->values[$la], ['id'=> $la, 'class'=>'form-control']); ?>
      <div class="help-block"></div>
    </div>
    <?php
  }
  ?>
 <? $form->field($model, 'value')->textarea(['rows' => 6]) ?>
  <div class="form-group">
    <?php 
    if($model->isNewRecord){
      echo Html::submitButton('Save + New', ['name'=>'sm', 'value' => 'sn', 'class' => 'btn btn-success']) . " ";
      echo Html::submitButton('Save + Generate + New', ['name'=>'sm', 'value' => 'sgn', 'class' => 'btn btn-success']) . " ";
      echo Html::submitButton('Save + Generate + Return', ['name'=>'sm', 'value' => 'sgr', 'class' => 'btn btn-success']);
    }
    else {
      echo Html::submitButton('Edit + Return', ['name'=>'sm', 'value' => 'er', 'class' => 'btn btn-primary']) . " ";
      echo Html::submitButton('Edit + New', ['name'=>'sm', 'value' => 'en', 'class' => 'btn btn-primary']) . " ";
    }
  ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>
