<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Cek apakah kolom role sudah ada, jika belum tambahkan
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['admin', 'petugas', 'anggota'])->default('anggota');
            }
            if (!Schema::hasColumn('users', 'nim')) {
                $table->string('nim', 20)->nullable()->unique();
            }
            if (!Schema::hasColumn('users', 'kelas')) {
                $table->string('kelas', 20)->nullable();
            }
            if (!Schema::hasColumn('users', 'jurusan')) {
                $table->string('jurusan', 50)->nullable();
            }
            if (!Schema::hasColumn('users', 'no_hp')) {
                $table->string('no_hp', 15)->nullable();
            }
            if (!Schema::hasColumn('users', 'alamat')) {
                $table->text('alamat')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'nim', 'kelas', 'jurusan', 'no_hp', 'alamat']);
        });
    }
};