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
  <div id="map"></div>
</body>
<script>
  const map = new L
    .map('map', {
      zoomControl: false
    })
    .setView([-7.801389, 110.364444], 13);

  const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
  }).addTo(map);

  (async () => {
    try {
      const coordinates = await fetch("http://localhost/lms/lms/src/feature/sending/endpoint/get_points.php");
      const coordinates_json = await coordinates.json();


      coordinates_json.forEach((coord) => L.circleMarker(coord, {
        radius: 10
      }).addTo(map));
    } catch (e) {
      throw new Error(e);
    }
  })()
</script>

</html>
