<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HKSR - Learning and Reporting Sexual Violence</title>
    @include('frontend.layouts.head')
</head>

<body>
    <!-- Navbar -->
    @include('frontend.layouts.navbar')

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center justify-between">
                <div class="col-lg-6 hero-text">
                    <h1>Welcome to HKSR Learning and Reporting Sexual Violence</h1>
                    <p>Platform edukasi dan pelaporan untuk mencegah dan menangani kekerasan seksual. Belajar, laporkan,
                        dan bantu membangun lingkungan yang aman.</p>
                    <div class="d-flex">
                        <a href="#" class="btn btn-report btn-lg me-3 rounded-pill px-4">Mulai Belajar</a>
                        <a href="#" class="btn btn-outline-light btn-lg rounded-pill px-4">Lapor Kasus</a>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block ">
                    <img src="{{ asset('assets/images/frontend/hero-section-1.png') }}" alt="HKSR Hero Image" class="img-fluid rounded-3" style="margin-left: 100px;">
                </div>
            </div>
        </div>
    </section>

    <!-- Info Cards Section -->
    <section class="py-5">
        <div class="container py-5">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="info-card p-4 text-center">
                        <div class="card-icon">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <h4 class="card-title">Modul Pembelajaran</h4>
                        <p class="card-text">Akses berbagai modul edukasi tentang kekerasan seksual, pencegahan, dan
                            penanganan.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-card p-4 text-center">
                        <div class="card-icon">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <h4 class="card-title">Pelaporan Anonim</h4>
                        <p class="card-text">Laporkan kasus kekerasan seksual secara anonim dan dapatkan bantuan dari
                            ahli.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-card p-4 text-center">
                        <div class="card-icon">
                            <i class="fas fa-hands-helping"></i>
                        </div>
                        <h4 class="card-title">Pendampingan</h4>
                        <p class="card-text">Dapatkan dukungan dan pendampingan dari konselor terlatih untuk membantu
                            pemulihan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modul Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title">Modul Pembelajaran</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card modul-card">
                        <img src="{{ asset('assets/images/frontend/modul-1.jpg') }}" class="card-img-top" alt="Modul 1">
                        <div class="card-body">
                            <h5 class="card-title">Pengenalan Kekerasan Seksual</h5>
                            <p class="card-text">Memahami berbagai bentuk kekerasan seksual dan dampaknya pada korban.
                            </p>
                            <a href="#" class="btn btn-primary">Pelajari Modul</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card modul-card">
                        <img src="{{ asset('assets/images/frontend/modul-2.jpg') }}" class="card-img-top" alt="Modul 2">
                        <div class="card-body">
                            <h5 class="card-title">Pencegahan Kekerasan Seksual</h5>
                            <p class="card-text">Strategi dan praktik terbaik untuk mencegah terjadinya kekerasan
                                seksual.</p>
                            <a href="#" class="btn btn-primary">Pelajari Modul</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card modul-card">
                        <img src="{{ asset('assets/images/frontend/modul-3.jpg') }}" class="card-img-top" alt="Modul 3">
                        <div class="card-body">
                            <h5 class="card-title">Aspek Hukum dan Pelaporan</h5>
                            <p class="card-text">Memahami proses hukum dan cara melaporkan kasus kekerasan seksual.</p>
                            <a href="#" class="btn btn-primary">Pelajari Modul</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="#" class="btn btn-outline-primary rounded-pill px-4">Lihat Semua Modul</a>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="section-title">Dampak Kami</h2>
                    <p class="mb-4">HKSR Learning Portal telah membantu ribuan orang memahami, mencegah, dan
                        melaporkan kekerasan seksual. Bergabunglah dengan komunitas kami untuk menciptakan lingkungan
                        yang lebih aman dan peduli.</p>
                    <div class="row g-4 mt-3">
                        <div class="col-md-4">
                            <div class="stat-card">
                                <div class="stat-number">5000+</div>
                                <div class="stat-label">Pengguna Aktif</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-card">
                                <div class="stat-number">20+</div>
                                <div class="stat-label">Modul Pembelajaran</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-card">
                                <div class="stat-number">1000+</div>
                                <div class="stat-label">Kasus Terbantu</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-4 mt-lg-0">
                    <img src="{{ asset('assets/images/frontend/dampak-kami.png') }}" alt="Impact Image" class="img-fluid rounded-3">
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonial Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title">Testimoni</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="mb-3 text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <p class="card-text">"Modul pembelajaran di HKSR sangat membantu saya memahami tentang
                                kekerasan seksual dan cara mencegahnya. Informasinya lengkap dan mudah dipahami."</p>
                            <div class="d-flex align-items-center mt-3">
                                <img src="{{ asset('assets/images/avatars/user-female.png') }}" alt="Testimonial 1" class="rounded-circle"
                                    width="50" height="50">
                                <div class="ms-3">
                                    <h6 class="mb-0">Ani S.</h6>
                                    <small class="text-muted">Mahasiswa</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="mb-3 text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <p class="card-text">"Platform pelaporan anonim membuat saya berani melaporkan kasus yang
                                saya alami. Proses pendampingannya sangat membantu pemulihan saya."</p>
                            <div class="d-flex align-items-center mt-3">
                                <img src="{{ asset('assets/images/avatars/user-male.png') }}" alt="Testimonial 2" class="rounded-circle"
                                    width="50" height="50">
                                <div class="ms-3">
                                    <h6 class="mb-0">Budi K.</h6>
                                    <small class="text-muted">Survivor</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="mb-3 text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <p class="card-text">"Sebagai pendidik, saya menggunakan materi HKSR untuk mengedukasi
                                murid-murid saya. Sangat membantu untuk menciptakan lingkungan sekolah yang aman."</p>
                            <div class="d-flex align-items-center mt-3">
                                <img src="{{ asset('assets/images/avatars/user-female.png') }}" alt="Testimonial 3" class="rounded-circle"
                                    width="50" height="50">
                                <div class="ms-3">
                                    <h6 class="mb-0">Dewi R.</h6>
                                    <small class="text-muted">Guru SMA</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="mb-4">Bergabunglah dengan Kami untuk Menciptakan Lingkungan yang Aman</h2>
                    <p class="mb-4">Daftarkan diri Anda untuk mendapatkan akses ke modul pembelajaran dan bantuan
                        dari tim kami.</p>
                    <div class="d-flex justify-content-center">
                        <a href="#" class="btn btn-report btn-lg me-3 rounded-pill px-4">Daftar Sekarang</a>
                        <a href="#" class="btn btn-outline-secondary btn-lg rounded-pill px-4">Pelajari Lebih
                            Lanjut</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    @include('frontend.layouts.footer')

    @include('frontend.layouts.script')
</body>

</html>
