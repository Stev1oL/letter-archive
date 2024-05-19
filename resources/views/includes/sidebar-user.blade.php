<nav class="sidenav shadow-right sidenav-light">
    <div class="sidenav-menu">
        <div class="nav accordion" id="accordionSidenav">
            <!-- Sidenav Menu Heading (Core)-->
            <div class="sidenav-menu-heading">Menu</div>
            <!-- Sidenav Link (Dashboard)-->
            @if(Auth::user()->role === 'user')
            <a class="nav-link {{ (request()->is('user/user-dashboard')) ? 'active' : '' }}" href="{{ route('user-dashboard') }}">
                <div class="nav-link-icon"><i data-feather="activity"></i></div>
                Dashboard
            </a>
            <a class="nav-link {{ (request()->is('user/disposisi-user/surat-disposisi')) ? 'active' : '' }}" href="{{ route('surat-disposisi-user') }}">
                <div class="nav-link-icon"><i data-feather="mail"></i></div>
                Pengajuan Disposisi
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