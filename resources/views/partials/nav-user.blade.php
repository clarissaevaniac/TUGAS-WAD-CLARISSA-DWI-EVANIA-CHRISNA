{{-- Bagian kanan navbar: nama user, role, dan tombol keluar --}}
<div class="nav-admin">
    <span class="nama-user">{{ auth()->user()->name }}</span>
    <span class="badge-admin {{ auth()->user()->role === 'admin' ? '' : 'badge-petugas' }}">{{ ucfirst(auth()->user()->role) }}</span>
    <form method="post" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn-keluar">Keluar</button>
    </form>
</div>
