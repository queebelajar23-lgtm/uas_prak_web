<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Kategori;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    // ============================================================
    // KATALOG BUKU — untuk anggota
    // ============================================================

    /**
     * Halaman katalog buku dengan card + filter
     * Route: GET /katalog
     */
    public function katalog(Request $request)
    {
        $query = Buku::with('kategori');

        // Filter pencarian judul / penulis
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul_buku', 'like', '%' . $request->search . '%')
                  ->orWhere('penulis',   'like', '%' . $request->search . '%');
            });
        }

        // Filter kategori
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Filter ketersediaan stok
        if ($request->tersedia === '1') {
            $query->where('stok', '>', 0);
        } elseif ($request->tersedia === '0') {
            $query->where('stok', 0);
        }

        $bukus     = $query->orderBy('judul_buku')->paginate(12);
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('peminjaman.katalog', compact('bukus', 'kategoris'));
    }

    // ============================================================
    // ADMIN & PETUGAS
    // ============================================================

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
        $bukus    = Buku::where('stok', '>', 0)->get();
        return view('peminjaman.create', compact('anggotas', 'bukus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_anggota'               => 'required|exists:anggotas,id_anggota',
            'id_buku'                  => 'required|array|min:1',
            'id_buku.*'                => 'exists:bukus,id_buku',
            'tanggal_kembali_rencana'  => 'required|date|after:today',
        ]);

        DB::beginTransaction();
        try {
            $peminjaman = Peminjaman::create([
                'id_anggota'              => $request->id_anggota,
                'id_user'                 => Auth::id(),
                'tanggal_pinjam'          => now(),
                'tanggal_kembali_rencana' => $request->tanggal_kembali_rencana,
                'status'                  => 'dipinjam',
                'status_pengajuan'        => 'disetujui',
            ]);

            foreach ($request->id_buku as $id_buku) {
                DetailPeminjaman::create([
                    'id_peminjaman' => $peminjaman->id_peminjaman,
                    'id_buku'       => $id_buku,
                    'jumlah'        => 1,
                ]);

                Buku::find($id_buku)->decrement('stok');
            }

            DB::commit();
            return redirect()->route('peminjaman.index')
                             ->with('success', 'Peminjaman berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $peminjaman = Peminjaman::with(['anggota', 'user', 'detailPeminjaman.buku'])
                                ->findOrFail($id);
        return view('peminjaman.show', compact('peminjaman'));
    }

    public function pengembalian($id)
    {
        $peminjaman = Peminjaman::with('detailPeminjaman.buku')->findOrFail($id);

        if ($peminjaman->status === 'kembali') {
            return redirect()->back()->with('error', 'Buku sudah dikembalikan.');
        }

        DB::beginTransaction();
        try {
            $terlambat_hari = max(0, now()->diffInDays($peminjaman->tanggal_kembali_rencana, false) * -1);
            $denda          = $terlambat_hari > 0 ? $terlambat_hari * 1000 : 0;

            $peminjaman->update([
                'tanggal_kembali_aktual' => now(),
                'status'                 => 'kembali',
                'denda'                  => $denda,
            ]);

            foreach ($peminjaman->detailPeminjaman as $detail) {
                Buku::find($detail->id_buku)->increment('stok', $detail->jumlah);
            }

            DB::commit();
            return redirect()->route('peminjaman.index')
                             ->with('success', 'Pengembalian berhasil. Denda: Rp ' . number_format($denda, 0, ',', '.'));
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status === 'dipinjam') {
            return redirect()->back()
                             ->with('error', 'Tidak dapat menghapus peminjaman yang masih aktif.');
        }

        $peminjaman->delete();
        return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman dihapus.');
    }

    // ── Persetujuan ────────────────────────────────────────────

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
                'id_user'          => Auth::id(),
                'tanggal_pinjam'   => now(),
                'status'           => 'dipinjam',
                'status_pengajuan' => 'disetujui',
            ]);

            foreach ($peminjaman->detailPeminjaman as $detail) {
              Buku::where('id_buku', $detail->id_buku)->decrement('stok', $detail->jumlah);
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
            'status'           => 'ditolak',
        ]);

        return redirect()->route('peminjaman.pending')->with('success', 'Peminjaman ditolak.');
    }

    // ============================================================
    // ANGGOTA — Pengajuan mandiri
    // ============================================================

    /**
     * Form pengajuan peminjaman oleh anggota
     * Menerima ?id_buku=X dari katalog (pre-select buku)
     */
    public function createAnggota(Request $request)
    {
        $bukus = Buku::with('kategori')->where('stok', '>', 0)->get();
        $bukuDipilih = $request->has('buku_id') ? (array) $request->buku_id : [];
        $bukusByKategori = $bukus->groupBy(function($item) {
            return $item->kategori->nama_kategori ?? 'Lainnya';
        });
        return view('peminjaman.anggota-create', compact('bukusByKategori', 'bukuDipilih'));
    }

    public function storeAnggota(Request $request)
    {
        $request->validate([
            'id_buku'                 => 'required|array|min:1',
            'id_buku.*'               => 'exists:bukus,id_buku',
            'tanggal_kembali_rencana' => 'required|date|after:today',
        ]);

        DB::beginTransaction();
        try {
            // Cari data anggota berdasarkan NIM user yang login
            $anggota = Anggota::where('nim', Auth::user()->nim)->first();

            if (!$anggota) {
                return redirect()->back()
                                ->with('error', 'Data anggota tidak ditemukan. Hubungi petugas.');
            }

            // Cek apakah semua buku masih ada stok
            foreach ($request->id_buku as $id_buku) {
                $buku = Buku::find($id_buku);
                if (!$buku || $buku->stok < 1) {
                    return redirect()->back()
                                    ->with('error', "Stok buku '{$buku?->judul_buku}' sudah habis.");
                }
            }

            $peminjaman = Peminjaman::create([
                'id_anggota'              => $anggota->id_anggota,
                'id_user'                 => Auth::id(), // Diisi ID user yang login agar tidak null
                'tanggal_pinjam'          => now(),      // Diubah jadi tanggal hari ini (waktu sekarang)
                'tanggal_kembali_rencana' => $request->tanggal_kembali_rencana,
                'status'                  => 'menunggu',
                'status_pengajuan'        => 'menunggu',
            ]);

            foreach ($request->id_buku as $id_buku) {
                DetailPeminjaman::create([
                    'id_peminjaman' => $peminjaman->id_peminjaman,
                    'id_buku'       => $id_buku,
                    'jumlah'        => 1,
                ]);
            }

            DB::commit();
            // Ubah tujuan redirect ke nama route yang baru & unik
            return redirect()->route('anggota.peminjaman.index')
                            ->with('success', 'Pengajuan berhasil dikirim! Menunggu persetujuan petugas.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function indexAnggota()
    {
        // Cari data anggota berdasarkan NIM user yang login
        $anggota = Anggota::where('nim', Auth::user()->nim)->first();

        // Jika data profil anggota belum sinkron di database, jangan biarkan sistem crash 403.
        // Berikan pesan error yang jelas agar tahu bahwa seeder/datanya belum beres.
        if (!$anggota) {
            return redirect()->route('dashboard')
                            ->with('error', 'Profil Anggota belum terdaftar di sistem. Silakan hubungi petugas untuk sinkronisasi NIM Anda.');
        }

        // Jika ada, ambil data peminjamannya seperti biasa
        $peminjamans = Peminjaman::where('id_anggota', $anggota->id_anggota)
            ->with('detailPeminjaman.buku')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('peminjaman.anggota-index', compact('peminjamans'));
    }
}