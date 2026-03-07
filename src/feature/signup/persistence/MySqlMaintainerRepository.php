<?php

namespace lms\feature\signup\persistence;

use lms\feature\signup\entities\IMaintainerRepository;
use lms\feature\signup\entities\Maintainer;
use mysqli;

require_once __DIR__."../../../../../vendor/autoload.php";
require_once __DIR__."../../../../../src/db/lms.php";

class MySqlMaintainerRepository implements IMaintainerRepository
{
    private MySqli $db;

    function __construct(MySqli $connection)
    {
        $this->db = $connection;
    }

    public function count(): int
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM maintainer");
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
        $stmt = $this->db->prepare("INSERT INTO maintainer (id, username, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $id, $username, $email, $password);
        $stmt->execute();
    }

    public function get(int $id): Maintainer | null
    {
        $stmt = $this->db->prepare("SELECT * FROM maintainer WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return new Maintainer($row['id'], $row['username'], $row['email'], $row['password']);
        } else {
            return null;
        }
    }

    public function getByUsername(string $username): Maintainer | null
    {
        $stmt = $this->db->prepare("SELECT * FROM maintainer WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return new Maintainer($row['id'], $row['username'], $row['email'], $row['password']);
        } else {
            return null;
        }
    }

    public function getAll(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM maintainer");
        $stmt->execute();
        $result = $stmt->get_result();
        $maintainer = [];
        while ($row = $result->fetch_assoc()) {
            $maintainer[] = $row;
        }
        return array_map(function($row) {
            return new Maintainer($row['id'], $row['username'], $row['email'], $row['password']);
        }, $maintainer);
    }
    public function update(int $id, string $username, string $email, string $password): void
    {
        $stmt = $this->db->prepare("UPDATE maintainer SET username = ?, email = ?, password = ? WHERE id = ?");
        $stmt->bind_param("sssi", $username, $email, $password, $id);
        $stmt->execute();
    }
    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM maintainer WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}