@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2>Transaksi Peminjaman</h2>
            <a href="{{ route('peminjaman.create') }}" class="btn btn-primary">Tambah Peminjaman</a>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr><th>No</th><th>Anggota</th><th>Tanggal Pinjam</th><th>Status</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @foreach($peminjamans as $pinjam)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $pinjam->anggota->nama_anggota ?? '-' }}</td>
                        <td>{{ $pinjam->tanggal_pinjam }}</td>
                        <td>{{ $pinjam->status }}</td>
                        <td>
                            <form action="{{ route('peminjaman.pengembalian', $pinjam->id_peminjaman) }}" method="POST">
                                @csrf @method('PUT')
                                <button type="submit" class="btn btn-success btn-sm">Kembali</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection