<?php

namespace lms\feature\signup\persistence;

use lms\feature\signup\entities\Driver;
use MySqli;
use lms\feature\signup\entities\IDriverRepository;

require_once __DIR__."../../../../../vendor/autoload.php";
require_once __DIR__."../../../../../src/db/lms.php";

class MySqlDriverRepository implements IDriverRepository
{
    private MySqli $db;

    function __construct(MySqli $connection)
    {
        $this->db = $connection;
    }

    public function count(): int
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM driver");
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return (int)$row['count'];
        } else {
            return 0;
        }
    }

    public function insert(int $id, string $username, string $email, string $password): void
    {
        $stmt = $this->db->prepare("INSERT INTO driver (id, username, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $id, $username, $email, $password);
        $stmt->execute();
    }

    public function get(int $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM driver WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return new Driver($row['id'], $row['username'], $row['email'], $row['password']);
        } else {
            return null;
        }
    }

    public function getByUsername(string $username)
    {
        $stmt = $this->db->prepare("SELECT * FROM driver WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return new Driver($row['id'], $row['username'], $row['email'], $row['password']);
        } else {
            return null;
        }
    }

    public function getAll(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM driver");
        $stmt->execute();
        $result = $stmt->get_result();
        $driver = [];
        while ($row = $result->fetch_assoc()) {
            $driver[] = $row;
        }
        return array_map(function($row) {
            return new Driver($row['id'], $row['username'], $row['email'], $row['password']);
        }, $driver);
        
    }
    public function update(int $id, string $username, string $email, string $password): void
    {
        $stmt = $this->db->prepare("UPDATE driver SET username = ?, email = ?, password = ? WHERE id = ?");
        $stmt->bind_param("sssi", $username, $email, $password, $id);
        $stmt->execute();
    }
    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM driver WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}