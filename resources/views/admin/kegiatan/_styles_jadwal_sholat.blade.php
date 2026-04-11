<style>
    .keg-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; flex-wrap:wrap; gap:10px; }
    .keg-title  { font-size:20px; font-weight:600; color:#111; display:flex; align-items:center; gap:10px; }
    .keg-icon   { width:38px; height:38px; background:#e1f5ee; border-radius:10px; display:flex; align-items:center; justify-content:center; }

    .keg-nav { display:flex; gap:10px; margin-bottom:25px; flex-wrap:wrap; }
    .keg-nav a {
        padding:9px 18px; border-radius:8px; font-size:13px; font-weight:500;
        text-decoration:none; border:1px solid #ddd; color:#555; background:#fff;
        display:inline-flex; align-items:center; gap:7px; transition:0.2s;
    }
    .keg-nav a:hover        { background:#f0fbf6; border-color:#0f8b6d; color:#0f8b6d; }
    .keg-nav a.active       { background:#0f8b6d; border-color:#0f8b6d; color:#fff; }

    .sholat-today {
        display:grid; grid-template-columns:repeat(6,1fr); gap:12px; margin-bottom:25px;
    }
    .sholat-card {
        background:#fff; border-radius:12px; border:1px solid #e5e5e5;
        padding:16px 12px; text-align:center;
    }
    .sholat-card.aktif { background:#0f8b6d; border-color:#0f8b6d; }
    .sholat-card .waktu-label { font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:.05em; color:#999; margin-bottom:6px; }
    .sholat-card.aktif .waktu-label { color:rgba(255,255,255,.8); }
    .sholat-card .waktu-jam   { font-size:22px; font-weight:700; color:#111; }
    .sholat-card.aktif .waktu-jam   { color:#fff; }
    .sholat-card .waktu-icon  { font-size:18px; margin-bottom:8px; color:#0f8b6d; }
    .sholat-card.aktif .waktu-icon  { color:rgba(255,255,255,.9); }

    .table-box { background:#fff; border-radius:10px; border:1px solid #e5e5e5; padding:20px; }
    .table-box h3 { font-size:15px; margin-bottom:15px; }
    .table-responsive { overflow-x:auto; }
    table { width:100%; border-collapse:collapse; min-width:600px; }
    table th { background:#f3f3f3; padding:10px 12px; font-size:12px; text-align:center; white-space:nowrap; border-bottom:1px solid #e5e5e5; }
    table td { padding:9px 12px; font-size:13px; text-align:center; border-bottom:1px solid #f5f5f5; }
    table tbody tr:hover { background:#f7fdf9; }
    table tbody tr.today-row { background:#e1f5ee; font-weight:600; }
    table tbody tr.today-row td { color:#0f6e56; }

    .kota-selector { display:flex; align-items:center; gap:10px; margin-bottom:20px; flex-wrap:wrap; }
    .kota-selector select { height:36px; border:1px solid #ddd; border-radius:8px; padding:0 12px; font-size:13px; outline:none; color:#333; }
    .kota-selector select:focus { border-color:#0f8b6d; }
    .kota-selector .btn-refresh { background:#0f8b6d; color:#fff; border:none; padding:8px 16px; border-radius:8px; font-size:13px; cursor:pointer; display:inline-flex; align-items:center; gap:6px; }
    .kota-selector .btn-refresh:hover { background:#0c6d55; }

    .loading-box { text-align:center; padding:3rem; color:#999; }
    .loading-box i { font-size:28px; color:#0f8b6d; display:block; margin-bottom:10px; }

    .info-badge { font-size:12px; background:#e1f5ee; color:#0f6e56; padding:4px 12px; border-radius:20px; display:inline-flex; align-items:center; gap:5px; }

    @media(max-width:900px){ .sholat-today { grid-template-columns:repeat(3,1fr); } }
    @media(max-width:600px){ .sholat-today { grid-template-columns:repeat(2,1fr); } }
    @media(max-width:400px){ .sholat-today { grid-template-columns:1fr 1fr; } }
</style>
