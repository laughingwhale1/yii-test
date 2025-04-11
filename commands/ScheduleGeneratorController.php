<?php

namespace app\commands;

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

    }
}