<?php
/* require_once __DIR__ . "/../vendor/autoload.php"; */

use lms\feature\maintenance_schedule\Scheduler;
use lms\feature\maintenance_schedule\ScheduleResult;
use PHPUnit\Framework\TestCase;

final class MaintenanceScheduleTest extends TestCase
{
    public function testAssigningScheduleToANonExistenceLocomotive_ShouldReturnLocomotiveNotFoundStatus()
    {
        $scheduler = Scheduler::create_inmemory()->build();

        $result = $scheduler->add_schedule(1, new DateTime(), new DateTime());

        $this->assertEquals(ScheduleResult::LocomotiveNotFound, $result);
    }

    public function testEditingAScheduleThatDoesNotExists_ShouldReturnLocomotiveUnscheduledStatus()
    {
        $scheduler = Scheduler::create_inmemory()
            ->with_locomotive(1, 1, "Model")
            ->build();

        $result = $scheduler->edit_schedule(1, new DateTime(), new DateTime());

        $this->assertEquals(ScheduleResult::LocomotiveUnscheduled, $result);
    }

    public function testAddingScheduleThatIsOccupiedByAnotherSchedule_ShouldReturnScheduleUnavailableStatus()
    {
        $scheduler = Scheduler::create_inmemory()
            ->with_locomotive(1, 1, "Model")
            ->with_schedule(1, DateTime::createFromFormat("m-d", "09-30"), DateTime::createFromFormat("m-d", "09-30"), 1)
            ->build();

        $result = $scheduler->add_schedule(1, DateTime::createFromFormat("m-d", "09-30"), DateTime::createFromFormat("m-d", "09-30"));

        $this->assertEquals(ScheduleResult::ScheduleUnavailable, $result);
    }

    public function testAddingScheduleToAnAlreadyScheduledLocomotive_ShouldAddAnotherSchedule()
    {
        $scheduler = Scheduler::create_inmemory()
            ->with_locomotive(1, 1, "Model")
            ->with_schedule(1, DateTime::createFromFormat("m-d", "09-30"), DateTime::createFromFormat("m-d", "09-30"), 1)
            ->build();

        $result = $scheduler->add_schedule(1, new DateTime(), new DateTime(), 1);

        $this->assertEquals(ScheduleResult::Success, $result);
    }
}
