<nav class="navbar navbar-expand-lg navbar-light bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">
            {{-- <img src="/api/placeholder/40/40" alt="Logo HKSR" width="40" height="40"> --}}
            HKSR Learning Portal
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('modul') }}">Modul</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('kekerasan.seksual') }}">Pelaporan Kekerasan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('konselor.index') }}">Konselor</a>
                </li>
            </ul>
            @auth
                <div class="ms-2 mt-2">
                    {{-- <a href="{{ route('homeadmin') }}" class="btn btn-outline-dark rounded-pill px-3">
                        <i class="fas fa-user me-1"></i> {{ Auth::user()->name }}
                    </a> --}}

                    <div class="dropdown user-dropdown ">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user-circle mr-2"></i>
                            <span class="user-name">{{ auth()->user()->name }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="{{ route('homeadmin') }}">
                                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                            </a>

                            <div class="dropdown-divider"></div>
                            {{-- <a class="dropdown-item" href="{{ route('logout') }}">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </a> --}}
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item"> <i class="fas fa-sign-out-alt mr-2"></i> Log
                                    out</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endauth

            @guest
                <div class="ms-2 mt-2">
                    <a href="{{ route('login') }}" class="btn btn-outline-dark rounded-pill px-3">
                        <i class="fas fa-user me-1"></i> Login
                    </a>
                </div>
            @endguest
        </div>
    </div>
</nav>
