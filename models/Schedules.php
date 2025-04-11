<?php

namespace app\models;

use yii\db\ActiveRecord;

class Schedules extends ActiveRecord
{
    public function getDay(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Days::class, ['id_day' => 'id_day']);
    }

    public function getBell(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Bells::class, ['id_bell' => 'id_bell']);
    }

    public function getClass(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Classes::class, ['id_class' => 'id_class']);
}

    public function getSubject(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Subjects::class, ['id_subject' => 'id_subject']);
    }

    public function getTeacher(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Teachers::class, ['id_teacher' => 'id_teacher']);
    }
}