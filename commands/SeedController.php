<?php

namespace app\commands;

use app\models\Bells;
use app\models\Classes;
use app\models\ClassSubjects;
use app\models\Days;
use app\models\Subjects;
use app\models\Teachers;
use app\models\TeacherSubjects;
use yii\console\Controller;
use yii\db\Exception;

class SeedController extends Controller
{

    const CLASSES = [
        '1-A',
        '1-B',
        '2-A',
        '2-B'
    ];

    /**
     * @throws Exception
     */
    public function actionClasses()
    {
        Classes::deleteAll();
        foreach (self::CLASSES as $className) {
            $class = new Classes();
            $class->name = $className;
            $class->save();
        }
    }

    const SUBJECTS = [
        'Mathematics',
        'Literature',
        'Physics',
        'History',
        'Biology',
        'Chemistry'
    ];

    /**
     * @throws Exception
     */
    public function actionSubjects()
    {
        Subjects::deleteAll();
        foreach (self::SUBJECTS as $subjectName) {
            $subject = new Subjects();
            $subject->name = $subjectName;
            $subject->save();
        }
    }

    const TEACHERS = [
        'Mr. Smith',
        'Ms. Johnson',
        'Mr. Brown',
        'Ms. Lee',
        'Mr. White'
    ];

    /**
     * @throws Exception
     */
    public function actionTeachers()
    {
        Teachers::deleteAll();
        foreach (self::TEACHERS as $teacherName) {
            $teacher = new Teachers();
            $teacher->name = $teacherName;
            $teacher->save();
        }
    }

    const BELLS = [
        'First Lesson',
        'Second Lesson',
        'Third Lesson',
        'Fourth Lesson',
        'Fifth Lesson',
        'Sixth Lesson'
    ];

    /**
     * @throws Exception
     */
    public function actionBells()
    {
        Bells::deleteAll();
        foreach (self::BELLS as $bellName) {
            $bell = new Bells();
            $bell->name = $bellName;
            $bell->save();
        }
    }

    const DAYS = [
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday'
    ];

    /**
     * @throws Exception
     */
    public function actionDays()
    {
        Days::deleteAll();
        foreach (self::DAYS as $dayName) {
            $day = new Days();
            $day->name = $dayName;
            $day->save();
        }
    }

    public function actionClassSubject()
    {
        ClassSubjects::deleteAll();

        $classes = Classes::find()->all();
        $subjects = Subjects::find()->all();

        foreach ($classes as $class) {
            $randomSubjects = array_rand($subjects, 3);

            foreach ($randomSubjects as $subjectIndex) {
                $classSubject = new \app\models\ClassSubjects();
                $classSubject->id_class = $class->id_class;
                $classSubject->id_subject = $subjects[$subjectIndex]->id_subject;
                $classSubject->save();
            }
        }
    }

    public function actionTeacherSubject()
    {
        TeacherSubjects::deleteAll();

        $teachers = Teachers::find()->all();
        $subjects = Subjects::find()->all();

        foreach ($subjects as $subject) {
            $randomTeachers = array_rand($teachers, 2);

            foreach ($randomTeachers as $teacher) {
                $teacherSubject = new \app\models\TeacherSubjects();
                $teacherSubject->id_teacher = $teachers[$teacher]->id_teacher;
                $teacherSubject->id_subject = $subject->id_subject;
                $teacherSubject->save();
            }
        }
    }

    public function actionBasic()
    {
        try {
            $this->actionClasses();
            $this->actionBells();
            $this->actionTeachers();
            $this->actionSubjects();
            $this->actionDays();
            $this->actionTeacherSubject();
            $this->actionClassSubject();
        } catch (\Throwable $throwable) {

        }
    }
}