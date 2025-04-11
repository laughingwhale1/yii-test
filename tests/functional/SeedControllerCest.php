<?php

declare(strict_types=1);


namespace Functional;

use app\models\Schedules;
use app\services\ScheduleService;
use \FunctionalTester;

final class SeedControllerCest
{
    public function _before(FunctionalTester $I): void
    {
    }

    public function tryToTest(FunctionalTester $I): void
    {
        $I->assertEquals(0, Schedules::find()->count());

        $seeder = \Yii::$container->get('app\commands\SeedController');
        $seeder->actionBasic();

        $scheduleGenerator = \Yii::$container->get('app\commands\ScheduleGeneratorController');
        $scheduleGenerator->actionGenerate(new ScheduleService());

        $count = Schedules::find()->count();
        $I->assertTrue($count > 0, "Schedule generated, records: $count");

        $entry = Schedules::find()->one();
        $I->assertNotEmpty($entry->id_class);
        $I->assertNotEmpty($entry->id_subject);
        $I->assertNotEmpty($entry->id_teacher);
    }
}
