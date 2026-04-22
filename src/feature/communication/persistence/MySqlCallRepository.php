<?php

namespace lms\feature\communication\persistence;

use lms\feature\communication\entities\Call;
use lms\feature\communication\entities\ICallRepository;
use mysqli;
use DateTime;

class MySqlCallRepository implements ICallRepository
{
    private mysqli $db;

    public function __construct(mysqli $db)
    {
        $this->db = $db;
    }

    public function count(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM calling");
        return (int)$stmt->fetch_assoc();
    }

    public function insert(int $id, int $driver_id, DateTime $timestamp): void
    {
        $stmt = $this->db->prepare("INSERT INTO calling (id, driver_id, call_time) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $id, $driver_id, $timestamp->format('Y-m-d H:i:s'));
        $stmt->execute();
        $stmt->close();
    }

    public function get(int $id): Call | null
    {
        $stmt = $this->db->prepare("
            SELECT 
                c.id AS id,
                c.driver_id AS driver_id,
                c.call_time AS call_time

            FROM calling c
            WHERE c.id = ?;");

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows === 0) {
            return null;
        }

        $row = $result->fetch_assoc();
        return new Call(
            $row['id'],
            $row['driver_id'],
            new DateTime($row['call_time'])
        );
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM calling");
        $calls = [];
        while ($row = $stmt->fetch_assoc()) {
            $calls[] = new Call($row['id'], $row['driver_id'], $row['call_time']);
        }
        return $calls;
    }

    public function update(int $id, int $driver_id, DateTime $timestamp): void
    {
        $stmt = $this->db->prepare("
            UPDATE calling 
            SET 
                driver_id = ?,
                call_time = ?
            WHERE id = ?");
        $stmt->bind_param("isi", $driver_id, $timestamp->format('Y-m-d H:i:s'), $id);
        $stmt->execute();
        $stmt->close();
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM calling WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}
