<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bells}}`.
 */
class m250411_120721_create_bells_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bells}}', [
            'id_bell' => $this->primaryKey(),
            'name' => $this->string()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%bells}}');
    }
}
