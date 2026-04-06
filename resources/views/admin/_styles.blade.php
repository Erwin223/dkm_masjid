  <style>
        .notif-success {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #28a745;
            color: white;
            padding: 12px 18px;
            border-radius: 10px;
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

        .dashboard-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .dashboard-title-group h2 {
            font-size: 28px;
            margin-bottom: 6px;
            color: #1f2937;
        }

        .dashboard-subtitle {
            color: #525f7f;
            font-size: 14px;
            max-width: 640px;
            line-height: 1.6;
        }

        .dashboard-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn-secondary {
            background: #4f46e5;
        }

        .btn-secondary:hover {
            background: #4338ca;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
            margin-bottom: 28px;
        }

        .card {
            padding: 24px;
            border-radius: 20px;
            background: #fff;
            color: #1f2937;
            display: flex;
            justify-content: space-between;
            align-items: center;
            min-height: 140px;
            box-shadow: 0 16px 30px rgba(15, 23, 42, 0.08);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 38px rgba(15, 23, 42, 0.12);
        }

        .card h3 {
            font-size: 14px;
            margin-bottom: 8px;
            color: #111827;
            font-weight: 600;
            letter-spacing: 0.01em;
        }

        .card .card-value {
            font-size: 20px;
            font-weight: 700;
            margin: 0;
            letter-spacing: 0.01em;
            color: #111827;
        }

        .card .card-sub {
            font-size: 12px;
            margin-top: 6px;
            opacity: 0.75;
            line-height: 1.4;
            color: #4b5563;
        }

        .card .card-note {
            font-size: 12px;
            margin-top: 8px;
            opacity: 0.85;
            line-height: 1.4;
            color: rgba(255,255,255,0.95);
        }

        .card i {
            width: 52px;
            height: 52px;
            font-size: 20px;
            color: #0f8b6d;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
            background: rgba(15, 139, 109, 0.10);
        }

        .card-note {
            font-size: 12px;
            margin-top: 10px;
            color: #6b7280;
            opacity: 0.95;
            line-height: 1.4;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 22px;
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
            border-radius: 20px;
            border: 1px solid #e5efe9;
            box-shadow: 0 16px 30px rgba(15, 23, 42, 0.06);
        }

        .table-box-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }

        .table-box-header h3 {
            font-size: 15px;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #111827;
        }

        .btn-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 600;
            color: #ffffff;
            background: #0f8b6d;
            border: 1px solid transparent;
            padding: 8px 14px;
            border-radius: 9999px;
            text-decoration: none;
            transition: background 0.2s ease, transform 0.2s ease;
        }

        .btn-link:hover {
            background: #0c6d55;
            transform: translateY(-1px);
        }

        .btn-link .icon {
            font-size: 12px;
        }

        .table-box h3 {
            font-size: 15px;
            margin-bottom: 5px;
        }

        .table-box-subtitle {
            font-size: 12px;
            color: #6b7280;
            line-height: 1.5;
            margin-top: 6px;
        }

        .table-box-summary {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
            margin-bottom: 16px;
        }

        .table-box-summary.summary-3 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .summary-chip {
            background: linear-gradient(180deg, #f9fcfa 0%, #f3f9f6 100%);
            border: 1px solid #e2eee7;
            border-radius: 16px;
            padding: 14px 16px;
            min-height: 88px;
        }

        .summary-chip-label {
            font-size: 11px;
            color: #6b7280;
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .summary-chip-value {
            font-size: 18px;
            font-weight: 700;
            color: #111827;
            line-height: 1.2;
        }

        .summary-chip-note {
            font-size: 11px;
            color: #6b7280;
            margin-top: 6px;
            line-height: 1.45;
        }

        .table-box-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 18px;
            padding-top: 16px;
            border-top: 1px solid #edf2ef;
        }

        .table-box-total {
            font-size: 13px;
            color: #374151;
            line-height: 1.5;
        }

        .table-box-total strong {
            display: block;
            font-size: 15px;
            color: #111827;
        }

        .entity-cell {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }

        .entity-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 12px;
            font-weight: 700;
            color: #0f6e56;
            background: #e1f5ee;
            border: 2px solid #9fe1cb;
        }

        .entity-body {
            min-width: 0;
        }

        .entity-title {
            font-size: 13px;
            font-weight: 600;
            color: #111827;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .entity-subtitle {
            font-size: 11px;
            color: #6b7280;
            margin-top: 3px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .amount-stack {
            display: flex;
            flex-direction: column;
            gap: 3px;
            min-width: 118px;
        }

        .amount-main {
            font-size: 13px;
            font-weight: 700;
            color: #111827;
            line-height: 1.35;
        }

        .amount-note {
            font-size: 11px;
            color: #6b7280;
            line-height: 1.4;
        }

        .badge-soft {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 600;
            background: #e8f6ee;
            color: #198754;
            border: 1px solid #b7e4c7;
        }

        .badge-warn {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 600;
            background: #fef4e8;
            color: #b76e00;
            border: 1px solid #f4d4a4;
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
            border-radius: 20px;
            border: 1px solid #e5efe9;
            box-shadow: 0 16px 30px rgba(15, 23, 42, 0.06);
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
                grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            }

            .dashboard-grid-3 {
                grid-template-columns: 1fr 360px;
            }
        }

        @media(max-width:980px) {
            .dashboard-grid-3,
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }

        @media(max-width:760px) {
            .cards {
                grid-template-columns: 1fr;
                gap: 14px;
            }

            .card {
                padding: 18px 16px;
            }

            .card h3 {
                font-size: 13px;
            }

            .card .card-value {
                font-size: 18px;
            }

            .card i {
                font-size: 20px;
                width: 46px;
                height: 46px;
            }

            .btn-tambah {
                width: 100%;
                justify-content: center;
                margin-top: 8px;
            }

            .table-box-summary,
            .table-box-summary.summary-3,
            .table-box-footer {
                grid-template-columns: 1fr;
            }

            .dashboard-header {
                flex-direction: column;
                align-items: stretch;
            }

            .dashboard-actions {
                justify-content: stretch;
            }

            .dashboard-title-group {
                width: 100%;
            }
        }

        @media(max-width:600px) {
            .cards {
                gap: 12px;
            }

            .table-box,
            .widget-box {
                padding: 16px;
            }

            .table-responsive table {
                min-width: 100%;
            }

            .btn-tambah,
            .btn-secondary {
                width: 100%;
            }

            .table-box-summary,
            .table-box-summary.summary-3 {
                grid-template-columns: 1fr;
            }
        }

        .pink {
            background: #d4537e;
        }

        .indigo {
            background: #4361ee;
        }
    </style>
