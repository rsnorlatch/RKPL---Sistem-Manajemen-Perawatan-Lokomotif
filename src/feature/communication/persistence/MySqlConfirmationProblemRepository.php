<?php

namespace lms\feature\communication\persistence;

use lms\feature\communication\entities\IConfirmationProblemRepository;
use lms\feature\communication\entities\ConfirmationProblem;
use MySqli;
use DateTime;

class MySqlConfirmationProblemRepository implements IConfirmationProblemRepository
{
    private Mysqli $db;

    public function __construct(Mysqli $db)
    {
        $this->db = $db;
    }

    public function count(): int
    {
        $result = $this->db->query("SELECT COUNT(*) as count FROM confirmation_problems");
        $row = $result->fetch_assoc();
        return (int)$row['count'];
    }

    public function insert(int $id, int $driver_id, int $call_id, DateTime $timestamp, string $problem): void
    {
        $stmt = $this->db->prepare("INSERT INTO confirmation_problems (id, driver_id, call_id, timestamp, problem) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiiss", $id, $driver_id, $call_id, $timestamp->format('Y-m-d H:i:s'), $problem);
        $stmt->execute();
        $stmt->close();
    }

    public function get(int $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM confirmation_problems WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return new ConfirmationProblem($row['id'], $row['driver_id'], $row['call_id'], new DateTime($row['timestamp']), $row['problem']);
        } else {
            return null;
        }
    }

    public function getAll(): array
    {
        $result = $this->db->query("SELECT * FROM confirmation_problems");
        $problems = [];
        while ($row = $result->fetch_assoc()) {
            $problems[] = new ConfirmationProblem($row['id'], $row['driver_id'], $row['call_id'], new DateTime($row['timestamp']), $row['problem']);
        }
        return $problems;
    }


    public function update(int $id, int $driver_id, int $call_id, DateTime $timestamp, string $problem): void
    {
        $stmt = $this->db->prepare("UPDATE confirmation_problems SET driver_id = ?, call_id = ?, timestamp = ?, problem = ? WHERE id = ?");
        $stmt->bind_param("iissi", $driver_id, $call_id, $timestamp->format('Y-m-d H:i:s'), $problem, $id);
        $stmt->execute();
        $stmt->close();
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM confirmation_problems WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}
