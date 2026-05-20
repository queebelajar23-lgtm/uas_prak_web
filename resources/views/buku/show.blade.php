@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold" style="color: #0a2e1a;">
                <i class="fas fa-info-circle me-2"></i> Detail Buku
            </h2>
            <p class="text-muted">Informasi lengkap buku</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="35%">Kategori</th>
                            <td>: {{ $buku->kategori->nama_kategori ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Judul Buku</th>
                            <td>: {{ $buku->judul_buku }}</td>
                        </tr>
                        <tr>
                            <th>Penulis</th>
                            <td>: {{ $buku->penulis }}</td>
                        </tr>
                        <tr>
                            <th>Penerbit</th>
                            <td>: {{ $buku->penerbit }}</td>
                        </tr>
                        <tr>
                            <th>Tahun Terbit</th>
                            <td>: {{ $buku->tahun_terbit }}</td>
                        </tr>
                        <tr>
                            <th>Stok</th>
                            <td>: {{ $buku->stok }}</td>
                        </tr>
                        <tr>
                            <th>Lokasi Rak</th>
                            <td>: {{ $buku->lokasi_rak ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="mt-3">
                @if(auth()->user()->role == 'admin')
                <a href="{{ route('buku.edit', $buku->id_buku) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-2"></i> Edit
                </a>
                @endif
                <a href="{{ route('buku.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection