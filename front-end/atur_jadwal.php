<?php
session_start();
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
$end_month   = isset($_GET['end_month'])   ? (int)$_GET['end_month']   : null;
$end_year    = isset($_GET['end_year'])    ? (int)$_GET['end_year']    : null;

// Mode pemilihan: 'start' atau 'end'
$mode = ($start_day !== null && $end_day === null) ? 'end' : 'start';

// Hitung kalender
$first_dow     = (int)date('w', mktime(0, 0, 0, $month, 1, $year));
$days_in_month = (int)date('t', mktime(0, 0, 0, $month, 1, $year));
$days_in_prev  = (int)date('t', mktime(0, 0, 0, $month - 1, 1, $year));

$month_names = [
  '',
  $_SESSION["language"] == "id" ? 'Januari' : "January",
  $_SESSION["language"] == "id" ? 'Februari' : "February",
  $_SESSION["language"] == "id" ? 'Maret' : "March",
  $_SESSION["language"] == "id" ? 'April' : "April",
  $_SESSION["language"] == "id" ? 'Mei' : "May",
  $_SESSION["language"] == "id" ? 'Juni' : "June",
  $_SESSION["language"] == "id" ? 'Juli' : "July",
  $_SESSION["language"] == "id" ? 'Agustus' : "August",
  $_SESSION["language"] == "id" ? 'September' : "September",
  $_SESSION["language"] == "id" ? 'Oktober' : "October",
  $_SESSION["language"] == "id" ? 'November' : "November",
  $_SESSION["language"] == "id" ? 'Desember' : "December"
];

$prev_m = $month - 1;
$prev_y = $year;
if ($prev_m < 1) {
  $prev_m = 12;
  $prev_y--;
}
$next_m = $month + 1;
$next_y = $year;
if ($next_m > 12) {
  $next_m = 1;
  $next_y++;
}

// Base URL untuk link kalender
$base = "atur_jadwal.php?loco_id=$loco_id&model=" . urlencode($model) . "&kode=" . urlencode($kode);

// Jika dalam mode 'end', tambahkan start ke base URL
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
</head>

<body>
  <div class="shell">
    <div class="topbar">
      <a href="jadwal.php" class="back-btn">
        <svg viewBox="0 0 24 24">
          <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" />
        </svg>
      </a>
      <h1><?= $_SESSION["language"] == "id" ? "Jadwal Perawatan" : "Maintenance Schedule" ?></h1>
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
            <svg viewBox="0 0 24 24">
              <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z" />
            </svg>
          </a>
          <span class="month-label"><?= $month_names[$month] ?> <?= $year ?></span>
          <a class="nav-btn" href="<?= $base ?>&year=<?= $next_y ?>&month=<?= $next_m ?>">
            <svg viewBox="0 0 24 24">
              <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z" />
            </svg>
          </a>
        </div>

        <!-- Instruksi -->
        <?php if ($mode === 'start'): ?>
          <?php if ($_SESSION["language"] == "id"): ?>
            <p style="text-align:center; font-size:14px; margin-bottom:10px; color:#666;">
              🟠 Pilih <strong>tanggal mulai</strong> perawatan
            </p>
          <?php elseif ($_SESSION["language"] == "en"): ?>
            <p style="text-align:center; font-size:14px; margin-bottom:10px; color:#666;">
              🟠 Choose a <strong>starting date</strong> for maintenance
            </p>
          <?php endif; ?>
        <?php else: ?>
          <?php if ($_SESSION["language"] == "id"): ?>
            <p style="text-align:center; font-size:14px; margin-bottom:10px; color:#666;">
              🟠 Pilih <strong>tanggal akhir</strong> perawatan
            </p>
          <?php elseif ($_SESSION["language"] == "en"): ?>
            <p style="text-align:center; font-size:14px; margin-bottom:10px; color:#666;">
              🟠 Choose an <strong>ending date</strong> for maintenance
            </p>
          <?php endif; ?>
        <?php endif; ?>

        <div class="day-headers">
          <span><?= $_SESSION["language"] == "id" ? "Min" : "Sun" ?></span>
          <span><?= $_SESSION["language"] == "id" ? "Sen" : "Mon" ?></span>
          <span><?= $_SESSION["language"] == "id" ? "Sel" : "Tue" ?></span>
          <span><?= $_SESSION["language"] == "id" ? "Rab" : "Wed" ?></span>
          <span><?= $_SESSION["language"] == "id" ? "Kam" : "Thu" ?></span>
          <span><?= $_SESSION["language"] == "id" ? "Jum" : "Fri" ?></span>
          <span><?= $_SESSION["language"] == "id" ? "Sab" : "Sat" ?></span>
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

          // Loop tanggal bulan ini
          for ($d = 1; $d <= $days_in_month; $d++) {
            $cls = 'day-cell';
            if ($d === $td && $month === $tm && $year === $ty) $cls .= ' today';

            // Highlight start
            if ($start_day !== null && $d == $start_day && $month == $start_month && $year == $start_year) {
              $cls .= ' start-selected';
            }

            // Highlight end
            if ($end_day !== null && $d == $end_day && $month == $end_month && $year == $end_year) {
              $cls .= ' end-selected';
            }

            // Link
            if ($mode === 'start') {
              $link = "{$base}&year=$year&month=$month&start_day=$d&start_month=$month&start_year=$year";
            } else {
              $link = "{$base}&year=$year&month=$month&end_day=$d&end_month=$month&end_year=$year";
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

      <!-- Form untuk submit (tombol hanya aktif jika kedua tanggal dipilih) -->
      <?php
      $start_str = '';
      $end_str   = '';
      $tombol_aktif = false;
      if ($start_day !== null && $end_day !== null) {
        $start_str = sprintf('%04d-%02d-%02d 00:00:00', $start_year, $start_month, $start_day);
        $end_str   = sprintf('%04d-%02d-%02d 23:59:59', $end_year, $end_month, $end_day);
        $tombol_aktif = true;
      }
      ?>
      <form id="form-jadwal" action="../src/feature/maintenance_schedule/endpoint/add_schedule.php" method="POST">
        <input type="hidden" name="locomotive_id" value="<?= $loco_id ?>" />
        <input type="hidden" name="start" value="<?= $start_str ?>" />
        <input type="hidden" name="end" value="<?= $end_str ?>" />
        <button type="submit" class="btn-pilih" <?= $tombol_aktif ? '' : 'disabled' ?>>
          <?= $tombol_aktif ? ($_SESSION["language"] == "id" ? "Pilih Rentang" : "Choose Range")
            : ($_SESSION["language"] == "id" ? "Pilih tanggal mulai dan akhir" : "Choose starting and ending date") ?>
        </button>
      </form>
    </div>
  </div>
</body>

</html>
