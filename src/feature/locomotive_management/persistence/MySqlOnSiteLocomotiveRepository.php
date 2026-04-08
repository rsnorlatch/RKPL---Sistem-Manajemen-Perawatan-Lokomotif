<?php

namespace lms\feature\locomotive_management\persistence;

use lms\feature\locomotive_management\entities\IOnSiteLocomotiveRepository;
use lms\feature\locomotive_management\entities\Locomotive;
use mysqli;

class MySqlOnSiteLocomotiveRepository implements IOnSiteLocomotiveRepository
{
    private mysqli $db;

    public function __construct(mysqli $db)
    {
        $this->db = $db;
    }

    public function count(): int
    {
        $result = $this->db->query("SELECT COUNT(*) AS count FROM onsite_locomotive");
        if ($result) {
            $row = $result->fetch_assoc();
            return (int)$row['count'];
        }
        return 0;
    }

    public function insert(int $id, int $driver_id, string $model): void
    {
        $stmt = $this->db->prepare("INSERT INTO onsite_locomotive (id, driver_id, model) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $id, $driver_id, $model);
        $stmt->execute();
    }

    public function get(int $id)
    {
        $stmt = $this->db->prepare("
            SELECT
                l.id,
                l.driver_id,
                l.model
            FROM onsite_locomotive o
            JOIN locomotive l ON o.id = l.id
            WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $row = $result->fetch_assoc()) {
            return new Locomotive((int)$row['id'], (int)$row['driver_id'], $row['model']);
        }
        return null;
    }

    public function getAll(): array
    {
        $result = $this->db->query("
            SELECT 
                l.id, 
                l.driver_id, 
                l.model 
            FROM onsite_locomotive o
            JOIN locomotive l ON o.id = l.id
        ");
        $locomotives = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $locomotives[] = new Locomotive((int)$row['id'], (int)$row['driver_id'], $row['model']);
            }
        }
        return $locomotives;
    }

    public function update(int $id, int $driver_id, string $model): void
    {
        $stmt = $this->db->prepare("UPDATE onsite_locomotive SET driver_id = ?, model = ? WHERE id = ?");
        $stmt->bind_param("isi", $driver_id, $model, $id);
        $stmt->execute();
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM onsite_locomotive WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}
