<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Atur Program Perawatan – LMS PT KAI</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="../styling_feature/atur_program_perawatan.css"/>
</head>
<body>

<div class="shell">

  <div class="topbar">
    <a href="dashboard.php" class="back-btn">
      <svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
    </a>
    <h1>Atur Program Perawatan</h1>
  </div>

  <div class="page-body">

    <?php
      if (isset($_GET['status'])) {
        $s = $_GET['status'];
        if ($s === 'added')   echo "<p class='msg success'>Unit berhasil ditambahkan.</p>";
        if ($s === 'edited')  echo "<p class='msg success'>Unit berhasil diperbarui.</p>";
        if ($s === 'deleted') echo "<p class='msg success'>Unit berhasil dihapus.</p>";
        if ($s === 'error')   echo "<p class='msg error'>Terjadi kesalahan.</p>";
      }
    ?>

    <!-- Form Tambah Unit — kirim ke backend add_unit.php -->
    <div class="card">
      <form action="../src/feature/maintenance_program/endpoint/add_unit.php" method="POST">
        <input type="text" name="unit" placeholder="Nama Unit Perawatan" required/>
        <div class="btn-row" style="margin-top:4px">
          <button type="submit" class="btn btn-orange2">Tambah</button>
          <a href="atur_program.php" class="btn btn-red" style="text-align:center">Cancel</a>
        </div>
      </form>
    </div>

    <p class="section-title">LIST UNIT</p>

    <div class="list-area">
      <?php
        require_once __DIR__ . "/../src/db/lms.php";
        $units  = [];
        $result = $db->query("SELECT * FROM maintenance_unit ORDER BY sequence_number");
        if ($result) {
          while ($row = $result->fetch_assoc()) $units[] = $row;
        }

        if (empty($units)):
      ?>
        <div class="list-placeholder">
          <span class="dots">⠿</span>
          <span>Unit Perawatan:</span>
        </div>

      <?php else: foreach ($units as $unit): ?>

        <div class="list-item">
          <span class="drag-icon">⠿</span>
          <div class="item-info">
            <div class="item-name"><?= htmlspecialchars($unit['unit']) ?></div>
            <div class="item-sub">Urutan: <?= $unit['sequence_number'] ?></div>
          </div>
          <div class="action-links">
            <!-- Update: buka form edit inline via GET parameter -->
            <a href="atur_program.php?edit=<?= $unit['id'] ?>" class="link-action">Update</a>
            <!-- Delete: langsung kirim ke backend delete_unit.php -->
            <!-- Hapus: kirim ke backend delete_unit.php via link form POST agar tidak via URL langsung -->
            <form action="../src/feature/maintenance_program/endpoint/delete_unit.php" method="GET" style="display:inline">
              <input type="hidden" name="id" value="<?= $unit['id'] ?>"/>
              <button type="submit" class="link-action del">Hapus</button>
            </form>
          </div>
        </div>

      <?php endforeach; endif; ?>
    </div>

    <?php
      // Form edit inline — muncul kalau ada ?edit=id di URL
      if (isset($_GET['edit'])) {
        $edit_id = (int)$_GET['edit'];
        $row = $db->query("SELECT * FROM maintenance_unit WHERE id = $edit_id")->fetch_assoc();
        if ($row):
    ?>
    <div class="card" style="border: 2px solid #2196F3;">
      <p style="font-weight:700; font-size:14px; color:#1565C0">Edit Unit</p>
      <!-- Kirim ke backend edit_unit.php -->
      <form action="../src/feature/maintenance_program/endpoint/edit_unit.php" method="GET">
        <input type="hidden" name="id"              value="<?= $row['id'] ?>"/>
        <input type="hidden" name="sequence_number" value="<?= $row['sequence_number'] ?>"/>
        <input type="text"   name="unit"            value="<?= htmlspecialchars($row['unit']) ?>" required/>
        <div class="btn-row" style="margin-top:4px">
          <button type="submit" class="btn btn-orange2">Simpan</button>
          <a href="atur_program.php" class="btn btn-red" style="text-align:center">Batal</a>
        </div>
      </form>
    </div>
    <?php endif; } ?>

    <a href="atur_program.php" class="btn btn-orange full-width" style="margin-top:4px; text-align:center">
      Update
    </a>

  </div>
</div>

</body>
</html>