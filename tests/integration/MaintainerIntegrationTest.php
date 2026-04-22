<?php

use lms\feature\signup\persistence\MySqlMaintainerRepository;
use PHPUnit\Framework\TestCase;

final class MaintainerIntegrationTest extends TestCase
{
    private mysqli $db;

    public function setUp(): void
    {
        parent::setUp();
        $this->db = new \mysqli("localhost", "root", "", "lms_test");
    }

    public function testCreatedUser_CanBeRetrievedFromStorage()
    {
        $user = new MySqlMaintainerRepository($this->db);

        $id = $user->count() + 1;

        $user->insert($id, "username", "email@email", "password");

        $retrieved = $user->get($id);

        $this->assertEquals("username", $retrieved->name);
        $this->assertEquals("email@email", $retrieved->email);
        $this->assertEquals("password", $retrieved->password);
    }

    public function testCreatedUser_CanBeUpdated()
    {
        $user = new MySqlMaintainerRepository($this->db);

        $id = $user->count() + 1;
        $user->insert($id, "username", "email@email", "password");


        $user->update($id, "user1", "email@gmail", "pass");


        $retrieved = $user->get($id);

        $this->assertEquals("user1", $retrieved->name);
        $this->assertEquals("email@gmail", $retrieved->email);
        $this->assertEquals("pass", $retrieved->password);
    }

    public function testCreatedUser_CanBeDeleted()
    {
        $user = new MySqlMaintainerRepository($this->db);

        $id = $user->count() + 1;
        $user->insert($id, "username", "email", "pass");


        $user->delete($id);

        $retrieved = $user->get($id);
        $this->assertEquals(null, $retrieved);
    }


    public function tearDown(): void
    {
        parent::tearDown();

        $stmt = $this->db->prepare("DELETE FROM maintainer");
        $stmt->execute();
    }
}
