<?php

namespace lms\feature\communication\persistence;

use lms\feature\communication\entities\AcceptedCall;
use lms\feature\communication\entities\IAcceptedCallRepository;

class MySqlAcceptedCallRepository implements IAcceptedCallRepository
{
    private $db;

    function __construct($db)
    {
        $this->db = $db;
    }

    public function insert(int $id, int $call_id): void
    {
        $stmt = $this->db->prepare("INSERT INTO accepted_call (id, call_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $id, $call_id);
        $stmt->execute();
        $stmt->close();
    }

    public function get(int $id): AcceptedCall | null
    {
        $stmt = $this->db->prepare("SELECT call_id FROM accepted_call WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            return null;
        }
        $row = $result->fetch_assoc();
        return new AcceptedCall($id, $row['call_id']);
    }

    public function getAll(): array
    {
        $stmt = $this->db->prepare("SELECT id, call_id FROM accepted_call");
        $stmt->execute();
        $result = $stmt->get_result();
        $calls = [];
        while ($row = $result->fetch_assoc()) {
            $calls[] = new AcceptedCall($row['id'], $row['call_id']);
        }
        return $calls;
    }

    public function update(int $id, int $call_id): void
    {
        $stmt = $this->db->prepare("UPDATE accepted_call SET call_id = ? WHERE id = ?");
        $stmt->bind_param("ii", $call_id, $id);
        $stmt->execute();
        $stmt->close();
    }

    public function count(): int
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM accepted_call");
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return (int)$row['count'];
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM accepted_call WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}
