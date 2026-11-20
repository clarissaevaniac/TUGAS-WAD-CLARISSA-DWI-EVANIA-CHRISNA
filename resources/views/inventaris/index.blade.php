<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Properti Kos SJB | Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin.css') }}">
</head>
<body class="admin-layout">
    <aside class="sidebar">
        <div class="sidebar-logo"><img src="{{ asset('Logo_Footer.png') }}" alt="Logo SJB"></div>
        <nav class="sidebar-nav" aria-label="Navigasi utama">
            <a href="#" class="sidebar-link">Beranda</a>
            <a href="#" class="sidebar-link">Tipe Kamar</a>
            <a href="#" class="sidebar-link">Penghuni</a>
            <a href="#" class="sidebar-link">Staff</a>
            <a href="{{ route('inventaris.index') }}" class="sidebar-link active">Properti</a>
        </nav>
    </aside>

    <div class="main-area">
        <header class="topbar">
            <span>Dashboard Manajemen Kos &amp; Properti SJB</span>
            <div class="topbar-user">
                <span>Halo, <strong>{{ auth()->user()->name }}</strong></span>
                <span class="topbar-role">{{ ucfirst(auth()->user()->role) }}</span>
                <form method="post" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-keluar">Keluar</button>
                </form>
            </div>
        </header>

        <main class="content-area">
            <div class="page-head">
                <h1>Properti Kos SJB</h1>
                <p>Kelola inventaris Kos SJB.</p>
            </div>

            @if (session('sukses'))
                <div class="pesan pesan-ok" role="status">{{ session('sukses') }}</div>
            @endif

            <form class="toolbar" method="get" action="{{ route('inventaris.index') }}">
                <input type="search" name="cari" value="{{ request('cari') }}" placeholder="Cari barang..." aria-label="Cari barang">
                <div class="filter-controls">
                    <select name="lokasi" aria-label="Filter lokasi">
                        <option value="">Filter lokasi</option>
                        @foreach ($daftarLokasi as $l)
                            <option value="{{ $l }}" {{ request('lokasi') === $l ? 'selected' : '' }}>{{ $l }}</option>
                        @endforeach
                    </select>
                    <select name="kondisi" aria-label="Filter kondisi">
                        <option value="">Filter kondisi</option>
                        @foreach (\App\Models\Inventaris::KONDISI as $k)
                            <option value="{{ $k }}" {{ request('kondisi') === $k ? 'selected' : '' }}>{{ $k }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-filter" type="submit">Filter</button>
                </div>
                <a class="btn btn-primary" href="{{ route('inventaris.create') }}">+ Tambah Barang</a>
            </form>

            <div class="tabel-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Lokasi</th>
                            <th>Barang</th>
                            <th>Merek</th>
                            <th>Kondisi</th>
                            <th>Keterangan</th>
                            <th class="tengah">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $item)
                            <tr>
                                <td>{{ $data->firstItem() + $loop->index }}</td>
                                <td>{{ $item->lokasi }}</td>
                                <td>{{ $item->barang }}</td>
                                <td>{{ $item->merek }}</td>
                                <td>{{ $item->kondisi }}</td>
                                <td>{{ $item->keterangan ?: '-' }}</td>
                                <td>
                                    <div class="aksi">
                                        <a class="edit" href="{{ route('inventaris.edit', $item) }}">Ubah</a>
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
                        @if ($data->previousPageUrl()) <a href="{{ $data->previousPageUrl() }}">Sebelumnya</a> @endif
                        @for ($n = 1; $n <= $data->lastPage(); $n++)
                            <a class="{{ $n === $data->currentPage() ? 'aktif' : '' }}" href="{{ $data->url($n) }}">{{ $n }}</a>
                        @endfor
                        @if ($data->nextPageUrl()) <a href="{{ $data->nextPageUrl() }}">Berikutnya</a> @endif
                    </nav>
                @endif
            </div>
        </main>

        <footer class="site-footer">
            <div>Clarissa Dwi Evania Chrisna <span>|</span> 102022500182 <span>|</span> SI-49-07</div>
            <div>Kelompok SJB <span>|</span> Studi Kasus Sistem Manajemen Kos &amp; Properti - Modul Inventaris Aset Kos</div>
        </footer>
    </div>
</body>
</html>
