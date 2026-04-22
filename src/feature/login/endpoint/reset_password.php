<?php
// src/feature/login/endpoint/reset_password.php
// Step 1: cek username ada di DB → redirect ke step 2
// Step 2: update password baru

require_once __DIR__ . '/../../../../src/db/lms.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../../../front-end/reset_password.php');
    exit;
}

$step = (int)($_POST['step'] ?? 1);
$back = '../../../../front-end/reset_password.php';

// ── STEP 1: cek username ──────────────────────────────────
if ($step === 1) {
    $username = trim($_POST['username'] ?? '');

    if ($username === '') {
        header("Location: $back?step=1&error=Username+tidak+boleh+kosong");
        exit;
    }

    $u = $db->real_escape_string($username);

    // Cari di ketiga tabel (driver, maintainer, central_office)
    $tables = ['driver', 'maintainer', 'central_office'];
    $found  = false;

    foreach ($tables as $table) {
        $res = $db->query("SELECT id FROM `$table` WHERE username='$u' LIMIT 1");
        if ($res && $res->num_rows > 0) {
            $found = true;
            break;
        }
    }

    if (!$found) {
        header("Location: $back?step=1&error=Username+tidak+ditemukan");
        exit;
    }

    // Username ada → lanjut ke step 2
    header("Location: $back?step=2&username=" . urlencode($username));
    exit;
}

// ── STEP 2: update password ───────────────────────────────
if ($step === 2) {
    $username        = trim($_POST['username']         ?? '');
    $new_password    = $_POST['new_password']          ?? '';
    $confirm_password = $_POST['confirm_password']     ?? '';

    if ($new_password !== $confirm_password) {
        header("Location: $back?step=2&username=" . urlencode($username) . "&error=Password+tidak+cocok");
        exit;
    }

    if (strlen($new_password) < 6) {
        header("Location: $back?step=2&username=" . urlencode($username) . "&error=Password+minimal+6+karakter");
        exit;
    }

    $u      = $db->real_escape_string($username);
    $hashed = $db->real_escape_string($new_password);
    $tables = ['driver', 'maintainer', 'central_office'];
    $updated = false;

    foreach ($tables as $table) {
        // Cek dulu apakah username ada di tabel ini
        $res = $db->query("SELECT id FROM `$table` WHERE username='$u' LIMIT 1");
        if ($res && $res->num_rows > 0) {
            $db->query("UPDATE `$table` SET password='$hashed' WHERE username='$u'");
            $updated = true;
            break;
        }
    }

    if ($updated) {
        header("Location: $back?success=1");
    } else {
        header("Location: $back?step=1&error=Username+tidak+ditemukan");
    }
    exit;
}

// Fallback
header("Location: $back");
exit;
