<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%days}}`.
 */
class m250411_120740_create_days_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%days}}', [
            'id_day' => $this->primaryKey(),
            'name' => $this->string()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%days}}');
    }
}
