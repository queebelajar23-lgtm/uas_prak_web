@extends('layouts.app')

@section('content')
<style>
.profile-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    border-radius: 24px;
    border: 1px solid rgba(255, 255, 255, 0.3);
    overflow: hidden;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    width: 100%;
}

.profile-header {
    background: linear-gradient(135deg, #00537A, #013C58);
    padding: 40px;
    color: white;
    display: flex;
    align-items: center;
    gap: 30px;
    flex-wrap: wrap;
}

.profile-avatar {
    width: 120px;
    height: 120px;
    background: linear-gradient(135deg, #F5A201, #FFD35B);
    border-radius: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 60px;
    color: #013C58;
}

.profile-info {
    flex: 1;
}

.profile-info h2 {
    font-weight: 700;
    margin-bottom: 5px;
    color: white;
}

.profile-info p {
    color: #A8E8F9;
    margin-bottom: 10px;
}

.status-badge {
    display: inline-block;
    background: #1a4a2a;
    color: white;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.btn-edit {
    background: #F5A201;
    border: none;
    padding: 10px 25px;
    border-radius: 12px;
    color: #013C58;
    font-weight: 600;
    transition: all 0.3s;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
}

.btn-edit:hover {
    background: #FFD35B;
    transform: scale(1.02);
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    padding: 30px;
}

.info-item {
    background: rgba(0, 83, 122, 0.05);
    border-radius: 16px;
    padding: 15px 20px;
    transition: all 0.3s;
}

.info-item:hover {
    background: rgba(0, 83, 122, 0.1);
    transform: translateY(-3px);
}

.info-label {
    font-size: 12px;
    color: #00537A;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 8px;
}

.info-value {
    font-size: 16px;
    font-weight: 600;
    color: #013C58;
    margin: 0;
}

.skill-tag {
    display: inline-block;
    background: linear-gradient(135deg, #F5A201, #FFD35B);
    color: #013C58;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    margin-right: 8px;
    margin-bottom: 8px;
}

.divider {
    height: 1px;
    background: linear-gradient(90deg, transparent, #F5A201, #FFD35B, transparent);
    margin: 0 30px;
}
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="profile-card">
                <div class="profile-header">
                    <div class="profile-avatar">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="profile-info">
                        <h2>{{ auth()->user()->name }}</h2>
                        <p>{{ auth()->user()->email }}</p>
                        <div class="status-badge">
                            <i class="fas fa-circle me-1" style="font-size: 8px;"></i> Aktif
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('profile.edit') }}" class="btn-edit">
                            <i class="fas fa-edit me-2"></i> Edit Profil
                        </a>
                    </div>
                </div>

                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label"><i class="fas fa-id-card me-1"></i> Peran</div>
                        <p class="info-value">
                            @if(auth()->user()->role == 'admin')
                                <span class="skill-tag">Administrator</span>
                            @elseif(auth()->user()->role == 'petugas')
                                <span class="skill-tag">Petugas</span>
                            @else
                                <span class="skill-tag">Anggota</span>
                            @endif
                        </p>
                    </div>
                    <div class="info-item">
                        <div class="info-label"><i class="fas fa-briefcase me-1"></i> Posisi Saat Ini</div>
                        <p class="info-value">
                            @if(auth()->user()->role == 'admin')
                                Administrator Perpustakaan
                            @elseif(auth()->user()->role == 'petugas')
                                Petugas Perpustakaan
                            @else
                                Anggota Perpustakaan
                            @endif
                        </p>
                    </div>
                    <div class="info-item">
                        <div class="info-label"><i class="fas fa-calendar me-1"></i> Bergabung Sejak</div>
                        <p class="info-value">{{ auth()->user()->created_at ?->format('d M Y') ?? 'Tanggal tidak tersedia' }}</p>
                        </div>
                    @if(auth()->user()->role == 'anggota')
                    <div class="info-item">
                        <div class="info-label"><i class="fas fa-id-card me-1"></i> NIM</div>
                        <p class="info-value">{{ auth()->user()->nim ?? '-' }}</p>
                    </div>
                    <div class="info-item">
                        <div class="info-label"><i class="fas fa-graduation-cap me-1"></i> Kelas</div>
                        <p class="info-value">{{ auth()->user()->kelas ?? '-' }}</p>
                    </div>
                    <div class="info-item">
                        <div class="info-label"><i class="fas fa-building me-1"></i> Jurusan</div>
                        <p class="info-value">{{ auth()->user()->jurusan ?? '-' }}</p>
                    </div>
                    <div class="info-item">
                        <div class="info-label"><i class="fas fa-phone me-1"></i> No HP</div>
                        <p class="info-value">{{ auth()->user()->no_hp ?? '-' }}</p>
                    </div>
                    <div class="info-item">
                        <div class="info-label"><i class="fas fa-map-marker-alt me-1"></i> Alamat</div>
                        <p class="info-value">{{ auth()->user()->alamat ?? '-' }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection