<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Buku extends Model
{
    protected $table = 'bukus';
    protected $primaryKey = 'id_buku';
    
    protected $fillable = [
        'id_kategori',
        'judul_buku',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'stok',
        'lokasi_rak'
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }
}