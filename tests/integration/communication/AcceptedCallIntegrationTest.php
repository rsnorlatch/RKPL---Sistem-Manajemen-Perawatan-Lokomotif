<?php

use lms\feature\communication\persistence\MySqlAcceptedCallRepository;
use lms\feature\communication\persistence\MySqlCallRepository;
use lms\feature\signup\persistence\MySqlDriverRepository;
use PHPUnit\Framework\TestCase;

final class AcceptedCallIntegrationTest extends TestCase
{
    private MySqli $db;

    public function setUp(): void
    {
        parent::setUp();
        $this->db = new \mysqli("localhost", "root", "", "lms_test");
        $this->db->begin_transaction();
    }


    public function testCreatedAcceptedCall_ShouldBeRetrieveable()
    {
        $calls = new MySqlCallRepository($this->db);
        $drivers = new MySqlDriverRepository($this->db);
        $accepted_calls = new MySqlAcceptedCallRepository($this->db);

        $driver_id = $drivers->count() + 1;
        $call_id = $calls->count() + 1;
        $accepted_calls_id = $accepted_calls->count() + 1;

        $drivers->insert($driver_id, "username", "email", "password");
        $calls->insert($call_id, $driver_id, new DateTime());
        $accepted_calls->insert($accepted_calls_id, $call_id);


        $retrieved = $calls->get($call_id);


        $this->assertNotNull($retrieved);
    }

    public function testCreatedAcceptedCall_ShouldBeUpdateable()
    {
        $calls = new MySqlCallRepository($this->db);
        $drivers = new MySqlDriverRepository($this->db);
        $accepted_calls = new MySqlAcceptedCallRepository($this->db);

        $driver_id = $drivers->count() + 1;
        $call_id = $calls->count() + 1;
        $accepted_calls_id = $accepted_calls->count() + 1;

        $drivers->insert($driver_id, "username", "email", "password");
        $drivers->insert($driver_id + 1, "username", "email", "password");
        $calls->insert($call_id, $driver_id, new DateTime());
        $calls->insert($call_id + 1, $driver_id + 1, new DateTime());
        $accepted_calls->insert($accepted_calls_id, $call_id);


        $accepted_calls->update($accepted_calls_id, $call_id + 1);


        $this->assertEquals($call_id + 1, $accepted_calls->get($accepted_calls_id)->call_id);
    }

    public function testCreatedAcceptedCall_ShouldBeDeletable()
    {
        $calls = new MySqlCallRepository($this->db);
        $drivers = new MySqlDriverRepository($this->db);
        $accepted_calls = new MySqlAcceptedCallRepository($this->db);

        $driver_id = $drivers->count() + 1;
        $call_id = $calls->count() + 1;
        $accepted_calls_id = $accepted_calls->count() + 1;

        $drivers->insert($driver_id, "username", "email", "password");
        $calls->insert($call_id, $driver_id, new DateTime());
        $accepted_calls->insert($accepted_calls_id, $call_id);


        $accepted_calls->delete($accepted_calls_id);


        $this->assertEquals(null, $accepted_calls->get($accepted_calls_id));
    }

    public function tearDown(): void
    {
        parent::tearDown();

        $this->db->rollback();
        $this->db->close();
    }
}
