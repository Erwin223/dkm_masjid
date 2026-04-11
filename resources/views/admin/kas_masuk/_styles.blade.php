<style>
        .form-box {
            background: #fff;
            border-radius: 10px;
            border: 1px solid #e5e5e5;
            padding: 28px;
            max-width: 750px;
            margin: auto;
        }

        .form-box h3 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #111;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: #444;
            margin-bottom: 6px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 9px 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 13px;
            color: #333;
            outline: none;
            background: #fff;
            transition: border 0.2s;
            box-sizing: border-box;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #0f8b6d;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 80px;
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
            color: #fff;
            border: none;
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
            color: #555;
            border: 1px solid #ddd;
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

        @media(max-width:600px) {
            .form-row {
                grid-template-columns: 1fr;
            }

            .form-box {
                padding: 18px;
            }
        }
    .kas-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; flex-wrap:wrap; gap:10px; }
    .kas-title  { font-size:20px; font-weight:600; color:#111; display:flex; align-items:center; gap:10px; }
    .kas-icon   { width:38px; height:38px; background:#e1f5ee; border-radius:10px; display:flex; align-items:center; justify-content:center; }

    .kas-nav { display:flex; gap:10px; margin-bottom:25px; flex-wrap:wrap; }
    .kas-nav a { padding:9px 18px; border-radius:8px; font-size:13px; font-weight:500; text-decoration:none; border:1px solid #ddd; color:#555; background:#fff; display:inline-flex; align-items:center; gap:7px; transition:0.2s; }
    .kas-nav a:hover  { background:#f0fbf6; border-color:#0f8b6d; color:#0f8b6d; }
    .kas-nav a.active { background:#0f8b6d; border-color:#0f8b6d; color:#fff; }

    .summary-row { display:grid; grid-template-columns:repeat(3,1fr); gap:12px; margin-bottom:20px; }
    .summary-card { background:#fff; border-radius:10px; border:1px solid #e5e5e5; padding:16px; }
    .summary-card .s-label { font-size:12px; color:#999; margin-bottom:6px; }
    .summary-card .s-value { font-size:20px; font-weight:700; color:#0f8b6d; }

    .table-box { background:#fff; border-radius:10px; border:1px solid #e5e5e5; padding:20px; }
    .table-responsive { overflow-x:auto; }
    table { width:100%; border-collapse:collapse; min-width:500px; }
    table th { background:#f3f3f3; padding:10px 12px; font-size:12px; text-align:left; white-space:nowrap; border-bottom:1px solid #e5e5e5; }
    table td { padding:10px 12px; font-size:13px; border-bottom:1px solid #f5f5f5; vertical-align:middle; }
    table tbody tr:hover { background:#f7fdf9; }
    .top-row { display:flex; align-items:center; justify-content:space-between; margin-bottom:15px; flex-wrap:wrap; gap:10px; }
    .search-input { height:36px; border:1px solid #ddd; border-radius:8px; padding:0 12px; font-size:13px; outline:none; min-width:200px; }
    .search-input:focus { border-color:#0f8b6d; }
    .btn-tambah { background:#0f8b6d; color:#fff; border:none; padding:9px 16px; border-radius:8px; font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:6px; text-decoration:none; }
    .btn-tambah:hover { background:#0c6d55; color:#fff; }
    .sumber-pill { display:inline-block; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; background:#e1f5ee; color:#085041; }
    td i { transition:0.2s; }
    .fa-edit:hover  { color:darkblue; transform:scale(1.2); }
    .fa-trash:hover { color:darkred;  transform:scale(1.2); }
    @media(max-width:768px){ .summary-row { grid-template-columns:1fr 1fr; } }
    @media(max-width:600px){ .summary-row { grid-template-columns:1fr; } .top-row { flex-direction:column; align-items:flex-start; } .search-input,.btn-tambah { width:100%; justify-content:center; } }
    </style>
