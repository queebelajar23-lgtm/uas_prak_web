<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BukuKita | pinjam.in - Daftar Anggota</title>
    <link rel="icon" type="image/png" href="https://cdn-icons-png.flaticon.com/512/2232/2232688.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *{font-family:'Poppins',sans-serif;}
        body{background:linear-gradient(135deg,#A8E8F9 0%,#00537A 100%);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px;}
        .register-card{background:rgba(1,60,88,0.85);backdrop-filter:blur(10px);border-radius:30px;box-shadow:0 25px 50px rgba(0,0,0,0.3);max-width:550px;width:100%;overflow:hidden;border:1px solid rgba(255,255,255,0.2);}
        .register-header{background:linear-gradient(135deg,#00537A,#013C58);padding:30px;text-align:center;}
        .register-header .logo i{font-size:50px;color:#FFD35B;}
        .register-header h1{font-weight:700;font-size:28px;color:#FFD35B;margin:10px 0 5px;}
        .register-header p{color:#A8E8F9;font-size:14px;}
        .register-body{padding:30px;}
        .form-group{margin-bottom:20px;}
        .form-group label{font-weight:500;color:#FFD35B;margin-bottom:8px;display:block;font-size:13px;}
        .form-control{background:rgba(255,255,255,0.9);border-radius:12px;padding:12px 16px;border:none;font-size:14px;}
        .form-control:focus{background:white;box-shadow:0 0 0 3px rgba(245,162,1,0.3);outline:none;}
        .btn-register{background:linear-gradient(135deg,#F5A201,#FFBA42);border:none;padding:14px;border-radius:12px;font-weight:600;width:100%;color:#013C58;transition:0.3s;}
        .btn-register:hover{background:linear-gradient(135deg,#FFBA42,#F5A201);transform:scale(1.02);}
        .login-link{text-align:center;margin-top:25px;padding-top:20px;border-top:1px solid rgba(168,232,249,0.2);}
        .login-link span{color:#A8E8F9;font-size:13px;}
        .login-link a{color:#F5A201;font-weight:600;text-decoration:none;}
        .alert{border-radius:12px;margin-bottom:20px;font-size:13px;background:rgba(255,255,255,0.9);}
    </style>
</head>
<body>
<div class="register-card">
    <div class="register-header">
        <div class="logo"><i class="fas fa-book"></i> <i class="fas fa-pencil-alt"></i></div>
        <h1>BukuKita</h1>
        <p>pinjam.in - Daftar Menjadi Anggota</p>
    </div>
    <div class="register-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus placeholder="Masukkan nama lengkap">
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="contoh@email.com">
            </div>

            <div class="form-group">
                <label>NIM</label>
                <input type="text" name="nim" class="form-control" value="{{ old('nim') }}" required placeholder="Masukkan NIM">
            </div>

            <div class="form-group">
                <label>Kelas</label>
                <input type="text" name="kelas" class="form-control" value="{{ old('kelas') }}" required placeholder="Contoh: 3A">
            </div>

            <div class="form-group">
                <label>Jurusan</label>
                <input type="text" name="jurusan" class="form-control" value="{{ old('jurusan') }}" required placeholder="Contoh: Teknik Informatika">
            </div>

            <div class="form-group">
                <label>No HP</label>
                <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}" required placeholder="08123456789">
            </div>

            <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control" rows="2" required placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
            </div>

            <div class="form-group">
                <label>Kata Sandi</label>
                <input type="password" name="password" class="form-control" required placeholder="Minimal 8 karakter">
            </div>

            <div class="form-group">
                <label>Konfirmasi Kata Sandi</label>
                <input type="password" name="password_confirmation" class="form-control" required placeholder="Ulangi kata sandi">
            </div>

            <button type="submit" class="btn-register"><i class="fas fa-user-plus me-2"></i> DAFTAR</button>

            <div class="login-link">
                <span>Sudah punya akun?</span>
                <a href="{{ route('login') }}">Masuk sekarang</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>