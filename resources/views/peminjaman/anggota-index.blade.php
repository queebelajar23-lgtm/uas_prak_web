@extends('layouts.app')

@section('content')
<style>
.history-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    border-radius: 24px;
    border: 1px solid rgba(255, 255, 255, 0.3);
    overflow: hidden;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    width: 100%;
}

.history-header {
    background: linear-gradient(135deg, #00537A, #013C58);
    padding: 30px 40px;
    color: white;
}

.history-header h3 {
    font-weight: 700;
    margin-bottom: 5px;
    font-size: 24px;
}

.history-header p {
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

.status-disetujui {
    background: #1a4a2a;
    color: white;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    display: inline-block;
}

.status-ditolak {
    background: #dc3545;
    color: white;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    display: inline-block;
}

.status-dipinjam {
    background: #17a2b8;
    color: white;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    display: inline-block;
}

.status-kembali {
    background: #28a745;
    color: white;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    display: inline-block;
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
            <div class="history-card">
                <div class="history-header">
                    <h3><i class="fas fa-history me-2"></i> Riwayat Pengajuan Peminjaman</h3>
                    <p>Lihat status pengajuan peminjaman buku Anda</p>
                </div>

                <div class="table-responsive">
                    @if(count($peminjamans) > 0)
                        <table class="table table-bordered">
                            <thead style="background: rgba(0,83,122,0.1);">
                                <tr>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Buku</th>
                                    <th>Rencana Kembali</th>
                                    <th>Status Pengajuan</th>
                                    <th>Status Peminjaman</th>
                                    <th>Denda</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($peminjamans as $pinjam)
                                    @foreach($pinjam->detailPeminjaman as $detail)
                                    <tr>
                                        <td>{{ $pinjam->created_at->format('d/m/Y H:i') }}</td>
                                        <td>{{ $detail->buku->judul_buku }}</td>
                                        <td>{{ $pinjam->tanggal_kembali_rencana ? \Carbon\Carbon::parse($pinjam->tanggal_kembali_rencana)->format('d/m/Y') : '-' }}</td>
                                        <td>
                                            @if($pinjam->status_pengajuan === 'menunggu')
                                                <span class="badge bg-warning">Menunggu</span>
                                            @elseif($pinjam->status_pengajuan === 'disetujui')
                                                <span class="badge bg-success">Disetujui</span>
                                            @elseif($pinjam->status_pengajuan === 'ditolak')
                                                <span class="badge bg-danger">Ditolak</span>
                                            @endif
                                        </td>

                                        <td>
                                            @if($pinjam->status === 'menunggu')
                                                <span class="badge bg-secondary">Menunggu Persetujuan</span>
                                            @elseif($pinjam->status === 'dipinjam')
                                                <span class="badge bg-info">Dipinjam</span>
                                            @elseif($pinjam->status === 'kembali')
                                                <span class="badge bg-success">Kembali</span>
                                            @elseif($pinjam->status === 'terlambat')
                                                <span class="badge bg-danger">Terlambat</span>
                                            @endif
                                        </td>
                                        <td>Rp {{ number_format($pinjam->denda, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <h4>Belum Ada Pengajuan</h4>
                            <p>Anda belum pernah mengajukan peminjaman buku.</p>
                            <a href="{{ route('anggota.peminjaman.create') }}" class="btn-primary" style="padding: 10px 25px; border-radius: 12px; text-decoration: none; display: inline-block;">
                                <i class="fas fa-hand-peace me-2"></i> Ajukan Sekarang
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection