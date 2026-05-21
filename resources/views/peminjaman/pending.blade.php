@extends('layouts.app')

@section('content')
<style>
.pending-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    border-radius: 24px;
    border: 1px solid rgba(255, 255, 255, 0.3);
    overflow: hidden;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    width: 100%;
}

.pending-header {
    background: linear-gradient(135deg, #00537A, #013C58);
    padding: 30px 40px;
    color: white;
}

.pending-header h3 {
    font-weight: 700;
    margin-bottom: 5px;
    font-size: 24px;
}

.pending-header p {
    color: #A8E8F9;
    margin: 0;
}

.table-responsive {
    padding: 20px;
}

.status-menunggu {
    background: #F5A201;
    color: #013C58;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    display: inline-block;
}

.btn-approve {
    background: #1a4a2a;
    border: none;
    padding: 6px 15px;
    border-radius: 10px;
    color: white;
    font-size: 12px;
    transition: all 0.3s;
}

.btn-approve:hover {
    background: #2a6a3a;
    transform: scale(1.02);
}

.btn-reject {
    background: #dc3545;
    border: none;
    padding: 6px 15px;
    border-radius: 10px;
    color: white;
    font-size: 12px;
    transition: all 0.3s;
}

.btn-reject:hover {
    background: #c82333;
    transform: scale(1.02);
}

.empty-state {
    text-align: center;
    padding: 60px;
    color: #00537A;
}

.empty-state i {
    font-size: 80px;
    margin-bottom: 20px;
    opacity: 0.5;
}
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="pending-card">
                <div class="pending-header">
                    <h3><i class="fas fa-clock me-2"></i> Pengajuan Peminjaman Menunggu</h3>
                    <p>Daftar pengajuan peminjaman yang perlu diproses</p>
                </div>

                <div class="table-responsive">
                    @if(isset($peminjamans) && count($peminjamans) > 0)
                        <table class="table table-bordered">
                            <thead style="background: rgba(0,83,122,0.1);">
                                <tr>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Anggota</th>
                                    <th>Buku yang Dipinjam</th>
                                    <th>Rencana Kembali</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($peminjamans as $pinjam)
                                <tr>
                                    <td>{{ $pinjam->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <strong>{{ $pinjam->anggota->nama_anggota ?? '-' }}</strong><br>
                                        <small class="text-muted">{{ $pinjam->anggota->nim ?? '-' }}</small>
                                     </td>
                                    <td>
                                        @foreach($pinjam->detailPeminjaman as $detail)
                                            - {{ $detail->buku->judul_buku }}<br>
                                        @endforeach
                                     </td>
                                    <td>{{ \Carbon\Carbon::parse($pinjam->tanggal_kembali_rencana)->format('d/m/Y') }}</td>
                                    <td><span class="status-menunggu"><i class="fas fa-clock me-1"></i> Menunggu</span></td>
                                    <td>
                                        <form action="{{ route('peminjaman.approve', $pinjam->id_peminjaman) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn-approve" onclick="return confirm('Setujui peminjaman ini?')">
                                                <i class="fas fa-check me-1"></i> Setujui
                                            </button>
                                        </form>
                                        <form action="{{ route('peminjaman.reject', $pinjam->id_peminjaman) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn-reject" onclick="return confirm('Tolak peminjaman ini?')">
                                                <i class="fas fa-times me-1"></i> Tolak
                                            </button>
                                        </form>
                                     </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-check-circle"></i>
                            <h4>Tidak Ada Pengajuan</h4>
                            <p>Semua pengajuan sudah diproses.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection