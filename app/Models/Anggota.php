<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $table = 'anggotas';
    protected $primaryKey = 'id_anggota';
    
    protected $fillable = [
        'nama_anggota',
        'nim',
        'kelas',
        'jurusan',
        'no_hp',
        'alamat'
    ];
}