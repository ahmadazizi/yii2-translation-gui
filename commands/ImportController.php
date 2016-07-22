<?php

namespace amdz\yii2Translator\commands;

use yii\console\Controller;
use yii\base\Exception;
use amdz\yii2Translator\models\Message;

class ImportController extends Controller {

  public function actionHelp() {
    $help = <<<help
Welcome to amdz\yii2Translator Importer
This utility helps you to import your current translation files(if any)
to database.
To import use the following command:
        
>>> yii translator/import/standard @app/path/to/message/directory
        
The structure of message directory must be standard. For example:
        
en-US/app.php
fa-IR/app.php
        
'en-US' and 'fa-IR' are language codes and 'app' is a sample category.
Please make sure you already configured the module in console mode.
help;
    echo $help;
  }

  /**
   * Imports Yii translation standard files to database
   * @param type $messagePath
   * @throws Exception
   */
  public function actionStandard($messagePath) {
    $command = \Yii::$app->db->createCommand();
    $categories = $this->module->categories;
    foreach ($this->module->languages as $lang => $value) {
      foreach ($categories as $catName => $catVal) {
        $filePath = $messagePath . '/' . $lang . '/' . $catName . '.php';
        $filePath = \Yii::getAlias($filePath);
        if (!file_exists($filePath))
          throw new Exception("File not found: $filePath");
        $imp = require $filePath;
        foreach ($imp as $key => $value) {
          $command->insert(Message::tableName(), [
              'lang' => $lang,
              'category' => $catName,
              'key' => $key,
              'value' => $value
          ])->execute();
        }
        if ($command)
          echo "Imported " . $filePath . "\n";
      }
    }
    echo "Import has been finished.";
  }

}
