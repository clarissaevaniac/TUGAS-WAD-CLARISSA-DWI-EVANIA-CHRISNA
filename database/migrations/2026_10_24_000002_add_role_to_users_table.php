<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Tambah kolom role ke tabel users bawaan Laravel
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 20)->default('petugas')->after('password');
        });

        // Dua akun awal: Admin dan Petugas (password disimpan dalam bentuk hash)
        $sekarang = now();
        DB::table('users')->insert([
            [
                'name'       => 'Admin SJB',
                'email'      => 'admin@sjb.test',
                'password'   => Hash::make('admin123'),
                'role'       => 'admin',
                'created_at' => $sekarang,
                'updated_at' => $sekarang,
            ],
            [
                'name'       => 'Petugas SJB',
                'email'      => 'petugas@sjb.test',
                'password'   => Hash::make('petugas123'),
                'role'       => 'petugas',
                'created_at' => $sekarang,
                'updated_at' => $sekarang,
            ],
        ]);
    }

    public function down()
    {
        DB::table('users')->whereIn('email', ['admin@sjb.test', 'petugas@sjb.test'])->delete();

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
