@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold" style="color: #0a2e1a;">
                <i class="fas fa-user-edit me-2"></i> Edit Anggota
            </h2>
            <p class="text-muted">Ubah data anggota</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('anggota.update', $anggota->id_anggota) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Anggota</label>
                        <input type="text" name="nama_anggota" value="{{ old('nama_anggota', $anggota->nama_anggota) }}" class="form-control @error('nama_anggota') is-invalid @enderror" required>
                        @error('nama_anggota')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">NIM</label>
                        <input type="text" name="nim" value="{{ old('nim', $anggota->nim) }}" class="form-control @error('nim') is-invalid @enderror" required>
                        @error('nim')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kelas</label>
                        <input type="text" name="kelas" value="{{ old('kelas', $anggota->kelas) }}" class="form-control @error('kelas') is-invalid @enderror" required>
                        @error('kelas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Jurusan</label>
                        <input type="text" name="jurusan" value="{{ old('jurusan', $anggota->jurusan) }}" class="form-control @error('jurusan') is-invalid @enderror" required>
                        @error('jurusan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">No HP</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp', $anggota->no_hp) }}" class="form-control @error('no_hp') is-invalid @enderror" required>
                        @error('no_hp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3" required>{{ old('alamat', $anggota->alamat) }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i> Update
                    </button>
                    <a href="{{ route('anggota.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection