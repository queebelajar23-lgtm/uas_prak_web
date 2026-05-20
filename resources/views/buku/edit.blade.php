@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold" style="color: #0a2e1a;">
                <i class="fas fa-edit me-2"></i> Edit Buku
            </h2>
            <p class="text-muted">Ubah data buku</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('buku.update', $buku->id_buku) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="id_kategori" class="form-select @error('id_kategori') is-invalid @enderror" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id_kategori }}" {{ $buku->id_kategori == $kategori->id_kategori ? 'selected' : '' }}>
                                {{ $kategori->nama_kategori }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Judul Buku</label>
                        <input type="text" name="judul_buku" value="{{ old('judul_buku', $buku->judul_buku) }}" class="form-control @error('judul_buku') is-invalid @enderror" required>
                        @error('judul_buku')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Penulis</label>
                        <input type="text" name="penulis" value="{{ old('penulis', $buku->penulis) }}" class="form-control @error('penulis') is-invalid @enderror" required>
                        @error('penulis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Penerbit</label>
                        <input type="text" name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}" class="form-control @error('penerbit') is-invalid @enderror" required>
                        @error('penerbit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tahun Terbit</label>
                        <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" class="form-control @error('tahun_terbit') is-invalid @enderror" required>
                        @error('tahun_terbit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stok" value="{{ old('stok', $buku->stok) }}" class="form-control @error('stok') is-invalid @enderror" required>
                        @error('stok')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Lokasi Rak</label>
                        <input type="text" name="lokasi_rak" value="{{ old('lokasi_rak', $buku->lokasi_rak) }}" class="form-control" placeholder="Contoh: Rak A1">
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i> Update
                    </button>
                    <a href="{{ route('buku.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection