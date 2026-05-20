@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold" style="color: #0a2e1a;">
                <i class="fas fa-hand-peace me-2"></i> Form Peminjaman
            </h2>
            <p class="text-muted">Input peminjaman buku untuk anggota</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('peminjaman.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Pilih Anggota</label>
                        <select name="id_anggota" class="form-select @error('id_anggota') is-invalid @enderror" required>
                            <option value="">-- Pilih Anggota --</option>
                            @foreach($anggotas as $anggota)
                            <option value="{{ $anggota->id_anggota }}">{{ $anggota->nama_anggota }} ({{ $anggota->nim }})</option>
                            @endforeach
                        </select>
                        @error('id_anggota')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Kembali Rencana</label>
                        <input type="date" name="tanggal_kembali_rencana" class="form-control @error('tanggal_kembali_rencana') is-invalid @enderror" required>
                        <small class="text-muted">Maksimal 7 hari dari hari ini</small>
                        @error('tanggal_kembali_rencana')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Pilih Buku (Bisa lebih dari satu)</label>
                        <select name="id_buku[]" class="form-select @error('id_buku') is-invalid @enderror" multiple size="5" required>
                            @foreach($bukus as $buku)
                            <option value="{{ $buku->id_buku }}" {{ $buku->stok <= 0 ? 'disabled' : '' }}>
                                {{ $buku->judul_buku }} - Stok: {{ $buku->stok }}
                                @if($buku->stok <= 0) (HABIS) @endif
                            </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Tekan Ctrl untuk memilih lebih dari satu buku</small>
                        @error('id_buku')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i> Simpan Peminjaman
                    </button>
                    <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Set default tanggal kembali rencana (7 hari dari sekarang)
    const today = new Date();
    const defaultReturn = new Date(today);
    defaultReturn.setDate(today.getDate() + 7);
    document.querySelector('input[name="tanggal_kembali_rencana"]').value = defaultReturn.toISOString().split('T')[0];
</script>
@endsection