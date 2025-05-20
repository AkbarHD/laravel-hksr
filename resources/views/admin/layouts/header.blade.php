<nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle js-sidebar-toggle">
        <i class="hamburger align-self-center"></i>
    </a>

    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">
            <li class="nav-item dropdown">
                <a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
                    <div class="position-relative">
                        <i class="align-middle" data-feather="bell"></i>
                        <span class="indicator allnotitifkasi">0</span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="alertsDropdown">
                    <div class="dropdown-menu-header">
                        <b class="allnotitifkasi">0</b> Notifikasi Tersedia
                    </div>
                    <div class="list-group">
                        <!-- notifikasi ada pada file notifikasi.js -->
                        <div class="notifkasiapprovalorder"></div>
                        <div class="notifkasiapprovalanggota"></div>
                    </div>
                    <div class="dropdown-menu-footer">
                        {{-- <a href="#" class="text-muted">Show all notifications</a> --}}
                    </div>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                    <i class="align-middle" data-feather="settings"></i>
                </a>

                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">

                    @if (auth()->user()->logo == null)
                        <img src="{{ asset('uploads/logo/logo-kuda.jpg') }}" class="avatar img-fluid rounded me-1"
                            alt="{{ auth()->user()->name }}" />
                    @else
                        <img src="{{ asset(auth()->user()->logo) }}"
                            class="avatar img-fluid rounded me-1" alt="{{ auth()->user()->name }}" />
                    @endif

                    <span class="text-dark">
                        {{ Auth::user()->name }}
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="javascript:void(0);"><i class="align-middle me-1"
                            data-feather="user"></i>
                        Profile</a>
                    <div class="dropdown-divider"></div>
                    {{-- <p class="dropdown-item">
                        <i class="align-middle me-1" data-feather="layers"></i>
                        {{ $jenisAnggota }}
                    </p> --}}
                    {{-- <div class="dropdown-divider"></div> --}}
                    {{-- <a class="dropdown-item" href="{{ route('index.location') }}"><i
                            class="fa-solid fa-location-dot me-1"></i>
                        Tambah Lokasi</a> --}}
                    <div class="dropdown-divider"></div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item">Log out</button>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>
