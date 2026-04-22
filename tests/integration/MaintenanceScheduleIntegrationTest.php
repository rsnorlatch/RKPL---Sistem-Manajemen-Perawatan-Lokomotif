<?php

use lms\feature\locomotive_management\persistence\MySqlLocomotiveRepository;
use lms\feature\maintenance_schedule\persistence\MySqlScheduleRepository;
use lms\feature\signup\persistence\MySqlDriverRepository;
use PHPUnit\Framework\TestCase;

final class MaintenanceScheduleIntegrationTest extends TestCase
{
    private mysqli $db;

    public function setUp(): void
    {
        parent::setUp();
        $this->db = new \mysqli("localhost", "root", "", "lms_test");
        $this->db->begin_transaction();
    }


    public function testCreatedSchedule_ShouldBeRetreiveable()
    {
        $schedules = new MySqlScheduleRepository($this->db);
        $locomotives = new MySqlLocomotiveRepository($this->db);
        $drivers = new MySqlDriverRepository($this->db);

        $driver_id = $drivers->count() + 1;
        $locomotive_id = $locomotives->count() + 1;
        $schedule_id = $schedules->count() + 1;

        $drivers->insert($driver_id, "username", "email", "password");
        $locomotives->insert($locomotive_id, $driver_id, "model-1");
        $schedules->insert($schedule_id, new DateTime(), new DateTime(), $locomotive_id);


        $retrieved = $schedules->get($schedule_id);


        $this->assertNotEquals(null, $retrieved);
    }

    public function testCreatedSchedule_ShouldBeUpdateable()
    {
        $schedules = new MySqlScheduleRepository($this->db);
        $locomotives = new MySqlLocomotiveRepository($this->db);
        $drivers = new MySqlDriverRepository($this->db);

        $driver_id = $drivers->count() + 1;
        $locomotive_id = $locomotives->count() + 1;
        $schedule_id = $schedules->count() + 1;

        $drivers->insert($driver_id, "username", "email", "password");
        $locomotives->insert($locomotive_id, $driver_id, "model-1");
        $locomotives->insert($locomotive_id + 1, $driver_id, "model-2");
        $schedules->insert($schedule_id, new DateTime(), new DateTime(), $locomotive_id);


        $schedules->update($schedule_id, new DateTime(), new DateTime(), $locomotive_id + 1);


        $this->assertEquals($locomotive_id + 1, $schedules->get($schedule_id)->locomotive_id);
    }

    public function testCreatedSchedule_ShouldBeDeleteable()
    {
        $schedules = new MySqlScheduleRepository($this->db);
        $locomotives = new MySqlLocomotiveRepository($this->db);
        $drivers = new MySqlDriverRepository($this->db);

        $driver_id = $drivers->count() + 1;
        $locomotive_id = $locomotives->count() + 1;
        $schedule_id = $schedules->count() + 1;

        $drivers->insert($driver_id, "username", "email", "password");
        $locomotives->insert($locomotive_id, $driver_id, "model-1");
        $schedules->insert($schedule_id, new DateTime(), new DateTime(), $locomotive_id);


        $schedules->delete($schedule_id);


        $this->assertEquals(null, $schedules->get($schedule_id));
    }


    public function tearDown(): void
    {
        parent::tearDown();

        $this->db->rollback();
        $this->db->close();
    }
}
