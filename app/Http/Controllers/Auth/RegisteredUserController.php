<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Anggota;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nim' => ['required', 'string', 'max:20', 'unique:users,nim', 'unique:anggotas,nim'],
            'kelas' => ['nullable', 'string', 'max:20'],
            'jurusan' => ['nullable', 'string', 'max:50'],
            'no_hp' => ['nullable', 'string', 'max:15'],
            'alamat' => ['nullable', 'string'],
        ]);

        // 1. Simpan ke tabel users (untuk kebutuhan login auth)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'anggota',
            'nim' => $request->nim,
            'kelas' => $request->kelas,
            'jurusan' => $request->jurusan,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ]);

        // 2. Otomatis sinkronisasi buat data di tabel anggotas
        Anggota::create([
            'nama_anggota' => $request->name,
            'nim' => $request->nim,
            'kelas' => $request->kelas ?? '',
            'jurusan' => $request->jurusan ?? '',
            'no_hp' => $request->no_hp ?? '',
            'alamat' => $request->alamat ?? '',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}