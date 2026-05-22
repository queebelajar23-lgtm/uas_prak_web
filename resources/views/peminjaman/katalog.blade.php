@extends('layouts.app')
@section('content')

<style>
/* ── Page header ───────────────────────────────────── */
.katalog-header {
    background: linear-gradient(135deg, #013C58, #00537A);
    border-radius: 20px;
    padding: 30px 35px;
    color: white;
    margin-bottom: 28px;
    border: 1px solid rgba(255,215,0,.2);
    box-shadow: 0 10px 25px rgba(0,0,0,.1);
}
.katalog-header h2 { font-weight: 700; margin-bottom: 5px; }
.katalog-header p  { color: #A8E8F9; margin: 0; }

/* ── Search & filter bar ───────────────────────────── */
.filter-bar {
    background: rgba(255,255,255,.9);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    padding: 18px 22px;
    margin-bottom: 24px;
    border: 1px solid rgba(255,255,255,.5);
    box-shadow: 0 4px 15px rgba(0,0,0,.06);
}
.filter-bar .form-control,
.filter-bar .form-select {
    border-radius: 10px;
    border: 1.5px solid #e2e8f0;
    font-size: 14px;
    padding: 9px 14px;
}
.filter-bar .form-control:focus,
.filter-bar .form-select:focus {
    border-color: #00537A;
    box-shadow: 0 0 0 3px rgba(0,83,122,.1);
}
.btn-search {
    background: linear-gradient(135deg, #F5A201, #FFD35B);
    color: #013C58;
    border: none;
    border-radius: 10px;
    padding: 9px 22px;
    font-weight: 700;
    font-size: 14px;
    transition: .2s;
}
.btn-search:hover { opacity: .88; color: #013C58; }
.btn-reset {
    background: #f1f5f9;
    color: #475569;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    padding: 9px 18px;
    font-size: 14px;
    transition: .2s;
}
.btn-reset:hover { background: #e2e8f0; }

/* ── Book card ─────────────────────────────────────── */
.book-card {
    background: rgba(255,255,255,.92);
    backdrop-filter: blur(10px);
    border-radius: 18px;
    border: 1px solid rgba(255,255,255,.5);
    overflow: hidden;
    transition: .3s;
    box-shadow: 0 4px 15px rgba(0,0,0,.06);
    height: 100%;
    display: flex;
    flex-direction: column;
}
.book-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 15px 35px rgba(0,0,0,.12);
}
.book-card-img {
    height: 175px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 72px;
    position: relative;
    overflow: hidden;
}
.book-card-img.tersedia  { background: linear-gradient(135deg, #013C58, #00537A); }
.book-card-img.habis     { background: linear-gradient(135deg, #94a3b8, #64748b); }

.stok-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
}
.stok-badge.ada   { background: #A8E8F9; color: #013C58; }
.stok-badge.habis { background: #fee2e2; color: #991b1b; }

.kategori-badge {
    display: inline-block;
    background: rgba(245,162,1,.15);
    color: #854f0b;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    margin-bottom: 8px;
}

.book-card-body {
    padding: 16px 18px;
    flex: 1;
    display: flex;
    flex-direction: column;
}
.book-title {
    font-size: 15px;
    font-weight: 700;
    color: #013C58;
    margin-bottom: 4px;
    line-height: 1.35;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.book-author {
    font-size: 12.5px;
    color: #64748b;
    margin-bottom: 10px;
}
.book-meta {
    font-size: 12px;
    color: #94a3b8;
    margin-bottom: auto;
    padding-bottom: 12px;
}
.book-meta span { display: block; margin-bottom: 2px; }

.book-card-footer { padding: 0 18px 16px; }

.btn-pinjam {
    width: 100%;
    background: linear-gradient(135deg, #F5A201, #FFD35B);
    color: #013C58;
    border: none;
    border-radius: 12px;
    padding: 10px;
    font-weight: 700;
    font-size: 14px;
    transition: .2s;
    text-decoration: none;
    display: block;
    text-align: center;
}
.btn-pinjam:hover { opacity: .88; color: #013C58; transform: scale(1.02); }
.btn-pinjam:active { transform: scale(0.98); }

.btn-pinjam-disabled {
    width: 100%;
    background: #e2e8f0;
    color: #94a3b8;
    border: none;
    border-radius: 12px;
    padding: 10px;
    font-weight: 600;
    font-size: 14px;
    display: block;
    text-align: center;
    cursor: not-allowed;
}

/* ── Empty state ───────────────────────────────────── */
.empty-state {
    text-align: center;
    padding: 80px 20px;
    color: #64748b;
}
.empty-state i { font-size: 80px; opacity: .35; margin-bottom: 20px; display: block; }
.empty-state h4 { font-weight: 700; color: #013C58; }

/* ── Result count ──────────────────────────────────── */
.result-info {
    font-size: 13px;
    color: #64748b;
    margin-bottom: 16px;
}
.result-info strong { color: #013C58; }
</style>

<div class="container-fluid" style="position:relative;z-index:10">

    {{-- Header --}}
    <div class="katalog-header d-flex justify-content-between align-items-center">
        <div>
            <h2><i class="fas fa-book-open me-2" style="color:#FFD35B"></i>Katalog Buku</h2>
            <p>Temukan buku yang ingin kamu pinjam — klik "Pinjam" untuk mengajukan peminjaman</p>
        </div>
        <div style="opacity:.5;font-size:60px">📚</div>
    </div>

    {{-- Alert session --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert"
             style="border-radius:12px;border:none;background:#d1fae5;color:#065f46">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert"
             style="border-radius:12px;border:none">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Filter bar --}}
    <div class="filter-bar">
        <form method="GET" action="{{ route('katalog.index') }}">
            <div class="row g-2 align-items-end">
                <div class="col-md-5">
                    <label class="form-label fw-semibold" style="color:#013C58;font-size:13px">
                        <i class="fas fa-search me-1"></i>Cari Buku
                    </label>
                    <input type="text" name="search" class="form-control"
                           placeholder="Judul atau nama penulis..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold" style="color:#013C58;font-size:13px">
                        <i class="fas fa-tag me-1"></i>Kategori
                    </label>
                    <select name="kategori_id" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoris as $k)
                            <option value="{{ $k->id_kategori }}"
                                {{ request('kategori_id') == $k->id_kategori ? 'selected' : '' }}>
                                {{ $k->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold" style="color:#013C58;font-size:13px">
                        <i class="fas fa-filter me-1"></i>Ketersediaan
                    </label>
                    <select name="tersedia" class="form-select">
                        <option value="">Semua</option>
                        <option value="1" {{ request('tersedia') == '1' ? 'selected' : '' }}>Tersedia</option>
                        <option value="0" {{ request('tersedia') == '0' ? 'selected' : '' }}>Habis</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn-search flex-fill">
                        <i class="fas fa-search me-1"></i>Cari
                    </button>
                    <a href="{{ route('katalog.index') }}" class="btn-reset">
                        <i class="fas fa-redo"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>

    {{-- Result count --}}
    <div class="result-info">
        Menampilkan <strong>{{ $bukus->count() }}</strong> buku
        @if(request('search'))
            untuk pencarian "<strong>{{ request('search') }}</strong>"
        @endif
        @if(request('kategori_id'))
            — Kategori: <strong>{{ $kategoris->find(request('kategori_id'))?->nama_kategori }}</strong>
        @endif
    </div>

    {{-- Book grid --}}
    @if($bukus->count() > 0)
        <div class="row g-4">
            @foreach($bukus as $buku)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="book-card">

                    {{-- Cover / Icon area --}}
                    <div class="book-card-img {{ $buku->stok > 0 ? 'tersedia' : 'habis' }}">
                        @if($buku->cover)
                            <img src="{{ asset('storage/'.$buku->cover) }}"
                                 alt="{{ $buku->judul_buku }}"
                                 style="width:100%;height:100%;object-fit:cover">
                        @else
                            📖
                        @endif
                        <span class="stok-badge {{ $buku->stok > 0 ? 'ada' : 'habis' }}">
                            @if($buku->stok > 0)
                                ✅ Stok: {{ $buku->stok }}
                            @else
                                ❌ Habis
                            @endif
                        </span>
                    </div>

                    {{-- Card body --}}
                    <div class="book-card-body">
                        @if($buku->kategori)
                            <span class="kategori-badge">
                                🏷️ {{ $buku->kategori->nama_kategori }}
                            </span>
                        @endif
                        <div class="book-title">{{ $buku->judul_buku }}</div>
                        <div class="book-author">
                            <i class="fas fa-user-edit me-1" style="color:#F5A201"></i>
                            {{ $buku->penulis }}
                        </div>
                        <div class="book-meta">
                            <span><i class="fas fa-building me-1"></i>{{ $buku->penerbit }}</span>
                            <span><i class="fas fa-calendar me-1"></i>{{ $buku->tahun_terbit }}</span>
                            <span><i class="fas fa-barcode me-1"></i>{{ $buku->isbn }}</span>
                        </div>
                    </div>

                    {{-- Footer: tombol pinjam --}}
                    <div class="book-card-footer">
                        @if($buku->stok > 0)
                            <a href="{{ route('anggota.peminjaman.create', ['id_buku' => $buku->id_buku]) }}"
                               class="btn-pinjam">
                                <i class="fas fa-paper-plane me-2"></i>Ajukan Pinjam
                            </a>
                        @else
                            <span class="btn-pinjam-disabled">
                                <i class="fas fa-times-circle me-2"></i>Stok Habis
                            </span>
                        @endif
                    </div>

                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($bukus->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $bukus->withQueryString()->links() }}
            </div>
        @endif

    @else
        <div class="empty-state">
            <i class="fas fa-search"></i>
            <h4>Buku Tidak Ditemukan</h4>
            <p>Coba ubah kata kunci atau filter pencarian kamu.</p>
            <a href="{{ route('katalog.index') }}" class="btn-search d-inline-block mt-2" style="text-decoration:none">
                <i class="fas fa-redo me-2"></i>Lihat Semua Buku
            </a>
        </div>
    @endif

</div>
@endsection