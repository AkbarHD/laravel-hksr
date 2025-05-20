<nav class="navbar navbar-expand-lg navbar-light bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="/api/placeholder/40/40" alt="Logo HKSR" width="40" height="40">
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
                    <a class="nav-link" href="{{ route('pelaporan') }}">Pelaporan Kekerasan</a>
                </li>
            </ul>
            <div class="ms-2 mt-2">
                <a href="#" class="btn btn-outline-dark rounded-pill px-3">
                    <i class="fas fa-user me-1"></i> User
                </a>
            </div>
        </div>
    </div>
</nav>
