<style>
    .zakat-nav { display:flex; gap:10px; margin-bottom:25px; flex-wrap:wrap; }
    .zakat-nav a { padding:9px 18px; border-radius:8px; font-size:13px; font-weight:500; text-decoration:none; border:1px solid #ddd; color:#555; background:#fff; display:inline-flex; align-items:center; gap:7px; transition:0.2s; }
    .zakat-nav a:hover  { background:#f0fbf6; border-color:#0f8b6d; color:#0f8b6d; }
    .zakat-nav a.active { background:#0f8b6d; border-color:#0f8b6d; color:#fff; }
    .table-box { background:#fff; border-radius:10px; border:1px solid #e5e5e5; padding:20px; }
    .table-responsive { overflow-x:auto; }
    table { width:100%; border-collapse:collapse; min-width:720px; }
    table th { background:#f3f3f3; padding:10px 12px; font-size:12px; text-align:left; white-space:nowrap; border-bottom:1px solid #e5e5e5; }
    table td { padding:10px 12px; font-size:13px; border-bottom:1px solid #f5f5f5; vertical-align:middle; }
    table tbody tr:hover { background:#f7fdf9; }
    .top-row { display:flex; align-items:center; justify-content:space-between; margin-bottom:15px; flex-wrap:wrap; gap:10px; }
    .search-input { height:36px; border:1px solid #ddd; border-radius:8px; padding:0 12px; font-size:13px; outline:none; min-width:220px; }
    .search-input:focus { border-color:#0f8b6d; }
    .form-box { background:#fff; border-radius:10px; border:1px solid #e5e5e5; padding:28px; max-width:780px; }
    .form-box h3 { font-size:16px; font-weight:600; margin-bottom:20px; color:#111; display:flex; align-items:center; gap:8px; }
    .form-group { margin-bottom:18px; }
    .form-group label { display:block; font-size:13px; font-weight:500; color:#444; margin-bottom:6px; }
    .form-group input, .form-group select, .form-group textarea { width:100%; padding:9px 12px; border:1px solid #ddd; border-radius:8px; font-size:13px; color:#333; outline:none; background:#fff; transition:border 0.2s; }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color:#0f8b6d; }
    .form-group textarea { resize:vertical; min-height:90px; }
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    .btn-tambah, .btn-simpan { background:#0f8b6d; color:#fff; border:none; padding:9px 16px; border-radius:8px; font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:6px; text-decoration:none; }
    .btn-tambah:hover, .btn-simpan:hover { background:#0c6d55; color:#fff; }
    .btn-batal { background:#fff; color:#555; border:1px solid #ddd; padding:10px 22px; border-radius:8px; font-size:13px; font-weight:500; text-decoration:none; display:inline-flex; align-items:center; gap:7px; }
    .btn-batal:hover { background:#f5f5f5; color:#333; }
    .form-actions { display:flex; gap:10px; margin-top:24px; flex-wrap:wrap; }
    .badge-soft { background:#e1f5ee; color:#085041; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; display:inline-block; }
    .badge-warn { background:#fff3cd; color:#856404; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; display:inline-block; }
    .avatar-init { width:34px; height:34px; border-radius:50%; background:#e1f5ee; border:2px solid #9fe1cb; display:inline-flex; align-items:center; justify-content:center; font-size:12px; font-weight:600; color:#0f6e56; flex-shrink:0; }
    .invalid-feedback { font-size:12px; color:#dc3545; margin-top:4px; display:block; }
    td i { transition:0.2s; }
    .fa-edit:hover  { color:darkblue; transform:scale(1.2); }
    .fa-trash:hover { color:darkred; transform:scale(1.2); }
    @media(max-width:600px){
        .top-row { flex-direction:column; align-items:flex-start; }
        .search-input, .btn-tambah { width:100%; justify-content:center; }
        .form-row { grid-template-columns:1fr; }
        .form-box { padding:18px; }
    }
</style>
