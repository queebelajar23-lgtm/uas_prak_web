@extends('layouts.app')

@section('content')
<style>
.form-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    border-radius: 24px;
    border: 1px solid rgba(255, 255, 255, 0.3);
    overflow: hidden;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    width: 100%;
}
.form-header {
    background: linear-gradient(135deg, #00537A, #013C58);
    padding: 30px 40px;
    color: white;
}
.form-header h3 {
    font-weight: 700;
    margin-bottom: 5px;
    font-size: 24px;
}
.form-header p {
    color: #A8E8F9;
    margin: 0;
}
.form-body {
    padding: 40px;
}
.form-group {
    margin-bottom: 25px;
}
.form-group label {
    font-size: 12px;
    color: #00537A;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 8px;
    display: block;
    font-weight: 600;
}
.form-control {
    background: white;
    border: 1px solid #e0e0e0;
    border-radius: 12px;
    padding: 14px 16px;
    font-size: 15px;
    width: 100%;
}
.form-control:focus {
    border-color: #F5A201;
    outline: none;
    box-shadow: 0 0 0 3px rgba(245,162,1,0.1);
}
select.form-control {
    cursor: pointer;
}
select[multiple] {
    min-height: 300px;
}
.btn-submit {
    background: linear-gradient(135deg, #F5A201, #FFD35B);
    border: none;
    padding: 14px 35px;
    border-radius: 12px;
    color: #013C58;
    font-weight: 600;
    font-size: 15px;
    transition: all 0.3s;
    cursor: pointer;
    width: 100%;
}
.btn-submit:hover {
    background: linear-gradient(135deg, #FFD35B, #F5A201);
    transform: scale(1.02);
}
.btn-cancel {
    background: rgba(0, 83, 122, 0.1);
    border: 1px solid rgba(0, 83, 122, 0.3);
    padding: 14px 35px;
    border-radius: 12px;
    color: #00537A;
    font-weight: 600;
    font-size: 15px;
    transition: all 0.3s;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    text-align: center;
    width: 100%;
    margin-top: 10px;
}
.btn-cancel:hover {
    background: rgba(0, 83, 122, 0.2);
}
.info-box {
    background: rgba(245, 162, 1, 0.1);
    border-left: 4px solid #F5A201;
    padding: 15px;
    border-radius: 12px;
    margin-bottom: 25px;
}
.info-box p {
    margin: 0;
    color: #013C58;
    font-size: 14px;
}
.info-box i {
    color: #F5A201;
    margin-right: 10px;
}
.kategori-group {
    margin-bottom: 20px;
    border: 1px solid #e0e0e0;
    border-radius: 12px;
    overflow: hidden;
}
.kategori-header {
    background: #F5A201;
    color: #013C58;
    padding: 10px 15px;
    font-weight: 600;
}
.kategori-header i {
    margin-right: 8px;
}
.kategori-buku {
    padding: 10px 15px;
    border-bottom: 1px solid #e0e0e0;
    display: flex;
    align-items: center;
    gap: 10px;
}
.kategori-buku:last-child {
    border-bottom: none;
}
.kategori-buku input {
    width: 18px;
    height: 18px;
    cursor: pointer;
}
.kategori-buku label {
    margin: 0;
    cursor: pointer;
    flex: 1;
}
.kategori-buku .stok {
    font-size: 12px;
    color: #6c757d;
}
.kategori-buku .habis {
    color: #dc3545;
    font-size: 12px;
    font-weight: 600;
}
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="form-card">
                <div class="form-header">
                    <h3><i class="fas fa-hand-peace me-2"></i> Ajukan Peminjaman Buku</h3>
                    <p>Silakan pilih buku yang ingin Anda pinjam</p>
                </div>

                <div class="form-body">
                    <div class="info-box">
                        <i class="fas fa-info-circle"></i>
                        <strong>Informasi:</strong> Pengajuan Anda akan diproses oleh petugas perpustakaan. 
                        Status pengajuan dapat dilihat di menu "Riwayat Pengajuan".
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger">{{ $errors->first() }}</div>
                    @endif

                    <form method="POST" action="{{ route('anggota.peminjaman.store') }}">
                        @csrf

                        <div class="form-group">
                            <label><i class="fas fa-calendar-alt me-1"></i> Tanggal Rencana Kembali</label>
                            <input type="date" name="tanggal_kembali_rencana" class="form-control" 
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}" 
                                   max="{{ date('Y-m-d', strtotime('+7 days')) }}" required>
                            <small class="text-muted">Maksimal 7 hari dari sekarang</small>
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-book me-1"></i> Pilih Buku (bisa lebih dari satu)</label>
                            <div class="border rounded-3" style="max-height: 400px; overflow-y: auto;">
                                @php
                                    $bukusByKategori = $bukusByKategori ?? collect();
                                @endphp
                                @foreach($bukusByKategori as $kategori => $bukuKategori)
                                <div class="kategori-group">
                                    <div class="kategori-header">
                                        <i class="fas fa-folder-open"></i> {{ $kategori }}
                                        <span class="badge bg-light text-dark ms-2">{{ count($bukuKategori) }} buku</span>
                                    </div>
                                    @foreach($bukuKategori as $buku)
                                    <div class="kategori-buku">
                                        <input type="checkbox" name="id_buku[]" value="{{ $buku->id_buku }}" id="buku_{{ $buku->id_buku }}" 
                                            {{ in_array($buku->id_buku, $bukuDipilih ?? []) ? 'checked' : '' }}
                                            {{ $buku->stok <= 0 ? 'disabled' : '' }}>
                                        <label for="buku_{{ $buku->id_buku }}" class="d-flex justify-content-between w-100">
                                            <span>
                                                <strong>{{ $buku->judul_buku }}</strong><br>
                                                <small class="text-muted">{{ $buku->penulis }} ({{ $buku->penerbit }}, {{ $buku->tahun_terbit }})</small>
                                            </span>
                                            <span class="stok">
                                                @if($buku->stok > 0)
                                                    <i class="fas fa-check-circle text-success"></i> Stok: {{ $buku->stok }}
                                                @else
                                                    <span class="habis"><i class="fas fa-times-circle"></i> Stok Habis</span>
                                                @endif
                                            </span>
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                                @endforeach
                            </div>
                            <small class="text-muted mt-2 d-block">Klik checkbox untuk memilih buku yang ingin dipinjam</small>
                        </div>

                        <button type="submit" class="btn-submit">
                            <i class="fas fa-paper-plane me-2"></i> Kirim Pengajuan
                        </button>

                        <a href="{{ route('dashboard') }}" class="btn-cancel">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const today = new Date();
    const defaultReturn = new Date(today);
    defaultReturn.setDate(today.getDate() + 7);
    document.querySelector('input[name="tanggal_kembali_rencana"]').value = defaultReturn.toISOString().split('T')[0];
</script>
@endsection