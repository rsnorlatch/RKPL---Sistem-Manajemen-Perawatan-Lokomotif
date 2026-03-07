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

  <!-- Top Bar -->
  <div class="topbar">
    <a href="dashboard_kantorpusat.php" class="back-btn">
      <svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
    </a>
    <h1>Atur Program Perawatan</h1>
  </div>

  <div class="page-body">

    <?php
      if (isset($_GET['status'])) {
        $s = $_GET['status'];
        if ($s === 'added')   echo "<p class='msg success'>Program berhasil ditambahkan.</p>";
        if ($s === 'edited')  echo "<p class='msg success'>Program berhasil diperbarui.</p>";
        if ($s === 'deleted') echo "<p class='msg success'>Program berhasil dihapus.</p>";
        if ($s === 'error')   echo "<p class='msg error'>Terjadi kesalahan.</p>";
      }
    ?>

    <!-- ── Form Tambah / Edit ── -->
    <?php
      require_once __DIR__ . "/../src/db/lms.php";

      // Cek apakah sedang mode edit
      $edit_mode = isset($_GET['edit']);
      $edit_row  = null;
      if ($edit_mode) {
        $edit_id  = (int)$_GET['edit'];
        $edit_row = $db->query("SELECT * FROM maintenance_unit WHERE id = $edit_id")->fetch_assoc();
      }
    ?>

    <div class="card">
      <?php if ($edit_mode && $edit_row): ?>
        <!-- Form Edit — kirim ke edit_unit.php -->
        <form action="../src/feature/maintenance_program/endpoint/edit_unit.php" method="GET">
          <input type="hidden" name="id"              value="<?= $edit_row['id'] ?>"/>
          <input type="hidden" name="sequence_number" value="<?= $edit_row['sequence_number'] ?>"/>
          <input type="text"   name="nama_program"    placeholder="Nama Program"    value="<?= htmlspecialchars($edit_row['unit']) ?>" required/>
          <input type="text"   name="deskripsi"       placeholder="Deskripsi Program" value="<?= htmlspecialchars($edit_row['deskripsi'] ?? '') ?>"/>
          <input type="text"   name="unit"            placeholder="Jenis Perawatan" value="<?= htmlspecialchars($edit_row['unit']) ?>" required/>
          <div class="btn-row">
            <button type="submit" class="btn btn-orange2">Simpan</button>
            <a href="atur_program.php" class="btn btn-red">Cancel</a>
          </div>
        </form>
      <?php else: ?>
        <!-- Form Tambah — kirim ke add_unit.php -->
        
        <form action="../src/feature/maintenance_program/endpoint/add_unit.php" method="GET">
          <input type="text" name="nama_program" placeholder="Nama Program"     required/>
          <input type="text" name="deskripsi"    placeholder="Deskripsi Program"/>
          <input type="text" name="unit"         placeholder="Jenis Perawatan"  required/>
          <div class="btn-row">
            <button type="submit" class="btn btn-orange2">Tambah</button>
            <a href="atur_program.php" class="btn btn-red">Cancel</a>
          </div>
        </form>
      <?php endif; ?>
    </div>

    <!-- ── LIST UNIT ── -->
    <p class="section-title">LIST UNIT</p>

    <div class="list-area">
      <?php
        $units  = [];
        $result = $db->query("SELECT * FROM maintenance_unit ORDER BY sequence_number");
        if ($result) {
          while ($row = $result->fetch_assoc()) $units[] = $row;
        }

        if (empty($units)):
      ?>
        <div class="list-placeholder">
          <span class="drag-icon">⠿</span>
          <span>Unit Perawatan:</span>
          <span class="dots-right">⋮</span>
        </div>

      <?php else: foreach ($units as $unit): ?>

        <div class="list-item">
          <span class="drag-icon">⠿</span>
          <div class="item-info">
            <div class="item-name"><?= htmlspecialchars($unit['unit']) ?></div>
          </div>
          <!-- Titik tiga → dropdown Update / Hapus via GET link -->
          <div class="menu-wrap">
            <!-- Pakai checkbox hack: klik titik tiga buka/tutup dropdown tanpa JS -->
            <input type="checkbox" id="menu-<?= $unit['id'] ?>" class="menu-toggle"/>
            <label for="menu-<?= $unit['id'] ?>" class="menu-btn">⋮</label>
            <div class="dropdown">
              <a href="atur_program.php?edit=<?= $unit['id'] ?>" class="dropdown-item">Update</a>
              <form action="../src/feature/maintenance_program/endpoint/_unit.php" method="POST">
                <input type="hidden" name="id" value="<?= $unit['id'] ?>"/>
                <button type="submit" class="dropdown-item del">Hapus</button>
              </form>
            </div>
          </div>
        </div>

      <?php endforeach; endif; ?>
    </div>

    <!-- Tombol Update orange di bawah -->
    <a href="atur_program.php" class="btn-update">Update</a>

  </div>
</div>

</body>
</html>