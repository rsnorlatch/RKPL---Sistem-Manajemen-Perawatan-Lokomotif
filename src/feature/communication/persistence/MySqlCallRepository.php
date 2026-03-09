<?php

use lms\feature\communication\entities\AcceptedCall;
use lms\feature\communication\entities\IAcceptedCallRepository;


class MySqlCallRepository implements IAcceptedCallRepository
{
    private mysqli $db;

    public function __construct(mysqli $db)
    {
        $this->db = $db;
    }

    public function count(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM accepted_calls");
        return (int)$stmt->fetch_assoc();
    }

    public function insert(int $id, int $call_id): void
    {
        $stmt = $this->db->prepare("INSERT INTO accepted_calls (id, call_id) VALUES (:id, :call_id)");
        $stmt->execute(['id' => $id, 'call_id' => $call_id]);
        $stmt->close();
    }

    public function get(int $id): AcceptedCall | null
    {
        $stmt = $this->db->prepare("SELECT * FROM accepted_calls WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows === 0) {
            return null;
        }

        $row = $result->fetch_assoc();
        return new AcceptedCall($row['id'], $row['call_id']);
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM accepted_calls");
        $calls = [];
        while ($row = $stmt->fetch_assoc()) {
            $calls[] = new AcceptedCall($row['id'], $row['call_id']);
        }
        return $calls;
    }

    public function update(int $id, int $call_id): void
    {
        $stmt = $this->db->prepare("UPDATE accepted_calls SET call_id = :call_id WHERE id = :id");
        $stmt->execute(['id' => $id, 'call_id' => $call_id]);
        $stmt->close();
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM accepted_calls WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $stmt->close();
    }
}
