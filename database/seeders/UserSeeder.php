<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Masukkan data Admin & Petugas ke tabel users
        DB::table('users')->insert([
            [
                'name' => 'Admin BukuKita',
                'email' => 'admin@bukukita.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'nim' => null,
            ],
            [
                'name' => 'Petugas Perpus',
                'email' => 'petugas@bukukita.com',
                'password' => Hash::make('password'),
                'role' => 'petugas',
                'nim' => null,
            ]
        ]);

        // 2. Masukkan data Akun Login Anggota ke tabel users
        DB::table('users')->insert([
            'name' => 'Anggota 1',
            'email' => 'anggota@bukukita.com',
            'password' => Hash::make('password'),
            'role' => 'anggota',
            'nim' => 'F55122001', // Kunci pencocokan
        ]);

        // 3. SEKALIGUS masukkan data profilnya ke tabel anggotas di sini
        DB::table('anggotas')->insert([
            'nim' => 'F55122001', // Harus sama persis dengan yang di atas
            'nama_anggota' => 'Anggota 1',
            'kelas' => 'A',
            'jurusan' => 'Informatika',
            'no_hp' => '081234567892',
            'alamat' => 'Jl. Kampus No 1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}