<?php

use lms\feature\locomotive_management\persistence\MySqlLocomotiveRepository;
use lms\feature\signup\persistence\MySqlDriverRepository;
use PHPUnit\Framework\TestCase;

final class LocomotiveIntegrationTest extends TestCase
{
    private mysqli $db;

    public function setUp(): void
    {
        parent::setUp();
        $this->db = new \mysqli("localhost", "root", "", "lms_test");
        $this->db->begin_transaction();
    }

    public function testCreatedLocomotive_ShouldBeRetrieveable()
    {
        $locomotives = new MySqlLocomotiveRepository($this->db);
        $drivers = new MySqlDriverRepository($this->db);

        $locomotive_id = $locomotives->count() + 1;
        $driver_id = $drivers->count() + 1;

        $drivers->insert($driver_id, "", "", "");
        $locomotives->insert($locomotive_id, $driver_id, "model1");


        $retrieved = $locomotives->get($locomotive_id);


        $this->assertNotNull($retrieved);
    }

    public function testCreatedLocomotive_ShouldBeUpdateable()
    {
        $locomotives = new MySqlLocomotiveRepository($this->db);
        $drivers = new MySqlDriverRepository($this->db);

        $locomotive_id = $locomotives->count() + 1;
        $driver_id = $drivers->count() + 1;

        $drivers->insert($driver_id, "", "", "");
        $locomotives->insert($locomotive_id, $driver_id, "model1");


        $locomotives->update($locomotive_id, $driver_id, "model2");


        $this->assertEquals("model2", $locomotives->get($locomotive_id)->model);
    }

    public function testCreatedLocomotive_ShouldBeDeleteable()
    {
        $locomotives = new MySqlLocomotiveRepository($this->db);
        $drivers = new MySqlDriverRepository($this->db);

        $locomotive_id = $locomotives->count() + 1;
        $driver_id = $drivers->count() + 1;

        $drivers->insert($driver_id, "", "", "");
        $locomotives->insert($locomotive_id, $driver_id, "model1");


        $locomotives->delete($locomotive_id);


        $this->assertEquals(null, $locomotives->get($locomotive_id));
    }

    public function tearDown(): void
    {
        parent::tearDown();

        $this->db->rollback();
        $this->db->close();
    }
}
