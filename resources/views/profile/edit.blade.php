@extends('layouts.app')

@section('content')
<style>
.profile-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    border-radius: 24px;
    border: 1px solid rgba(255, 255, 255, 0.3);
    overflow: hidden;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    width: 100%;
}

.profile-header {
    background: linear-gradient(135deg, #00537A, #013C58);
    padding: 30px 40px;
    color: white;
}

.profile-header h3 {
    font-weight: 700;
    margin-bottom: 5px;
    font-size: 24px;
}

.profile-header p {
    color: #A8E8F9;
    margin: 0;
}

.form-section {
    padding: 40px;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 25px;
    margin-bottom: 30px;
}

.form-group-full {
    grid-column: span 2;
}

.form-group {
    margin-bottom: 0;
}

.form-group label {
    font-size: 12px;
    color: #00537A;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 8px;
    display: block;
    font-weight: 600;
}

.form-control {
    background: white;
    border: 1px solid #e0e0e0;
    border-radius: 12px;
    padding: 14px 16px;
    font-size: 15px;
    transition: all 0.3s;
    width: 100%;
}

.form-control:focus {
    border-color: #F5A201;
    outline: none;
    box-shadow: 0 0 0 3px rgba(245, 162, 1, 0.1);
}

textarea.form-control {
    resize: vertical;
    min-height: 80px;
}

.button-group {
    display: flex;
    gap: 15px;
    margin-top: 20px;
}

.btn-save {
    background: linear-gradient(135deg, #F5A201, #FFD35B);
    border: none;
    padding: 14px 35px;
    border-radius: 12px;
    color: #013C58;
    font-weight: 600;
    font-size: 15px;
    transition: all 0.3s;
    cursor: pointer;
}

.btn-save:hover {
    background: linear-gradient(135deg, #FFD35B, #F5A201);
    transform: scale(1.02);
}

.btn-cancel {
    background: rgba(0, 83, 122, 0.1);
    border: 1px solid rgba(0, 83, 122, 0.3);
    padding: 14px 35px;
    border-radius: 12px;
    color: #00537A;
    font-weight: 600;
    font-size: 15px;
    transition: all 0.3s;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    text-align: center;
}

.btn-cancel:hover {
    background: rgba(0, 83, 122, 0.2);
}

.alert {
    border-radius: 12px;
    padding: 12px 20px;
    margin-bottom: 25px;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border: none;
}

.alert-danger {
    background: #f8d7da;
    color: #721c24;
    border: none;
}
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="profile-card">
                <div class="profile-header">
                    <h3><i class="fas fa-edit me-2"></i> Edit Profil</h3>
                    <p>Perbarui informasi akun Anda</p>
                </div>

                <div class="form-section">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger">{{ $errors->first() }}</div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="form-grid">
                            <div class="form-group">
                                <label><i class="fas fa-user me-1"></i> Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
                            </div>

                            <div class="form-group">
                                <label><i class="fas fa-envelope me-1"></i> Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required>
                            </div>

                            @if(auth()->user()->role == 'anggota')
                            <div class="form-group">
                                <label><i class="fas fa-id-card me-1"></i> NIM</label>
                                <input type="text" name="nim" class="form-control" value="{{ old('nim', auth()->user()->nim) }}">
                            </div>

                            <div class="form-group">
                                <label><i class="fas fa-graduation-cap me-1"></i> Kelas</label>
                                <input type="text" name="kelas" class="form-control" value="{{ old('kelas', auth()->user()->kelas) }}">
                            </div>

                            <div class="form-group">
                                <label><i class="fas fa-building me-1"></i> Jurusan</label>
                                <input type="text" name="jurusan" class="form-control" value="{{ old('jurusan', auth()->user()->jurusan) }}">
                            </div>

                            <div class="form-group">
                                <label><i class="fas fa-phone me-1"></i> No HP</label>
                                <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', auth()->user()->no_hp) }}">
                            </div>

                            <div class="form-group-full">
                                <label><i class="fas fa-map-marker-alt me-1"></i> Alamat</label>
                                <textarea name="alamat" class="form-control" rows="3">{{ old('alamat', auth()->user()->alamat) }}</textarea>
                            </div>
                            @endif
                        </div>

                        <div class="button-group">
                            <button type="submit" class="btn-save">
                                <i class="fas fa-save me-2"></i> Simpan Perubahan
                            </button>
                            <a href="{{ url('/profile') }}" class="btn-cancel">
                                <i class="fas fa-times me-2"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection