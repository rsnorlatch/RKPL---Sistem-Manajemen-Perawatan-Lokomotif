<?php

use lms\feature\locomotive_management\persistence\MySqlLocomotiveRepository;
use lms\feature\sending\persistence\MySqlSendRequestRepository;
use lms\feature\sending\persistence\MySqlStopRepository;
use lms\feature\signup\persistence\MySqlDriverRepository;
use PHPUnit\Framework\TestCase;

final class SendRequestIntegrationTest extends TestCase
{
    private mysqli $db;

    public function setUp(): void
    {
        parent::setUp();
        $this->db = new \mysqli("localhost", "root", "", "lms_test");
        $this->db->begin_transaction();
    }


    public function testCreatedSendRequest_ShouldBeRetrieveable()
    {
        $send_requests = new MySqlSendRequestRepository($this->db);
        $drivers = new MySqlDriverRepository($this->db);
        $locomotives = new MySqlLocomotiveRepository($this->db);
        $stops = new MySqlStopRepository($this->db);

        $stop_id = $stops->count() + 1;
        $driver_id = $drivers->count() + 1;
        $locomotive_id = $locomotives->count() + 1;
        $send_requests_id = $send_requests->count() + 1;

        $stops->insert($stop_id, "name", 1, 1);
        $drivers->insert($driver_id, "name", "email", "pass");
        $locomotives->insert($locomotive_id, $driver_id, "model-1");
        $send_requests->insert($send_requests_id, $locomotive_id, $stop_id, new DateTime());


        $retrieved = $send_requests->get($send_requests_id);


        $this->assertNotNull($retrieved);
    }

    public function testCreatedSendRequest_ShouldBeUpdateable()
    {
        $send_requests = new MySqlSendRequestRepository($this->db);
        $drivers = new MySqlDriverRepository($this->db);
        $locomotives = new MySqlLocomotiveRepository($this->db);
        $stops = new MySqlStopRepository($this->db);

        $stop_id = $stops->count() + 1;
        $driver_id = $drivers->count() + 1;
        $locomotive_id = $locomotives->count() + 1;
        $send_requests_id = $send_requests->count() + 1;

        $stops->insert($stop_id, "name", 1, 1);
        $drivers->insert($driver_id, "name", "email", "pass");
        $locomotives->insert($locomotive_id, $driver_id, "model-1");
        $locomotives->insert($locomotive_id + 1, $driver_id, "model-2");
        $send_requests->insert($send_requests_id, $locomotive_id, $stop_id, new DateTime());


        $send_requests->update($send_requests_id, $locomotive_id + 1, $stop_id, new DateTime());


        $this->assertEquals($locomotive_id + 1, $send_requests->get($send_requests_id)->locomotive_id);
    }

    public function testCreatedSendRequest_ShouldBeDeleteable()
    {
        $send_requests = new MySqlSendRequestRepository($this->db);
        $drivers = new MySqlDriverRepository($this->db);
        $locomotives = new MySqlLocomotiveRepository($this->db);
        $stops = new MySqlStopRepository($this->db);

        $stop_id = $stops->count() + 1;
        $driver_id = $drivers->count() + 1;
        $locomotive_id = $locomotives->count() + 1;
        $send_requests_id = $send_requests->count() + 1;

        $stops->insert($stop_id, "name", 1, 1);
        $drivers->insert($driver_id, "name", "email", "pass");
        $locomotives->insert($locomotive_id, $driver_id, "model-1");
        $send_requests->insert($send_requests_id, $locomotive_id, $stop_id, new DateTime());


        $send_requests->delete($send_requests_id);


        $this->assertEquals(null, $send_requests->get($send_requests_id));
    }

    public function tearDown(): void
    {
        parent::tearDown();

        $this->db->rollback();
        $this->db->close();
    }
}
