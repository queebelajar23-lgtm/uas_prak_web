<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(Request $request): View
    {
        return view('profile.show', [
            'user' => $request->user(),
        ]);
    }

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ];
        
        if ($user->role == 'anggota') {
            $rules['nim'] = 'nullable|string|max:20';
            $rules['kelas'] = 'nullable|string|max:20';
            $rules['jurusan'] = 'nullable|string|max:50';
            $rules['no_hp'] = 'nullable|string|max:15';
            $rules['alamat'] = 'nullable|string';
        }
        
        $request->validate($rules);
        
        $user->fill($request->only(['name', 'email']));
        
        if ($user->role == 'anggota') {
            $user->nim = $request->nim;
            $user->kelas = $request->kelas;
            $user->jurusan = $request->jurusan;
            $user->no_hp = $request->no_hp;
            $user->alamat = $request->alamat;
        }
        
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        
        $user->save();
        
        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui!');
    }
}