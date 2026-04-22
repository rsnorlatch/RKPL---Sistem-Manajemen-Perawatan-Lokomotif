<?php

use lms\feature\locomotive_management\persistence\MySqlLocomotiveRepository;
use lms\feature\locomotive_management\persistence\MySqlOnSiteLocomotiveRepository;
use lms\feature\signup\persistence\MySqlDriverRepository;
use PHPUnit\Framework\TestCase;

final class OnsiteLocomotiveIntegrationTest extends TestCase
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
        $onsite_locomotives = new MySqlOnSiteLocomotiveRepository($this->db);

        $driver_id = $drivers->count() + 1;
        $locomotive_id = $locomotives->count() + 1;
        $onsite_locomotive_id = $onsite_locomotives->count() + 1;

        $drivers->insert($driver_id, "", "", "");
        $locomotives->insert($locomotive_id, $driver_id, "model1");
        $onsite_locomotives->insert($onsite_locomotive_id, $locomotive_id);


        $retrieved = $onsite_locomotives->get($locomotive_id);


        $this->assertNotNull($retrieved);
    }

    public function testCreatedLocomotive_ShouldBeUpdateable()
    {
        $locomotives = new MySqlLocomotiveRepository($this->db);
        $drivers = new MySqlDriverRepository($this->db);
        $onsite_locomotives = new MySqlOnSiteLocomotiveRepository($this->db);

        $driver_id = $drivers->count() + 1;
        $locomotive_id = $locomotives->count() + 1;
        $onsite_locomotive_id = $onsite_locomotives->count() + 1;

        $drivers->insert($driver_id, "", "", "");
        $locomotives->insert($locomotive_id, $driver_id, "model1");
        $locomotives->insert($locomotive_id + 1, $driver_id, "model2");
        $onsite_locomotives->insert($onsite_locomotive_id, $locomotive_id);


        $onsite_locomotives->update($onsite_locomotive_id, $locomotive_id + 1);


        $this->assertEquals("model2", $onsite_locomotives->get($onsite_locomotive_id)->model);
    }

    public function testCreatedLocomotive_ShouldBeDeleteable()
    {
        $locomotives = new MySqlLocomotiveRepository($this->db);
        $drivers = new MySqlDriverRepository($this->db);
        $onsite_locomotives = new MySqlOnSiteLocomotiveRepository($this->db);

        $locomotive_id = $locomotives->count() + 1;
        $driver_id = $drivers->count() + 1;
        $onsite_locomotive_id = $onsite_locomotives->count() + 1;

        $drivers->insert($driver_id, "", "", "");
        $locomotives->insert($locomotive_id, $driver_id, "model1");
        $onsite_locomotives->insert($onsite_locomotive_id, $locomotive_id);


        $onsite_locomotives->delete($onsite_locomotive_id);


        $this->assertEquals(null, $onsite_locomotives->get($onsite_locomotive_id));
    }

    public function tearDown(): void
    {
        parent::tearDown();

        $this->db->rollback();
        $this->db->close();
    }
}
