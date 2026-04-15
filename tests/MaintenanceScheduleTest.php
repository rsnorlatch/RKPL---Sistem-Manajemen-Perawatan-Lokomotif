<?php
require_once __DIR__ . "/../vendor/autoload.php";

use lms\feature\locomotive_management\entities\Locomotive;
use lms\feature\locomotive_management\persistence\InMemoryLocomotiveRepository;
use lms\feature\maintenance_schedule\entities\Schedule;
use lms\feature\maintenance_schedule\persistence\InMemoryScheduleRepository;
use lms\feature\maintenance_schedule\Scheduler;
use lms\feature\maintenance_schedule\ScheduleResult;
use PHPUnit\Framework\TestCase;

final class MaintenanceScheduleTest extends TestCase
{
    public function testAssigningScheduleToANonExistenceLocomotive_ShouldReturnLocomotiveNotFoundStatus()
    {
        $locomotives = new InMemoryLocomotiveRepository([]);
        $schedules = new InMemoryScheduleRepository([]);

        $scheduler = new Scheduler($locomotives, $schedules);
        $result = $scheduler->add_schedule(1, new DateTime(), new DateTime());

        $this->assertEquals(ScheduleResult::LocomotiveNotFound, $result);
    }

    public function testEditingAScheduleThatDoesNotExists_ShouldReturnLocomotiveUnscheduledStatus()
    {
        $locomotives = new InMemoryLocomotiveRepository([
            new Locomotive(1, 1, "Model")
        ]);
        $schedules = new InMemoryScheduleRepository([]);

        $scheduler = new Scheduler($locomotives, $schedules);
        $result = $scheduler->edit_schedule(1, new DateTime(), new DateTime());

        $this->assertEquals(ScheduleResult::LocomotiveUnscheduled, $result);
    }

    public function testAddingScheduleThatIsOccupiedByAnotherSchedule_ShouldReturnScheduleUnavailableStatus()
    {
        $locomotives = new InMemoryLocomotiveRepository([
            new Locomotive(1, 1, "Model")
        ]);
        $schedules = new InMemoryScheduleRepository([
            new Schedule(1, DateTime::createFromFormat("m-d", "09-30"), DateTime::createFromFormat("m-d", "09-30"), 1)
        ]);

        $scheduler = new Scheduler($locomotives, $schedules);
        $result = $scheduler->add_schedule(1, DateTime::createFromFormat("m-d", "09-30"), DateTime::createFromFormat("m-d", "09-30"));

        $this->assertEquals(ScheduleResult::ScheduleUnavailable, $result);
    }

    public function testAddingScheduleToAnAlreadyScheduledLocomotive_ShouldAddAnotherSchedule()
    {
        $locomotives = new InMemoryLocomotiveRepository([
            new Locomotive(1, 1, "Model")
        ]);
        $schedules = new InMemoryScheduleRepository([
            new Schedule(1, DateTime::createFromFormat("m-d", "09-30"), DateTime::createFromFormat("m-d", "09-30"), 1)
        ]);

        $scheduler = new Scheduler($locomotives, $schedules);
        $result = $scheduler->add_schedule(1, new DateTime(), new DateTime(), 1);

        $this->assertEquals(ScheduleResult::Success, $result);
    }
}
