{{-- Satu file untuk tambah dan ubah. $item = null saat tambah baru, berisi data saat ubah --}}
@php
    $edit = $item !== null;
    $judul = $edit ? 'Ubah data barang' : 'Tambah barang baru';
    $kelasLabel = ['Baik' => 'k-baik', 'Rusak Ringan' => 'k-ringan', 'Rusak Berat' => 'k-berat'];
    $kondisiTerpilih = old('kondisi', $item->kondisi ?? 'Baik');
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $judul }} | Admin SJB</title>
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

        <p class="breadcrumb"><a href="{{ route('inventaris.index') }}">Kelola Inventaris</a> / {{ $judul }}</p>

        <section class="form-card">
            <div class="page-head">
                <h2>{{ $judul }}</h2>
                <p>Isi data barang inventaris. Semua kolom bertanda * wajib diisi.</p>
            </div>

            @if ($errors->any())
                <div class="pesan pesan-gagal" role="alert">
                    @foreach ($errors->all() as $pesanError)
                        <div>{{ $pesanError }}</div>
                    @endforeach
                </div>
            @endif

            <form method="post" action="{{ $edit ? route('inventaris.update', $item) : route('inventaris.store') }}">
                @csrf
                @if ($edit)
                    @method('PUT')
                @endif

                <div class="form-baris">
                    <div class="form-grup">
                        <label for="lokasi">Lokasi *</label>
                        <select id="lokasi" name="lokasi" required>
                            <option value="">Pilih lokasi</option>
                            @foreach ($daftarLokasi as $lantai => $isi)
                                <optgroup label="{{ $lantai }}">
                                    @foreach ($isi as $l)
                                        <option {{ old('lokasi', $item->lokasi ?? '') === $l ? 'selected' : '' }}>{{ $l }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-grup">
                        <label for="barang">Nama barang *</label>
                        <select id="barang" name="barang" required>
                            <option value="">Pilih barang</option>
                            @foreach ($daftarBarang as $b)
                                <option {{ old('barang', $item->barang ?? '') === $b ? 'selected' : '' }}>{{ $b }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-grup">
                    <label for="merek">Merek *</label>
                    <input type="text" id="merek" name="merek" list="daftar-merek" maxlength="50"
                        value="{{ old('merek', $item->merek ?? '') }}" placeholder="Contoh: Panasonic" required>
                    <datalist id="daftar-merek">
                        @foreach ($daftarMerek as $m)
                            <option value="{{ $m }}">
                        @endforeach
                    </datalist>
                    <p class="bantuan">Pilih dari daftar atau ketik merek baru.</p>
                </div>

                <fieldset class="form-grup">
                    <legend>Kondisi fisik *</legend>
                    <div class="pilihan-kondisi">
                        @foreach ($kelasLabel as $nilai => $kelas)
                            <div>
                                <input type="radio" id="{{ $kelas }}" name="kondisi" value="{{ $nilai }}"
                                    {{ $kondisiTerpilih === $nilai ? 'checked' : '' }}>
                                <label class="{{ $kelas }}" for="{{ $kelas }}">{{ $nilai }}</label>
                            </div>
                        @endforeach
                    </div>
                </fieldset>

                <div class="form-grup">
                    <label for="keterangan">Keterangan</label>
                    <textarea id="keterangan" name="keterangan" maxlength="255"
                            placeholder="Contoh: AC kurang dingin, perlu servis freon">{{ old('keterangan', $item->keterangan ?? '') }}</textarea>
                    <p class="bantuan">Kosongkan jika tidak ada catatan.</p>
                </div>

                <div class="form-aksi">
                    <a class="btn btn-garis" href="{{ route('inventaris.index') }}">Batal</a>
                    <button class="btn" type="submit">Simpan barang</button>
                </div>
            </form>
        </section>

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
