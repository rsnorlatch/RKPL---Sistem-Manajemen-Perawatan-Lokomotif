<?php

namespace lms\feature\communication\persistence;

use lms\feature\communication\entities\IConfirmationFinishRepository;
use lms\feature\communication\entities\ConfirmationFinish;
use DateTime;
use MySqli;

class MySqlConfirmationFinishRepository implements IConfirmationFinishRepository
{
    private MySqli $db;

    public function __construct(MySqli $db)
    {
        $this->db = $db;
    }

    public function count(): int
    {
        $result = $this->db->query("SELECT COUNT(*) as count FROM confirmation_finish");
        $row = $result->fetch_assoc();
        return (int)$row['count'];
    }

    public function insert(int $id, int $driver_id, int $call_id, DateTime $timestamp): void
    {
        $stmt = $this->db->prepare("INSERT INTO confirmation_finish (id, driver_id, call_id, timestamp) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiis", $id, $driver_id, $call_id, $timestamp->format('Y-m-d H:i:s'));
        $stmt->execute();
        $stmt->close();
    }

    public function get(int $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM confirmation_finish WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return new ConfirmationFinish($row['id'], $row['driver_id'], $row['call_id'], new DateTime($row['timestamp']));
        } else {
            return null;
        }
    }

    public function getAll(): array
    {
        $result = $this->db->query("SELECT * FROM confirmation_finish");
        $finishes = [];
        while ($row = $result->fetch_assoc()) {
            $finishes[] = new ConfirmationFinish($row['id'], $row['driver_id'], $row['call_id'], new DateTime($row['timestamp']));
        }
        return $finishes;
    }

    public function update(int $id, int $driver_id, int $call_id, DateTime $timestamp): void
    {
        $stmt = $this->db->prepare("UPDATE confirmation_finish SET driver_id = ?, call_id = ?, timestamp = ? WHERE id = ?");
        $stmt->bind_param("iisi", $driver_id, $call_id, $timestamp->format('Y-m-d H:i:s'), $id);
        $stmt->execute();
        $stmt->close();
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM confirmation_finish WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}
