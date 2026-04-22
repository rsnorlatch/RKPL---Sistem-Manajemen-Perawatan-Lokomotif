<?php

namespace lms\feature\sending\persistence;

use lms\feature\sending\entities\ISendRequestRepository;
use lms\feature\sending\entities\SendRequest;
use DateTime;
use mysqli;

class MySqlSendRequestRepository implements ISendRequestRepository
{
    private mysqli $db;

    public function __construct(mysqli $db)
    {
        $this->db = $db;
    }

    public function count(): int
    {
        $result = $this->db->query("SELECT COUNT(*) AS count FROM send_request");
        if ($result) {
            $row = $result->fetch_assoc();
            return (int)$row['count'];
        }

        return 0;
    }

    public function insert(int $id, int $locomotive_id, int $destination_id, DateTime $request_time): void
    {
        $stmt = $this->db->prepare("INSERT INTO send_request (id, locomotive_id, destination_id, request_time) VALUES (?, ?, ?, ?)");
        $timestamp = $request_time->format('Y-m-d H:i:s');
        $stmt->bind_param("iiis", $id, $locomotive_id, $destination_id, $timestamp);
        $stmt->execute();
    }

    public function get(int $id): SendRequest | null
    {
        $stmt = $this->db->prepare("SELECT id, locomotive_id, destination_id, request_time FROM send_request WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $row = $result->fetch_assoc()) {
            return new SendRequest(
                (int)$row['id'],
                (int)$row['locomotive_id'],
                (int)$row['destination_id'],
                new DateTime($row['request_time'])
            );
        }

        return null;
    }

    public function getAll(): array
    {
        $result = $this->db->query("SELECT id, locomotive_id, destination_id, request_time FROM send_request");
        $sendRequests = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $sendRequests[] = new SendRequest(
                    (int)$row['id'],
                    (int)$row['locomotive_id'],
                    (int)$row['destination_id'],
                    new DateTime($row['request_time'])
                );
            }
        }

        return $sendRequests;
    }

    public function update(int $id, int $locomotive_id, int $destination_id, DateTime $request_time): void
    {
        $stmt = $this->db->prepare("UPDATE send_request SET locomotive_id = ?, destination_id = ?, request_time = ? WHERE id = ?");
        $timestamp = $request_time->format('Y-m-d H:i:s');
        $stmt->bind_param("iisi", $locomotive_id, $destination_id, $timestamp, $id);
        $stmt->execute();
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM send_request WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}
