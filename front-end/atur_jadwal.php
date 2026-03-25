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

  <?php
  $loco_id      = isset($_GET['loco_id']) ? (int)$_GET['loco_id']           : 0;
  $model        = isset($_GET['model'])   ? htmlspecialchars($_GET['model']) : 'Lokomotif';
  $kode         = isset($_GET['kode'])    ? htmlspecialchars($_GET['kode'])  : 'LK-' . $loco_id;

  $year         = isset($_GET['year'])    ? (int)$_GET['year']               : (int)date('Y');
  $month        = isset($_GET['month'])   ? (int)$_GET['month']              : (int)date('n');
  $selected_day = isset($_GET['day'])     ? (int)$_GET['day']                : null;

  // Hitung kalender
  $first_dow     = (int)date('w', mktime(0, 0, 0, $month, 1, $year)); // 0=Min
  $days_in_month = (int)date('t', mktime(0, 0, 0, $month, 1, $year));
  $days_in_prev  = (int)date('t', mktime(0, 0, 0, $month - 1, 1, $year));

  $month_names = [
    '',
    'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
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
  ?>

  <div class="shell">

    <div class="topbar">
      <a href="jadwal.php" class="back-btn">
        <svg viewBox="0 0 24 24">
          <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" />
        </svg>
      </a>
      <h1>Jadwal Perawatan</h1>
    </div>

    <div class="page-body">

      <!-- Info lokomotif -->
      <div class="loco-header">
        <div class="loco-name"><?= $model ?></div>
        <div class="loco-code"><?= $kode ?></div>
      </div>

      <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] === 'success'):     ?><p class="msg success">Jadwal berhasil disimpan.</p>
        <?php elseif ($_GET['status'] === 'error'):   ?><p class="msg error">Terjadi kesalahan.</p>
        <?php endif; ?>
      <?php endif; ?>

      <!-- Kalender -->
      <div class="cal-card">

        <!-- Navigasi bulan -->
        <div class="month-nav">
          <a class="nav-btn" href="<?= $base ?>&year=<?= $prev_y ?>&month=<?= $prev_m ?>">
            <svg viewBox="0 0 24 24">
              <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z" />
            </svg>
          </a>
          <span class="month-label"><?= $month_names[$month] ?></span>
          <a class="nav-btn" href="<?= $base ?>&year=<?= $next_y ?>&month=<?= $next_m ?>">
            <svg viewBox="0 0 24 24">
              <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z" />
            </svg>
          </a>
        </div>

        <!-- Header hari -->
        <div class="day-headers">
          <span>Min</span><span>Sen</span><span>Sel</span>
          <span>Rab</span><span>Kam</span><span>Jum</span><span>Sab</span>
        </div>

        <!-- Grid tanggal -->
        <div class="day-grid">
          <?php
          // Trailing hari bulan sebelumnya
          for ($i = $first_dow - 1; $i >= 0; $i--) {
            echo '<div class="day-cell other-month">' . ($days_in_prev - $i) . '</div>';
          }

          $td = (int)date('d');
          $tm = (int)date('n');
          $ty = (int)date('Y');

          for ($d = 1; $d <= $days_in_month; $d++) {
            $cls = 'day-cell';
            if ($d === $td && $month === $tm && $year === $ty) $cls .= ' today';
            if ($d === $selected_day) $cls .= ' selected';
            $href = "$base&year=$year&month=$month&day=$d";
            echo "<a class='$cls' href='$href'>$d</a>";
          }

          // Trailing hari bulan berikutnya
          $total    = $first_dow + $days_in_month;
          $trailing = $total % 7 === 0 ? 0 : 7 - ($total % 7);
          for ($d = 1; $d <= $trailing; $d++) {
            echo '<div class="day-cell other-month">' . $d . '</div>';
          }
          ?>
        </div>
      </div>

      <!-- Form submit ke backend — hanya aktif kalau sudah pilih tanggal -->
      <form action="../src/feature/maintenance_schedule/endpoint/add_schedule.php" method="POST">
        <input type="hidden" name="locomotive_id" value="<?= $loco_id ?>" />
        <?php if ($selected_day):
          $date_str = sprintf('%04d-%02d-%02d', $year, $month, $selected_day);
        ?>
          <input type="hidden" name="start" value="<?= $date_str ?> 00:00:00" />
          <input type="hidden" name="end" value="<?= $date_str ?> 23:59:59" />
          <button type="submit" class="btn-pilih">Pilih Tanggal</button>
        <?php else: ?>
          <button type="submit" class="btn-pilih" disabled>Pilih Tanggal</button>
        <?php endif; ?>
      </form>

    </div>
  </div>

</body>

</html>
