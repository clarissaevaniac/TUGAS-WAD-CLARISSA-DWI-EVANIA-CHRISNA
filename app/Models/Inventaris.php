<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    use HasFactory;

    protected $table = 'inventaris';

    // Kolom yang boleh diisi lewat create() dan update()
    protected $fillable = ['lokasi', 'barang', 'merek', 'kondisi', 'keterangan'];

    // Pilihan untuk dropdown dan radio di form
    public const KONDISI = ['Baik', 'Rusak Ringan', 'Rusak Berat'];

    public const DAFTAR_BARANG = [
        'AC', 'Kasur', 'Lemari', 'TV', 'Meja', 'Kursi',
        'Shower', 'Toilet', 'Water Heater', 'Kulkas', 'WIFI',
    ];

    public const DAFTAR_LOKASI = [
        'Lantai 1' => ['Lantai 1', 'Kamar 101', 'Kamar 102', 'Kamar 103'],
        'Lantai 2' => ['Lantai 2', 'Kamar 201', 'Kamar 202', 'Kamar 203'],
        'Lantai 3' => ['Lantai 3', 'Kamar 301', 'Kamar 302', 'Kamar 303', 'Kamar 304'],
    ];

    // Dipakai di Blade: $item->kelas_kondisi -> nama class warna label
    public function getKelasKondisiAttribute()
    {
        return match ($this->kondisi) {
            'Baik'         => 'kondisi-baik',
            'Rusak Ringan' => 'kondisi-ringan',
            default        => 'kondisi-berat',
        };
    }
}
