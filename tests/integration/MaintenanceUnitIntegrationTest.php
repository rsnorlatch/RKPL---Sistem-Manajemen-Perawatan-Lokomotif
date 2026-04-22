<?php

use lms\feature\maintenance_program\persistence\MySqlMaintenanceUnitRepository;
use PHPUnit\Framework\TestCase;

final class MaintenanceUnitIntegrationTest extends TestCase
{
    private mysqli $db;

    public function setUp(): void
    {
        parent::setUp();
        $this->db = new \mysqli("localhost", "root", "", "lms_test");
        $this->db->begin_transaction();
    }

    public function testCreatedUnit_ShouldBeRetrieveable()
    {
        $units = new MySqlMaintenanceUnitRepository($this->db);

        $unit_id = $units->count() + 1;
        $units->insert($unit_id, 1, "", "", "");


        $retrieved = $units->get($unit_id);


        $this->assertNotEquals(null, $retrieved);
    }

    public function testCreatedUnit_ShouldBeUpdateable()
    {
        $units = new MySqlMaintenanceUnitRepository($this->db);

        $unit_id = $units->count() + 1;
        $units->insert($unit_id, 1, "", "", "");


        $units->update($unit_id, 1, "named", "", "");


        $this->assertEquals("named", $units->get($unit_id)->unit_name);
    }

    public function testCreatedUnit_ShouldBeDeleteable()
    {
        $units = new MySqlMaintenanceUnitRepository($this->db);

        $unit_id = $units->count() + 1;
        $units->insert($unit_id, 1, "", "", "");


        $units->delete($unit_id);


        $this->assertEquals(null, $units->get($unit_id));
    }


    public function tearDown(): void
    {
        parent::tearDown();

        $this->db->rollback();
        $this->db->close();
    }
}
