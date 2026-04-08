<?php

namespace lms\feature\sending\persistence;

use lms\feature\sending\entities\IStopRepository;
use lms\feature\sending\entities\Stop;
use mysqli;

class MySqlStopRepository implements IStopRepository
{
    private mysqli $db;

    public function __construct(mysqli $db)
    {
        $this->db = $db;
    }

    public function count(): int
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) AS count FROM stop");
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $row = $result->fetch_assoc()) {
            return (int)$row['count'];
        }

        return 0;
    }

    public function insert(int $id, string $name, int $x, int $y): void
    {
        $stmt = $this->db->prepare("INSERT INTO stop (id, name, x, y) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isii", $id, $name, $x, $y);
        $stmt->execute();
    }

    public function get(int $id): Stop
    {
        $stmt = $this->db->prepare("SELECT id, name, x, y FROM stop WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $row = $result->fetch_assoc()) {
            return new Stop((int)$row['id'], $row['name'], (int)$row['x'], (int)$row['y']);
        }

        throw new \RuntimeException("Stop with id {$id} not found.");
    }

    public function getAll(): array
    {
        $stmt = $this->db->prepare("SELECT id, name, x, y FROM stop");
        $stmt->execute();
        $result = $stmt->get_result();

        $stops = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $stops[] = new Stop((int)$row['id'], $row['name'], (int)$row['x'], (int)$row['y']);
            }
        }

        return $stops;
    }

    public function update(int $id, string $name, int $x, int $y): void
    {
        $stmt = $this->db->prepare("UPDATE stop SET name = ?, x = ?, y = ? WHERE id = ?");
        $stmt->bind_param("siii", $name, $x, $y, $id);
        $stmt->execute();
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM stop WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}
