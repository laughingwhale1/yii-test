<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%class_subjects}}`.
 */
class m250411_133008_create_class_subjects_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%class_subjects}}', [
            'id' => $this->primaryKey(),
            'id_class' => $this->integer()->notNull(),
            'id_subject' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-class_subjects-class',
            '{{%class_subjects}}', 'id_class',
            '{{%classes}}', 'id_class',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-class_subjects-subject',
            '{{%class_subjects}}', 'id_subject',
            '{{%subjects}}', 'id_subject',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%class_subjects}}');
    }
}
