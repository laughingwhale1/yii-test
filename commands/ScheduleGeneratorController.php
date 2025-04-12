<?php

namespace app\commands;

use app\models\Days;
use app\models\Schedules;
use app\services\ScheduleService;
use yii\console\Controller;

class ScheduleGeneratorController extends Controller
{
    private $scheduleService;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->scheduleService = \Yii::$container->get('app\services\ScheduleService');
    }

    public function actionGenerate(ScheduleService $scheduleService)
    {
        $this->scheduleService->generateSchedule();

        echo "Schedule generated successfully!\n";
    }

    public function actionDraw()
    {

        $schedules = Schedules::find()
            ->with(['day', 'bell', 'class', 'subject', 'teacher'])
            ->orderBy('schedules.id_bell')
            ->all();

        if (empty($schedules)) {
            echo "No schedules available.\n";
            return;
        }

        $header = sprintf("%-5s %-10s %-15s %-20s %-15s %-20s", 'ID', 'Day', 'Bell', 'Class', 'Subject', 'Teacher');
        echo $header . "\n";
        echo str_repeat("-", strlen($header)) . "\n";

        foreach ($schedules as $schedule) {
            $day = $schedule->day->name;
            $bell = $schedule->bell->name;
            $class = $schedule->class->name;
            $subject = $schedule->subject->name;
            $teacher = $schedule->teacher->name;

            echo sprintf("%-5s %-10s %-15s %-20s %-15s %-20s\n",
                $schedule->id_schedule, $day, $bell, $class, $subject, $teacher);
        }
    }
}