<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'petugas', 'anggota'])->default('anggota');
            $table->string('nim', 20)->nullable();
            $table->string('kelas', 20)->nullable();
            $table->string('jurusan', 50)->nullable();
            $table->string('no_hp', 15)->nullable();
            $table->text('alamat')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'nim', 'kelas', 'jurusan', 'no_hp', 'alamat']);
        });
    }
};