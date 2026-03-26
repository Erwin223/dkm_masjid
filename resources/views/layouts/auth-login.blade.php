<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Login Admin')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: sans-serif;
            min-height: 100vh;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        .left {
            width: 50%;
            background: linear-gradient(90deg, #2f8f6b, #a7c6b8);
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            padding: 20px;
        }

        .left-content img {
            width: 90px;
            margin-bottom: 20px;
        }

        .right {
            width: 50%;
            background: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-card {
            background: white;
            padding: 50px;
            width: 420px;
            max-width: 100%;
            border-radius: 14px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
            text-align: center;
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

        .input-group i {
            position: absolute;
            top: 50%;
            left: 12px;
            transform: translateY(-50%);
            color: #777;
        }

        .input-group i.toggle-password {
            left: auto;
            right: 12px;
            cursor: pointer;
        }

        .input-group input {
            width: 100%;
            padding: 12px 40px 12px 40px;
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

        @media (max-width:768px) {
            .container {
                flex-direction: column;
            }

            .left {
                width: 100%;
                min-height: 200px;
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
                <img src="/images/logo.png">
                <h2><i class="fa-solid fa-mosque"></i> DKM AL-MUSABAQOH</h2>
                <p>@yield('subtitle', 'Login Admin Website DKM')</p>
            </div>
        </div>
        <div class="right">
            <div class="login-card">
                @yield('content')
                <div class="footer">
                    <i class="fa-solid fa-copyright"></i> 2026 DKM AL-MUSABAQOH
                </div>
            </div>
        </div>
    </div>
    <script>
    function togglePasswordVisibility(inputId, iconElement) {
        const passwordInput = document.getElementById(inputId);
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            iconElement.classList.remove("fa-eye");
            iconElement.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            iconElement.classList.remove("fa-eye-slash");
            iconElement.classList.add("fa-eye");
        }
    }
    </script>
</body>

</html>