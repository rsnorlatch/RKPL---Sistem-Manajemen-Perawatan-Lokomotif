<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Atur Jadwal – LMS PT KAI</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --blue:   #2196F3;
      --orange: #FF7043;
      --dark:   #1a1a1a;
      --gray:   #757575;
      --lgray:  #bdbdbd;
      --bg:     #f5f5f5;
      --card:   #ffffff;
    }

    body {
      font-family: 'DM Sans', sans-serif;
      background: #e8edf2;
      min-height: 100vh;
      display: flex;
      align-items: flex-start;
      justify-content: center;
      padding: 24px 12px;
    }

    .shell {
      width: 340px;
      background: var(--bg);
      border-radius: 24px;
      box-shadow: 0 20px 56px rgba(0,0,0,.13);
      overflow: hidden;
      display: flex;
      flex-direction: column;
      animation: fadeUp .45s ease both;
    }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(16px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    /* Top Bar */
    .topbar {
      background: var(--blue);
      display: flex;
      align-items: center;
      padding: 16px 14px;
      gap: 8px;
    }

    .topbar a {
      display: flex;
      align-items: center;
      color: #fff;
      text-decoration: none;
    }

    .topbar a svg { width: 22px; height: 22px; fill: #fff; }

    .topbar h1 { font-size: 17px; font-weight: 600; color: #fff; }

    /* Body */
    .body { padding: 20px 18px 28px; display: flex; flex-direction: column; gap: 18px; }

    .loco-name { font-size: 20px; font-weight: 700; color: var(--dark); }
    .loco-code { font-size: 14px; color: var(--gray); margin-top: 2px; }

    /* Calendar card */
    .cal-card {
      background: var(--card);
      border-radius: 16px;
      padding: 16px;
      box-shadow: 0 3px 10px rgba(0,0,0,.07);
    }

    /* Month nav */
    .month-nav {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 12px;
    }

    .nav-btn {
      background: none;
      border: none;
      cursor: pointer;
      padding: 6px;
      border-radius: 8px;
      display: flex;
      align-items: center;
      color: var(--dark);
      transition: background .15s;
    }
    .nav-btn:hover { background: #f0f0f0; }
    .nav-btn svg { width: 20px; height: 20px; fill: currentColor; }

    .month-label { font-size: 16px; font-weight: 600; color: var(--dark); }

    /* Day headers */
    .day-headers {
      display: grid;
      grid-template-columns: repeat(7, 1fr);
      margin-bottom: 4px;
    }

    .day-header {
      text-align: center;
      font-size: 12px;
      font-weight: 500;
      color: var(--lgray);
      padding: 4px 0;
    }

    /* Day grid */
    .day-grid {
      display: grid;
      grid-template-columns: repeat(7, 1fr);
      gap: 2px;
    }

    .day-cell {
      aspect-ratio: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 13px;
      border-radius: 50%;
      cursor: pointer;
      transition: background .15s, color .15s;
      color: var(--dark);
      user-select: none;
    }

    .day-cell.other-month { color: var(--lgray); cursor: default; pointer-events: none; }
    .day-cell.today       { font-weight: 700; color: var(--blue); }
    .day-cell:not(.other-month):hover { background: #e3f2fd; }
    .day-cell.selected    { background: var(--blue) !important; color: #fff !important; font-weight: 600; }

    /* Pilih Tanggal button */
    .btn-pilih {
      width: 100%;
      padding: 14px;
      background: var(--orange);
      color: #fff;
      border: none;
      border-radius: 10px;
      font-family: inherit;
      font-size: 15px;
      font-weight: 600;
      cursor: pointer;
      letter-spacing: .3px;
      transition: opacity .15s, transform .1s;
    }

    .btn-pilih:hover  { opacity: .88; }
    .btn-pilih:active { transform: scale(.98); }

    /* Status */
    .status-msg {
      font-size: 13px;
      text-align: center;
      color: var(--gray);
      min-height: 18px;
    }
  </style>
</head>
<body>

<div class="shell">

  <div class="topbar">
    <a href="jadwal.html">
      <svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
    </a>
    <h1>Jadwal Perawatan</h1>
  </div>

  <div class="body">

    <div>
      <div class="loco-name" id="locoName">Lokomotif A</div>
      <div class="loco-code" id="locoCode">LK-53</div>
    </div>

    <!-- Calendar -->
    <div class="cal-card">
      <div class="month-nav">
        <button class="nav-btn" onclick="prevMonth()">
          <svg viewBox="0 0 24 24"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
        </button>
        <span class="month-label" id="monthLabel"></span>
        <button class="nav-btn" onclick="nextMonth()">
          <svg viewBox="0 0 24 24"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
        </button>
      </div>

      <div class="day-headers">
        <div class="day-header">Min</div>
        <div class="day-header">Sen</div>
        <div class="day-header">Sel</div>
        <div class="day-header">Rab</div>
        <div class="day-header">Kam</div>
        <div class="day-header">Jum</div>
        <div class="day-header">Sab</div>
      </div>

      <div class="day-grid" id="dayGrid"></div>
    </div>

    <p class="status-msg" id="statusMsg"></p>

    <button class="btn-pilih" onclick="pilihTanggal()">Pilih Tanggal</button>

  </div>
</div>

<script>
  const MONTHS = [
    'Januari','Februari','Maret','April','Mei','Juni',
    'Juli','Agustus','September','Oktober','November','Desember'
  ];

  const today = new Date();
  let year    = today.getFullYear();
  let month   = today.getMonth(); // 0-indexed
  let selected = null; // { year, month, day }

  // Read loco name & code from URL params
  const params = new URLSearchParams(window.location.search);
  document.getElementById('locoName').textContent = params.get('loco') || 'Lokomotif A';
  document.getElementById('locoCode').textContent = params.get('kode') || 'LK-53';

  function renderCalendar() {
    document.getElementById('monthLabel').textContent = `${MONTHS[month]} ${year}`;

    const grid      = document.getElementById('dayGrid');
    grid.innerHTML  = '';

    const firstDay  = new Date(year, month, 1).getDay();   // 0 = Minggu
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const prevDays  = new Date(year, month, 0).getDate();  // days in prev month

    // Leading cells from previous month
    for (let i = firstDay - 1; i >= 0; i--) {
      const cell = document.createElement('div');
      cell.className = 'day-cell other-month';
      cell.textContent = prevDays - i;
      grid.appendChild(cell);
    }

    // Current month days
    for (let d = 1; d <= daysInMonth; d++) {
      const cell = document.createElement('div');
      cell.className = 'day-cell';
      cell.textContent = d;

      // Today highlight
      if (d === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
        cell.classList.add('today');
      }

      // Selected
      if (selected && selected.day === d && selected.month === month && selected.year === year) {
        cell.classList.add('selected');
      }

      cell.addEventListener('click', () => {
        selected = { year, month, day: d };
        document.getElementById('statusMsg').textContent = '';
        renderCalendar();
      });

      grid.appendChild(cell);
    }

    // Trailing cells from next month
    const totalCells = firstDay + daysInMonth;
    const trailing   = totalCells % 7 === 0 ? 0 : 7 - (totalCells % 7);
    for (let d = 1; d <= trailing; d++) {
      const cell = document.createElement('div');
      cell.className = 'day-cell other-month';
      cell.textContent = d;
      grid.appendChild(cell);
    }
  }

  function prevMonth() {
    if (month === 0) { month = 11; year--; }
    else month--;
    selected = null;
    renderCalendar();
  }

  function nextMonth() {
    if (month === 11) { month = 0; year++; }
    else month++;
    selected = null;
    renderCalendar();
  }

  function pilihTanggal() {
    if (!selected) {
      document.getElementById('statusMsg').textContent = 'Silakan pilih tanggal terlebih dahulu.';
      return;
    }
    const tgl = `${selected.day} ${MONTHS[selected.month]} ${selected.year}`;
    document.getElementById('statusMsg').textContent = `Jadwal dipilih: ${tgl}`;
  }

  renderCalendar();
</script>

</body>
</html>