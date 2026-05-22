<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BukuKita | pinjam.in - Sistem Peminjaman Perpustakaan</title>
    
    <link rel="icon" type="image/png" href="https://cdn-icons-png.flaticon.com/512/2232/2232688.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        *{font-family:'Poppins',sans-serif;}
        body{background:linear-gradient(135deg,#A8E8F9 0%,#00537A 100%);min-height:100vh;}
        
        .float{position:fixed;color:rgba(255,255,255,0.1);animation:floatAnim 6s ease-in-out infinite;pointer-events:none;z-index:0;}
        @keyframes floatAnim{0%,100%{transform:translateY(0)rotate(0deg);}50%{transform:translateY(-25px)rotate(5deg);}}
        .f1{top:5%;left:2%;font-size:80px;}.f2{top:15%;right:3%;font-size:70px;animation-delay:0.5s;}
        .f3{bottom:10%;left:3%;font-size:90px;animation-delay:1s;}.f4{bottom:20%;right:5%;font-size:65px;animation-delay:1.5s;}
        .f5{top:40%;left:5%;font-size:55px;animation-delay:0.8s;}.f6{top:70%;right:8%;font-size:75px;animation-delay:2s;}
        .f7{bottom:40%;left:8%;font-size:50px;animation-delay:0.3s;}.f8{top:55%;right:12%;font-size:70px;animation-delay:1.8s;}
        .f9{bottom:55%;left:12%;font-size:60px;animation-delay:1.2s;}.f10{top:80%;right:15%;font-size:65px;animation-delay:0.6s;}
        .f11{top:10%;right:18%;font-size:55px;animation-delay:2.2s;}.f12{bottom:8%;right:22%;font-size:80px;animation-delay:1.4s;}
        .f13{top:30%;left:15%;font-size:45px;animation-delay:0.7s;}.f14{top:85%;left:18%;font-size:60px;animation-delay:2.5s;}
        
        .sidebar {
            background: rgba(1,60,88,0.95);
            backdrop-filter: blur(10px);
            min-height: 100vh;
            transition: all 0.3s ease;
            position: relative;
            z-index: 10;
            border-right: 1px solid rgba(255,255,255,0.2);
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            margin: 5px 10px;
            border-radius: 12px;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover {
            background: rgba(255,215,0,0.15);
            color: #FFD35B;
            transform: translateX(5px);
        }
        .sidebar .nav-link.active {
            background: rgba(255,215,0,0.2);
            color: #FFD35B;
        }
        .sidebar .nav-link i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
        }
        .logo-area {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }
        .logo-area h3 { color: #FFD35B; font-weight: 700; margin-bottom: 5px; }
        .logo-area p { color: #A8E8F9; font-size: 12px; margin-bottom: 0; }
        .content-area {
            background: transparent;
            min-height: 100vh;
            padding: 20px;
            position: relative;
            z-index: 10;
        }
        
        .btn-primary {
            background: linear-gradient(135deg,#F5A201,#FFBA42);
            border: none;
            padding: 10px 20px;
            border-radius: 12px;
            color: #013C58;
            font-weight: 600;
        }
        .btn-primary:hover { background: linear-gradient(135deg,#FFBA42,#F5A201); transform: scale(1.02); }
        
        #loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg,#A8E8F9,#00537A);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }
        .loader { text-align: center; }
        .loader .fa-book { font-size: 60px; color: #FFD35B; animation: bounce 1s infinite; }
        @keyframes bounce { 0%,100%{transform:translateY(0);}50%{transform:translateY(-15px);} }
    </style>
</head>
<body>

<i class="fas fa-book f1 float"></i>
<i class="fas fa-book-open f2 float"></i>
<i class="fas fa-pencil-alt f3 float"></i>
<i class="fas fa-eraser f4 float"></i>
<i class="fas fa-layer-group f5 float"></i>
<i class="fas fa-bookmark f6 float"></i>
<i class="fas fa-chalkboard f7 float"></i>
<i class="fas fa-couch f8 float"></i>
<i class="fas fa-draw-polygon f9 float"></i>
<i class="fas fa-glasses f10 float"></i>
<i class="fas fa-marker f11 float"></i>
<i class="fas fa-folder-open f12 float"></i>
<i class="fas fa-atom f13 float"></i>
<i class="fas fa-graduation-cap f14 float"></i>

<div id="loading-screen">
    <div class="loader">
        <i class="fas fa-book"></i>
        <i class="fas fa-pencil-alt"></i>
        <h2 style="color:white; margin-top:20px;">BukuKita</h2>
        <p style="color:#A8E8F9;">pinjam.in - Sistem Peminjaman Perpustakaan</p>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 p-0 sidebar">
            <div class="logo-area text-center">
                <i class="fas fa-book" style="font-size: 40px; color: #FFD35B;"></i>
                <i class="fas fa-pencil-alt" style="font-size: 25px; color: #A8E8F9;"></i>
                <h3>BukuKita</h3>
                <p>pinjam.in</p>
                <small style="color:#A8E8F9;">Sistem Peminjaman</small>
            </div>
            <nav class="nav flex-column">
                <!-- DASHBOARD - SEMUA ROLE -->
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                
                <!-- MENU UNTUK ADMIN DAN PETUGAS -->
                @if(auth()->user()->role == 'admin' || auth()->user()->role == 'petugas')
                    <a class="nav-link" href="{{ route('buku.index') }}"><i class="fas fa-book"></i> Data Buku</a>
                    <a class="nav-link" href="{{ route('anggota.index') }}"><i class="fas fa-users"></i> Data Anggota</a>
                    <a class="nav-link" href="{{ route('peminjaman.index') }}"><i class="fas fa-hand-peace"></i> Transaksi Peminjaman</a>
                    <a class="nav-link" href="{{ route('peminjaman.pending') }}">
                        <i class="fas fa-clock"></i> Pengajuan Menunggu
                    </a>
                @endif
                
                <!-- MENU UNTUK ANGGOTA SAJA -->
                @if(auth()->user()->role == 'anggota')
                    <a class="nav-link" href="{{ route('anggota.peminjaman.create') }}"><i class="fas fa-hand-peace"></i> Ajukan Peminjaman</a>
                    <a class="nav-link" href="{{ route('anggota.peminjaman.index') }}"><i class="fas fa-history"></i> Riwayat Pengajuan</a>
                @endif
                
                <hr style="border-color:rgba(255,255,255,0.1); margin:15px;">
                
                <!-- MENU UNTUK SEMUA ROLE -->
                <a class="nav-link" href="{{ route('profile.show') }}"><i class="fas fa-user-circle"></i> Profil Saya</a>
                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
            </nav>
        </div>

        <!-- Content -->
        <div class="col-md-9 col-lg-10 content-area">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    window.addEventListener('load', function() {
        setTimeout(function() {
            var loader = document.getElementById('loading-screen');
            loader.style.opacity = '0';
            setTimeout(function() { loader.style.display = 'none'; }, 500);
        }, 500);
    });
</script>
</body>
</html>