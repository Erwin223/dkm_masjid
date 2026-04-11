 <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            min-height: 100%;
            overflow-x: hidden;
            overflow-y: auto;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            display: flex;
            background: linear-gradient(180deg, #eef2f6 0%, #f8fafc 100%);
            min-height: 100vh;
        }

        /* ===================== SIDEBAR ===================== */
        .sidebar {
            width: 250px;
            background: linear-gradient(180deg, #0f8b6d 0%, #0b6a54 100%);
            color: white;
            height: 100vh;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            transition: transform 0.3s ease, width 0.3s ease, background 0.3s ease;
            overflow: hidden;
            box-shadow: 4px 0 28px rgba(15, 23, 42, 0.12);
        }

        .sidebar.hide {
            transform: translateX(-250px);
        }

        /* LOGO */
        .sidebar-logo {
            padding: 24px 20px 20px;
            display: flex;
            align-items: center;
            gap: 14px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.14);
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar-logo .logo-icon {
            width: 44px;
            height: 44px;
            background: rgba(255, 255, 255, 0.18);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: #f8fafc;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.15);
        }

        .sidebar-logo .logo-text span {
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 0.03em;
            color: #f8fafc;
        }

        .sidebar-logo .logo-text {
            line-height: 1.2;
        }

        /* NAV LABEL */
        .nav-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            opacity: 0.5;
            padding: 18px 20px 6px;
        }

        /* NAV ITEMS */
        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            min-height: 0;
            padding: 8px 12px;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-nav::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            padding: 12px 14px;
            border-radius: 14px;
            margin-bottom: 6px;
            font-size: 14px;
            font-weight: 500;
            transition: transform 0.18s ease, background 0.18s ease, color 0.18s ease;
            cursor: pointer;
            border: none;
            background: rgba(255, 255, 255, 0.04);
            width: 100%;
            text-align: left;
        }

        .nav-item i {
            width: 22px;
            text-align: center;
            font-size: 14px;
            opacity: 0.9;
            flex-shrink: 0;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.16);
            color: #fff;
            transform: translateX(2px);
        }

        .nav-item.active {
            background: rgba(255, 255, 255, 0.22);
            color: #fff;
            font-weight: 700;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.18);
        }

        /* DROPDOWN NAV */
        .nav-dropdown {
            display: none;
            padding-left: 16px;
            transition: max-height 0.25s ease;
        }

        .nav-dropdown.open {
            display: block;
        }

        .nav-dropdown .nav-item {
            font-size: 13px;
            padding: 10px 14px;
            color: rgba(255, 255, 255, 0.78);
            background: rgba(255, 255, 255, 0.03);
            border-radius: 12px;
            margin-bottom: 4px;
        }

        .nav-dropdown .nav-item i {
            font-size: 12px;
        }

        .nav-item .nav-arrow {
            margin-left: auto;
            font-size: 11px;
            opacity: 0.6;
            transition: transform 0.2s;
        }

        .nav-item.open .nav-arrow {
            transform: rotate(90deg);
        }

        /* DIVIDER */
        .nav-divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
            margin: 10px 0;
        }

        /* SIDEBAR BOTTOM */
        .sidebar-bottom {
            padding: 18px 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.14);
            background: rgba(255, 255, 255, 0.03);
        }

        .btn-tambah-admin {
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
            padding: 12px 16px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 14px;
            color: white;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
            margin-bottom: 12px;
        }

        .btn-tambah-admin:hover {
            background: rgba(255, 255, 255, 0.22);
            border-color: rgba(255, 255, 255, 0.28);
            transform: translateY(-1px);
        }

        .btn-tambah-admin .icon-circle {
            width: 32px;
            height: 32px;
            background: rgba(255, 255, 255, 0.18);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.12);
        }

        .btn-logout {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 12px 14px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: rgba(255, 255, 255, 0.85);
            font-size: 13px;
            cursor: pointer;
            transition: background 0.18s ease, transform 0.18s ease;
            text-align: left;
        }

        .btn-logout:hover {
            background: rgba(220, 53, 69, 0.24);
            color: #fff;
            transform: translateY(-1px);
        }

        .btn-logout i {
            width: 18px;
            text-align: center;
        }

        .btn-logout i {
            width: 18px;
            text-align: center;
        }

        /* ===================== MAIN ===================== */
        .main {
            flex: 1;
            margin-left: 250px;
            transition: margin-left 0.3s ease;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .main.expanded {
            margin-left: 0;
        }

        /* NAVBAR */
        .navbar {
            background: white;
            padding: 0 24px;
            height: 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e8e8e8;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .navbar-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .menu-btn {
            background: none;
            border: none;
            color: #555;
            font-size: 18px;
            cursor: pointer;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
        }

        .menu-btn:hover {
            background: #f0f0f0;
        }

        .navbar-title {
            font-size: 15px;
            font-weight: 600;
            color: #222;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .nav-icon-btn {
            position: relative;
            width: 38px;
            height: 38px;
            border-radius: 9px;
            background: none;
            border: none;
            color: #666;
            font-size: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
            text-decoration: none;
        }

        .nav-icon-btn:hover {
            background: #f0f0f0;
            color: #333;
        }

        .notif-dot {
            position: absolute;
            top: 6px;
            right: 6px;
            width: 8px;
            height: 8px;
            background: #e74c3c;
            border-radius: 50%;
            border: 2px solid white;
        }

        .navbar-divider {
            width: 1px;
            height: 28px;
            background: #e8e8e8;
            margin: 0 6px;
        }

        .user-pill {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 5px 12px 5px 5px;
            border-radius: 30px;
            border: 1px solid #e8e8e8;
            cursor: pointer;
            transition: background 0.2s;
            background: white;
            text-decoration: none;
        }

        .user-pill:hover {
            background: #f8f8f8;
        }

        .user-avatar {
            width: 30px;
            height: 30px;
            background: #0f8b6d;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            color: white;
        }

        .user-name {
            font-size: 13px;
            font-weight: 600;
            color: #333;
        }

        /* BREADCRUMB */
        .breadcrumb-bar {
            padding: 10px 24px;
            font-size: 12px;
            color: #999;
            border-bottom: 1px solid #ebebeb;
            background: white;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .breadcrumb-bar a {
            color: #0f8b6d;
            text-decoration: none;
        }

        .breadcrumb-bar a:hover {
            text-decoration: underline;
        }

        /* CONTENT */
        .content-scroll {
            flex: 1;
            min-width: 0;
            overflow-x: auto;
            overflow-y: visible;
            -webkit-overflow-scrolling: touch;
        }

        .container {
            padding: 24px;
            min-width: 0;
            min-height: 100%;
        }

        .content-inner {
            min-width: 1100px;
        }

        .content-inner .form-box {
            width: 100%;
            margin-left: auto !important;
            margin-right: auto !important;
        }

        .content-inner :is(.don-nav, .keg-nav, .zakat-nav, .kas-nav):has(+ .form-box) {
            width: fit-content;
            max-width: 100%;
            margin-left: auto !important;
            margin-right: auto !important;
            justify-content: center;
        }

        canvas {
            display: block;
            width: 100%;
            background: transparent !important;
        }

        /* OVERLAY mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            z-index: 90;
        }

        .sidebar-overlay.show {
            display: block;
        }

        /* ===================== RESPONSIVE ===================== */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-250px);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main {
                margin-left: 0 !important;
            }

            .container {
                padding: 16px;
            }

            .content-inner {
                min-width: 100%;
            }

            .content-inner :is(.don-nav, .keg-nav, .zakat-nav, .kas-nav):has(+ .form-box) {
                width: 100%;
                justify-content: flex-start;
            }

            .navbar {
                padding: 0 16px;
            }

            .navbar-title {
                display: none;
            }
        }
    </style>
