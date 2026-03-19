<!DOCTYPE html>
<html>
<head>
<title>Dashboard Admin</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

body{
margin:0;
font-family:Arial;
display:flex;
background:#f3f3f3;
}

/* SIDEBAR */

.sidebar{
width:230px;
background:#0f8b6d;
color:white;
min-height:100vh;
padding:20px;
transition:0.3s;
}

.sidebar.hide{
margin-left:-230px;
}

.sidebar h2{
margin-bottom:20px;
}

.sidebar a{
display:block;
color:white;
text-decoration:none;
padding:10px;
margin:5px 0;
border-radius:6px;
}

.sidebar a i{
margin-right:10px;
}

.sidebar a:hover{
background:#0c6d55;
}

/* MAIN */

.main{
flex:1;
transition:0.3s;
}

/* NAVBAR */

.navbar{
background:#0f8b6d;
color:white;
padding:15px 20px;
display:flex;
justify-content:space-between;
align-items:center;
}

/* HAMBURGER */

.menu-btn{
background:none;
border:none;
color:white;
font-size:20px;
cursor:pointer;
margin-right:10px;
}

.left-nav{
display:flex;
align-items:center;
gap:10px;
}

/* DASHBOARD */

.container{
padding:20px;
}

/* CARD */

.cards{
display:grid;
grid-template-columns:repeat(4,1fr);
gap:15px;
margin-bottom:20px;
}

.card{
padding:20px;
color:white;
border-radius:8px;
display:flex;
justify-content:space-between;
align-items:center;
}

.card i{
font-size:30px;
opacity:0.8;
}

.green{background:#28a745;}
.blue{background:#17a2b8;}
.orange{background:#fd7e14;}
.purple{background:#6f42c1;}

/* TABLE */

.table-box{
background:white;
padding:15px;
border-radius:8px;
margin-bottom:20px;
}

table{
width:100%;
border-collapse:collapse;
}

table th, table td{
padding:10px;
border-bottom:1px solid #eee;
}

</style>

</head>

<body>

<div class="sidebar" id="sidebar">

<h2><i class="fa-solid fa-mosque"></i> DKM</h2>

<a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Dashboard</a>
<a href="{{ route('pengurus.index') }}"><i class="fa fa-users"></i> Data Pengurus</a>
<a href="{{ route('kegiatan.jadwal') }}">
    <i class="fa fa-calendar"></i> Kegiatan
</a>
<a href="#"><i class="fa fa-hand-holding-dollar"></i> Donasi</a>
<a href="#"><i class="fa fa-chart-line"></i> Laporan</a>
<a href="#"><i class="fa fa-user"></i> User</a>

<form method="POST" action="{{ route('logout') }}">
@csrf

<button type="submit"
style="margin-top:15px;padding:8px 10px;border:none;border-radius:5px;cursor:pointer">

<i class="fa fa-sign-out-alt"></i> Logout

</button>

</form>

</form>

</div>

<div class="main">

<div class="navbar">

<div class="left-nav">

<button class="menu-btn" id="menu-toggle">
<i class="fa fa-bars"></i>
</button>



</div>

<div>
<i class="fa-solid fa-bell"></i> Notifikasi
&nbsp;&nbsp;
<i class="fa-solid fa-user-circle"></i> Admin
</div>

</div>

<div class="container">

@yield('content')

</div>

</div>

<script>
document.addEventListener("DOMContentLoaded", function(){

    const toggleBtn = document.getElementById("menu-toggle");
    const sidebar = document.getElementById("sidebar");

    if(toggleBtn && sidebar){
        toggleBtn.addEventListener("click", function(){
            sidebar.classList.toggle("hide");
        });
    }

});
</script>

</body>
</html>
