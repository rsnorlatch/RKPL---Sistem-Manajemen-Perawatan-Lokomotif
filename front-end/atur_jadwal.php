<?php
$loco_id      = isset($_GET['loco_id']) ? (int)$_GET['loco_id']           : 0;
$model        = isset($_GET['model'])   ? htmlspecialchars($_GET['model']) : 'Lokomotif';
$kode         = isset($_GET['kode'])    ? htmlspecialchars($_GET['kode'])  : 'LK-' . $loco_id;

// Parameter kalender bulan/tahun saat ini
$year         = isset($_GET['year'])    ? (int)$_GET['year']               : (int)date('Y');
$month        = isset($_GET['month'])   ? (int)$_GET['month']              : (int)date('n');

// Parameter range
$start_day   = isset($_GET['start_day'])   ? (int)$_GET['start_day']   : null;
$start_month = isset($_GET['start_month']) ? (int)$_GET['start_month'] : null;
$start_year  = isset($_GET['start_year'])  ? (int)$_GET['start_year']  : null;
$end_day     = isset($_GET['end_day'])     ? (int)$_GET['end_day']     : null;

// Mode pemilihan: 'start' atau 'end'
$mode = ($start_day !== null && $end_day === null) ? 'end' : 'start';

// Jika end sudah dipilih, kita langsung submit form
$auto_submit = false;
if ($start_day !== null && $end_day !== null) {
    $auto_submit = true;
}

// Hitung kalender seperti biasa
$first_dow     = (int)date('w', mktime(0, 0, 0, $month, 1, $year));
$days_in_month = (int)date('t', mktime(0, 0, 0, $month, 1, $year));
$days_in_prev  = (int)date('t', mktime(0, 0, 0, $month - 1, 1, $year));

$month_names = ['', 'Januari','Februari','Maret','April','Mei','Juni',
    'Juli','Agustus','September','Oktober','November','Desember'];

$prev_m = $month - 1; $prev_y = $year;
if ($prev_m < 1) { $prev_m = 12; $prev_y--; }
$next_m = $month + 1; $next_y = $year;
if ($next_m > 12) { $next_m = 1; $next_y++; }

// Base URL untuk link kalender (dengan info lokomotif)
$base = "atur_jadwal.php?loco_id=$loco_id&model=" . urlencode($model) . "&kode=" . urlencode($kode);

// Jika dalam mode 'end', kita tambahkan start ke base URL
if ($mode === 'end') {
    $base .= "&start_day=$start_day&start_month=$start_month&start_year=$start_year";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Jadwal Perawatan – LMS PT KAI</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../styling_feature/atur_jadwal.css" />
  <?php if ($auto_submit): ?>
  <script>
    // Auto-submit saat end sudah dipilih
    window.addEventListener('DOMContentLoaded', function() {
      document.getElementById('form-jadwal').submit();
    });
  </script>
  <?php endif; ?>
</head>
<body>
<div class="shell">
  <div class="topbar">
    <a href="jadwal.php" class="back-btn">
      <svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
    </a>
    <h1>Jadwal Perawatan</h1>
  </div>

  <div class="page-body">
    <div class="loco-header">
      <div class="loco-name"><?= $model ?></div>
      <div class="loco-code"><?= $kode ?></div>
    </div>

    <?php if (isset($_GET['status'])): ?>
      <?php if ($_GET['status'] === 'success'):  ?><p class="msg success">Jadwal berhasil disimpan.</p>
      <?php elseif ($_GET['status'] === 'error'): ?><p class="msg error">Terjadi kesalahan.</p>
      <?php endif; ?>
    <?php endif; ?>

    <div class="cal-card">
      <div class="month-nav">
        <a class="nav-btn" href="<?= $base ?>&year=<?= $prev_y ?>&month=<?= $prev_m ?>">
          <svg viewBox="0 0 24 24"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
        </a>
        <span class="month-label"><?= $month_names[$month] ?> <?= $year ?></span>
        <a class="nav-btn" href="<?= $base ?>&year=<?= $next_y ?>&month=<?= $next_m ?>">
          <svg viewBox="0 0 24 24"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
        </a>
      </div>

      <!-- Instruksi -->
      <?php if ($mode === 'start'): ?>
        <p style="text-align:center; font-size:14px; margin-bottom:10px; color:#666;">🟠 Pilih <strong>tanggal mulai</strong> perawatan</p>
      <?php else: ?>
        <p style="text-align:center; font-size:14px; margin-bottom:10px; color:#666;">🟠 Pilih <strong>tanggal akhir</strong> perawatan</p>
      <?php endif; ?>

      <div class="day-headers">
        <span>Min</span><span>Sen</span><span>Sel</span><span>Rab</span><span>Kam</span><span>Jum</span><span>Sab</span>
      </div>

      <div class="day-grid">
        <?php
        // Trailing bulan sebelumnya
        for ($i = $first_dow - 1; $i >= 0; $i--) {
          echo '<div class="day-cell other-month">' . ($days_in_prev - $i) . '</div>';
        }

        $td = (int)date('d');
        $tm = (int)date('n');
        $ty = (int)date('Y');

        for ($d = 1; $d <= $days_in_month; $d++) {
          $cls = 'day-cell';
          if ($d === $td && $month === $tm && $year === $ty) $cls .= ' today';

          // Apakah tanggal ini adalah start yang sudah dipilih?
          if ($mode === 'end' && $d == $start_day && $month == $start_month && $year == $start_year) {
            $cls .= ' start-selected'; // bisa ditandai dengan border khusus
          }

          // Link
          if ($mode === 'start') {
            // Klik untuk memilih start
            $link = "{$base}&year=$year&month=$month&start_day=$d&start_month=$month&start_year=$year";
          } else {
            // Mode 'end', klik untuk memilih end
            $link = "{$base}&year=$year&month=$month&end_day=$d";
          }

          echo "<a class='$cls' href='$link'>$d</a>";
        }

        // Trailing bulan depan
        $total    = $first_dow + $days_in_month;
        $trailing = $total % 7 === 0 ? 0 : 7 - ($total % 7);
        for ($d = 1; $d <= $trailing; $d++) {
          echo '<div class="day-cell other-month">' . $d . '</div>';
        }
        ?>
      </div>
    </div>

    <!-- Form untuk submit (auto-submit jika end sudah dipilih) -->
    <?php
    if ($auto_submit) {
        // Format datetime untuk backend
        $start_str = sprintf('%04d-%02d-%02d 00:00:00', $start_year, $start_month, $start_day);
        $end_str   = sprintf('%04d-%02d-%02d 23:59:59', $year, $month, $end_day);
    } else {
        $start_str = '';
        $end_str   = '';
    }
    ?>
    <form id="form-jadwal" action="../src/feature/maintenance_schedule/endpoint/add_schedule.php" method="POST">
      <input type="hidden" name="locomotive_id" value="<?= $loco_id ?>" />
      <input type="hidden" name="start" value="<?= $start_str ?>" />
      <input type="hidden" name="end" value="<?= $end_str ?>" />
      <?php if (!$auto_submit): ?>
        <button type="submit" class="btn-pilih" disabled>Pilih Rentang</button>
      <?php else: ?>
        <button type="submit" class="btn-pilih">Mengirim...</button>
      <?php endif; ?>
    </form>
  </div>
</div>
</body>
</html>