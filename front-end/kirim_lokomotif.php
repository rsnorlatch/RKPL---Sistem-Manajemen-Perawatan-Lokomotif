<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../styling_feature/kirim_lokomotif.css" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  <title>Document</title>
</head>

<body>
  <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 100vh; width: 25vw; gap: 1rem;">
    <div style="display: flex; flex-direction: row; width: 100%; align-items: center; gap: 0.5em">
      <a href="dashboard_timbalaiyasa.php">
        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0" />
        </svg>
      </a>
      <div style="display: flex; flex-direction: column; gap: 0.5em; width: 100%;">
        <div style="display: flex; flex-direction: row; gap: 1em; align-items: center; width: 100%;">
          <p style="vertical-align: middle;">from: </p>
          <p style="background-color: grey; padding: 0.5em; color: white; border-radius: 5px;" class="chip">BY-1</p>
        </div>
        <hr>
        <div style="display: flex; flex-direction: row; gap: 1em; align-items: center;">
          <p style="vertical-align: middle;">to: </p>
          <p style="background-color: grey; padding: 0.5em; color:white; border-radius: 5px;" class="id-display--stop chip"></p>
        </div>
      </div>
    </div>
    <div id="map"></div>

    <div style="width: 100%; height: 50%; display: flex; flex-direction: column; gap: 5em;">
      <h1><?= $_GET['model'] ?></h1>
      <form action="../src/feature/sending/endpoint/send_locomotive.php" method="GET" style="display: flex; flex-direction: column; align-items: center; gap: .75rem; width: 100%;">
        <input type="hidden" name="destination_id" class="current-stop-input" value="0" />
        <input type="hidden" name="locomotive_id" class="current-stop-input" value="<?= $_GET['loco_id'] ?>" />

        <button type="submit" class="btn-primary">Kirim</button>
      </form>
    </div>
  </div>
</body>

<script src="../js/kirim_lokomotif.js"></script>

</html>
