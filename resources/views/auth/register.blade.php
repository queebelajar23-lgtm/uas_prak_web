<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BukuKita | pinjam.in - Daftar Anggota Perpustakaan</title>
    
    <link rel="icon" type="image/png" href="https://cdn-icons-png.flaticon.com/512/2232/2232688.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        *{font-family:'Poppins',sans-serif;}
        body{background:linear-gradient(135deg,#A8E8F9 0%,#00537A 100%);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px;}
        
        .float{position:fixed;color:rgba(255,255,255,0.1);animation:floatAnim 6s ease-in-out infinite;pointer-events:none;z-index:0;}
        @keyframes floatAnim{0%,100%{transform:translateY(0)rotate(0deg);}50%{transform:translateY(-25px)rotate(5deg);}}
        .f1{top:5%;left:2%;font-size:80px;}.f2{top:15%;right:3%;font-size:70px;animation-delay:0.5s;}
        .f3{bottom:10%;left:3%;font-size:90px;animation-delay:1s;}.f4{bottom:20%;right:5%;font-size:65px;animation-delay:1.5s;}
        .f5{top:40%;left:5%;font-size:55px;animation-delay:0.8s;}.f6{top:70%;right:8%;font-size:75px;animation-delay:2s;}
        .f7{bottom:40%;left:8%;font-size:50px;animation-delay:0.3s;}.f8{top:55%;right:12%;font-size:70px;animation-delay:1.8s;}
        .f9{bottom:55%;left:12%;font-size:60px;animation-delay:1.2s;}.f10{top:80%;right:15%;font-size:65px;animation-delay:0.6s;}
        .f11{top:10%;right:18%;font-size:55px;animation-delay:2.2s;}.f12{bottom:8%;right:22%;font-size:80px;animation-delay:1.4s;}
        .f13{top:30%;left:15%;font-size:45px;animation-delay:0.7s;}.f14{top:85%;left:18%;font-size:60px;animation-delay:2.5s;}
        
        .register-card{background:rgba(1,60,88,0.85);backdrop-filter:blur(10px);border-radius:30px;box-shadow:0 25px 50px rgba(0,0,0,0.3);max-width:550px;width:100%;overflow:hidden;border:1px solid rgba(255,255,255,0.2);}
        .register-header{background:linear-gradient(135deg,#00537A,#013C58);padding:30px;text-align:center;}
        .register-header .logo i{font-size:50px;color:#FFD35B;}
        .register-header h1{font-weight:700;font-size:28px;color:#FFD35B;margin:10px 0 5px;}
        .register-header p{color:#A8E8F9;font-size:14px;}
        .register-body{padding:30px;}
        .form-group{margin-bottom:20px;}
        .form-group label{font-weight:500;color:#FFD35B;margin-bottom:8px;display:block;font-size:13px;}
        .form-control{background:rgba(255,255,255,0.9);border-radius:12px;padding:12px 16px;border:none;font-size:14px;width:100%;}
        .form-control:focus{background:white;box-shadow:0 0 0 3px rgba(245,162,1,0.3);outline:none;}
        textarea.form-control{resize:vertical;}
        .btn-register{background:linear-gradient(135deg,#F5A201,#FFBA42);border:none;padding:14px;border-radius:12px;font-weight:600;width:100%;color:#013C58;transition:0.3s;cursor:pointer;}
        .btn-register:hover{background:linear-gradient(135deg,#FFBA42,#F5A201);transform:scale(1.02);}
        .login-link{text-align:center;margin-top:25px;padding-top:20px;border-top:1px solid rgba(168,232,249,0.2);}
        .login-link span{color:#A8E8F9;font-size:13px;}
        .login-link a{color:#F5A201;font-weight:600;text-decoration:none;}
        .alert{border-radius:12px;margin-bottom:20px;font-size:13px;padding:12px;background:rgba(255,255,255,0.9);color:#721c24;}
        .alert ul{margin-bottom:0;padding-left:20px;}
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

<div class="register-card">
    <div class="register-header">
        <div class="logo">
            <i class="fas fa-book"></i>
            <i class="fas fa-pencil-alt"></i>
        </div>
        <h1>BukuKita</h1>
        <p>pinjam.in - Daftar Menjadi Anggota</p>
    </div>

    <div class="register-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>
                            @if($error == 'The email has already been taken.')
                                Email sudah pernah digunakan.
                            @elseif($error == 'The name field is required.')
                                Nama lengkap wajib diisi.
                            @elseif($error == 'The password field is required.')
                                Kata sandi wajib diisi.
                            @elseif($error == 'The password confirmation does not match.')
                                Konfirmasi kata sandi tidak cocok.
                            @elseif($error == 'The email field is required.')
                                Email wajib diisi.
                            @elseif($error == 'The nim field is required.')
                                NIM wajib diisi.
                            @elseif($error == 'The kelas field is required.')
                                Kelas wajib diisi.
                            @elseif($error == 'The jurusan field is required.')
                                Jurusan wajib diisi.
                            @elseif($error == 'The no hp field is required.')
                                No HP wajib diisi.
                            @elseif($error == 'The alamat field is required.')
                                Alamat wajib diisi.
                            @else
                                {{ $error }}
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label><i class="fas fa-user me-1"></i> Nama Lengkap</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus placeholder="Masukkan nama lengkap">
            </div>

            <div class="form-group">
                <label><i class="fas fa-envelope me-1"></i> Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="contoh@email.com">
            </div>

            <div class="form-group">
                <label><i class="fas fa-id-card me-1"></i> NIM</label>
                <input type="text" name="nim" class="form-control" value="{{ old('nim') }}" placeholder="Masukkan NIM">
            </div>

            <div class="form-group">
                <label><i class="fas fa-graduation-cap me-1"></i> Kelas</label>
                <input type="text" name="kelas" class="form-control" value="{{ old('kelas') }}" placeholder="Contoh: 3A">
            </div>

            <div class="form-group">
                <label><i class="fas fa-building me-1"></i> Jurusan</label>
                <input type="text" name="jurusan" class="form-control" value="{{ old('jurusan') }}" placeholder="Contoh: Teknik Informatika">
            </div>

            <div class="form-group">
                <label><i class="fas fa-phone me-1"></i> No HP</label>
                <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}" placeholder="08123456789">
            </div>

            <div class="form-group">
                <label><i class="fas fa-map-marker-alt me-1"></i> Alamat</label>
                <textarea name="alamat" class="form-control" rows="2" placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
            </div>

            <div class="form-group">
                <label><i class="fas fa-lock me-1"></i> Kata Sandi</label>
                <input type="password" name="password" class="form-control" required placeholder="Minimal 8 karakter">
            </div>

            <div class="form-group">
                <label><i class="fas fa-check-circle me-1"></i> Konfirmasi Kata Sandi</label>
                <input type="password" name="password_confirmation" class="form-control" required placeholder="Ulangi kata sandi">
            </div>

            <button type="submit" class="btn-register">
                <i class="fas fa-user-plus me-2"></i> DAFTAR
            </button>

            <div class="login-link">
                <span>Sudah punya akun?</span>
                <a href="{{ route('login') }}">Masuk sekarang</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>