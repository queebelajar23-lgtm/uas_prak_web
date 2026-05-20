@extends('layouts.app')
@section('content')
<style>
.welcome-card{background:rgba(1,60,88,0.9);backdrop-filter:blur(10px);border-radius:20px;padding:25px;margin-bottom:30px;color:white;border:1px solid rgba(255,215,0,0.3);box-shadow:0 10px 25px rgba(0,0,0,0.1);}
.welcome-card h2{font-weight:700;margin-bottom:5px;color:white;}
.welcome-card p{color:#A8E8F9;margin:0;}
.stat-card{background:rgba(255,255,255,0.85);backdrop-filter:blur(10px);border-radius:20px;padding:20px;transition:.3s;border:1px solid rgba(255,255,255,0.5);margin-bottom:20px;position:relative;overflow:hidden;box-shadow:0 5px 15px rgba(0,0,0,0.05);}
.stat-card::before{content:'';position:absolute;top:0;left:0;right:0;height:4px;background:linear-gradient(135deg,#F5A201,#FFD35B);}
.stat-card:hover{transform:translateY(-5px);background:rgba(255,255,255,0.95);box-shadow:0 15px 30px rgba(0,0,0,0.1);}
.stat-icon{width:55px;height:55px;border-radius:15px;display:flex;align-items:center;justify-content:center;font-size:24px;color:white;}
.stat-icon.buku{background:linear-gradient(135deg,#667eea,#764ba2);}
.stat-icon.anggota{background:linear-gradient(135deg,#1a4a2a,#0d3b1f);}
.stat-icon.peminjaman{background:linear-gradient(135deg,#f093fb,#f5576c);}
.stat-icon.aktif{background:linear-gradient(135deg,#4facfe,#00f2fe);}
.stat-number{font-size:32px;font-weight:700;color:#013C58;margin:0;}
.stat-label{color:#555;font-size:14px;margin:0;font-weight:500;}
.info-card{background:rgba(255,255,255,0.85);backdrop-filter:blur(10px);border-radius:20px;border:1px solid rgba(255,255,255,0.5);overflow:hidden;margin-bottom:20px;height:100%;transition:.3s;box-shadow:0 5px 15px rgba(0,0,0,0.05);}
.info-card:hover{transform:translateY(-3px);background:rgba(255,255,255,0.95);box-shadow:0 10px 25px rgba(0,0,0,0.1);}
.info-card .card-body{padding:20px;}
.info-card p{margin-bottom:12px;color:#013C58;font-size:14px;}
.info-card .info-icon{font-size:18px;margin-right:10px;}
.badge-dipinjam{background:#F5A201;color:#013C58;padding:5px 12px;border-radius:20px;font-size:12px;font-weight:600;}
.badge-kembali{background:#1a4a2a;color:white;padding:5px 12px;border-radius:20px;font-size:12px;font-weight:600;}
.center-elements{position:fixed;top:50%;left:50%;transform:translate(-50%,-50%);width:100%;height:100%;pointer-events:none;z-index:1;}
.center-elem{position:absolute;color:rgba(255,215,0,0.08);font-size:120px;animation:centerFloat 8s ease-in-out infinite;}
.ce1{top:20%;left:20%;animation-delay:0s;}
.ce2{top:60%;right:25%;animation-delay:1.5s;font-size:100px;}
.ce3{bottom:15%;left:35%;animation-delay:3s;font-size:90px;}
.ce4{top:40%;right:40%;animation-delay:4.5s;font-size:80px;}
.ce5{bottom:40%;left:15%;animation-delay:2s;font-size:110px;}
@keyframes centerFloat{0%,100%{transform:translateY(0)rotate(0deg);opacity:0.08;}50%{transform:translateY(-30px)rotate(10deg);opacity:0.15;}}
.table-glass{background:rgba(255,255,255,0.7);backdrop-filter:blur(10px);border-radius:20px;overflow:hidden;}
.table-glass thead th{background:rgba(255,255,255,0.5);color:#013C58;font-weight:600;border:none;}
.table-glass tbody td{color:#013C58;border-bottom:1px solid rgba(0,0,0,0.05);}
</style>

<div class="center-elements">
    <i class="fas fa-book ce1 center-elem"></i>
    <i class="fas fa-pencil-alt ce2 center-elem"></i>
    <i class="fas fa-layer-group ce3 center-elem"></i>
    <i class="fas fa-graduation-cap ce4 center-elem"></i>
    <i class="fas fa-scroll ce5 center-elem"></i>
</div>

<div class="container-fluid position-relative" style="z-index:10">
    <div class="welcome-card d-flex justify-content-between align-items-center">
        <div><h2><i class="fas fa-smile-wink me-2" style="color:#FFD35B"></i>Selamat Datang, {{ auth()->user()->name }}!</h2><p>Kelola perpustakaan BukuKita dengan mudah dan nyaman</p></div>
        <div><i class="fas fa-book" style="font-size:60px;opacity:0.5"></i><i class="fas fa-pencil-alt" style="font-size:40px;opacity:0.5"></i></div>
    </div>

    <div class="row">
        <div class="col-md-3"><div class="stat-card d-flex align-items-center"><div class="stat-icon buku me-3"><i class="fas fa-book"></i></div><div><h3 class="stat-number">{{ $totalBuku ?? 0 }}</h3><p class="stat-label">Total Buku</p></div></div></div>
        <div class="col-md-3"><div class="stat-card d-flex align-items-center"><div class="stat-icon anggota me-3"><i class="fas fa-users"></i></div><div><h3 class="stat-number">{{ $totalAnggota ?? 0 }}</h3><p class="stat-label">Total Anggota</p></div></div></div>
        <div class="col-md-3"><div class="stat-card d-flex align-items-center"><div class="stat-icon peminjaman me-3"><i class="fas fa-hand-peace"></i></div><div><h3 class="stat-number">{{ $totalPeminjaman ?? 0 }}</h3><p class="stat-label">Total Peminjaman</p></div></div></div>
        <div class="col-md-3"><div class="stat-card d-flex align-items-center"><div class="stat-icon aktif me-3"><i class="fas fa-spinner"></i></div><div><h3 class="stat-number">{{ $peminjamanAktif ?? 0 }}</h3><p class="stat-label">Sedang Dipinjam</p></div></div></div>
    </div>

    <div class="row mt-3">
        <div class="col-md-6"><div class="info-card"><div class="card-header" style="background:linear-gradient(135deg,#F5A201,#FFD35B);color:#013C58;padding:15px 20px;font-weight:700">📊 Informasi Sistem</div><div class="card-body">
            <p><span class="info-icon">📚</span> Total Buku Tersedia: <strong>{{ $totalStokBuku ?? 0 }}</strong></p>
            <p><span class="info-icon">📖</span> Total Buku Dipinjam: <strong>{{ $totalBukuDipinjam ?? 0 }}</strong></p>
            <p><span class="info-icon">👥</span> Total Anggota Aktif: <strong>{{ $anggotaAktif ?? 0 }}</strong></p>
            <p><span class="info-icon">💰</span> Denda Terkumpul: <strong style="color:#F5A201">Rp {{ number_format($totalDenda ?? 0,0,',','.') }}</strong></p>
            <p><span class="info-icon">⚠️</span> Belum Bayar Denda: <strong style="color:#e74c3c">{{ $belumBayarDenda ?? 0 }} transaksi</strong></p>
            <p><span class="info-icon">📅</span> Denda per Hari: <strong>Rp 1.000</strong></p>
        </div></div></div>
        <div class="col-md-6"><div class="info-card"><div class="card-header" style="background:linear-gradient(135deg,#F5A201,#FFD35B);color:#013C58;padding:15px 20px;font-weight:700">🏆 Buku Terpopuler</div><div class="card-body">
            @if(isset($bukuTerpopuler) && count($bukuTerpopuler)>0)
                @foreach($bukuTerpopuler as $i=>$b)
                <p>@if($i==0)🥇 @elseif($i==1)🥈 @else🥉 @endif<strong>{{ $b->buku->judul_buku ?? 'Tidak diketahui' }}</strong><br><small class="text-muted ms-4">📊 Dipinjam {{ $b->total }} kali oleh {{ $b->total }} orang</small></p>
                @endforeach
            @else <p><span class="info-icon">📭</span> Belum ada data peminjaman</p>@endif
        </div></div></div>
    </div>

    @if(auth()->user()->role=='anggota' && isset($riwayatPinjaman) && count($riwayatPinjaman)>0)
    <div class="info-card mt-3"><div class="card-header" style="background:linear-gradient(135deg,#00537A,#013C58);color:white;padding:15px 20px;font-weight:700">📜 Riwayat Peminjaman Saya</div>
    <div class="card-body p-0"><div class="table-responsive"><table class="table table-glass mb-0"><thead><tr><th>📅 Tgl Pinjam</th><th>📚 Buku</th><th>📅 Rencana Kembali</th><th>📌 Status</th><th>💰 Denda</th></tr></thead>
    <tbody>@foreach($riwayatPinjaman as $p)@foreach($p->detailPeminjaman as $d)
    <tr><td>{{ $p->tanggal_pinjam->format('d/m/Y') }}</td><td>{{ $d->buku->judul_buku }}</td><td>{{ $p->tanggal_kembali_rencana->format('d/m/Y') }}</td><td>@if($p->status=='dipinjam')<span class="badge-dipinjam">Dipinjam</span>@else<span class="badge-kembali">Kembali</span>@endif</td><td>Rp {{ number_format($p->denda,0,',','.') }}</td></tr>
    @endforeach @endforeach</tbody></table></div></div></div>
    @endif
</div>
@endsection