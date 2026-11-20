{{-- Satu file untuk tambah dan ubah. $item = null saat tambah baru, berisi data saat ubah --}}
@php
    $edit = $item !== null;
    $judul = $edit ? 'Form Ubah Barang' : 'Form Tambah Barang';
    $kondisiTerpilih = old('kondisi', $item->kondisi ?? 'Baik');
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $judul }} | Admin SJB</title>
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
                <h1>{{ $judul }}</h1>
                <p>{{ $edit ? 'Ubah informasi barang inventaris.' : 'Tambah data barang baru.' }}</p>
            </div>

            @if ($errors->any())
                <div class="pesan pesan-gagal" role="alert">
                    @foreach ($errors->all() as $pesanError)
                        <div>{{ $pesanError }}</div>
                    @endforeach
                </div>
            @endif

            <section class="form-card">
                <form method="post" action="{{ $edit ? route('inventaris.update', $item) : route('inventaris.store') }}">
                    @csrf
                    @if ($edit)
                        @method('PUT')
                    @endif

                    <div class="form-baris">
                        <div class="form-grup">
                            <label for="lokasi">Lokasi</label>
                            <select id="lokasi" name="lokasi" required>
                                <option value="">Pilih lokasi</option>
                                @foreach ($daftarLokasi as $lantai => $isi)
                                    <optgroup label="{{ $lantai }}">
                                        @foreach ($isi as $l)
                                            <option value="{{ $l }}" {{ old('lokasi', $item->lokasi ?? '') === $l ? 'selected' : '' }}>{{ $l }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-grup">
                            <label for="barang">Nama Barang</label>
                            <select id="barang" name="barang" required>
                                <option value="">Pilih barang</option>
                                @foreach ($daftarBarang as $b)
                                    <option value="{{ $b }}" {{ old('barang', $item->barang ?? '') === $b ? 'selected' : '' }}>{{ $b }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-grup">
                            <label for="merek">Merek</label>
                            <input type="text" id="merek" name="merek" list="daftar-merek" maxlength="50"
                                value="{{ old('merek', $item->merek ?? '') }}" placeholder="Contoh: Panasonic" required>
                            <datalist id="daftar-merek">
                                @foreach ($daftarMerek as $m)
                                    <option value="{{ $m }}">
                                @endforeach
                            </datalist>
                        </div>

                        <div class="form-grup">
                            <label for="kondisi">Kondisi</label>
                            <select id="kondisi" name="kondisi" required>
                                <option value="">-- Pilih --</option>
                                @foreach (\App\Models\Inventaris::KONDISI as $k)
                                    <option value="{{ $k }}" {{ $kondisiTerpilih === $k ? 'selected' : '' }}>{{ $k }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-grup form-keterangan">
                        <label for="keterangan">Keterangan <span>(opsional)</span></label>
                        <textarea id="keterangan" name="keterangan" maxlength="255"
                            placeholder="Contoh: AC kurang dingin">{{ old('keterangan', $item->keterangan ?? '') }}</textarea>
                    </div>

                    <div class="form-aksi">
                        <a class="btn btn-garis" href="{{ route('inventaris.index') }}">Batal</a>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </form>
            </section>
        </main>

        <footer class="site-footer">
            <div>Clarissa Dwi Evania Chrisna <span>|</span> 102022500182 <span>|</span> SI-49-07</div>
            <div>Kelompok SJB <span>|</span> Studi Kasus Sistem Manajemen Kos &amp; Properti - Modul Inventaris Aset Kos</div>
        </footer>
    </div>
</body>
</html>
