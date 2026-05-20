@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold" style="color: #0a2e1a;">
                    <i class="fas fa-hand-peace me-2"></i> Transaksi Peminjaman
                </h2>
                <p class="text-muted">Kelola peminjaman dan pengembalian buku</p>
            </div>
            <a href="{{ route('peminjaman.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> Peminjaman Baru
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Anggota</th>
                            <th>Petugas</th>
                            <th>Tanggal Pinjam</th>
                            <th>Rencana Kembali</th>
                            <th>Status</th>
                            <th>Denda</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($peminjamans as $index => $pinjam)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $pinjam->anggota->nama_anggota }} <br><small class="text-muted">({{ $pinjam->anggota->nim }})</small></td>
                            <td>{{ $pinjam->user->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($pinjam->tanggal_kembali_rencana)->format('d/m/Y') }}</td>
                            <td>
                                @if($pinjam->status == 'dipinjam')
                                    <span class="badge bg-warning">Dipinjam</span>
                                @elseif($pinjam->status == 'terlambat')
                                    <span class="badge bg-danger">Terlambat</span>
                                @else
                                    <span class="badge bg-success">Kembali</span>
                                @endif
                            </td>
                            <td>Rp {{ number_format($pinjam->denda, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('peminjaman.show', $pinjam->id_peminjaman) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($pinjam->status == 'dipinjam')
                                <form action="{{ route('peminjaman.pengembalian', $pinjam->id_peminjaman) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Proses pengembalian buku?')">
                                        <i class="fas fa-undo"></i> Kembali
                                    </button>
                                </form>
                                @endif
                            </div>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection