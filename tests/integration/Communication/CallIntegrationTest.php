<?php

use lms\feature\communication\persistence\MySqlCallRepository;
use lms\feature\signup\persistence\MySqlDriverRepository;
use PHPUnit\Framework\TestCase;

final class CallIntegrationTest extends TestCase
{
    private MySqli $db;

    public function setUp(): void
    {
        parent::setUp();
        $this->db = new \mysqli("localhost", "root", "", "lms_test");
    }

    public function testCreatedCall_CanBeRetrievedFromStorage()
    {
        $calls = new MySqlCallRepository($this->db);
        $driver = new MySqlDriverRepository($this->db);

        $driver_id = $driver->count() + 1;
        $call_id = $calls->count() + 1;

        $driver->insert($driver_id, "driver1", "email@driver.com", "pass");
        $calls->insert($call_id, 1, new DateTime());

        $retrieved = $calls->get(2);


        $this->assertNotNull($retrieved);
    }

    public function testCreatedCall_CanBeUpdatedFromStorage()
    {
        $calls = new MySqlCallRepository($this->db);
        $driver = new MySqlDriverRepository($this->db);

        $call_id = $calls->count() + 1;
        $timestamp = new DateTime();

        $driver->insert($driver->count() + 1, "driver1", "email@driver.com", "pass");
        $driver->insert($driver->count() + 1, "driver2", "email2driver.com", "pass");
        $calls->insert($call_id, 1, $timestamp);


        $calls->update($call_id, 2, $timestamp);


        $retrieved = $calls->get($call_id);

        $this->assertEquals(2, $retrieved->driver_id);
    }

    public function testCreatedCall_CanBeDeletedFromStorage()
    {
        $calls = new MySqlCallRepository($this->db);
        $driver = new MySqlDriverRepository($this->db);

        $call_id = $calls->count() + 1;
        $driver_id = $driver->count() + 1;

        $driver->insert($driver_id, "driver2", "email2driver.com", "pass");
        $calls->insert($call_id, 1, new DateTime());


        $calls->delete($call_id);


        $retrieved = $calls->get($call_id);

        $this->assertEquals(null, $retrieved);
    }


    public function tearDown(): void
    {
        parent::tearDown();

        $stmt_call = $this->db->prepare("DELETE FROM calling");
        $stmt_driver = $this->db->prepare("DELETE FROM driver");
        $stmt_call->execute();
        $stmt_driver->execute();
    }
}
