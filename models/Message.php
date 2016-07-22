<?php

namespace amdz\yii2Translator\models;

use Yii;

/**
 * This is the model class for table "{{%translator_messages}}".
 *
 * @property integer $id
 * @property string $lang
 * @property string $category
 * @property string $key
 * @property string $value
 */
class Message extends \yii\db\ActiveRecord
{
  public $params;
  public $values;

  public function init() {
    $this->params = \Yii::$app->controller->module;
    parent::init();
  }

  /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%translator_messages}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value'], 'string'],
            [['lang', 'category', 'key'], 'string', 'max' => 50],
            [['key', 'category'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'lang' => Yii::t('app', 'Lang'),
            'category' => Yii::t('app', 'Category'),
            'key' => Yii::t('app', 'Key'),
            'value' => Yii::t('app', 'Value'),
        ];
    }

    /**
     * @inheritdoc
     * @return MessageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MessageQuery(get_called_class());
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['parent_id' => 'id'])->from(['cat' => 'category']);
    }
    
    
}
