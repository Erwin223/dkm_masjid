<style>
    .keg-nav { display:flex; gap:10px; margin-bottom:25px; flex-wrap:wrap; }
    .keg-nav a { padding:9px 18px; border-radius:8px; font-size:13px; font-weight:500; text-decoration:none; border:1px solid #ddd; color:#555; background:#fff; display:inline-flex; align-items:center; gap:7px; transition:0.2s; }
    .keg-nav a:hover  { background:#f0fbf6; border-color:#0f8b6d; color:#0f8b6d; }
    .keg-nav a.active { background:#0f8b6d; border-color:#0f8b6d; color:#fff; }

    .form-box { background:#fff; border-radius:10px; border:1px solid #e5e5e5; padding:28px; max-width:700px; }
    .form-box h3 { font-size:16px; font-weight:600; margin-bottom:20px; color:#111; display:flex; align-items:center; gap:8px; }
    .form-group { margin-bottom:18px; }
    .form-group label { display:block; font-size:13px; font-weight:500; color:#444; margin-bottom:6px; }
    .form-group input, .form-group select, .form-group textarea { width:100%; padding:9px 12px; border:1px solid #ddd; border-radius:8px; font-size:13px; color:#333; outline:none; background:#fff; transition:border 0.2s; }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color:#0f8b6d; }
    .form-group textarea { resize:vertical; min-height:80px; }
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    .form-actions { display:flex; gap:10px; margin-top:24px; flex-wrap:wrap; }
    .btn-simpan { background:#0f8b6d; color:#fff; border:none; padding:10px 22px; border-radius:8px; font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:7px; }
    .btn-simpan:hover { background:#0c6d55; }
    .btn-batal { background:#fff; color:#555; border:1px solid #ddd; padding:10px 22px; border-radius:8px; font-size:13px; font-weight:500; text-decoration:none; display:inline-flex; align-items:center; gap:7px; }
    .btn-batal:hover { background:#f5f5f5; color:#333; }
    .invalid-feedback { font-size:12px; color:#dc3545; margin-top:4px; display:block; }
    @media(max-width:600px){ .form-row { grid-template-columns:1fr; } .form-box { padding:18px; } }
    .keg-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; flex-wrap:wrap; gap:10px; }
    .keg-title  { font-size:20px; font-weight:600; color:#111; display:flex; align-items:center; gap:10px; }
    .keg-icon   { width:38px; height:38px; background:#e1f5ee; border-radius:10px; display:flex; align-items:center; justify-content:center; }

    .keg-nav { display:flex; gap:10px; margin-bottom:25px; flex-wrap:wrap; }
    .keg-nav a { padding:9px 18px; border-radius:8px; font-size:13px; font-weight:500; text-decoration:none; border:1px solid #ddd; color:#555; background:#fff; display:inline-flex; align-items:center; gap:7px; transition:0.2s; }
    .keg-nav a:hover  { background:#f0fbf6; border-color:#0f8b6d; color:#0f8b6d; }
    .keg-nav a.active { background:#0f8b6d; border-color:#0f8b6d; color:#fff; }

    .table-box { background:#fff; border-radius:10px; border:1px solid #e5e5e5; padding:20px; }
    .table-responsive { overflow-x:auto; }
    table { width:100%; border-collapse:collapse; min-width:500px; }
    table th { background:#f3f3f3; padding:10px 12px; font-size:12px; text-align:left; white-space:nowrap; border-bottom:1px solid #e5e5e5; }
    table td { padding:10px 12px; font-size:13px; border-bottom:1px solid #f5f5f5; vertical-align:middle; }
    table tbody tr:hover { background:#f7fdf9; }

    .btn-tambah { background:#0f8b6d; color:#fff; border:none; padding:9px 16px; border-radius:8px; font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:6px; text-decoration:none; }
    .btn-tambah:hover { background:#0c6d55; color:#fff; }

    .top-row { display:flex; align-items:center; justify-content:space-between; margin-bottom:15px; flex-wrap:wrap; gap:10px; }
    .search-input { height:36px; border:1px solid #ddd; border-radius:8px; padding:0 12px; font-size:13px; outline:none; min-width:200px; }
    .search-input:focus { border-color:#0f8b6d; }

    td i { transition:0.2s; }
    .fa-edit:hover  { color:darkblue; transform:scale(1.2); }
    .fa-trash:hover { color:darkred;  transform:scale(1.2); }

    @media(max-width:600px){ .top-row { flex-direction:column; align-items:flex-start; } .search-input { width:100%; } .btn-tambah { width:100%; justify-content:center; } }
    .status-tetap { background:#e1f5ee; color:#085041; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; display:inline-block; }
    .status-tamu  { background:#fff3cd; color:#856404; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; display:inline-block; }
    .avatar-initials { width:36px; height:36px; border-radius:50%; background:#e1f5ee; border:2px solid #9fe1cb; display:inline-flex; align-items:center; justify-content:center; font-size:13px; font-weight:600; color:#0f6e56; }
     .keg-nav { display:flex; gap:10px; margin-bottom:25px; flex-wrap:wrap; }
    .keg-nav a { padding:9px 18px; border-radius:8px; font-size:13px; font-weight:500; text-decoration:none; border:1px solid #ddd; color:#555; background:#fff; display:inline-flex; align-items:center; gap:7px; transition:0.2s; }
    .keg-nav a:hover  { background:#f0fbf6; border-color:#0f8b6d; color:#0f8b6d; }
    .keg-nav a.active { background:#0f8b6d; border-color:#0f8b6d; color:#fff; }

    .form-box { background:#fff; border-radius:10px; border:1px solid #e5e5e5; padding:28px; max-width:700px; }
    .form-box h3 { font-size:16px; font-weight:600; margin-bottom:20px; color:#111; display:flex; align-items:center; gap:8px; }
    .form-group { margin-bottom:18px; }
    .form-group label { display:block; font-size:13px; font-weight:500; color:#444; margin-bottom:6px; }
    .form-group input, .form-group select, .form-group textarea { width:100%; padding:9px 12px; border:1px solid #ddd; border-radius:8px; font-size:13px; color:#333; outline:none; background:#fff; transition:border 0.2s; }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color:#0f8b6d; }
    .form-group textarea { resize:vertical; min-height:80px; }
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    .form-actions { display:flex; gap:10px; margin-top:24px; flex-wrap:wrap; }
    .btn-simpan { background:#0f8b6d; color:#fff; border:none; padding:10px 22px; border-radius:8px; font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:7px; }
    .btn-simpan:hover { background:#0c6d55; }
    .btn-batal { background:#fff; color:#555; border:1px solid #ddd; padding:10px 22px; border-radius:8px; font-size:13px; font-weight:500; text-decoration:none; display:inline-flex; align-items:center; gap:7px; }
    .btn-batal:hover { background:#f5f5f5; color:#333; }
    .invalid-feedback { font-size:12px; color:#dc3545; margin-top:4px; display:block; }
    @media(max-width:600px){ .form-row { grid-template-columns:1fr; } .form-box { padding:18px; } }
      .keg-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; flex-wrap:wrap; gap:10px; }
    .keg-title  { font-size:20px; font-weight:600; color:#111; display:flex; align-items:center; gap:10px; }
    .keg-icon   { width:38px; height:38px; background:#e1f5ee; border-radius:10px; display:flex; align-items:center; justify-content:center; }

    .keg-nav { display:flex; gap:10px; margin-bottom:25px; flex-wrap:wrap; }
    .keg-nav a { padding:9px 18px; border-radius:8px; font-size:13px; font-weight:500; text-decoration:none; border:1px solid #ddd; color:#555; background:#fff; display:inline-flex; align-items:center; gap:7px; transition:0.2s; }
    .keg-nav a:hover  { background:#f0fbf6; border-color:#0f8b6d; color:#0f8b6d; }
    .keg-nav a.active { background:#0f8b6d; border-color:#0f8b6d; color:#fff; }

    .table-box { background:#fff; border-radius:10px; border:1px solid #e5e5e5; padding:20px; }
    .table-responsive { overflow-x:auto; }
    table { width:100%; border-collapse:collapse; min-width:500px; }
    table th { background:#f3f3f3; padding:10px 12px; font-size:12px; text-align:left; white-space:nowrap; border-bottom:1px solid #e5e5e5; }
    table td { padding:10px 12px; font-size:13px; border-bottom:1px solid #f5f5f5; vertical-align:middle; }
    table tbody tr:hover { background:#f7fdf9; }

    .btn-tambah { background:#0f8b6d; color:#fff; border:none; padding:9px 16px; border-radius:8px; font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:6px; text-decoration:none; }
    .btn-tambah:hover { background:#0c6d55; color:#fff; }

    .top-row { display:flex; align-items:center; justify-content:space-between; margin-bottom:15px; flex-wrap:wrap; gap:10px; }
    .search-input { height:36px; border:1px solid #ddd; border-radius:8px; padding:0 12px; font-size:13px; outline:none; min-width:200px; }
    .search-input:focus { border-color:#0f8b6d; }

    td i { transition:0.2s; }
    .fa-edit:hover  { color:darkblue; transform:scale(1.2); }
    .fa-trash:hover { color:darkred;  transform:scale(1.2); }

    @media(max-width:600px){ .top-row { flex-direction:column; align-items:flex-start; } .search-input { width:100%; } .btn-tambah { width:100%; justify-content:center; } }
     .sholat-pill   { display:inline-block; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; background:#e1f5ee; color:#085041; }
    .status-tetap  { background:#e1f5ee; color:#085041; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; display:inline-block; }
    .status-tamu   { background:#fff3cd; color:#856404; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; display:inline-block; }
    .avatar-initials { width:34px; height:34px; border-radius:50%; background:#e1f5ee; border:2px solid #9fe1cb; display:inline-flex; align-items:center; justify-content:center; font-size:13px; font-weight:600; color:#0f6e56; flex-shrink:0; }
     .keg-nav { display:flex; gap:10px; margin-bottom:25px; flex-wrap:wrap; }
    .keg-nav a { padding:9px 18px; border-radius:8px; font-size:13px; font-weight:500; text-decoration:none; border:1px solid #ddd; color:#555; background:#fff; display:inline-flex; align-items:center; gap:7px; transition:0.2s; }
    .keg-nav a:hover  { background:#f0fbf6; border-color:#0f8b6d; color:#0f8b6d; }
    .keg-nav a.active { background:#0f8b6d; border-color:#0f8b6d; color:#fff; }
    .form-box { background:#fff; border-radius:10px; border:1px solid #e5e5e5; padding:28px; max-width:750px; }
    .form-box h3 { font-size:16px; font-weight:600; margin-bottom:20px; color:#111; display:flex; align-items:center; gap:8px; }
    .form-group { margin-bottom:18px; }
    .form-group label { display:block; font-size:13px; font-weight:500; color:#444; margin-bottom:6px; }
    .form-group input, .form-group select, .form-group textarea { width:100%; padding:9px 12px; border:1px solid #ddd; border-radius:8px; font-size:13px; color:#333; outline:none; background:#fff; transition:border 0.2s; }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color:#0f8b6d; }
    .form-group textarea { resize:vertical; min-height:80px; }
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    .form-actions { display:flex; gap:10px; margin-top:24px; flex-wrap:wrap; }
    .btn-simpan { background:#0f8b6d; color:#fff; border:none; padding:10px 22px; border-radius:8px; font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:7px; }
    .btn-simpan:hover { background:#0c6d55; }
    .btn-batal { background:#fff; color:#555; border:1px solid #ddd; padding:10px 22px; border-radius:8px; font-size:13px; font-weight:500; text-decoration:none; display:inline-flex; align-items:center; gap:7px; }
    .btn-batal:hover { background:#f5f5f5; }
    .invalid-feedback { font-size:12px; color:#dc3545; margin-top:4px; display:block; }
    .kas-info { background:#faeeda; border:1px solid #f0c070; border-radius:8px; padding:10px 14px; font-size:12px; color:#633806; margin-top:6px; display:none; }
    .field-hint { font-size:11px; color:#6b7280; margin-top:5px; }
    @media(max-width:600px){ .form-row { grid-template-columns:1fr; } .form-box { padding:18px; } }
     .keg-nav { display:flex; gap:10px; margin-bottom:25px; flex-wrap:wrap; }
    .keg-nav a { padding:9px 18px; border-radius:8px; font-size:13px; font-weight:500; text-decoration:none; border:1px solid #ddd; color:#555; background:#fff; display:inline-flex; align-items:center; gap:7px; transition:0.2s; }
    .keg-nav a:hover  { background:#f0fbf6; border-color:#0f8b6d; color:#0f8b6d; }
    .keg-nav a.active { background:#0f8b6d; border-color:#0f8b6d; color:#fff; }
    .form-box { background:#fff; border-radius:10px; border:1px solid #e5e5e5; padding:28px; max-width:750px; }
    .form-box h3 { font-size:16px; font-weight:600; margin-bottom:20px; color:#111; display:flex; align-items:center; gap:8px; }
    .form-group { margin-bottom:18px; }
    .form-group label { display:block; font-size:13px; font-weight:500; color:#444; margin-bottom:6px; }
    .form-group input, .form-group select, .form-group textarea { width:100%; padding:9px 12px; border:1px solid #ddd; border-radius:8px; font-size:13px; color:#333; outline:none; background:#fff; transition:border 0.2s; }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color:#0f8b6d; }
    .form-group textarea { resize:vertical; min-height:80px; }
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    .form-actions { display:flex; gap:10px; margin-top:24px; flex-wrap:wrap; }
    .btn-simpan { background:#0f8b6d; color:#fff; border:none; padding:10px 22px; border-radius:8px; font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:7px; }
    .btn-simpan:hover { background:#0c6d55; }
    .btn-batal { background:#fff; color:#555; border:1px solid #ddd; padding:10px 22px; border-radius:8px; font-size:13px; font-weight:500; text-decoration:none; display:inline-flex; align-items:center; gap:7px; }
    .btn-batal:hover { background:#f5f5f5; }
    .invalid-feedback { font-size:12px; color:#dc3545; margin-top:4px; display:block; }
    .kas-info { background:#faeeda; border:1px solid #f0c070; border-radius:8px; padding:10px 14px; font-size:12px; color:#633806; margin-top:6px; display:none; }
    .field-hint { font-size:11px; color:#6b7280; margin-top:5px; }
    @media(max-width:600px){ .form-row { grid-template-columns:1fr; } .form-box { padding:18px; } }
     .keg-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; flex-wrap:wrap; gap:10px; }
    .keg-title  { font-size:20px; font-weight:600; color:#111; display:flex; align-items:center; gap:10px; }
    .keg-icon   { width:38px; height:38px; background:#e1f5ee; border-radius:10px; display:flex; align-items:center; justify-content:center; }
    .keg-nav { display:flex; gap:10px; margin-bottom:25px; flex-wrap:wrap; }
    .keg-nav a { padding:9px 18px; border-radius:8px; font-size:13px; font-weight:500; text-decoration:none; border:1px solid #ddd; color:#555; background:#fff; display:inline-flex; align-items:center; gap:7px; transition:0.2s; }
    .keg-nav a:hover  { background:#f0fbf6; border-color:#0f8b6d; color:#0f8b6d; }
    .keg-nav a.active { background:#0f8b6d; border-color:#0f8b6d; color:#fff; }
    .table-box { background:#fff; border-radius:10px; border:1px solid #e5e5e5; padding:20px; }
    .table-responsive { overflow-x:auto; }
    table { width:100%; border-collapse:collapse; min-width:800px; }
    table th { background:#f3f3f3; padding:10px 12px; font-size:12px; text-align:left; white-space:nowrap; border-bottom:1px solid #e5e5e5; }
    table td { padding:10px 12px; font-size:13px; border-bottom:1px solid #f5f5f5; vertical-align:middle; }
    table tbody tr:hover { background:#f7fdf9; }
    .btn-tambah { background:#0f8b6d; color:#fff; border:none; padding:9px 16px; border-radius:8px; font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:6px; text-decoration:none; }
    .btn-tambah:hover { background:#0c6d55; color:#fff; }
    .top-row { display:flex; align-items:center; justify-content:space-between; margin-bottom:15px; flex-wrap:wrap; gap:10px; }
    .search-input { height:36px; border:1px solid #ddd; border-radius:8px; padding:0 12px; font-size:13px; outline:none; min-width:200px; }
    .search-input:focus { border-color:#0f8b6d; }
    .badge-status  { display:inline-block; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; }
    .badge-akan    { background:#fff3cd; color:#856404; }
    .badge-selesai { background:#d1e7dd; color:#0f5132; }
    .badge-berjalan{ background:#cfe2ff; color:#084298; }
    .anggaran-pill { background:#faeeda; color:#633806; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; display:inline-block; }
    .anggaran-none { color:#9ca3af; font-size:12px; }
    td i { transition:0.2s; }
    .fa-edit:hover  { color:darkblue; transform:scale(1.2); }
    .fa-trash:hover { color:darkred;  transform:scale(1.2); }
    @media(max-width:600px){ .top-row { flex-direction:column; align-items:flex-start; } .search-input { width:100%; } .btn-tambah { width:100%; justify-content:center; } }
</style>
