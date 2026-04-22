<?php

use lms\feature\communication\persistence\MySqlCallRepository;
use lms\feature\communication\persistence\MySqlRejectedCallRepository;
use lms\feature\signup\persistence\MySqlDriverRepository;
use PHPUnit\Framework\TestCase;

final class RejectedCallIntegrationTest extends TestCase
{
    private MySqli $db;

    public function setUp(): void
    {
        parent::setUp();
        $this->db = new \mysqli("localhost", "root", "", "lms_test");
        $this->db->begin_transaction();
    }


    public function testCreatedRejection_ShouldBeRetrievable()
    {
        $drivers = new MySqlDriverRepository($this->db);
        $calls = new MySqlCallRepository($this->db);
        $rejections = new MySqlRejectedCallRepository($this->db);

        $driver_id = $drivers->count() + 1;
        $call_id = $calls->count() + 1;
        $rejection_id = $rejections->count() + 1;

        $drivers->insert($driver_id, "username", "email", "password");
        $calls->insert($call_id, $driver_id, new DateTime());
        $rejections->insert($rejection_id, $call_id, "");


        $retrieved = $rejections->get($rejection_id);


        $this->assertNotNull($retrieved);
    }

    public function testCreatedRejection_ShouldBeUpdateable()
    {
        $drivers = new MySqlDriverRepository($this->db);
        $calls = new MySqlCallRepository($this->db);
        $rejections = new MySqlRejectedCallRepository($this->db);

        $driver_id = $drivers->count() + 1;
        $call_id = $calls->count() + 1;
        $rejection_id = $rejections->count() + 1;

        $drivers->insert($driver_id, "username", "email", "password");
        $drivers->insert($driver_id + 1, "username", "email", "password");
        $calls->insert($call_id, $driver_id, new DateTime());
        $calls->insert($call_id + 1, $driver_id + 1, new DateTime());
        $rejections->insert($rejection_id, $call_id, "");


        $rejections->update($rejection_id, $call_id + 1, "");


        $this->assertEquals($call_id + 1, $rejections->get($rejection_id)->call_id);
    }

    public function testCreatedRejection_ShouldBeDeleteable()
    {
        $drivers = new MySqlDriverRepository($this->db);
        $calls = new MySqlCallRepository($this->db);
        $rejections = new MySqlRejectedCallRepository($this->db);

        $driver_id = $drivers->count() + 1;
        $call_id = $calls->count() + 1;
        $rejection_id = $rejections->count() + 1;

        $drivers->insert($driver_id, "username", "email", "password");
        $drivers->insert($driver_id + 1, "username", "email", "password");
        $calls->insert($call_id, $driver_id, new DateTime());
        $calls->insert($call_id + 1, $driver_id + 1, new DateTime());
        $rejections->insert($rejection_id, $call_id, "");


        $rejections->delete($rejection_id);


        $this->assertEquals(null, $rejections->get($rejection_id));
    }


    public function tearDown(): void
    {
        parent::tearDown();

        $this->db->rollback();
        $this->db->close();
    }
}
