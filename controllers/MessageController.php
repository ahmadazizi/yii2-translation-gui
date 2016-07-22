<?php

namespace amdz\yii2Translator\controllers;

use Yii;
use amdz\yii2Translator\models\Message;
use amdz\yii2Translator\models\MessageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;

/**
 * MainController implements the CRUD actions for Message model.
 */
class MessageController extends Controller {

  /**
   * @inheritdoc
   */
  public function behaviors() {
    return [
        'verbs' => [
            'class' => VerbFilter::className(),
            'actions' => [
                'delete' => ['POST'],
            ],
        ],
    ];
  }

  /**
   * Lists all Message models.
   * @return mixed
   */
  public function actionIndex() {
    $searchModel = new MessageSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
    ]);
  }

  /**
   * Displays a single Message model.
   * @param integer $id
   * @return mixed
   */
  public function actionView($id) {
    return $this->render('view', [
                'model' => $this->findModel($id),
    ]);
  }

  /**
   * Checks to see if the key already exists. To prevent duplicate keys.
   * @param type $key
   * @param type $category
   * @return boolean
   */
  public function keyExists($key, $category) {
    if (Message::find()->where(['key' => $key, 'category' => $category])->exists())
      return true;
    return false;
  }

  /**
   * Creates a new Message model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate() {
    $model = new Message();

    if ($model->load(Yii::$app->request->post())) {
      if ($this->keyExists($model->key, $model->category)) {
        $model->addError('key', 'Key already exists in this category.');
        foreach ($this->module->languages as $a => $b)
          $model->values[$a] = Yii::$app->request->post()['Message'][$a];
        return $this->render('create', [
                    'model' => $model
        ]);
      }
      $command = Yii::$app->db->createCommand();
      foreach ($this->module->languages as $a => $b) {
        $val = Yii::$app->request->post()['Message'][$a];
        $command->insert(Message::tableName(), [
            'lang' => $a,
            'category' => $model->category,
            'key' => $model->key,
            'value' => $val
        ])->execute();
      }
      return $this->redirect(['action', 'id' => Yii::$app->request->post()['sm']]);
    } else {
      return $this->render('create', [
                  'model' => $model,
      ]);
    }
  }

  /**
   * Updates an existing Message model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id
   * @return mixed
   */
  public function actionUpdate($id) {
    $model = $this->findModel($id);

    if ($model->load(Yii::$app->request->post())) {
      $savedRecord = Message::findOne([$model->id]);
      if ($this->keyExists($model->key, $model->category) && $model->key != $savedRecord->key) {
        $model->addError('key', $model->key . " conflicts with another record in this category.");
        foreach ($this->module->languages as $a => $b)
          $model->values[$a] = Yii::$app->request->post()['Message'][$a];
        return $this->render('create', [
                    'model' => $model
        ]);
      }
      foreach ($this->module->languages as $a => $b) {
        $val = Yii::$app->request->post()['Message'][$a];
        $mVal = Message::find()->where([
                    'key' => $savedRecord->key,
                    'lang' => $a
                ])->one();
        $mVal->load(Yii::$app->request->post());
        $mVal->value = $val;
        $mVal->save();
      }
      return $this->redirect(['action', 'id' => Yii::$app->request->post()['sm']]);
    } else {

      return $this->render('update', [
                  'model' => $model,
      ]);
    }
  }

  /**
   * Deletes an existing Message model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param integer $id
   * @return mixed
   */
  public function actionDelete($id) {
    $similar = Message::findOne($id);

    while ($model = Message::find()->where(['key' => $similar->key, 'category' => $similar->category])->one()) {
      $model->delete();
    }

    return $this->redirect(['index']);
  }

  /**
   * Finds the Message model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return Message the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id) {
    if (($model = Message::findOne($id)) !== null) {
      $values = Message::find()->where(['key' => $model->key])->all();
      foreach ($this->module->languages as $la => $lb) {
        for ($i = 0; $i < count($values); $i++) {
          if ($la == $values[$i]['lang']) {
            $model->values[$la] = $values[$i]['value'];
            break;
          }
        }
      }
      return $model;
    } else {
      throw new NotFoundHttpException('The requested page does not exist.');
    }
  }

  /*
   * Generates the translation files from database
   */
  public function generateFiles() {
    $categories = $this->module->categories;
    foreach ($this->module->languages as $lang => $value) {
      $filePath = \Yii::getAlias($this->module->messagePath) . "/" . $lang . "/";
      FileHelper::createDirectory($filePath);
      foreach ($categories as $catName => $catVal) {
        $output = '//Generated by amdz/yii2translator on ' . date("F j, Y, g:i a") . " \r\n";
        ;
        $fileName = $filePath . $catName . ".php";
        $fileName = FileHelper::normalizePath($fileName);
        foreach (Message::find()->where(['lang' => $lang, 'category' => $catName])->orderBy('key')->all() as $message) {
          $key = addslashes($message->key);
          $value = addslashes($message->value);
          $output .= "\t'{$key}' => '{$value}',\r\n";
        }
        $output = "<?php\r\nreturn [ \r\n" . $output . "];";
        $h = fopen($fileName, 'w');
        fwrite($h, $output);
        fclose($h);
      }
    }
  }

  /*
   * action switch
   */
  public function actionAction($id) {
    switch ($id) {
      case 'sn':
        $action = 'create';
        break;
      case 'sgn':
        $this->generateFiles();
        $action = 'create';
        break;
      case 'sgr':
        $this->generateFiles();
        $action = 'index';
        break;
      case 'er':
        $action = 'index';
        break;
      case 'en':
        $action = 'create';
        break;
      case 'gr':
        $this->generateFiles();
        $action = 'index';
        break;
      default :
        $action = 'index';
    }
    $this->redirect([$action]);
  }

}
