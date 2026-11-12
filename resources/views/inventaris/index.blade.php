<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Inventaris Aset | Admin SJB</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin.css') }}">
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="nav-logo">
            <img src="{{ asset('Logo_NavBar.png') }}" alt="Logo SJB">
        </div>

        <ul class="nav">
            <li class="nav-item"><a class="nav-link" href="#">Beranda</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Tipe Kamar</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Staff</a></li>
            <li class="nav-item"><a class="nav-link active" href="{{ route('inventaris.index') }}">Fasilitas</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Booking</a></li>
        </ul>

        @include('partials.nav-user')
    </nav>

    <main class="container">

        <div class="page-head">
            <h2>Kelola Inventaris Aset Kos</h2>
            <p>Tambah, ubah, dan hapus barang inventaris beserta merek dan kondisi fisiknya.</p>
        </div>

        @if (session('sukses'))
            <div class="pesan pesan-ok" role="status">{{ session('sukses') }}</div>
        @endif

        <!-- RINGKASAN -->
        <section class="ringkasan" aria-label="Ringkasan kondisi barang">
            <div class="ringkasan-item"><strong>{{ $hitung->sum() }}</strong><span>Total barang</span></div>
            <div class="ringkasan-item"><strong>{{ $hitung->get('Baik', 0) }}</strong><span>Kondisi baik</span></div>
            <div class="ringkasan-item ringan"><strong>{{ $hitung->get('Rusak Ringan', 0) }}</strong><span>Rusak ringan</span></div>
            <div class="ringkasan-item berat"><strong>{{ $hitung->get('Rusak Berat', 0) }}</strong><span>Rusak berat</span></div>
        </section>

        <!-- TOOLBAR -->
        <form class="toolbar" method="get" action="{{ route('inventaris.index') }}">
            <input type="search" name="cari" value="{{ request('cari') }}" placeholder="Cari barang atau merek" aria-label="Cari barang atau merek">

            <select name="lokasi" aria-label="Filter lokasi">
                <option value="">Semua lokasi</option>
                @foreach ($daftarLokasi as $l)
                    <option {{ request('lokasi') === $l ? 'selected' : '' }}>{{ $l }}</option>
                @endforeach
            </select>

            <select name="kondisi" aria-label="Filter kondisi">
                <option value="">Semua kondisi</option>
                @foreach (\App\Models\Inventaris::KONDISI as $k)
                    <option {{ request('kondisi') === $k ? 'selected' : '' }}>{{ $k }}</option>
                @endforeach
            </select>

            <button class="btn btn-hijau" type="submit">Terapkan</button>
            <a class="btn spacer" href="{{ route('inventaris.create') }}">+ Tambah barang</a>
        </form>

        <!-- TABEL INVENTARIS -->
        <div class="tabel-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Lokasi</th>
                        <th>Barang</th>
                        <th>Merek</th>
                        <th>Kondisi fisik</th>
                        <th>Keterangan</th>
                        <th class="tengah">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $item)
                        <tr>
                            <td>{{ $data->firstItem() + $loop->index }}.</td>
                            <td>{{ $item->lokasi }}</td>
                            <td>{{ $item->barang }}</td>
                            <td>{{ $item->merek }}</td>
                            <td><span class="kondisi {{ $item->kelas_kondisi }}">{{ $item->kondisi }}</span></td>
                            <td>{{ $item->keterangan ?: '-' }}</td>
                            <td>
                                <div class="aksi">
                                    <a class="edit" href="{{ route('inventaris.edit', $item) }}">Edit</a>
                                    {{-- Tombol Hapus hanya tampil untuk Admin --}}
                                    @if (auth()->user()->role === 'admin')
                                    <form method="post" action="{{ route('inventaris.destroy', $item) }}"
                                        onsubmit="return confirm('Hapus data barang ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="hapus" type="submit">Hapus</button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td class="kosong" colspan="7">Belum ada barang yang cocok. Ubah filter atau tambah barang baru.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINASI -->
        <div class="paginasi">
            <span>
                @if ($data->total())
                    Menampilkan {{ $data->firstItem() }}-{{ $data->lastItem() }} dari {{ $data->total() }} barang
                @else
                    Tidak ada data
                @endif
            </span>
            @if ($data->lastPage() > 1)
                <nav aria-label="Halaman">
                    @if ($data->previousPageUrl())
                        <a href="{{ $data->previousPageUrl() }}">Sebelumnya</a>
                    @endif
                    @for ($n = 1; $n <= $data->lastPage(); $n++)
                        <a class="{{ $n === $data->currentPage() ? 'aktif' : '' }}" href="{{ $data->url($n) }}">{{ $n }}</a>
                    @endfor
                    @if ($data->nextPageUrl())
                        <a href="{{ $data->nextPageUrl() }}">Berikutnya</a>
                    @endif
                </nav>
            @endif
        </div>

    </main>

    <!-- FOOTER -->
    <footer class="site-footer">
        <div class="footer-content">
            <div class="footer-logo">
                <img src="{{ asset('Logo_Footer.png') }}" alt="Logo Footer">
            </div>
            <div class="footer-col"><h4>Beranda</h4><p>Tentang Kami</p><p>Dokumentasi</p></div>
            <div class="footer-col"><h4>Tipe Kamar</h4><p>Reguler</p><p>Premium</p><p>Platinum</p></div>
            <div class="footer-col"><h4>Staff</h4><p>Tabel Staff</p><p>Biodata Staff</p></div>
            <div class="footer-col"><h4>Fasilitas</h4><p>Fasilitas Lantai 1</p><p>Fasilitas Lantai 2</p><p>Fasilitas Lantai 3</p></div>
            <div class="footer-col"><h4>Booking</h4><p>Daftar</p><p>Biodata Penghuni</p></div>
        </div>
        <div class="footer-credit">
            Clarissa Dwi Evania Chrisna | 102022500182 | Kelompok SJB | Modul Inventaris Kos
        </div>
    </footer>

</body>

</html>
