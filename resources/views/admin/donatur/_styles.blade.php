<style>
    /* Navigation */
    .don-nav { display:flex; gap:10px; margin-bottom:25px; flex-wrap:wrap; }
    .don-nav a { padding:9px 18px; border-radius:8px; font-size:13px; font-weight:500; text-decoration:none; border:1px solid #ddd; color:#555; background:#fff; display:inline-flex; align-items:center; gap:7px; transition:0.2s; }
    .don-nav a:hover  { background:#f0fbf6; border-color:#0f8b6d; color:#0f8b6d; }
    .don-nav a.active { background:#0f8b6d; border-color:#0f8b6d; color:#fff; }

    /* Table Box */
    .table-box { background:#fff; border-radius:10px; border:1px solid #e5e5e5; padding:20px; }
    .top-row { display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; gap:15px; flex-wrap:wrap; }
    .search-input { padding:9px 12px; border:1px solid #ddd; border-radius:8px; font-size:13px; color:#333; outline:none; background:#fff; transition:border 0.2s; }
    .search-input:focus { border-color:#0f8b6d; }
    .btn-tambah { background:#0f8b6d; color:#fff; border:none; padding:9px 18px; border-radius:8px; font-size:13px; font-weight:500; text-decoration:none; cursor:pointer; display:inline-flex; align-items:center; gap:7px; transition:0.2s; }
    .btn-tambah:hover { background:#0c6d55; }

    /* Table Responsive */
    .table-responsive { overflow-x:auto; }
    table { width:100%; border-collapse:collapse; }
    table thead { background:#f8f8f8; }
    table th { padding:12px; text-align:left; font-size:12px; font-weight:600; color:#444; border-bottom:2px solid #e5e5e5; }
    table td { padding:14px 12px; border-bottom:1px solid #e5e5e5; color:#555; font-size:13px; }
    table tbody tr:hover { background:#fafafa; }

    /* Avatar */
    .avatar-init { width:36px; height:36px; border-radius:50%; background:#0f8b6d; color:#fff; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:600; flex-shrink:0; }

    /* Badge */
    .badge-individu { background:#e3f2fd; color:#1976d2; padding:4px 10px; border-radius:20px; font-size:11px; font-weight:500; display:inline-block; }
    .badge-lembaga { background:#f3e5f5; color:#7b1fa2; padding:4px 10px; border-radius:20px; font-size:11px; font-weight:500; display:inline-block; }

    /* Form Styles */
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

    @media(max-width:600px) {
        .form-row { grid-template-columns:1fr; }
        .form-box { padding:18px; }
        .top-row { flex-direction:column; align-items:stretch; }
        .search-input { width:100%; }
        table { font-size:12px; }
        table th, table td { padding:10px 8px; }
    }
</style>
