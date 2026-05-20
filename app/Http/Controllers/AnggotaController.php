<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin,petugas');
    }

    // ... sisanya sama seperti sebelumnya
}