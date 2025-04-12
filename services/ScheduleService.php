<?php

namespace app\services;

use app\models\Bells;
use app\models\Classes;
use app\models\ClassSubjects;
use app\models\Days;
use app\models\Schedules;
use app\models\TeacherSubjects;

class ScheduleService
{
    public function generateSchedule(): void
    {
        $days = Days::find()->all();

        if (!count($days)) {
            echo "Seed database or specify period";
        }

        $bells = Bells::find()->all();
        $classes = Classes::find()->all();
        $totalClasses = count($classes);
        $classCounter = 0;

        Schedules::deleteAll();

        \Yii::info("All existing schedules deleted.");

        \Yii::info("Starting schedule generation for {$totalClasses} classes...");

        foreach ($classes as $class) {
            $classCounter++;
            \Yii::info("[$classCounter/$totalClasses] 📚 Generating schedule for class ID {$class->id_class}...");

            // getting shuffled class subjects
            $subjectIds = $this->getShuffledSubjectIdsForClass($class->id_class);

            foreach ($subjectIds as $subjectId) {
                $this->assignLesson($class->id_class, $subjectId, $days, $bells);
            }
        }
    }

    private function getShuffledSubjectIdsForClass(int $classId): array
    {
        $subjectIds = ClassSubjects::find()
            ->where(['id_class' => $classId])
            ->select('id_subject')
            ->column();

        shuffle($subjectIds);

        return $subjectIds;
    }

    private function assignLesson(int $classId, int $subjectId, $days, $bells): void
    {
        // getting teachers who can teach this subject
        $teachers = TeacherSubjects::find()
            ->where(['id_subject' => $subjectId])
            ->select('id_teacher')
            ->column();

        if (empty($teachers)) {
            \Yii::info("Warning: No teachers found for subject ID $subjectId\n");
            return;
        }

        $transaction = \Yii::$app->db->beginTransaction();
        try {
            foreach ($days as $day) {
                foreach ($bells as $bell) {

                    if ($this->isClassBusy($classId, $day->id_day, $bell->id_bell)) {
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

                        $transaction->commit();

                        return;
                    }
                }
            }

        } catch (\Throwable $throwable) {
            $transaction->rollBack();
            \Yii::error($throwable->getMessage());
        }
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

    private function isClassBusy(int $classId, int $dayId, int $bellId): bool
    {
        return Schedules::find()
            ->where([
                'id_class' => $classId,
                'id_day' => $dayId,
                'id_bell' => $bellId,
            ])
            ->exists();
    }
}