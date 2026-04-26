<?php
/**
 * theme_helper.php
 * 
 * Include file ini di semua halaman SETELAH session_start() dan DB connection.
 * Fungsinya: ambil preferensi theme user dari DB/session, 
 * lalu return string class CSS untuk ditaruh di <body>.
 * 
 * CARA PAKAI:
 *   require_once __DIR__ . '/path/to/theme_helper.php';
 *   // lalu di <body>:
 *   <body class="<?= $body_class ?>">
 * 
 * SYARAT:
 *   - session_start() sudah dipanggil
 *   - $db (mysqli) sudah tersedia
 *   - user sudah login ($_SESSION['is_logged_in'] = true)
 */

// Kalau belum punya theme di session (belum diset saat login),
// coba ambil dari DB langsung
if (empty($_SESSION['theme']) && !empty($_SESSION['user_id']) && !empty($_SESSION['is_logged_in'])) {
    
    if (!empty($_SESSION['user_is_driver']))
        $pref_table = 'driver_preference';
    elseif (!empty($_SESSION['user_is_maintainer']))
        $pref_table = 'maintainer_preference';
    else
        $pref_table = 'central_office_preference';

    $uid  = (int)$_SESSION['user_id'];
    $res  = $db->query("SELECT theme FROM `$pref_table` WHERE user_id = $uid LIMIT 1");
    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();
        // ThemeVariant::Dark = "Dark", ThemeVariant::Light = "Light"
        $_SESSION['theme'] = ($row['theme'] === 'Dark') ? 'night' : 'day';
    } else {
        $_SESSION['theme'] = 'day'; // default
    }
}

// Hasilkan string class untuk <body>
$body_class = (!empty($_SESSION['theme']) && $_SESSION['theme'] === 'night') ? 'dark' : '';