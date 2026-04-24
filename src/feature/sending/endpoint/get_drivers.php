<?php
require_once __DIR__ . '/../../../db/lms.php';
header('Content-Type: application/json');

$drivers = [];
$result = $db->query("SELECT id, username FROM driver ORDER BY username ASC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $drivers[] = [
            'id'       => (int)$row['id'],
            'username' => $row['username']
        ];
    }
}
echo json_encode($drivers);