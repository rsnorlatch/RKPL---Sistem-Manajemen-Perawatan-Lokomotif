<?php

namespace lms\feature\maintenance_schedule\persistence;

use lms\feature\maintenance_schedule\entities\IScheduleRepository;
use lms\feature\maintenance_schedule\entities\Schedule;
use DateTime;
use MySqli;

require_once __DIR__ . "../../../../../vendor/autoload.php";


class MySqlScheduleRepository implements IScheduleRepository
{
    private MySqli $db;

    function __construct(MySqli $connection)
    {
        $this->db = $connection;
    }

    public function count(): int
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM maintenance_schedule");
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return (int)$row['count'];
        } else {
            return 0;
        }
    }

    public function insert(int $id, DateTime $start, DateTime $end, int $locomotive_id): void
    {
        $stmt = $this->db->prepare("INSERT INTO maintenance_schedule (id, start, end, locomotive_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $id, $start->format('Y-m-d H:i:s'), $end->format('Y-m-d H:i:s'), $locomotive_id);
        $stmt->execute();
    }

    public function get(int $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM maintenance_schedule WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return new Schedule($row['id'], new DateTime($row['start']), new DateTime($row['end']), $row['locomotive_id']);
        } else {
            return null;
        }
    }
    public function getAll(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM maintenance_schedule");
        $stmt->execute();
        $result = $stmt->get_result();
        $maintenance_schedule = [];
        while ($row = $result->fetch_assoc()) {
            $maintenance_schedule[] = new Schedule($row['id'], new DateTIme($row['start']), new DateTime($row['end']), $row['locomotive_id']);
        }
        return $maintenance_schedule;
    }
    public function update(int $id, DateTime $start, DateTime $end, int $locomotive_id): void
    {
        $stmt = $this->db->prepare("UPDATE maintenance_schedule SET start = ?, end = ?, locomotive_id = ? WHERE id = ?");
        $stmt->bind_param("ssii", $start->format('Y-m-d H:i:s'), $end->format('Y-m-d H:i:s'), $locomotive_id, $id);
        $stmt->execute();
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM maintenance_schedule WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}
