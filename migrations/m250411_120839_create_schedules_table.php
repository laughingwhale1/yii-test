<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%schedules}}`.
 */
class m250411_120839_create_schedules_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%schedules}}', [
            'id_schedule' => $this->primaryKey(),
            'id_day' => $this->integer()->null(),
            'id_bell' => $this->integer()->null(),
            'id_class' => $this->integer()->null(),
            'id_subject' => $this->integer()->null(),
            'id_teacher' => $this->integer()->null(),
        ]);

        $this->addForeignKey(
            'fk-schedule-day',
            '{{%schedules}}', 'id_day',
            '{{%days}}', 'id_day',
            'SET NULL'
        );

        $this->addForeignKey(
            'fk-schedule-bell',
            '{{%schedules}}', 'id_bell',
            '{{%bells}}', 'id_bell',
            'SET NULL'
        );

        $this->addForeignKey(
            'fk-schedule-class',
            '{{%schedules}}', 'id_class',
            '{{%classes}}', 'id_class',
            'SET NULL'
        );

        $this->addForeignKey(
            'fk-schedule-subject',
            '{{%schedules}}', 'id_subject',
            '{{%subjects}}', 'id_subject',
            'SET NULL'
        );

        $this->addForeignKey(
            'fk-schedule-teacher',
            '{{%schedules}}', 'id_teacher',
            '{{%teachers}}', 'id_teacher',
            'SET NULL'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%schedules}}');
    }
}
