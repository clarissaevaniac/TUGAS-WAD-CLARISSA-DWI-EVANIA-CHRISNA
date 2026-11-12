<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Dijalankan saat: php artisan migrate
    public function up()
    {
        Schema::create('inventaris', function (Blueprint $table) {
            $table->id();
            $table->string('lokasi', 50);
            $table->string('barang', 50);
            $table->string('merek', 50);
            $table->enum('kondisi', ['Baik', 'Rusak Ringan', 'Rusak Berat'])->default('Baik');
            $table->string('keterangan', 255)->nullable();
            $table->timestamps();
        });

        // Data contoh (langsung terisi saat migrate)
        $sekarang = now();
        $data = [
            ['Lantai 1',  'WIFI',         'MyRepublic', 'Baik',         null],
            ['Lantai 1',  'Kulkas',       'LG',         'Baik',         null],
            ['Kamar 101', 'AC',           'Panasonic',  'Rusak Ringan', 'AC kurang dingin'],
            ['Kamar 101', 'Kasur',        'Comforta',   'Baik',         null],
            ['Kamar 102', 'Shower',       'TOTO',       'Rusak Ringan', 'Aliran air kecil'],
            ['Kamar 103', 'Water Heater', 'Ariston',    'Rusak Berat',  'Tidak dapat menghasilkan air panas'],
            ['Kamar 201', 'Kursi',        'Informa',    'Rusak Ringan', 'Kaki kursi longgar'],
            ['Kamar 202', 'Kasur',        'Comforta',   'Rusak Ringan', 'Permukaan kasur mulai rusak'],
            ['Kamar 203', 'Lemari',       'Olympic',    'Rusak Ringan', 'Pintu lemari sulit ditutup'],
            ['Kamar 301', 'Toilet',       'TOTO',       'Rusak Ringan', 'Flush tidak berfungsi dengan baik'],
            ['Kamar 302', 'Meja',         'Informa',    'Rusak Ringan', 'Permukaan meja tergores'],
        ];
        foreach ($data as [$lokasi, $barang, $merek, $kondisi, $keterangan]) {
            DB::table('inventaris')->insert([
                'lokasi' => $lokasi, 'barang' => $barang, 'merek' => $merek,
                'kondisi' => $kondisi, 'keterangan' => $keterangan,
                'created_at' => $sekarang, 'updated_at' => $sekarang,
            ]);
        }
    }

    public function down()
    {
        Schema::dropIfExists('inventaris');
    }
};
