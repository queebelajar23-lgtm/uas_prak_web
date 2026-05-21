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
    // HAPUS __construct() !!!

    public function index()
    {
        $peminjamans = Peminjaman::with(['anggota', 'user', 'detailPeminjaman.buku'])->orderBy('created_at', 'desc')->get();
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
            $tanggal_rencana = $peminjaman->tanggal_kembali_rencana;
            
            // Hitung selisih hari (pembulatan ke atas jika lewat)
            $terlambat_hari = 0;
            if ($tanggal_kembali->gt($tanggal_rencana)) {
                $terlambat_hari = $tanggal_kembali->diffInDays($tanggal_rencana);
            }
            
            $denda = $terlambat_hari * 1000;

            $peminjaman->update([
                'tanggal_kembali_aktual' => $tanggal_kembali,
                'status' => 'kembali',
                'denda' => $denda,
            ]);

            // Kembalikan stok
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
}