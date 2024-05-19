<nav class="sidenav shadow-right sidenav-light">
    <div class="sidenav-menu">
        <div class="nav accordion" id="accordionSidenav">
            <!-- Sidenav Menu Heading (Core)-->
            <div class="sidenav-menu-heading">Menu</div>
            <!-- Sidenav Link (Dashboard)-->
            @if(Auth::user()->role === 'super_admin')
            <a class="nav-link {{ (request()->is('admin/dashboard')) ? 'active' : '' }}" href="{{ route('superadmin-dashboard') }}">
                <div class="nav-link-icon"><i data-feather="activity"></i></div>
                Dashboard
            </a>
            <a class="nav-link {{ (request()->is('admin/department*')) ? 'active' : '' }}" href="{{ route('department.index') }}">
                <div class="nav-link-icon"><i data-feather="home"></i></div>
                Data Departemen
            </a>
            <a class="nav-link {{ (request()->is('admin/sender*')) ? 'active' : '' }}" href="{{ route('sender.index') }}">
                <div class="nav-link-icon"><i data-feather="users"></i></div>
                Pengirim Surat
            </a>
            <a class="nav-link {{ (request()->is('admin/letter/surat-masuk')) ? 'active' : '' }}" href="{{ route('surat-masuk') }}">
                <div class="nav-link-icon"><i data-feather="mail"></i></div>
                Surat Masuk
            </a>
            <a class="nav-link {{ (request()->is('admin/letterout/surat-keluar')) ? 'active' : '' }}" href="{{ route('surat-keluar') }}">
                <div class="nav-link-icon"><i data-feather="mail"></i></div>
                Surat Keluar
            </a>
            <a class="nav-link {{ (request()->is('admin/disposisi/surat-disposisi')) ? 'active' : '' }}" href="{{ route('surat-disposisi') }}">
                <div class="nav-link-icon"><i data-feather="mail"></i></div>
                Pengajuan Disposisi
            </a>
            <a class="nav-link {{ (request()->is('admin/user*')) ? 'active' : '' }}" href="{{ route('user.index') }}">
                <div class="nav-link-icon"><i data-feather="user"></i></div>
                Data User
            </a>
            @elseif(Auth::user()->role === 'admin')
            <a class="nav-link {{ (request()->is('staff/staff-dashboard')) ? 'active' : '' }}" href="{{ route('admin-dashboard') }}">
                <div class="nav-link-icon"><i data-feather="activity"></i></div>
                Dashboard
            </a>
            <a class="nav-link {{ (request()->is('staff/department-staff*')) ? 'active' : '' }}" href="{{ route('department-staff.index') }}">
                <div class="nav-link-icon"><i data-feather="home"></i></div>
                Data Departemen
            </a>
            <a class="nav-link {{ (request()->is('staff/sender-staff*')) ? 'active' : '' }}" href="{{ route('sender-staff.index') }}">
                <div class="nav-link-icon"><i data-feather="users"></i></div>
                Pengirim Surat
            </a>
            <a class="nav-link {{ (request()->is('staff/letter-in/surat-masuk')) ? 'active' : '' }}" href="{{ route('surat-masuk-staff') }}">
                <div class="nav-link-icon"><i data-feather="mail"></i></div>
                Surat Masuk
            </a>
            <a class="nav-link {{ (request()->is('staff/letter-out/surat-keluar')) ? 'active' : '' }}" href="{{ route('surat-keluar-staff') }}">
                <div class="nav-link-icon"><i data-feather="mail"></i></div>
                Surat Keluar
            </a>
            @elseif(Auth::user()->role === 'user')
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