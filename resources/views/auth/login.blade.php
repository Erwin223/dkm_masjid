<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>Login Admin</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

body{
margin:0;
font-family:sans-serif;
min-height:100vh;
}

/* CONTAINER */

.container{
display:flex;
min-height:100vh;
}

/* LEFT SIDE */

.left{
width:50%;
background:linear-gradient(90deg,#2f8f6b,#a7c6b8);
display:flex;
justify-content:center;
align-items:center;
color:white;
text-align:center;
padding:20px;
}

.left-content img{
width:90px;
margin-bottom:20px;
}

/* RIGHT SIDE */

.right{
width:50%;
background:#f2f2f2;
display:flex;
justify-content:center;
align-items:center;
padding:20px;
}

/* LOGIN CARD */

.login-card{
background:white;
padding:50px;
width:420px;
max-width:100%;
border-radius:14px;
box-shadow:0 15px 35px rgba(0,0,0,0.15);
text-align:center;
}

.login-card h2{
margin-bottom:5px;
}

.login-card p{
font-size:14px;
color:#666;
margin-bottom:25px;
}

/* INPUT GROUP */

.input-group{
position:relative;
margin-bottom:18px;
}

.input-group i{
position:absolute;
top:50%;
left:12px;
transform:translateY(-50%);
color:#777;
}

.input-group i.toggle-password {
left:auto;
right:12px;
cursor:pointer;
}

.input-group input{
width:100%;
padding:12px 40px 12px 40px;
border-radius:6px;
border:1px solid #ccc;
font-size:16px;
box-sizing: border-box;
}

/* BUTTON */

button{
width:100%;
padding:14px;
background:#137c3b;
border:none;
color:white;
font-weight:bold;
border-radius:6px;
cursor:pointer;
font-size:16px;
}

button:hover{
background:#0f6832;
}

/* FOOTER */

.footer{
margin-top:20px;
font-size:12px;
color:#666;
}

/* ERROR MESSAGE */

.error-box{
background:#ffe0e0;
color:#a30000;
padding:10px;
border-radius:6px;
margin-bottom:15px;
font-size:14px;
}

/* MOBILE */

@media (max-width:768px){

.container{
flex-direction:column;
}

.left{
width:100%;
min-height:200px;
}

.right{
width:100%;
}

.login-card{
padding:30px;
}

.left-content img{
width:70px;
}

}

</style>
</head>

<body>

<div class="container">

<!-- LEFT -->

<div class="left">

<div class="left-content">

<img src="/images/logo.png">

<h2><i class="fa-solid fa-mosque"></i> DKM AL-MUSABAQOH</h2>

<p>Login Admin Website DKM</p>

</div>

</div>

<!-- RIGHT -->

<div class="right">

<div class="login-card">

<h2><i class="fa-solid fa-user-shield"></i> Login Admin</h2>

<p>Silahkan login untuk mengelola sistem informasi masjid</p>

{{-- SESSION EXPIRED --}}
@if(session('error'))
<div class="error-box">
{{ session('error') }}
</div>
@endif

{{-- LOGIN ERROR --}}
@if ($errors->any())
<div class="error-box">
{{ $errors->first() }}
</div>
@endif

<form method="POST" action="{{ route('login') }}">
@csrf

<div class="input-group">
<i class="fa fa-user"></i>
<input
type="email"
name="email"
placeholder="Email"
required
value="{{ old('email') }}">
</div>

<div class="input-group">
<i class="fa fa-lock"></i>
<input
type="password"
name="password"
id="password"
placeholder="Password"
required>
<i class="fa fa-eye toggle-password" onclick="togglePasswordVisibility('password', this)"></i>
</div>

<div style="text-align: right; margin-bottom: 20px;">
    <a href="{{ route('password.request') }}" style="font-size: 13px; color: #137c3b; text-decoration: none;">Lupa Password?</a>
</div>

<button type="submit">
<i class="fa fa-right-to-bracket"></i> Login
</button>

</form>

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
