<?php
session_start();
require_once __DIR__ . '/../src/db/lms.php';

$loco_id = isset($_GET['loco_id']) ? (int)$_GET['loco_id'] : 0;
$model   = isset($_GET['model'])   ? htmlspecialchars($_GET['model']) : '-';
$kode    = isset($_GET['kode'])    ? htmlspecialchars($_GET['kode'])  : '-';

$driver_name = '-';
$stmt = $db->prepare("SELECT d.username FROM driver d JOIN locomotive l ON l.driver_id = d.id WHERE l.id = ? LIMIT 1");
if ($stmt) {
  $stmt->bind_param("i", $loco_id);
  $stmt->execute();
  $row = $stmt->get_result()->fetch_assoc();
  if ($row) $driver_name = htmlspecialchars($row['username']);
  $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kirim Lokomotif – LMS PT KAI</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  <link rel="stylesheet" href="../styling_feature/kirim_lokomotif.css" />
</head>

<body>

<div class="shell">
  <div class="topbar">
    <a href="kirim_lokomotif_pilihan.php" class="back-btn">
      <svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
      </a>
    <h1>Kirim Lokomotif</h1>
  </div>

  <div class="route-strip">
    <div class="route-col">
      <div class="route-label">Dari</div>
      <div class="route-val">Balai Yasa</div>
    </div>
    <div class="route-arrow">→</div>
    <div class="route-col">
      <div class="route-label">Tujuan</div>
      <div class="route-val" id="route-to">Pilih di peta</div>
        </div>
        </div>

  <div id="map"></div>

  <div class="info-box">
    <p>Ketuk stasiun di peta untuk memilih tujuan</p>
    <div class="selected-stop">
      <div class="stop-dot"></div>
      <div>
        <div class="stop-name" id="stop-name">Belum dipilih</div>
        <div class="stop-hint" id="stop-hint">Tap marker di peta</div>
      </div>
    </div>
  </div>

  <div class="loco-box">
    <div class="loco-icon">
      <svg viewBox="0 0 24 24"><path d="M12 2c-4 0-8 .5-8 4v9.5A2.5 2.5 0 0 0 6.5 18l-1.5 1.5v.5h2l2-2h6l2 2h2v-.5L17.5 18a2.5 2.5 0 0 0 2.5-2.5V6c0-3.5-3.58-4-8-4zM7.5 17a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm3.5-7H6V6h5v4zm2 0V6h5v4h-5zm3.5 7a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/></svg>
    </div>
    <div>
      <div class="loco-label">Lokomotif dipilih — Masinis: <?= $driver_name ?></div>
      <div class="loco-model"><?= $model ?> <span style="font-weight:400;color:#b45309">(<?= $kode ?>)</span></div>
    </div>
  </div>

  <div class="btn-wrap">
    <button class="btn-kirim" id="btn-kirim" disabled onclick="bukaModal()">Kirim Lokomotif</button>
    <p class="hint-txt">Masinis akan menerima notifikasi panggilan setelah dikirim</p>
  </div>
</div>

<div class="modal-overlay" id="modal" onclick="tutupJikaLuar(event)">
  <div class="modal-sheet">
    <p class="modal-title">Konfirmasi Pengiriman</p>
    <p class="modal-desc">
      Kirim lokomotif <strong><?= $model ?></strong> ke <strong id="modal-tujuan">-</strong>?<br/>
      Masinis <strong><?= $driver_name ?></strong> akan mendapat notifikasi panggilan.
    </p>
    <div class="modal-actions">
      <button class="btn-batal" onclick="tutupModal()">Batal</button>
      <button class="btn-ya" onclick="kirimSekarang()">Ya, Kirim</button>
    </div>
  </div>
</body>

<script src="../js/kirim_lokomotif.js"></script>

</html>
