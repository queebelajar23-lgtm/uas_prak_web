@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold" style="color: #0a2e1a;">
                    <i class="fas fa-users me-2"></i> Data Anggota
                </h2>
                <p class="text-muted">Kelola data anggota perpustakaan</p>
            </div>
            @if(auth()->user()->role == 'admin')
            <a href="{{ route('anggota.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> Tambah Anggota
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
                            <th>Nama Anggota</th>
                            <th>NIM</th>
                            <th>Kelas</th>
                            <th>Jurusan</th>
                            <th>No HP</th>
                            <th>Alamat</th>
                            @if(auth()->user()->role == 'admin')
                            <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($anggotas as $index => $anggota)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $anggota->nama_anggota }}</td>
                            <td>{{ $anggota->nim }}</td>
                            <td>{{ $anggota->kelas }}</td>
                            <td>{{ $anggota->jurusan }}</td>
                            <td>{{ $anggota->no_hp }}</td>
                            <td>{{ Str::limit($anggota->alamat, 30) }}</td>
                            @if(auth()->user()->role == 'admin')
                            <td>
                                <a href="{{ route('anggota.edit', $anggota->id_anggota) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('anggota.destroy', $anggota->id_anggota) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus anggota ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
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