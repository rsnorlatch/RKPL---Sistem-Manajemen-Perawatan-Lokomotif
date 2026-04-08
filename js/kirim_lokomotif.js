const CONFIG = {
  initialCoordinates: [-7.801389, 110.364444],
  initialZoom: 13,
  markerRadius: 10,
  tileLayer: 'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
  apiEndpoint: 'http://localhost/lms/lms/src/feature/sending/endpoint/get_points.php'
};

const stopDisplay = document.querySelector(".id-display--stop");
const stopInput = document.querySelector(".current-stop-input");

let currentStopIndex = 0;

function initializeMap() {
  const map = new L.map('map', {
    zoomControl: false
  }).setView(CONFIG.initialCoordinates, CONFIG.initialZoom);

  L.tileLayer(CONFIG.tileLayer, {
    maxZoom: 19
  }).addTo(map);

  return map;
}

function updateStopDisplay(index) {
  currentStopIndex = index;
  stopDisplay.textContent = "DP-" + currentStopIndex;

  if (stopInput) {
    stopInput.value = currentStopIndex;
  }
}

function addStopMarkers(map, stops) {
  stops.forEach((stop, index) => {
    L.circleMarker([stop.x, stop.y], {
      radius: CONFIG.markerRadius
    })
      .addTo(map)
      .on('click', () => {
        updateStopDisplay(index);
        map.setView([stop.x, stop.y]);
      });
  });
}

async function loadAndDisplayStops() {
  try {
    const map = initializeMap();

    const response = await fetch(CONFIG.apiEndpoint);
    if (!response.ok) {
      throw new Error(`API error: ${response.status}`);
    }

    const stops = await response.json();
    updateStopDisplay(0);
    addStopMarkers(map, stops);
  } catch (error) {
    console.error('Failed to load stops:', error);
  }
}

loadAndDisplayStops();

