<?php

use lms\feature\communication\entities\ICallRepository;
use lms\feature\communication\entities\Call;
use DateTime;

class MySqlCallRepository implements ICallRepository
{
    private mysqli $db;

    function __construct(mysqli $db)
    {
        $this->db = $db;
    }

    function count(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) as count FROM calls");
        $result = $stmt->fetch_assoc();
        return (int)$result['count'];
    }

    function insert(int $id, int $driver_id, DateTime $timestamp): void
    {
        $stmt = $this->db->prepare("INSERT INTO calls (id, driver_id, timestamp) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $id, $driver_id, $timestamp->format('Y-m-d H:i:s'));
        $stmt->execute();
        $stmt->close();
    }

    function get(int $id): Call | null
    {
        $stmt = $this->db->prepare("SELECT * FROM calls WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return new Call($row['id'], $row['driver_id'], new DateTime($row['timestamp']));
        } else {
            return null;
        }
    }

    function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM calls");
        $calls = [];
        while ($row = $stmt->fetch_assoc()) {
            $calls[] = new Call($row['id'], $row['driver_id'], new DateTime($row['timestamp']));
        }
        return $calls;
    }

    function update(int $id, int $driver_id, DateTime $timestamp): void
    {
        $stmt = $this->db->prepare("UPDATE calls SET driver_id = ?, timestamp = ? WHERE id = ?");
        $stmt->bind_param("isi", $driver_id, $timestamp->format('Y-m-d H:i:s'), $id);
        $stmt->execute();
        $stmt->close();
    }

    function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM calls WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}
