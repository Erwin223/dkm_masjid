<style>
    .form-box { background:#fff; border-radius:10px; border:1px solid #e5e5e5; padding:28px; max-width:750px; margin:auto; }
    .form-box h3 { font-size:16px; font-weight:600; margin-bottom:20px; color:#111; display:flex; align-items:center; gap:8px; }
    .form-group { margin-bottom:18px; }
    .form-group label { display:block; font-size:13px; font-weight:500; color:#444; margin-bottom:6px; }
    .form-group input, .form-group select, .form-group textarea { width:100%; padding:9px 12px; border:1px solid #ddd; border-radius:8px; font-size:13px; color:#333; outline:none; background:#fff; transition:border 0.2s; box-sizing: border-box; }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color:#0f8b6d; }
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    .form-actions { display:flex; gap:10px; margin-top:24px; flex-wrap:wrap; }
    .btn-simpan { background:#0f8b6d; color:#fff; border:none; padding:10px 22px; border-radius:8px; font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:7px; }
    .btn-simpan:hover { background:#0c6d55; }
    .btn-batal { background:#fff; color:#555; border:1px solid #ddd; padding:10px 22px; border-radius:8px; font-size:13px; font-weight:500; text-decoration:none; display:inline-flex; align-items:center; gap:7px; }
    .btn-batal:hover { background:#f5f5f5; }
    .invalid-feedback { font-size:12px; color:#dc3545; margin-top:4px; display:block; }
    .error-list { background:#fff5f5; border:1px solid #feb2b2; padding:15px; border-radius:8px; margin-bottom:20px; color:#c53030; font-size:13px; }
    .error-list ul { margin:0; padding-left:20px; }
    .password-wrapper { position: relative; }
    .password-wrapper input { padding-right: 40px !important; }
    .password-wrapper .toggle-password { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #777; }
    @media(max-width:600px){ .form-row { grid-template-columns:1fr; } .form-box { padding:18px; } }
    .header-box {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .table-box {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, .1);
    }

    .table-responsive {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table th {
        background: #f3f3f3;
        padding: 12px;
        text-align: left;
        font-size: 13px;
        border-bottom: 1px solid #e5e5e5;
    }

    table td {
        padding: 12px;
        border-bottom: 1px solid #eee;
        font-size: 13px;
    }

    .btn-tambah {
        background: #0f8b6d;
        color: white;
        padding: 10px 20px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-tambah:hover {
        background: #0c6d55;
    }

    .pgr-avatar-sm {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #e1f5ee;
        border: 2px solid #9fe1cb;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 600;
        color: #0f6e56;
    }
</style>
