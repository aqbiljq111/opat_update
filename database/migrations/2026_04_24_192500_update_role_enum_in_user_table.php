<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Ubah ENUM menjadi VARCHAR sementara untuk menghindari error pemotongan data (Data truncated)
        Schema::table('user', function (Blueprint $table) {
            $table->string('role', 50)->default('siswa')->change();
        });

        // 2. Ubah data lama: 'user' menjadi 'siswa'
        DB::table('user')->where('role', 'user')->update(['role' => 'siswa']);

        // 3. Ubah kembali tipe data ke ENUM dengan pilihan baru
        Schema::table('user', function (Blueprint $table) {
            $table->enum('role', ['admin', 'guru', 'siswa'])->default('siswa')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user', function (Blueprint $table) {
            $table->string('role', 50)->default('user')->change();
        });

        DB::table('user')->where('role', 'siswa')->update(['role' => 'user']);
        DB::table('user')->where('role', 'guru')->update(['role' => 'user']); // fallback

        Schema::table('user', function (Blueprint $table) {
            $table->enum('role', ['user', 'admin'])->default('user')->change();
        });
    }
};
