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
    <p class="id-display--stop"></p>
    <div id="map"></div>

    <div style="width: 100%; height: 50%; display: flex; flex-direction: column; gap: 5em;">
      <h1>Lokomotif A</h1>
      <form action="../src/feature/sending/endpoint/send_locomotive.php" method="GET" style="display: flex; flex-direction: column; align-items: center; gap: .75rem; width: 100%;">
        <input type="hidden" name="destination_id" class="current-stop-input" value="0" />
        <button type="submit" class="btn-primary">Kirim</button>
      </form>
    </div>
  </div>
</body>

<script src="../js/kirim_lokomotif.js"></script>

</html>
