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
        $day = Days::find()->one();

        $schedules = Schedules::find()
            ->with(['day', 'bell', 'class', 'subject', 'teacher'])
            ->where(['id_day' => $day->id_day])
            ->orderBy('schedules.id_bell')
            ->all();

        if (empty($schedules)) {
            echo "No schedules available.\n";
            return;
        }

        $header = sprintf("%-5s %-10s %-15s %-20s %-15s %-20s", 'ID', 'Day', 'Bell', 'Class', 'Subject', 'Teacher');
        echo $header . "\n";
        echo str_repeat("-", strlen($header)) . "\n"; // Underline header

        // Loop through schedules and print each
        foreach ($schedules as $schedule) {
            $day = $schedule->day->name; // Assuming 'name' is the property of 'day' model
            $bell = $schedule->bell->name; // Assuming 'time' is the property of 'bell' model
            $class = $schedule->class->name; // Assuming 'name' is the property of 'class' model
            $subject = $schedule->subject->name; // Assuming 'name' is the property of 'subject' model
            $teacher = $schedule->teacher->name; // Assuming 'name' is the property of 'teacher' model

            // Print schedule details in a formatted way
            echo sprintf("%-5s %-10s %-15s %-20s %-15s %-20s\n",
                $schedule->id_schedule, $day, $bell, $class, $subject, $teacher);
        }
    }
}