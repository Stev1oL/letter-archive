<nav class="sidenav shadow-right sidenav-light">
    <div class="sidenav-menu">
        <div class="nav accordion" id="accordionSidenav">
            <!-- Sidenav Menu Heading (Core)-->
            <div class="sidenav-menu-heading">Menu</div>
            <!-- Sidenav Link (Dashboard)-->
            @if(Auth::user()->role === 'admin')
            <a class="nav-link {{ (request()->is('admin/dashboard')) ? 'active' : '' }}" href="{{ route('admin-dashboard') }}">
                <div class="nav-link-icon"><i data-feather="activity"></i></div>
                Dashboard
            </a>
            <a class="nav-link {{ (request()->is('admin/letter/surat-masuk')) ? 'active' : '' }}" href="{{ route('surat-masuk') }}">
                <div class="nav-link-icon"><i data-feather="mail"></i></div>
                Surat Masuk
            </a>
            <a class="nav-link {{ (request()->is('admin/letterout/surat-keluar')) ? 'active' : '' }}" href="{{ route('surat-keluar') }}">
                <div class="nav-link-icon"><i data-feather="mail"></i></div>
                Surat Keluar
            </a>
            @endif
        </div>
    </div>
    <!-- Sidenav Footer-->
    <div class="sidenav-footer">
        <div class="sidenav-footer-content">
            <div class="sidenav-footer-subtitle">Logged in as:</div>
            <div class="sidenav-footer-title">{{ Auth::user()->name }}</div>
        </div>
    </div>
</nav>