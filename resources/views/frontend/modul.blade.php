<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modul</title>
    @include('frontend.layouts.head')
</head>
<style>
    :root {
        --secondary-color: #1d3557;
        --light-color: #f1faee;
        --medium-color: #a8dadc;
        --dark-color: #457b9d;
    }

    body {
        background-color: #f8f9fa;
    }

    .modul-card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        height: 100%;
    }

    .modul-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
    }

    .modul-card .card-img-top {
        height: 200px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .modul-card:hover .card-img-top {
        transform: scale(1.05);
    }

    .modul-card .card-body {
        padding: 24px;
        display: flex;
        flex-direction: column;
    }

    .modul-card .card-title {
        font-weight: 700;
        color: var(--secondary-color);
        font-size: 1.1rem;
        margin-bottom: 12px;
        line-height: 1.4;
    }

    .modul-card .card-text {
        color: #6c757d;
        margin-bottom: 16px;
        flex-grow: 1;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .category-badge {
        background: linear-gradient(135deg, var(--primary-color), #ff6b6b);
        color: white;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 6px 12px;
        border-radius: 20px;
        display: inline-block;
        margin-bottom: 12px;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--dark-color), #6fa8dc);
        border: none;
        padding: 12px 24px;
        font-weight: 600;
        border-radius: 25px;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #3a6b91, var(--dark-color));
        transform: translateY(-2px);
    }

    .search-container {
        position: relative;
        margin-bottom: 2rem;
    }

    .search-container .btn {
        position: absolute;
        right: 0;
        top: 0;
        border-radius: 0 30px 30px 0;
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .search-input {
        border-radius: 30px;
        padding-right: 50px;
        background-color: #e9ecef;
        border: none;
    }

    .page-title {
        margin-bottom: 0.5rem;
        font-weight: bold;
    }

    .page-subtitle {
        color: #6c757d;
        margin-bottom: 2rem;
    }

    .pagination {
        justify-content: center;
        margin-top: 3rem;
    }

    .pagination .page-link {
        border-radius: 25px;
        margin: 0 4px;
        border: none;
        color: var(--dark-color);
    }

    .pagination .page-item.active .page-link {
        background-color: var(--dark-color);
        border-color: var(--dark-color);
    }

    .loading-skeleton {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: loading 1.5s infinite;
    }
</style>

<body>
    @include('frontend.layouts.navbar')


    <!-- Main content area -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="page-title">Materi HKSR</h1>
                    <p class="page-subtitle">Artikel, video, atau modul pembelajaran terkait Kesehatan Seksual dan
                        Reproduksi</p>
                </div>
            </div>

            <form method="GET" action="{{ route('modul') }}">
                <div class="row mb-4">
                    <div class="col-lg-4 col-md-6">
                        <div class="search-container">
                            <input t type="text" name="search" class="form-control search-input"
                                placeholder="Masukkan kata kunci..." value="{{ $search }}" aria-label="Search">
                            <button type="submit" class="btn btn-dark">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                    <path
                                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                </div>
            </form>


            <!-- Modul Section -->
            <section class="bg-light rounded-4">
                <div class="container">
                    @if ($moduls->count() > 0)
                        <div class="row g-4">
                            @foreach ($moduls as $modul)
                                <div class="col-lg-4 col-md-6">
                                    <div class="card modul-card">
                                        <div class="position-relative">
                                            @if ($modul->gambar)
                                                <img src="{{ asset($modul->gambar) }}" class="card-img-top"
                                                    alt="{{ $modul->judul }}">
                                            @else
                                                <img src="{{ asset('assets/images/frontend/default-modul.jpg') }}"
                                                    class="card-img-top" alt="Default Image">
                                            @endif
                                            <div class="position-absolute top-0 start-0 p-3">
                                                <span class="category-badge">{{ $modul->nama_category }}</span>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $modul->judul }}</h5>
                                            <p class="card-text">
                                                {{ Str::limit(strip_tags($modul->isi), 120, '...') }}
                                            </p>
                                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                                <small class="text-muted">
                                                    <i class="bi bi-calendar-event me-1"></i>
                                                    {{ \Carbon\Carbon::parse($modul->created_at)->format('d M Y') }}
                                                </small>
                                                <a href="{{ route('modul.detail', $modul->slug) }}"
                                                    class="btn btn-primary">
                                                    <i class="bi bi-book me-1"></i>
                                                    Pelajari
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-5">
                            {{ $moduls->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="no-data">
                            <i class="bi bi-search text-muted"></i>
                            <h4 class="mt-3">Tidak Ada Modul Ditemukan</h4>
                            <p class="text-muted">
                                @if ($search || $category)
                                    Coba ubah kata kunci pencarian
                                @else
                                    Belum ada modul yang tersedia saat ini.
                                @endif
                            </p>
                            @if ($search || $category)
                                <a href="{{ route('modul') }}" class="btn btn-primary mt-3">
                                    <i class="bi bi-arrow-left me-1"></i>
                                    Lihat Semua Modul
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </section>


        </div>
    </section>


    @include('frontend.layouts.footer')
    @include('frontend.layouts.script')

</body>

</html>
