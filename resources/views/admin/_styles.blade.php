  <style>
        .notif-success {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #28a745;
            color: white;
            padding: 12px 18px;
            border-radius: 8px;
            z-index: 999;
            animation: fadeIn 0.5s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
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

        .card h3 {
            font-size: 13px;
            margin-bottom: 6px;
            opacity: .9;
            font-weight: 500;
        }

        .card .card-value {
            font-size: 18px;
            font-weight: 700;
            margin: 0;
        }

        .card .card-sub {
            font-size: 11px;
            margin-top: 3px;
            opacity: .75;
        }

        .card i {
            font-size: 28px;
            opacity: .7;
        }

        .green {
            background: #28a745;
        }

        .blue {
            background: #17a2b8;
        }

        .orange {
            background: #fd7e14;
        }

        .red {
            background: #dc3545;
        }

        .purple {
            background: #6f42c1;
        }

        .teal {
            background: #0f8b6d;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .dashboard-grid-3 {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 20px;
            align-items: start;
        }

        .table-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, .1);
        }

        .table-box h3 {
            font-size: 15px;
            margin-bottom: 5px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 500px;
        }

        table th {
            background: #f3f3f3;
            padding: 10px;
            text-align: left;
            font-size: 13px;
            white-space: nowrap;
            border-bottom: 1px solid #e5e5e5;
        }

        table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            font-size: 13px;
            white-space: nowrap;
        }

        .total-box {
            text-align: center;
            margin-top: 15px;
            font-size: 13px;
        }

        .btn-tambah {
            background: #0f8b6d;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
        }

        .btn-tambah:hover {
            background: #0c6d55;
            color: white;
        }

        .widget-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, .1);
            font-size: 13px;
        }

        .saldo-positif {
            color: #28a745;
            font-weight: 700;
        }

        .badge-akan {
            background: #fff3cd;
            color: #856404;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-selesai {
            background: #d1e7dd;
            color: #0f5132;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-berjalan {
            background: #cfe2ff;
            color: #084298;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-anggaran {
            background: #faeeda;
            color: #633806;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            display: inline-block;
        }

        .pgr-avatar-sm {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #e1f5ee;
            border: 2px solid #9fe1cb;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 600;
            color: #0f6e56;
            flex-shrink: 0;
            object-fit: cover;
        }

        .status-tetap-sm {
            background: #e1f5ee;
            color: #085041;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
            display: inline-block;
        }

        .status-tamu-sm {
            background: #fff3cd;
            color: #856404;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
            display: inline-block;
        }

        .saldo-negatif {
            color: #dc3545;
            font-weight: 700;
        }

        td i {
            transition: 0.2s;
        }

        .fa-edit:hover {
            color: darkblue;
            transform: scale(1.2);
        }

        .fa-trash:hover {
            color: darkred;
            transform: scale(1.2);
        }

        @media(max-width:1200px) {
            .cards {
                grid-template-columns: repeat(4, 1fr);
            }

            .dashboard-grid-3 {
                grid-template-columns: 1fr 360px;
            }
        }

        @media(max-width:900px) {
            .dashboard-grid-3 {
                grid-template-columns: 1fr;
            }
        }

        @media(max-width:900px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }

            .cards {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media(max-width:600px) {
            .cards {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }

            .card {
                padding: 14px 12px;
            }

            .card h3 {
                font-size: 12px;
            }

            .card .card-value {
                font-size: 15px;
            }

            .card i {
                font-size: 22px;
            }

            .btn-tambah {
                width: 100%;
                justify-content: center;
                margin-top: 8px;
            }

            h2 {
                font-size: 18px;
            }
        }

        .pink {
            background: #d4537e;
        }

        .indigo {
            background: #4361ee;
        }
    </style>
