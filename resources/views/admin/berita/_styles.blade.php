<style>
    .table-box {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e5e5e5;
        padding: 24px;
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.05);
    }
    .table-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 18px;
        flex-wrap: wrap;
    }
    .table-header h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        color: #111827;
    }
    .table-responsive { overflow-x:auto; }
    table {
        width:100%;
        border-collapse:collapse;
        min-width:780px;
        table-layout:fixed;
    }
    table th {
        background:#f8fafc;
        padding:14px 14px;
        font-size:13px;
        text-align:left;
        color:#374151;
        white-space:nowrap;
        border-bottom:1px solid #e5e7eb;
    }
    table td {
        padding:13px 14px;
        font-size:13px;
        border-bottom:1px solid #f3f4f6;
        vertical-align:top;
        color:#475569;
    }
    table tbody tr:hover { background:#f8fafc; }
    .title-cell, .summary-cell, .isi-cell { min-width:0; }
    .text-cell { display:block; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
    .line-clamp-2 { display:-webkit-box; -webkit-box-orient:vertical; -webkit-line-clamp:2; overflow:hidden; white-space:normal; }
    .line-clamp-3 { display:-webkit-box; -webkit-box-orient:vertical; -webkit-line-clamp:3; overflow:hidden; white-space:normal; }
    .top-row { display:flex; align-items:center; justify-content:space-between; margin-bottom:15px; flex-wrap:wrap; gap:10px; }
    .search-input { height:38px; border:1px solid #d1d5db; border-radius:10px; padding:0 14px; font-size:13px; outline:none; min-width:220px; }
    .search-input:focus { border-color:#0f8b6d; box-shadow: 0 0 0 4px rgba(15, 139, 109, 0.1); }
    .btn-tambah { background:#0f8b6d; color:#fff; border:none; padding:10px 18px; border-radius:10px; font-size:13px; font-weight:600; cursor:pointer; display:inline-flex; align-items:center; gap:8px; text-decoration:none; box-shadow: 0 10px 24px rgba(15, 139, 109, 0.12); }
    .btn-tambah:hover { background:#0c6d55; color:#fff; transform: translateY(-1px); }
    .badge { font-size:12px; color:#0f6e56; background:#e1f5ee; padding:5px 12px; border-radius:20px; font-weight:600; }
    .thumb { width:56px; height:40px; object-fit:cover; border-radius:10px; border:1px solid #e5e7eb; background:#f3f3f3; }
    .td-note { color:#64748b; font-size:12px; }
    td i { transition:0.2s; }
    .fa-edit:hover  { color:#0e4eb0; transform:scale(1.15); }
    .fa-trash:hover { color:#c53030;  transform:scale(1.15); }
    @media(max-width:900px){
        table { min-width: 680px; }
    }
    @media(max-width:760px){
        .top-row { flex-direction:column; align-items:flex-start; }
        .search-input, .btn-tambah { width:100%; justify-content:center; }
        .table-box { padding:18px; }
    }
    .form-box { background:#fff; border-radius:10px; border:1px solid #e5e5e5; padding:28px; max-width:900px; margin:auto; }
    .form-box h3 { font-size:16px; font-weight:600; margin-bottom:20px; color:#111; display:flex; align-items:center; gap:8px; }
    .form-group { margin-bottom:18px; }
    .form-group label { display:block; font-size:13px; font-weight:500; color:#444; margin-bottom:6px; }
    .form-group input, .form-group textarea { width:100%; padding:9px 12px; border:1px solid #ddd; border-radius:8px; font-size:13px; color:#333; outline:none; background:#fff; transition:border 0.2s; box-sizing:border-box; }
    .form-group input:focus, .form-group textarea:focus { border-color:#0f8b6d; }
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    .form-actions { display:flex; gap:10px; margin-top:24px; flex-wrap:wrap; }
    .btn-simpan { background:#0f8b6d; color:#fff; border:none; padding:10px 22px; border-radius:8px; font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:7px; }
    .btn-simpan:hover { background:#0c6d55; }
    .btn-batal { background:#fff; color:#555; border:1px solid #ddd; padding:10px 22px; border-radius:8px; font-size:13px; font-weight:500; text-decoration:none; display:inline-flex; align-items:center; gap:7px; }
    .btn-batal:hover { background:#f5f5f5; }
    .error-list { background:#fff5f5; border:1px solid #feb2b2; padding:15px; border-radius:8px; margin-bottom:20px; color:#c53030; font-size:13px; }
    .error-list ul { margin:0; padding-left:20px; }
    textarea { min-height: 150px; resize: vertical; }
    .thumb { width:120px; height:84px; object-fit:cover; border-radius:10px; border:1px solid #e6e6e6; background:#f3f3f3; display:block; }
    @media(max-width:600px){ .form-row { grid-template-columns:1fr; } .form-box { padding:18px; } }
</style>