<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin BukuKita',
                'email' => 'admin@bukukita.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'nim' => null,
                'kelas' => null,
                'jurusan' => null,
                'no_hp' => '081234567890',
                'alamat' => 'Kantor Perpustakaan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Petugas Perpus',
                'email' => 'petugas@bukukita.com',
                'password' => Hash::make('password'),
                'role' => 'petugas',
                'nim' => null,
                'kelas' => null,
                'jurusan' => null,
                'no_hp' => '081234567891',
                'alamat' => 'Meja Layanan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Anggota 1',
                'email' => 'anggota@bukukita.com',
                'password' => Hash::make('password'),
                'role' => 'anggota',
                'nim' => 'F55122001',
                'kelas' => 'A',
                'jurusan' => 'Informatika',
                'no_hp' => '081234567892',
                'alamat' => 'Jl. Kampus No 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}