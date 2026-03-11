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
        $stmt = $this->db->query("SELECT COUNT(*) FROM accepted_call");
        return (int)$stmt->fetch_assoc();
    }

    public function insert(int $id, int $driver_id, DateTime $timestamp): void
    {
        $stmt = $this->db->prepare("INSERT INTO accepted_call (id, call_id) VALUES (:id, :call_id)");
        $stmt->execute(['id' => $id, 'call_id' => $driver_id]);
        $stmt->close();
    }

    public function get(int $id): Call | null
    {
        $stmt = $this->db->prepare("
            SELECT 
                c.id AS id,
                c.driver_id AS driver_id,
                c.call_time AS timestamp

            FROM accepted_call a
            JOIN calling c ON c.id = a.call_id
            WHERE a.id = ?;");

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
            new DateTime($row['timestamp'])
        );
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM accepted_call");
        $calls = [];
        while ($row = $stmt->fetch_assoc()) {
            $calls[] = new Call($row['id'], $row['driver_id'], $row['timestamp']);
        }
        return $calls;
    }

    public function update(int $id, int $driver_id, DateTime $timestamp): void
    {
        $stmt = $this->db->prepare("UPDATE accepted_call SET call_id = :call_id WHERE id = :id");
        $stmt->execute(['id' => $id, 'call_id' => $driver_id]);
        $stmt->close();
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM accepted_call WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $stmt->close();
    }
}
