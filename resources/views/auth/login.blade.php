<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Admin SJB</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin.css') }}">
</head>

<body class="halaman-login">

    <main class="login-card">
        <img src="{{ asset('Logo_Footer.png') }}" alt="Logo SJB" class="login-logo">
        <h2>Masuk ke Sistem</h2>
        <p class="login-sub">Login diperlukan untuk membuka modul Inventaris.</p>

        @if ($errors->any())
            <div class="pesan pesan-gagal" role="alert">
                @foreach ($errors->all() as $pesanError)
                    <div>{{ $pesanError }}</div>
                @endforeach
            </div>
        @endif

        <form method="post" action="{{ route('login.proses') }}">
            @csrf
            <div class="form-grup">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" value="{{ old('email') }}" placeholder="admin@sjb.com" autofocus required>
            </div>
            <div class="form-grup">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button class="btn login-btn" type="submit">Masuk</button>
        </form>
    </main>

</body>

</html>
