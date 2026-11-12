<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use Illuminate\Http\Request;

class InventarisController extends Controller
{
    // ---------- READ: daftar + cari + filter + paginasi ----------
    public function index(Request $request)
    {
        $query = Inventaris::query();

        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('barang', 'like', "%$cari%")
                ->orWhere('merek', 'like', "%$cari%");
            });
        }
        if ($request->filled('lokasi')) {
            $query->where('lokasi', $request->lokasi);
        }
        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        $data = $query->orderBy('lokasi')->orderBy('barang')
                    ->paginate(10)->withQueryString();

        // Ringkasan: jumlah per kondisi dari seluruh data
        $hitung = Inventaris::selectRaw('kondisi, COUNT(*) as n')
                            ->groupBy('kondisi')->pluck('n', 'kondisi');

        $daftarLokasi = Inventaris::select('lokasi')->distinct()
                                ->orderBy('lokasi')->pluck('lokasi');

        return view('inventaris.index', compact('data', 'hitung', 'daftarLokasi'));
    }

    // ---------- CREATE: tampilkan form kosong ----------
    public function create()
    {
        return view('inventaris.form', $this->dataForm() + ['item' => null]);
    }

    // ---------- CREATE: simpan data baru ke database ----------
    public function store(Request $request)
    {
        Inventaris::create($request->validate($this->aturan()));

        return redirect()->route('inventaris.index')
                        ->with('sukses', 'Data barang berhasil ditambahkan.');
    }

    // ---------- UPDATE: tampilkan form berisi data lama ----------
    public function edit(Inventaris $inventaris)
    {
        return view('inventaris.form', $this->dataForm() + ['item' => $inventaris]);
    }

    // ---------- UPDATE: simpan perubahan ----------
    public function update(Request $request, Inventaris $inventaris)
    {
        $inventaris->update($request->validate($this->aturan()));

        return redirect()->route('inventaris.index')
                        ->with('sukses', 'Data barang berhasil diubah.');
    }

    // ---------- DELETE: hapus data ----------
    public function destroy(Inventaris $inventaris)
    {
        // Lapis kedua setelah middleware role:admin: cek Gate 'hapus-inventaris'
        $this->authorize('hapus-inventaris');

        $inventaris->delete();

        return redirect()->route('inventaris.index')
                        ->with('sukses', 'Data barang berhasil dihapus.');
    }

    // Aturan validasi (dipakai store dan update)
    private function aturan()
    {
        return [
            'lokasi'     => 'required|string|max:50',
            'barang'     => 'required|string|max:50',
            'merek'      => 'required|string|max:50',
            'kondisi'    => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'keterangan' => 'nullable|string|max:255',
        ];
    }

    // Data pilihan dropdown untuk form
    private function dataForm()
    {
        return [
            'daftarLokasi' => Inventaris::DAFTAR_LOKASI,
            'daftarBarang' => Inventaris::DAFTAR_BARANG,
            'daftarMerek'  => Inventaris::select('merek')->distinct()->orderBy('merek')->pluck('merek'),
        ];
    }
}
