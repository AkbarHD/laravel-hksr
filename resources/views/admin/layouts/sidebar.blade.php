<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar custom-sidebar">
        <a class="sidebar-brand" href="{{ route('homeadmin') }}">
            <span class="align-middle">
                {{-- {{ Auth::user()->nameclub }}.com --}}
                {{ Auth::user()->name }}
            </span>
        </a>
        <ul class="sidebar-nav">
            {{-- Dashboard --}}
            <li class="sidebar-item {{ request()->routeIs('homeadmin') ? 'active' : '' }}">
                <a href="{{ route('homeadmin') }}" class="sidebar-link">
                    <i class="fa-solid fa-book-open"></i>
                    <span class="align-middle">Dashboard</span>
                </a>
            </li>

            {{-- Kondisi berdasarkan level pengguna --}}
            @if (Auth::check() && Auth::user()->role === 1)
                {{-- Sidebar untuk Admin --}}
                <li class="sidebar-item {{ request()->routeIs('category.index') ? 'active' : '' }}">
                    <a href="{{ route('category.index') }}" class="sidebar-link">
                        <i class="fas fa-upload"></i>
                        <span class="align-middle">Category</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('materi.index') ? 'active' : '' }}">
                    <a href="{{ route('materi.index') }}" class="sidebar-link">
                        <i class="fas fa-upload"></i>
                        <span class="align-middle">Materi</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->routeIs('admin.laporan.pending') ? 'active' : '' }}">
                    <a href="{{ route('admin.laporan.pending') }}" class="sidebar-link">
                        <i class="fas fa-upload"></i>
                        <span class="align-middle">Laporan Masuk</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->routeIs('admin.managament.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.managament.index') }}" class="sidebar-link">
                        <i class="fas fa-upload"></i>
                        <span class="align-middle">Manajement User</span>
                    </a>
                </li>
            @elseif (Auth::check() && Auth::user()->role === 2)
                {{-- Sidebar untuk staff --}}
                <li class="sidebar-item {{ request()->routeIs('stackholder.laporan.pending') ? 'active' : '' }}">
                    <a href="{{ route('stackholder.laporan.pending') }}" class="sidebar-link">
                        <i class="fa-solid fa-file-invoice-dollar"></i>
                        <span class="align-middle">{{ __('Laporan Masuk') }}</span>
                    </a>
                </li>
            @elseif (Auth::check() && Auth::user()->role === 3)
                {{-- Sidebar untuk user --}}
                <li class="sidebar-item {{ request()->routeIs('list.laporan.index') ? 'active' : '' }}">
                    <a href="{{ route('list.laporan.index') }}" class="sidebar-link">
                        <i class="fa-solid fa-file-invoice-dollar"></i>
                        <span class="align-middle">{{ __('List Laporan') }}</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('user.hasil.tindaklanjut') ? 'active' : '' }}">
                    <a href="{{ route('user.hasil.tindaklanjut') }}" class="sidebar-link">
                        <i class="fa-solid fa-file-invoice-dollar"></i>
                        <span class="align-middle">{{ __('Laporan Terjawab') }}</span>
                    </a>
                </li>
            @elseif (Auth::check() && Auth::user()->role === 4)
                {{-- Sidebar untuk konselor --}}
                <li class="sidebar-item {{ request()->routeIs('list.konselor.index') ? 'active' : '' }}">
                    <a href="{{ route('list.konselor.index') }}" class="sidebar-link">
                        <i class="fa-solid fa-file-invoice-dollar"></i>
                        <span class="align-middle">{{ __('List Konselor') }}</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('konselor-dashboard.index') ? 'active' : '' }}">
                    <a href="{{ route('konselor-dashboard.index') }}" class="sidebar-link">
                        <i class="fa-solid fa-file-invoice-dollar"></i>
                        <span class="align-middle">{{ __('List Chat Konselor') }}</span>
                    </a>
                </li>
            @endif

            <li class="sidebar-item {{ request()->routeIs('home') ? 'active' : '' }}">
                <a href="{{ route('home') }}" class="sidebar-link">
                    <i class="fa-solid fa-book-open"></i>
                    <span class="align-middle">Beranda</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
