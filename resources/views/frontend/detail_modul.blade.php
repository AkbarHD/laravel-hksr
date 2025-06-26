<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail modul</title>
    @include('frontend.layouts.head')
</head>
<style>
    :root {
        --primary-color: #e63946;
        --secondary-color: #1d3557;
        --light-color: #f1faee;
        --medium-color: #a8dadc;
        --dark-color: #457b9d;
    }

    body {
        background-color: #f8f9fa;
        line-height: 1.7;
    }

    .hero-section {
        background: linear-gradient(135deg, var(--secondary-color), var(--dark-color));
        color: white;
        padding: 80px 0;
        position: relative;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        opacity: 0.1;
    }

    .hero-content {
        position: relative;
        z-index: 1;
    }

    .breadcrumb {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 25px;
        padding: 10px 20px;
    }

    .breadcrumb-item a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
    }

    .breadcrumb-item.active {
        color: white;
    }

    .content-section {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        margin-top: -50px;
        position: relative;
        z-index: 2;
    }

    .modul-image {
        width: 100%;
        height: 300px;
        object-fit: cover;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .category-badge {
        background: linear-gradient(135deg, var(--primary-color), #ff6b6b);
        color: white;
        font-size: 0.85rem;
        font-weight: 600;
        padding: 8px 16px;
        border-radius: 25px;
        display: inline-block;
        margin-bottom: 20px;
    }

    .modul-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--secondary-color);
        margin-bottom: 20px;
        line-height: 1.2;
    }

    .modul-meta {
        color: #6c757d;
        font-size: 0.95rem;
        margin-bottom: 30px;
        padding: 15px 0;
        border-bottom: 2px solid #e9ecef;
    }

    .modul-content {
        font-size: 1.1rem;
        color: #333;
        line-height: 1.8;
        margin-bottom: 40px;
    }

    .modul-content h1,
    .modul-content h2,
    .modul-content h3 {
        color: var(--secondary-color);
        margin-top: 30px;
        margin-bottom: 15px;
    }

    .modul-content p {
        margin-bottom: 20px;
    }

    .modul-content img {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
        margin: 20px 0;
    }

    .back-btn {
        background: linear-gradient(135deg, var(--dark-color), #6fa8dc);
        border: none;
        color: white;
        padding: 12px 24px;
        border-radius: 25px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s ease;
    }

    .back-btn:hover {
        background: linear-gradient(135deg, #3a6b91, var(--dark-color));
        color: white;
        transform: translateY(-2px);
    }

    .share-section {
        background: #f8f9fa;
        padding: 25px;
        border-radius: 15px;
        margin-bottom: 30px;
    }

    .share-btn {
        background: #25d366;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 25px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        margin-right: 10px;
        margin-bottom: 10px;
        transition: all 0.3s ease;
    }

    .share-btn:hover {
        color: white;
        transform: translateY(-2px);
    }

    .share-btn.facebook {
        background: #1877f2;
    }

    .share-btn.twitter {
        background: #1da1f2;
    }

    .share-btn.linkedin {
        background: #0077b5;
    }
</style>

<body>
    @include('frontend.layouts.navbar')
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">
                                <i class="bi bi-house-fill me-1"></i>Beranda
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('modul') }}">Modul</a>
                        </li>
                        <li class="breadcrumb-item active">{{ Str::limit($modul->judul, 30) }}</li>
                    </ol>
                </nav>

                <div class="row align-items-center">
                    <div class="col-md-8">
                        {{-- <span class="category-badge">{{ $modul->nama_category }}</span> --}}
                        <h1 class="modul-title text-white">{{ $modul->judul }}</h1>
                        <div class="modul-meta text-white-50">
                            <i class="bi bi-calendar-event me-2"></i>
                            Dipublikasi: {{ \Carbon\Carbon::parse($modul->created_at)->format('d F Y') }}
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <a href="{{ route('modul') }}" class="back-btn">
                            <i class="bi bi-arrow-left me-2"></i>
                            Kembali ke Modul
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="content-section p-5">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Modul Image -->
                    @if ($modul->gambar)
                        <img src="{{ asset($modul->gambar) }}" class="modul-image mb-4" alt="{{ $modul->judul }}"
                            onerror="this.src='{{ asset('assets/images/frontend/default-modul.jpg') }}'">
                    @endif

                    <!-- Info Views dan Tombol Download -->
                    <div class="d-flex justify-content-between align-items-center mt-3 mb-4">
                        {{-- Jumlah views modul --}}
                        <small class="text-muted">
                            <i class="fas fa-eye me-1"></i> {{ number_format($modul->views) }} kali dilihat
                        </small>

                        {{-- Tombol Download modul --}}
                        <a href="{{ route('modul.download.pdf', $modul->id) }}" class="btn btn-success btn-sm">
                            <i class="fas fa-download me-1"></i> Unduh Modul
                        </a>

                    </div>


                    <!-- Modul Content -->
                    <div class="modul-content">
                        {!! $modul->isi !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('frontend.layouts.footer')
    @include('frontend.layouts.script')
</body>

</html>
