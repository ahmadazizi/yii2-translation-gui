<?php

use yii\db\Migration;

class m160722_013957_create_translator_name extends Migration {

  public $tableName = '{{%translator_messages}}';

  public function up() {
    $this->createTable($this->tableName, [
        'id' => $this->primaryKey(),
        'lang' => $this->string(),
        'category' => $this->string(),
        'key' => $this->string(),
        'value' => $this->text(),
    ]);
    $this->createIndex(
            'key-index',
            $this->tableName,
            'key'
        );
  }

  public function down() {
    $this->dropTable($this->tableName);
  }

  /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
   */
}
