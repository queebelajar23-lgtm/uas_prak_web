<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Menampilkan profil
    public function show()
    {
        $user = Auth::user(); // Ambil data user yang login
        return view('profile.show', compact('user'));
    }

    // Form edit profil
    public function edit()
    {
        $user = Auth::user();
        $anggota = Anggota::where('nim', $user->nim)->first();
        return view('profile.edit', compact('user', 'anggota'));
    }

    // Update profil
    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'kelas' => 'nullable|string|max:20',
            'jurusan' => 'nullable|string|max:50',
            'no_hp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'kelas' => $request->kelas,
            'jurusan' => $request->jurusan,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ]);

        // Update tabel anggota jika ada
        $anggota = Anggota::where('nim', $user->nim)->first();
        if ($anggota) {
            $anggota->update([
                'nama_anggota' => $request->name,
                'kelas' => $request->kelas,
                'jurusan' => $request->jurusan,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
            ]);
        }

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diupdate.');
    }
}