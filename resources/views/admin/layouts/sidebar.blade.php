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
                <li class="sidebar-item">
                    <a href="javascript:void(0);" class="sidebar-link">
                        <i class="fas fa-upload"></i>
                        <span class="align-middle">Admin</span>
                    </a>
                </li>
            @elseif (Auth::check() && Auth::user()->role === 2)
                {{-- Sidebar untuk staff --}}
                <li class="sidebar-item ">
                    <a href="javascript:void(0);" class="sidebar-link">
                        <i class="fa-solid fa-file-invoice-dollar"></i>
                        <span class="align-middle">{{ __('Staff') }}</span>
                    </a>
                </li>
            @elseif (Auth::check() && Auth::user()->role === 3)
                {{-- Sidebar untuk user --}}
                <li class="sidebar-item ">
                    <a href="javascript:void(0);" class="sidebar-link">
                        <i class="fa-solid fa-file-invoice-dollar"></i>
                        <span class="align-middle">{{ __('User') }}</span>
                    </a>
                </li>
            @endif
        </ul>



    </div>
</nav>
