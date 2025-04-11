<?php

namespace app\commands;

use app\models\Classes;
use app\models\ClassSubjects;
use app\models\Schedules;
use app\models\Days;
use app\models\Bells;
use app\models\TeacherSubjects;
use yii\console\Controller;

class ScheduleGeneratorController extends Controller
{
    public function actionGenerate()
    {
        $days = Days::find()->all();
        $bells = Bells::find()->all();
        $classes = Classes::find()->all();

        Schedules::deleteAll();

        // iterating classes
        foreach ($classes as $class) {
            // getting class subjects
            $classSubjects = ClassSubjects::find()
                ->where(['id_class' => $class->id_class])
                ->select('id_subject')
                ->column();

            shuffle($classSubjects);

            foreach ($classSubjects as $subjectId) {
                $this->assignLesson($class->id_class, $subjectId, $days, $bells);
            }
        }

        echo "Schedule generated successfully!\n";
    }

    /**
     * Choose free as of this day and lesson is free
     */
    private function assignLesson(int $classId, int $subjectId, $days, $bells): void
    {
        // getting teachers who can teach this subject
        $teachers = TeacherSubjects::find()
            ->where(['id_subject' => $subjectId])
            ->select('id_teacher')
            ->column();

        if (empty($teachers)) {
            echo "Warning: No teachers found for subject ID $subjectId\n";
            return;
        }


        foreach ($days as $day) {
            foreach ($bells as $bell) {

                $isClassBusy = Schedules::find()
                    ->where([
                        'id_class' => $classId,
                        'id_day' => $day->id_day,
                        'id_bell' => $bell->id_bell
                    ])
                    ->exists();

                if ($isClassBusy) {
                    continue;
                }

                $availableTeacher = $this->findAvailableTeacher($teachers, $day->id_day, $bell->id_bell);

                if ($availableTeacher) {
                    $schedule = new Schedules();
                    $schedule->id_day = $day->id_day;
                    $schedule->id_bell = $bell->id_bell;
                    $schedule->id_class = $classId;
                    $schedule->id_subject = $subjectId;
                    $schedule->id_teacher = $availableTeacher;
                    $schedule->save();

                    return;
                }
            }
        }

        echo "Warning: Could not assign subject ID $subjectId for class ID $classId. No available slots found.\n";
    }

    private function findAvailableTeacher(array $teacherIds, int $dayId, int $bellId): int|null
    {
        $occupiedTeachers = Schedules::find()
            ->where(['id_day' => $dayId, 'id_bell' => $bellId])
            ->select('id_teacher')
            ->column();

        $availableTeachers = array_diff($teacherIds, $occupiedTeachers);

        if (!empty($availableTeachers)) {
            return $availableTeachers[array_rand($availableTeachers)];
        }

        return null;
    }
}