<?php

namespace lms\feature\communication\persistence;

use lms\feature\communication\entities\IRejectedCallRepository;
use lms\feature\communication\entities\RejectedCall;
use mysqli;

class MySqlRejectedCallRepository implements IRejectedCallRepository
{
    private mysqli $db;

    public function __construct(mysqli $db)
    {
        $this->db = $db;
    }

    public function count(): int
    {
        $result = $this->db->query("SELECT COUNT(*) as count FROM rejected_calls");
        $row = $result->fetch_assoc();
        return (int)$row['count'];
    }

    public function insert(int $id, int $call_id, string $reason): void
    {
        $stmt = $this->db->prepare("INSERT INTO rejected_calls (id, call_id, reason) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $id, $call_id, $reason);
        $stmt->execute();
        $stmt->close();
    }

    public function get(int $id): RejectedCall | null
    {
        $stmt = $this->db->prepare("SELECT call_id, reason FROM rejected_calls WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            return null;
        }
        $row = $result->fetch_assoc();
        return new RejectedCall($id, $row['call_id'], $row['reason']);
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT id, call_id, reason FROM rejected_calls");
        $calls = [];
        while ($row = $stmt->fetch_assoc()) {
            $calls[] = new RejectedCall($row['id'], $row['call_id'], $row['reason']);
        }
        return $calls;
    }

    public function update(int $id, int $call_id, string $reason): void
    {
        $stmt = $this->db->prepare("UPDATE rejected_calls SET call_id = ?, reason = ? WHERE id = ?");
        $stmt->bind_param("isi", $call_id, $reason, $id);
        $stmt->execute();
        $stmt->close();
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM rejected_calls WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}
