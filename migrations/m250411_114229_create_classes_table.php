<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%class}}`.
 */
class m250411_114229_create_classes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%classes}}', [
            'id_class' => $this->primaryKey(),
            'name' => $this->string()
        ]);
     }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%classes}}');
    }
}
