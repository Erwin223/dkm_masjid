<style>
    /* ═══════════════════════════════════════════════════════════════ */
    /* ARSIP INDEX PAGE - MODERN STYLES                                */
    /* ═══════════════════════════════════════════════════════════════ */

    .arsip-page { padding: 24px 0; display: flex; flex-direction: column; gap: 24px; }

    /* ── HERO SECTION ──────────────────────────────────────────── */
    .arsip-hero {
        background: linear-gradient(135deg, #0f8b6d 0%, #0e7a5e 60%, #085041 100%);
        border-radius: 18px; padding: 28px 32px;
        color: #fff; display: flex;
        align-items: center; justify-content: space-between;
        gap: 24px; flex-wrap: wrap;
        position: relative; overflow: hidden;
    }
    .arsip-hero::before {
        content: ''; position: absolute;
        right: -60px; top: -60px;
        width: 240px; height: 240px;
        border-radius: 50%;
        background: rgba(255,255,255,0.07);
    }
    .arsip-hero::after {
        content: ''; position: absolute;
        right: 60px; bottom: -80px;
        width: 180px; height: 180px;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
    }
    .arsip-hero-left { z-index: 1; }
    .arsip-hero-tag {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(255,255,255,0.18);
        border-radius: 99px; padding: 4px 12px;
        font-size: 11px; font-weight: 700;
        letter-spacing: .06em; text-transform: uppercase;
        margin-bottom: 10px;
    }
    .arsip-hero-tag span {
        width: 7px; height: 7px;
        border-radius: 50%;
        background: #a7f3d0;
        display: inline-block;
    }
    .arsip-hero-left h1 { font-size: 24px; font-weight: 800; margin: 0 0 6px; }
    .arsip-hero-left p { font-size: 13px; color: rgba(255,255,255,0.82); margin: 0; }
    .arsip-hero-kpis {
        display: flex; gap: 12px;
        flex-wrap: wrap; z-index: 1;
    }
    .arsip-kpi-pill {
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.22);
        border-radius: 14px; padding: 14px 20px;
        min-width: 140px; backdrop-filter: blur(6px);
    }
    .arsip-kpi-label {
        font-size: 10px; text-transform: uppercase;
        letter-spacing: .08em;
        color: rgba(255,255,255,0.75);
    }
    .arsip-kpi-value {
        font-size: 20px; font-weight: 800;
        margin: 6px 0 2px;
    }
    .arsip-kpi-sub {
        font-size: 11px;
        color: rgba(255,255,255,0.65);
    }

    /* ── SUMMARY CARDS ─────────────────────────────────────────── */
    .arsip-summary-row {
        display: grid; grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-bottom: 22px;
    }
    @media(max-width:900px){ .arsip-summary-row { grid-template-columns: repeat(2, 1fr); } }
    @media(max-width:600px){ .arsip-summary-row { grid-template-columns: 1fr; } }

    .arsip-stat-card {
        background: #fff; border: 1.5px solid #e5e7eb;
        border-radius: 16px; padding: 18px 20px;
        display: flex; align-items: center; gap: 14px;
        transition: box-shadow .18s, transform .18s;
    }
    .arsip-table-box {
        background: #fff; border: 1.5px solid #e5e7eb;
        border-radius: 16px; padding: 24px;
        margin-top: 12px;
    }
    .arsip-stat-card:hover {
        box-shadow: 0 8px 24px rgba(0,0,0,.08);
        transform: translateY(-2px);
    }
    .arsip-stat-icon {
        width: 46px; height: 46px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 18px; flex-shrink: 0;
    }
    .arsip-stat-body {}
    .arsip-stat-label {
        font-size: 11px; color: #9ca3af;
        text-transform: uppercase; letter-spacing: .06em; font-weight: 600;
    }
    .arsip-stat-value {
        font-size: 22px; font-weight: 800;
        color: #111827; margin: 4px 0;
    }
    .arsip-stat-sub {
        font-size: 12px; color: #6b7280;
        margin-top: 2px;
    }

    /* ── TABLE BOX ─────────────────────────────────────────────── */
    .arsip-table-box {
        background: #fff; border: 1.5px solid #e5e7eb;
        border-radius: 16px; padding: 24px;
    }
    .arsip-table-top {
        display: flex; align-items: center;
        justify-content: space-between;
        gap: 16px; flex-wrap: wrap;
        margin-bottom: 20px;
    }
    .arsip-search-input {
        height: 38px; border: 1.5px solid #e5e7eb;
        border-radius: 10px; padding: 0 14px;
        font-size: 13px; outline: none;
        min-width: 220px; transition: border .2s;
    }
    .arsip-search-input:focus {
        border-color: #0f8b6d;
        box-shadow: 0 0 0 3px rgba(15, 139, 109, 0.1);
    }
    .arsip-btn-tambah {
        background: #0f8b6d; color: #fff;
        border: none; padding: 10px 20px;
        border-radius: 10px; font-size: 13px;
        font-weight: 600; cursor: pointer;
        display: inline-flex; align-items: center;
        gap: 7px; text-decoration: none;
        transition: background .2s;
    }
    .arsip-btn-tambah:hover {
        background: #0c6d55;
    }

    /* ── TABLE STYLING ───────────────────────────────────────── */
    .arsip-table {
        width: 100%; border-collapse: collapse;
    }
    .arsip-table thead tr {
        background: #f9fafb; border-bottom: 2px solid #e5e7eb;
    }
    .arsip-table th {
        padding: 14px 16px; text-align: left;
        font-size: 12px; font-weight: 700;
        color: #6b7280; text-transform: uppercase;
        letter-spacing: .05em;
    }
    .arsip-table tbody tr {
        border-bottom: 1px solid #f3f4f6;
        transition: background .15s;
    }
    .arsip-table tbody tr:hover {
        background: #f9fafb;
    }
    .arsip-table tbody tr:last-child {
        border-bottom: none;
    }
    .arsip-table td {
        padding: 16px; font-size: 13px;
        color: #374151; vertical-align: middle;
    }

    .arsip-judul {
        font-weight: 600; color: #111827;
        display: block;
    }
    .arsip-deskripsi {
        font-size: 12px; color: #9ca3af;
        display: block; margin-top: 4px;
    }

    /* ── BADGE CATEGORIES ────────────────────────────────────── */
    .arsip-badge {
        display: inline-block;
        padding: 4px 12px; border-radius: 20px;
        font-size: 11px; font-weight: 600;
        text-transform: uppercase;
    }
    .arsip-badge-surat {
        background: #fef3c7; color: #92400e;
    }
    .arsip-badge-dokumen {
        background: #dbeafe; color: #1e40af;
    }
    .arsip-badge-laporan {
        background: #d1fae5; color: #065f46;
    }
    .arsip-badge-kontrak {
        background: #ede9fe; color: #5b21b6;
    }
    .arsip-badge-proposal {
        background: #fecaca; color: #7c2d12;
    }
    .arsip-badge-lainnya {
        background: #e5e7eb; color: #374151;
    }

    /* ── ACTION BUTTONS ──────────────────────────────────────── */
    .arsip-action-group {
        display: flex; gap: 8px;
        justify-content: center;
        align-items: center;
    }
    .arsip-btn-action,
    .arsip-btn-action-cell {
        cursor: pointer;
        display: inline-flex;
        align-items: center; justify-content: center;
        font-size: 15px;
        transition: all .2s;
        border: none;
        background: none;
        padding: 0;
    }
    .arsip-btn-action-cell {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        border: 1.5px solid #e5e7eb;
        background: #fff;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06);
    }
    .arsip-btn-action {
        width: 32px; height: 32px;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        background: #fff;
    }
    .arsip-btn-download {
        color: #1e7c34;
    }
    .arsip-btn-download:hover {
        background: #dcfce7;
        border-color: #1e7c34;
        color: #1e7c34;
        box-shadow: 0 4px 12px rgba(30, 124, 52, 0.15);
        transform: translateY(-1px);
    }
    .arsip-btn-edit {
        color: #1e40af;
    }
    .arsip-btn-edit:hover {
        background: #dbeafe;
        border-color: #1e40af;
        color: #1e40af;
        box-shadow: 0 4px 12px rgba(30, 64, 175, 0.15);
        transform: translateY(-1px);
    }
    .arsip-btn-delete {
        color: #dc2626;
    }
    .arsip-btn-delete:hover {
        background: #fee2e2;
        border-color: #dc2626;
        color: #dc2626;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.15);
        transform: translateY(-1px);
    }

    /* ────────────────────────────────────────────────────────── */
    /* FORM STYLES (Create/Edit Pages)                             */
    /* ────────────────────────────────────────────────────────── */

    .form-box {
        background: #fff; border-radius: 10px;
        border: 1px solid #e5e5e5; padding: 28px;
        max-width: 750px; margin: auto;
    }
    .form-box h3 {
        font-size: 16px; font-weight: 600;
        margin-bottom: 20px; color: #111;
        display: flex; align-items: center; gap: 8px;
    }
    .form-group {
        margin-bottom: 18px;
    }
    .form-group label {
        display: block; font-size: 13px;
        font-weight: 500; color: #444;
        margin-bottom: 6px;
    }
    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%; padding: 9px 12px;
        border: 1px solid #ddd; border-radius: 8px;
        font-size: 13px; color: #333;
        outline: none; background: #fff;
        transition: border 0.2s;
        box-sizing: border-box;
    }
    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        border-color: #0f8b6d;
    }
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }
    .form-actions {
        display: flex;
        gap: 10px;
        margin-top: 24px;
        flex-wrap: wrap;
    }
    .btn-simpan {
        background: #0f8b6d;
        color: #fff; border: none;
        padding: 10px 22px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 7px;
    }
    .btn-simpan:hover {
        background: #0c6d55;
    }
    .btn-batal {
        background: #fff;
        color: #555; border: 1px solid #ddd;
        padding: 10px 22px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 7px;
    }
    .btn-batal:hover {
        background: #f5f5f5;
    }
    .error-list {
        background: #fff5f5;
        border: 1px solid #feb2b2;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        color: #c53030;
        font-size: 13px;
    }
    .error-list ul {
        margin: 0;
        padding-left: 20px;
    }
    .preview {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px;
        background: #f9f9f9;
        border-radius: 8px;
        border: 1px dashed #ddd;
    }
    .preview-info {
        flex: 1;
    }
    .preview-info div {
        font-size: 13px;
        font-weight: 600;
        color: #333;
    }
    .preview-info span {
        font-size: 11px;
        color: #666;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #6b7280;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        padding: 8px 16px;
        background: #f3f4f6;
        border-radius: 10px;
        transition: background .2s;
    }
    .btn-back:hover {
        background: #e5e7eb;
    }

    /* ── RESPONSIVE ────────────────────────────────────────────── */
    @media(max-width:900px){
        .arsip-hero {
            flex-direction: column;
            text-align: center;
        }
        .arsip-hero-left {
            width: 100%;
        }
        .arsip-hero-kpis {
            width: 100%;
            justify-content: center;
        }
        .arsip-table-top {
            flex-direction: column;
            align-items: stretch;
        }
        .arsip-search-input,
        .arsip-btn-tambah {
            width: 100%;
        }
    }

    @media(max-width:600px){
        .arsip-summary-row {
            grid-template-columns: 1fr;
        }
        .arsip-stat-card {
            flex-direction: column;
            text-align: center;
        }
        .arsip-table {
            font-size: 12px;
        }
        .arsip-table th,
        .arsip-table td {
            padding: 12px 8px;
        }
        .form-row {
            grid-template-columns: 1fr;
        }
        .form-box {
            padding: 18px;
        }
    }
    .arsip-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; flex-wrap:wrap; gap:10px; }
    .arsip-title  { font-size:20px; font-weight:600; color:#111; display:flex; align-items:center; gap:10px; }
    .arsip-icon   { width:38px; height:38px; background:#e1f5ee; border-radius:10px; display:flex; align-items:center; justify-content:center; }
</style>
