<?php

namespace amdz\yii2Translator;

/**
 * translator module definition class
 */
class Module extends \yii\base\Module {

  public $languages;
  public $categories;
  public $defaultLanguage;
  public $defaultCategory;
  public $messagePath;
  public $layout = 'main';
  public $defaultRoute = 'message';

  /**
   * @inheritdoc
   */
  public function init() {
    
    if ($this->messagePath == '')
      $this->messagePath = '@app/messages';
    if (\Yii::$app instanceof \yii\console\Application) {
      $this->controllerNamespace = 'amdz\yii2Translator\commands';
      $this->defaultRoute = 'import/help';
    }
    parent::init();
  }

}
