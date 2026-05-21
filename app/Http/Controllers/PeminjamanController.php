<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    // ============ UNTUK ADMIN & PETUGAS ============
    
    public function index()
    {
        $peminjamans = Peminjaman::with(['anggota', 'user', 'detailPeminjaman.buku'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        $anggotas = Anggota::all();
        $bukus = Buku::where('stok', '>', 0)->get();
        return view('peminjaman.create', compact('anggotas', 'bukus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_anggota' => 'required|exists:anggotas,id_anggota',
            'id_buku' => 'required|array',
            'id_buku.*' => 'exists:bukus,id_buku',
            'tanggal_kembali_rencana' => 'required|date|after:today',
        ]);

        DB::beginTransaction();
        try {
            $peminjaman = Peminjaman::create([
                'id_anggota' => $request->id_anggota,
                'id_user' => Auth::id(),
                'tanggal_pinjam' => now(),
                'tanggal_kembali_rencana' => $request->tanggal_kembali_rencana,
                'status' => 'dipinjam',
                'status_pengajuan' => 'disetujui',
            ]);

            foreach ($request->id_buku as $id_buku) {
                DetailPeminjaman::create([
                    'id_peminjaman' => $peminjaman->id_peminjaman,
                    'id_buku' => $id_buku,
                    'jumlah' => 1,
                ]);

                $buku = Buku::find($id_buku);
                $buku->stok -= 1;
                $buku->save();
            }

            DB::commit();
            return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $peminjaman = Peminjaman::with(['anggota', 'user', 'detailPeminjaman.buku'])->findOrFail($id);
        return view('peminjaman.show', compact('peminjaman'));
    }

    public function pengembalian($id)
    {
        $peminjaman = Peminjaman::with('detailPeminjaman.buku')->findOrFail($id);
        
        if ($peminjaman->status == 'kembali') {
            return redirect()->back()->with('error', 'Buku sudah dikembalikan');
        }

        DB::beginTransaction();
        try {
            $tanggal_kembali = now();
            $terlambat_hari = max(0, now()->diffInDays($peminjaman->tanggal_kembali_rencana));
            $denda = $terlambat_hari > 0 ? $terlambat_hari * 1000 : 0;

            $peminjaman->update([
                'tanggal_kembali_aktual' => $tanggal_kembali,
                'status' => 'kembali',
                'denda' => $denda,
            ]);

            foreach ($peminjaman->detailPeminjaman as $detail) {
                $buku = Buku::find($detail->id_buku);
                $buku->stok += $detail->jumlah;
                $buku->save();
            }

            DB::commit();
            return redirect()->route('peminjaman.index')->with('success', 'Pengembalian berhasil. Denda: Rp ' . number_format($denda, 0, ',', '.'));
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        if ($peminjaman->status == 'dipinjam') {
            return redirect()->back()->with('error', 'Hapus peminjaman yang sedang aktif tidak diperbolehkan');
        }
        $peminjaman->delete();
        return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman dihapus');
    }

    // ============ UNTUK PERSETUJUAN PETUGAS ============
    
    public function pending()
    {
        $peminjamans = Peminjaman::where('status_pengajuan', 'menunggu')
            ->with(['anggota', 'detailPeminjaman.buku'])
            ->orderBy('created_at', 'asc')
            ->get();
        return view('peminjaman.pending', compact('peminjamans'));
    }

    public function approve($id)
    {
        DB::beginTransaction();
        try {
            $peminjaman = Peminjaman::with('detailPeminjaman.buku')->findOrFail($id);
            
            $peminjaman->update([
                'id_user' => Auth::id(),
                'tanggal_pinjam' => now(),
                'status' => 'dipinjam',
                'status_pengajuan' => 'disetujui',
            ]);

            foreach ($peminjaman->detailPeminjaman as $detail) {
                $buku = Buku::find($detail->id_buku);
                $buku->stok -= $detail->jumlah;
                $buku->save();
            }

            DB::commit();
            return redirect()->route('peminjaman.pending')->with('success', 'Peminjaman disetujui.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function reject($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update([
            'status_pengajuan' => 'ditolak',
            'status' => 'ditolak',
        ]);
        
        return redirect()->route('peminjaman.pending')->with('success', 'Peminjaman ditolak.');
    }

    // ============ UNTUK ANGGOTA (PENGAJUAN) ============
    
    public function createAnggota()
    {
        $bukus = Buku::where('stok', '>', 0)->get();
        return view('peminjaman.anggota-create', compact('bukus'));
    }

    public function storeAnggota(Request $request)
    {
        $request->validate([
            'id_buku' => 'required|array',
            'id_buku.*' => 'exists:bukus,id_buku',
            'tanggal_kembali_rencana' => 'required|date|after:today',
        ]);

        DB::beginTransaction();
        try {
            $anggota = Anggota::where('nim', Auth::user()->nim)->first();
            
            if (!$anggota) {
                return redirect()->back()->with('error', 'Data anggota tidak ditemukan. Hubungi petugas.');
            }

            $peminjaman = Peminjaman::create([
                'id_anggota' => $anggota->id_anggota,
                'id_user' => null,
                'tanggal_pinjam' => null,
                'tanggal_kembali_rencana' => $request->tanggal_kembali_rencana,
                'status' => 'menunggu',
                'status_pengajuan' => 'menunggu',
            ]);

            foreach ($request->id_buku as $id_buku) {
                DetailPeminjaman::create([
                    'id_peminjaman' => $peminjaman->id_peminjaman,
                    'id_buku' => $id_buku,
                    'jumlah' => 1,
                ]);
            }

            DB::commit();
            return redirect()->route('peminjaman.anggota.index')->with('success', 'Pengajuan peminjaman berhasil dikirim. Menunggu persetujuan petugas.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function indexAnggota()
    {
        $anggota = Anggota::where('nim', Auth::user()->nim)->first();
        $peminjamans = Peminjaman::where('id_anggota', $anggota->id_anggota ?? 0)
            ->with('detailPeminjaman.buku')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('peminjaman.anggota-index', compact('peminjamans'));
    }
}