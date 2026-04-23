let selectedStopId = 0, selectedStopName = '';
let selectedDriverId = 0;

const map = L.map('map', { zoomControl: false }).setView([-7.0, 110.0], 7);
L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(map);

function cekTombolKirim() {
    document.getElementById('btn-kirim').disabled = !(selectedStopId > 0 && selectedDriverId > 0);
}

// Load daftar masinis dari database
async function loadDrivers() {
    try {
        const resp = await fetch('../src/feature/sending/endpoint/get_drivers.php');
        const drivers = await resp.json();
        const select = document.getElementById('driver-select');
        drivers.forEach(d => {
            const opt = document.createElement('option');
            opt.value = d.id;
            opt.textContent = d.username;
            select.appendChild(opt);
        });
        select.addEventListener('change', function() {
            selectedDriverId = parseInt(this.value) || 0;
            cekTombolKirim();
        });
    } catch(e) {
        console.error('Gagal load driver:', e);
    }
}

// Load titik stasiun dari database
async function loadStops() {
    try {
        const resp = await fetch('../src/feature/sending/endpoint/get_points.php');
        const stops = await resp.json();
        stops.forEach(stop => {
            const lat = stop.x ?? stop.lat;
            const lng = stop.y ?? stop.lng ?? stop.lon;
            const marker = L.circleMarker([lat, lng], {
                radius: 9, fillColor: '#f97316', color: '#fff', weight: 2, fillOpacity: 0.9
            }).addTo(map);
            marker.bindTooltip(stop.name, { permanent: false, direction: 'top', offset: [0, -10] });
            marker.on('click', () => {
                selectedStopId = stop.id;
                selectedStopName = stop.name;
                document.getElementById('stop-name').textContent = stop.name;
                document.getElementById('stop-hint').textContent = 'Stasiun terpilih ✓';
                document.getElementById('route-to').textContent = stop.name;
                cekTombolKirim();
            });
        });
    } catch(e) {
        console.error('Gagal load stops:', e);
    }
}

// Modal
function bukaModal() {
    document.getElementById('modal-tujuan').textContent = selectedStopName;
    const driverSelect = document.getElementById('driver-select');
    const driverName = driverSelect.selectedOptions[0]?.text || '-';
    document.getElementById('modal-driver').textContent = driverName;
    document.getElementById('modal').classList.add('open');
}
function tutupModal() { document.getElementById('modal').classList.remove('open'); }
function tutupJikaLuar(e) { if (e.target === document.getElementById('modal')) tutupModal(); }
function kirimSekarang() {
    document.getElementById('input-dest').value = selectedStopId;
    document.getElementById('input-driver').value = selectedDriverId;
    document.getElementById('form-kirim').submit();
}

// Jalankan
loadDrivers();
loadStops();