<?php

use lms\feature\communication\persistence\MySqlAcceptedCallRepository;
use PHPUnit\Framework\TestCase;

final class AcceptedCallIntegrationTest extends TestCase
{
    private MySqli $db;

    public function setUp(): void
    {
        parent::setUp();
        $this->db = new \mysqli("localhost", "root", "", "lms_test");
    }


    public function testCreatedAcceptedCall_ShouldBeRetrievedableFromStorage()
    {
        $accepted_calls = new MySqlAcceptedCallRepository($this->db);
    }


    public function tearDown(): void
    {
        parent::tearDown();

        $stmt = $this->db->prepare("DELETE FROM AcceptedCall");
        $stmt->execute();
    }
}
