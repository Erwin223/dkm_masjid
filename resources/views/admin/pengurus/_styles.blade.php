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
    .error-list { background:#fff5f5; border:1px solid #feb2b2; padding:15px; border-radius:8px; margin-bottom:20px; color:#c53030; font-size:13px; }
    .error-list ul { margin:0; padding-left:20px; }
    @media(max-width:600px){ .form-row { grid-template-columns:1fr; } .form-box { padding:18px; } }
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
    .error-list { background:#fff5f5; border:1px solid #feb2b2; padding:15px; border-radius:8px; margin-bottom:20px; color:#c53030; font-size:13px; }
    .error-list ul { margin:0; padding-left:20px; }
    .preview { display:flex; align-items:center; gap:15px; margin-bottom:20px; padding:15px; background:#f9f9f9; border-radius:8px; border:1px dashed #ddd; }
    .preview img { width:70px; height:70px; border-radius:50%; object-fit:cover; border:2px solid #0f8b6d; }
    .preview-info { flex:1; }
    .preview-info div { font-size:13px; font-weight:600; color:#333; }
    .preview-info span { font-size:11px; color:#666; }
    @media(max-width:600px){ .form-row { grid-template-columns:1fr; } .form-box { padding:18px; } }
      .cards {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        margin-bottom: 25px;
    }

    .card {
        padding: 20px;
        border-radius: 8px;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card i { font-size: 28px; opacity: 0.8; }
    .green  { background: #28a745; }
    .blue   { background: #17a2b8; }
    .orange { background: #fd7e14; }
    .purple { background: #6f42c1; }

    .table-box {
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }

    .table-box h3 {
        margin-bottom: 5px;
        font-size: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    table th {
        background: #f3f3f3;
        padding: 10px;
        text-align: left;
        font-size: 13px;
    }

    table td {
        padding: 10px;
        border-bottom: 1px solid #eee;
        font-size: 13px;
        vertical-align: middle;
    }

    td i { transition: 0.2s; }
    .fa-edit:hover  { color: darkblue; transform: scale(1.2); }
    .fa-trash:hover { color: darkred; transform: scale(1.2); }

    .pgr-top-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .pgr-search {
        height: 36px;
        border: 1px solid #ddd;
        border-radius: 6px;
        padding: 0 12px;
        font-size: 13px;
        outline: none;
        min-width: 200px;
    }

    .pgr-search:focus { border-color: #0f8b6d; }

    .pgr-badge {
        font-size: 12px;
        color: #085041;
        background: #e1f5ee;
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 500;
    }

    /* BUTTON */
    .btn-tambah {
        background: #0f8b6d;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 13px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-tambah:hover { background: #0c6d55; color: white; }

    .pgr-avatar-img {
        width: 40px; height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #9fe1cb;
    }

    .pgr-avatar-initials {
        width: 40px; height: 40px;
        border-radius: 50%;
        background: #e1f5ee;
        border: 2px solid #9fe1cb;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 600;
        color: #0f6e56;
    }

    .pgr-avatar-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .pgr-nama {
        font-weight: 500;
        color: #111 !important;
        font-size: 14px;
        display: block !important;
        opacity: 1 !important;
    }

    .pgr-sub {
        font-size: 11px;
        color: #999 !important;
        display: block !important;
    }

    .pgr-jabatan-pill {
        display: inline-block;
        background: #e1f5ee;
        color: #085041;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    /* RESPONSIVE  */
    @media (max-width: 992px) {
        .cards {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .cards {
            grid-template-columns: repeat(2, 1fr);
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        table th, table td {
            white-space: nowrap;
            min-width: 100px;
        }

        .pgr-top-row {
            flex-direction: column;
            align-items: flex-start;
        }

        .pgr-search { width: 100%; min-width: unset; }
    }

    @media (max-width: 480px) {
        .cards {
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .card { padding: 14px; }
        .card h3 { font-size: 13px; }
        .card i  { font-size: 22px; }

        .btn-tambah { width: 100%; justify-content: center; }
    }
</style>
