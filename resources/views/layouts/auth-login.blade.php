<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Login Admin')</title>
    <style>
        body {
            margin: 0;
            font-family: sans-serif;
            min-height: 100vh;
            background:
                linear-gradient(rgba(10, 24, 17, 0.35), rgba(10, 24, 17, 0.35)),
                url('{{ asset('storage/icon/FOTO.jpeg') }}') center/cover no-repeat fixed;
        }

        .container {
            display: flex;
            min-height: 100vh;
            background: rgba(255, 255, 255, 0.08);
        }

        .left {
            width: 50%;
            background:
                linear-gradient(135deg, rgba(47, 143, 107, 0.88), rgba(167, 198, 184, 0.72));
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        

        .left-content {
            position: relative;
            z-index: 1;
        }

        .left-content img {
            width: 90px;
            margin-bottom: 20px;
        }

        .brand-mark {
            width: 78px;
            height: 78px;
            margin: 0 auto 18px;
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.24);
            display: grid;
            place-items: center;
            backdrop-filter: blur(6px);
        }

        .brand-mark svg {
            width: 42px;
            height: 42px;
            fill: currentColor;
        }

        .right {
            width: 50%;
            background: rgba(242, 242, 242, 0.84);
            backdrop-filter: blur(6px);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.9);
            padding: 50px;
            width: 420px;
            max-width: 100%;
            border-radius: 14px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
            text-align: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.45);
        }

        .login-card h2 {
            margin-bottom: 5px;
        }

        .login-card p {
            font-size: 14px;
            color: #666;
            margin-bottom: 25px;
        }

        .input-group {
            position: relative;
            margin-bottom: 18px;
            text-align: left;
        }

        .input-icon {
            position: absolute;
            top: 50%;
            left: 14px;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            color: #5d7669;
            pointer-events: none;
        }

        .input-icon svg {
            width: 18px;
            height: 18px;
            fill: currentColor;
        }

        .input-group input {
            width: 100%;
            padding: 12px 14px 12px 42px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 16px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 14px;
            background: #137c3b;
            border: none;
            color: white;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background: #0f6832;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }

        .error-box {
            background: #ffe0e0;
            color: #a30000;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 14px;
            text-align: left;
        }

        .status-box {
            background: #e1f5ee;
            color: #0f6e56;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 14px;
            text-align: left;
        }

        .link {
            font-size: 13px;
            color: #137c3b;
            text-decoration: none;
        }

        .link:hover {
            text-decoration: underline;
        }

        .actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 20px;
        }

        .btn-inline {
            width: auto;
            padding: 10px 16px;
            font-size: 13px;
            border-radius: 6px;
        }

        .btn-secondary {
            background: #6c757d;
        }

        .btn-secondary:hover {
            background: #5c636a;
        }

        .btn-secondary[disabled] {
            opacity: .6;
            cursor: not-allowed;
        }

        .toggle-password-btn {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            border: 0;
            background: transparent;
            color: #555;
            width: 24px;
            height: 24px;
            padding: 0;
            display: grid;
            place-items: center;
        }

        .toggle-password-btn:hover {
            background: transparent;
            color: #111;
        }

        .toggle-password-btn svg {
            width: 18px;
            height: 18px;
            stroke: currentColor;
            fill: none;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .auth-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 14px;
            padding: 8px 12px;
            border-radius: 999px;
            background: #edf7f0;
            color: #0f6e56;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .02em;
        }

        .auth-badge svg {
            width: 15px;
            height: 15px;
            fill: currentColor;
        }

        @media (max-width:768px) {
            .container {
                flex-direction: column;
            }

            .left {
                width: 100%;
                min-height: 200px;
                background:
                    linear-gradient(135deg, rgba(47, 143, 107, 0.9), rgba(167, 198, 184, 0.76));
            }

            .right {
                width: 100%;
            }

            .login-card {
                padding: 30px;
            }

            .left-content img {
                width: 70px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="left">
            <div class="left-content">
                <div class="brand-mark" aria-hidden="true">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 2 4 6v2h16V6l-8-4Zm-6 8v8H4v2h16v-2h-2v-8h-2v8h-3v-5h-2v5H8v-8H6Zm2.5-1.5A1.5 1.5 0 1 0 8.5 7a1.5 1.5 0 0 0 0 3Zm7 0A1.5 1.5 0 1 0 15.5 7a1.5 1.5 0 0 0 0 3Z"/>
                    </svg>
                </div>
                <h2>DKM Masjid AL-MUSABAQOH</h2>
                <p>@yield('subtitle', 'Login Admin Website DKM')</p>
            </div>
        </div>
        <div class="right">
            <div class="login-card">
                @yield('content')
                <div class="footer">
                    Copyright 2026 DKM Masjid AL-MUSABAQOH
                </div>
            </div>
        </div>
    </div>
    <script>
    function togglePasswordVisibility(inputId, buttonElement) {
        const passwordInput = document.getElementById(inputId);
        const iconOpen = '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z"></path><circle cx="12" cy="12" r="3"></circle></svg>';
        const iconClosed = '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 3l18 18"></path><path d="M10.58 10.58A2 2 0 0 0 10 12a2 2 0 0 0 2 2c.52 0 1-.2 1.42-.58"></path><path d="M9.88 5.09A10.94 10.94 0 0 1 12 5c6.5 0 10 7 10 7a17.6 17.6 0 0 1-4.04 4.72"></path><path d="M6.61 6.61A17.28 17.28 0 0 0 2 12s3.5 7 10 7a10.8 10.8 0 0 0 3.06-.43"></path></svg>';

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            if (buttonElement) buttonElement.innerHTML = iconClosed;
        } else {
            passwordInput.type = "password";
            if (buttonElement) buttonElement.innerHTML = iconOpen;
        }
    }
    </script>
</body>

</html>
