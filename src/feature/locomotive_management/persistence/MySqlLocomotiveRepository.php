<?php

namespace lms\feature\locomotive_management\persistence;
use lms\feature\locomotive_management\entities\Locomotive;
use lms\feature\locomotive_management\entities\ILocomotiveRepository;
use MySqli;

require_once __DIR__ . "../../../../../vendor/autoload.php";

class MySqlLocomotiveRepository implements ILocomotiveRepository
{
    private MySqli $db;

    function __construct(MySqli $connection)
    {
        $this->db = $connection;
    }

    public function count(): int
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM maintenance_schedule");
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return (int)$row['count'];
        } else {
            return 0;
        }
    }

    public function insert(int $id, int $driver_id, string $model): void
    {
        $stmt = $this->db->prepare("INSERT INTO locomotive (id, driver_id, model) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $id, $driver_id, $model);
        $stmt->execute();
    }

    public function get(int $id): Locomotive | null
    {
        $stmt = $this->db->prepare("SELECT * FROM locomotive WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return new Locomotive($row['id'], $row['driver_id'], $row['model']);
        } else {
            return null;
        }
    }
    public function getAll(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM locomotive");
        $stmt->execute();
        $result = $stmt->get_result();
        $locomotives = [];
        while ($row = $result->fetch_assoc()) {
            $locomotives[] = new Locomotive($row['id'], $row['name'], $row['model']);
        }
        return $locomotives;
        
    }

    public function update(int $id, int $driver_id, string $model): void
    {
        $stmt = $this->db->prepare("UPDATE locomotive SET driver_id = ?, model = ? WHERE id = ?");
        $stmt->bind_param("iis", $driver_id, $model, $id);
        $stmt->execute();
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM locomotive WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}