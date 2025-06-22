<style>
    /* Custom Navbar Styles */
    .navbar {
        transition: all 0.3s ease;
        background-color: #212529 !important;
        /* Force dark background */
    }

    .navbar-brand {
        font-size: 1.5rem;
        letter-spacing: -0.5px;
        color: #ffffff !important;
    }

    .navbar-nav .nav-link {
        position: relative;
        transition: all 0.3s ease;
        font-weight: 500;
        color: #e9ecef !important;
        /* Light gray instead of transparent white */
    }

    .navbar-nav .nav-link:hover {
        color: #ffffff !important;
        transform: translateY(-2px);
    }

    .navbar-nav .nav-link.active {
        color: #ffffff !important;
        font-weight: 600;
    }

    .navbar-nav .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 50%;
        transform: translateX(-50%);
        width: 30px;
        height: 3px;
        background: linear-gradient(45deg, #007bff, #0056b3);
        border-radius: 2px;
    }

    /* User Avatar & Dropdown Styles */
    .user-avatar {
        background: linear-gradient(45deg, #007bff, #0056b3) !important;
        box-shadow: 0 2px 8px rgba(0, 123, 255, 0.3);
    }

    .user-name {
        color: #ffffff !important;
        /* Force white color for username */
    }

    .nav-link.dropdown-toggle {
        color: #e9ecef !important;
    }

    .nav-link.dropdown-toggle:hover {
        color: #ffffff !important;
    }

    /* Dropdown Styles */
    .dropdown-menu {
        border: none;
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        margin-top: 8px;
        min-width: 200px;
    }

    .dropdown-item {
        border-radius: 8px;
        margin: 4px 8px;
        transition: all 0.2s ease;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
        transform: translateX(4px);
    }

    .dropdown-item.text-danger:hover {
        background-color: #fff5f5;
        color: #dc3545 !important;
    }

    /* Login Button Styles */
    .btn-outline-light {
        border: 2px solid #ffffff;
        color: #ffffff !important;
        background-color: transparent;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .btn-outline-light:hover {
        background-color: #ffffff;
        color: #212529 !important;
        border-color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 255, 255, 0.3);
    }

    /* Mobile Responsiveness */
    @media (max-width: 991.98px) {
        .navbar-nav {
            padding-top: 1rem;
        }

        .navbar-nav .nav-link {
            padding: 0.7rem 1rem;
            border-radius: 8px;
            margin: 2px 0;
        }

        .navbar-nav .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: none;
        }

        .btn-outline-light {
            margin-top: 1rem;
            width: 100%;
        }

        .dropdown-menu {
            margin-top: 0;
            border-radius: 8px;
        }
    }

    /* Navbar Toggler Custom */
    .navbar-toggler:focus {
        box-shadow: none;
    }

    .navbar-toggler {
        padding: 6px 8px;
        border-radius: 8px;
    }

    .navbar-toggler:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }
</style>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow-sm">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand fw-bold text-white" href="#">
            {{-- <img src="/api/placeholder/40/40" alt="Logo HKSR" width="40" height="40" class="me-2"> --}}
            HKSR Learning Portal
        </a>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Content -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Navigation Links -->
            <ul class="navbar-nav ms-auto me-3">
                <li class="nav-item">
                    <a class="nav-link px-3 {{ Route::currentRouteName() == 'home' ? 'active' : '' }}" aria-current="page" href="{{ route('home') }}">
                        <i class="fas fa-home me-1"></i>Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 {{ Route::currentRouteName() == 'modul' ? 'active' : '' }}" href="{{ route('modul') }}">
                        <i class="fas fa-book me-1"></i>Modul
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 {{ Route::currentRouteName() == 'kekerasan.seksual' ? 'active' : '' }}" href="{{ route('kekerasan.seksual') }}">
                        <i class="fas fa-shield-alt me-1"></i>Pelaporan Kekerasan
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link px-3 {{ Route::currentRouteName() == 'konselor.index' ? 'active' : '' }}" href="{{ route('konselor.index') }}">
                        <i class="fas fa-user-md me-1"></i>Konselor
                    </a>
                </li>
            </ul>

            <!-- User Authentication Section -->
            @auth
                <div class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center px-3" href="#" id="userDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-avatar bg-primary rounded-circle d-flex align-items-center justify-content-center me-2"
                                style="width: 32px; height: 32px;">
                                <i class="fas fa-user text-white" style="font-size: 14px;"></i>
                            </div>
                            <span class="user-name fw-medium">{{ auth()->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('homeadmin') }}">
                                    <i class="fas fa-tachometer-alt me-2 text-primary"></i>Dashboard
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="mb-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </div>
            @endauth

            @guest
                <div class="navbar-nav">
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="btn btn-outline-light rounded-pill px-4 py-2">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                    </li>
                </div>
            @endguest
        </div>
    </div>
</nav>
