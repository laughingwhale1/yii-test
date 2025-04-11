<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%teacher_subjects}}`.
 */
class m250411_133133_create_teacher_subjects_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%teacher_subjects}}', [
            'id' => $this->primaryKey(),
            'id_subject' => $this->integer()->notNull(),
            'id_teacher' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-teacher_subjects-subject',
            '{{%teacher_subjects}}', 'id_subject',
            '{{%subjects}}', 'id_subject',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-teacher_subjects-teacher',
            '{{%teacher_subjects}}', 'id_teacher',
            '{{%teachers}}', 'id_teacher',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%teacher_subjects}}');
    }
}
