<?php

namespace lms\feature\locomotive_management\persistence;

use lms\feature\maintenance_program\entities\MaintenanceUnit;
use lms\feature\maintenance_program\entities\IMaintenanceUnitRepository;

require_once __DIR__ . "../../../../../vendor/autoload.php";
require_once __DIR__."../../../../../src/db/lms.php";


class MySqlMaintenanceUnitRepository implements IMaintenanceUnitRepository 
{
    private \mysqli $db;

    public function __construct(\mysqli $db) {
        $this->db = $db;
    }

    public function insert(int $id, int $sequence_number, string $unit): void
    {
        $stmt = $this->db->prepare("INSERT INTO maintenance_unit (id, sequence_number, unit) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $id, $sequence_number, $unit);
        $stmt->execute();
    }

    public function get(int $id): MaintenanceUnit | null
    {
        $stmt = $this->db->prepare("SELECT * FROM maintenance_unit WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return new MaintenanceUnit($row['id'], $row['sequence_number'], $row['unit']);
        } else {
            return null;
        }
    }

    public function getAll(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM maintenance_unit");
        $stmt->execute();
        $result = $stmt->get_result();
        $units = [];
        while ($row = $result->fetch_assoc()) {
            $units[] = new MaintenanceUnit($row['id'], $row['sequence_number'], $row['unit']);
        }
        return $units;
    }       

    public function count(): int
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM maintenance_unit");
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return (int)$row['count'];
        } else {
            return 0;
        }
    }   

    public function update(int $id, int $sequence_number, string $unit): void
    {
        $stmt = $this->db->prepare("UPDATE maintenance_unit SET sequence_number = ?, unit = ? WHERE id = ?");
        $stmt->bind_param("isi", $sequence_number, $unit, $id);
        $stmt->execute();
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM maintenance_unit WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
} 