@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold" style="color: #0a2e1a;">
                    <i class="fas fa-book me-2"></i> Data Buku
                </h2>
                <p class="text-muted">Kelola koleksi buku perpustakaan</p>
            </div>
            @if(auth()->user()->role == 'admin')
            <a href="{{ route('buku.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> Tambah Buku
            </a>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kategori</th>
                            <th>Judul Buku</th>
                            <th>Penulis</th>
                            <th>Penerbit</th>
                            <th>Tahun</th>
                            <th>Stok</th>
                            <th>Lokasi Rak</th>
                            @if(auth()->user()->role == 'admin')
                            <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bukus as $index => $buku)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $buku->kategori->nama_kategori ?? '-' }}</td>
                            <td>{{ $buku->judul_buku }}</td>
                            <td>{{ $buku->penulis }}</td>
                            <td>{{ $buku->penerbit }}</td>
                            <td>{{ $buku->tahun_terbit }}</td>
                            <td>
                                @if($buku->stok > 0)
                                    <span class="badge bg-success">{{ $buku->stok }}</span>
                                @else
                                    <span class="badge bg-danger">Habis</span>
                                @endif
                            </td>
                            <td>{{ $buku->lokasi_rak ?? '-' }}</td>
                            @if(auth()->user()->role == 'admin')
                            <td>
                                <a href="{{ route('buku.show', $buku->id_buku) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('buku.edit', $buku->id_buku) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('buku.destroy', $buku->id_buku) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection