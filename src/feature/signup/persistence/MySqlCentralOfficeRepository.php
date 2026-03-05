<?php

namespace lms\feature\signup\persistence;

use lms\feature\signup\entities\CentralOffice;
use lms\feature\signup\entities\ICentralOfficeRepository;
use mysqli;

require_once __DIR__."../../../../../vendor/autoload.php";
require_once __DIR__."../../../../../src/db/lms.php";


class MySqlCentralOfficeRepository implements ICentralOfficeRepository
{
    private MySqli $db;

    function __construct(MySqli $connection)
    {
        $this->db = $connection;
    }

    public function count(): int
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM central_office");
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
        $stmt = $this->db->prepare("INSERT INTO central_office (id, username, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $id, $username, $email, $password);
        $stmt->execute();
    }

    public function get(int $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM central_office WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return new CentralOffice($row['id'], $row['username'], $row['email'], $row['password']);
        } else {
            return null;
        }
    }
    public function getAll(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM central_office");
        $stmt->execute();
        $result = $stmt->get_result();
        $central_office = [];
        while ($row = $result->fetch_assoc()) {
            $central_office[] = $row;
        }
        
        return array_map(function($row) {
            return new CentralOffice($row['id'], $row['username'], $row['email'], $row['password']);
        }, $central_office);
        
    }
    public function update(int $id, string $username, string $email, string $password): void
    {
        $stmt = $this->db->prepare("UPDATE central_office SET username = ?, email = ?, password = ? WHERE id = ?");
        $stmt->bind_param("sssi", $username, $email, $password, $id);
        $stmt->execute();
    }
    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM central_office WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}
