<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('bukus')->insert([
            ['id_kategori' => 3, 'judul_buku' => 'Belajar Laravel 11', 'penulis' => 'Sandhika Galih', 'penerbit' => 'UNPAS Press', 'tahun_terbit' => 2024, 'stok' => 10, 'lokasi_rak' => 'Rak A1', 'created_at' => now(), 'updated_at' => now()],
            ['id_kategori' => 3, 'judul_buku' => 'Pemrograman Web dengan PHP', 'penulis' => 'Rudy Susanto', 'penerbit' => 'Informatika', 'tahun_terbit' => 2023, 'stok' => 8, 'lokasi_rak' => 'Rak A2', 'created_at' => now(), 'updated_at' => now()],
            ['id_kategori' => 1, 'judul_buku' => 'Laskar Pelangi', 'penulis' => 'Andrea Hirata', 'penerbit' => 'Bentang Pustaka', 'tahun_terbit' => 2005, 'stok' => 5, 'lokasi_rak' => 'Rak B1', 'created_at' => now(), 'updated_at' => now()],
            ['id_kategori' => 5, 'judul_buku' => 'Dilan 1990', 'penulis' => 'Pidi Baiq', 'penerbit' => 'Pastel Books', 'tahun_terbit' => 2014, 'stok' => 7, 'lokasi_rak' => 'Rak B2', 'created_at' => now(), 'updated_at' => now()],
            ['id_kategori' => 2, 'judul_buku' => 'Atomic Habits', 'penulis' => 'James Clear', 'penerbit' => 'Gramedia', 'tahun_terbit' => 2018, 'stok' => 12, 'lokasi_rak' => 'Rak C1', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}