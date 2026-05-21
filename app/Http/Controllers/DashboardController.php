<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Statistik dasar
        $totalBuku = Buku::count();
        $totalAnggota = Anggota::count();
        $totalPeminjaman = Peminjaman::count();
        $peminjamanAktif = Peminjaman::where('status', 'dipinjam')->count();
        
        // Total Buku Tersedia (stok > 0)
        $totalStokBuku = Buku::where('stok', '>', 0)->sum('stok');
        
        // Total Buku Dipinjam
        $totalBukuDipinjam = DetailPeminjaman::whereHas('peminjaman', function($q) {
            $q->where('status', 'dipinjam');
        })->sum('jumlah');
        
        // Total Anggota Aktif (yang pernah pinjam)
        $anggotaAktif = Peminjaman::distinct('id_anggota')->count('id_anggota');
        
        // Total Denda Terkumpul
        $totalDenda = Peminjaman::sum('denda');
        
        // Yang Belum Bayar Denda
        $belumBayarDenda = Peminjaman::where('denda', '>', 0)->where('status', '!=', 'kembali')->count();
        
        // Buku Terpopuler (3 buku paling sering dipinjam)
        $bukuTerpopuler = DetailPeminjaman::select('id_buku', DB::raw('count(*) as total'))
            ->with('buku')
            ->groupBy('id_buku')
            ->orderBy('total', 'desc')
            ->limit(3)
            ->get();
        
        // Untuk anggota: riwayat peminjaman sendiri
        $riwayatPinjaman = null;
        if ($user->role == 'anggota') {
            $anggota = Anggota::where('nim', $user->nim)->first();
            if ($anggota) {
                $riwayatPinjaman = Peminjaman::where('id_anggota', $anggota->id_anggota)
                    ->with('detailPeminjaman.buku')
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
        }
        
        return view('dashboard', compact(
            'totalBuku', 'totalAnggota', 'totalPeminjaman', 'peminjamanAktif',
            'totalStokBuku', 'totalBukuDipinjam', 'anggotaAktif', 'totalDenda',
            'belumBayarDenda', 'bukuTerpopuler', 'riwayatPinjaman', 'user'
        ));
    }
}