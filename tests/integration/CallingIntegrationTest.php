<?php

use lms\feature\communication\persistence\MySqlAcceptedCallRepository;
use lms\feature\communication\persistence\MySqlCallRepository;
use lms\feature\signup\persistence\MySqlDriverRepository;
use PHPUnit\Framework\TestCase;

final class CallingIntegrationTest extends TestCase
{
    private MySqli $db;

    public function setUp(): void
    {
        parent::setUp();
        $this->db = new \mysqli("localhost", "root", "", "lms_test");
    }

    public function testCreatedCall_ShouldBeRetrievableFromStorage()
    {
        $calls = new MySqlCallRepository($this->db);
        $drivers = new MySqlDriverRepository($this->db);

        $driver_id = $drivers->count() + 1;
        $call_id = $calls->count() + 1;

        $drivers->insert($driver_id, "username", "email", "password");
        $calls->insert($call_id, $driver_id, new DateTime());


        $retrieved = $calls->get($call_id);


        $this->assertNotNull($retrieved);
    }

    public function testCreatedCall_ShouldBeUpdatedFromStorage()
    {
        $calls = new MySqlCallRepository($this->db);
        $drivers = new MySqlDriverRepository($this->db);

        $call_id = $calls->count() + 1;

        $drivers->insert($drivers->count() + 1, "username", "email", "password");
        $drivers->insert($drivers->count() + 1, "username", "email", "password");
        $calls->insert($call_id, 1, new DateTime());


        $calls->update($call_id, 2, new DateTime());


        $this->assertEquals(2, $calls->get($call_id)->driver_id);
    }

    public function testCreatedCall_ShouldBeDeleteableFromStorage()
    {
        $calls = new MySqlCallRepository($this->db);
        $drivers = new MySqlDriverRepository($this->db);

        $call_id = $calls->count() + 1;
        $driver_id = $drivers->count() + 1;

        $drivers->insert($driver_id, "username", "email", "password");
        $calls->insert($call_id, 1, new DateTime());


        $calls->delete($call_id);


        $this->assertEquals(null, $calls->get($call_id));
    }




    public function tearDown(): void
    {
        parent::tearDown();

        $call_stmt = $this->db->prepare("DELETE FROM calling");
        $driver_stmt = $this->db->prepare("DELETE FROM driver");

        $call_stmt->execute();
        $driver_stmt->execute();
    }
}
