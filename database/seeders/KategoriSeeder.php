<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kategoris')->insert([
            ['nama_kategori' => 'Fiksi', 'deskripsi' => 'Buku cerita fiksi', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Non Fiksi', 'deskripsi' => 'Buku berdasarkan fakta', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Komputer', 'deskripsi' => 'Buku tentang pemrograman dan teknologi', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Pendidikan', 'deskripsi' => 'Buku pelajaran sekolah/kuliah', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Novel', 'deskripsi' => 'Cerita roman dan petualangan', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}