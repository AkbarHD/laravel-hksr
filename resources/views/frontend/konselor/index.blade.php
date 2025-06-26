<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Konselor - HKSR</title>
    @include('frontend.layouts.head')
    <style>
        :root {
            --primary-color: #e63946;
            --secondary-color: #1d3557;
            --light-color: #f1faee;
            --medium-color: #a8dadc;
            --dark-color: #457b9d;
            --warning-color: #f39c12;
            --warning-light: #fef9e7;
        }

        .konselor-section {
            padding: 60px 0;
            background: linear-gradient(135deg, var(--light-color) 0%, var(--medium-color) 100%);
            min-height: 80vh;
        }

        .section-title {
            text-align: center;
            margin-bottom: 30px;
        }

        .section-title h2 {
            color: var(--secondary-color);
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .section-title p {
            color: var(--dark-color);
            font-size: 1.1rem;
            max-width: 650px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* Warning Section Styles */
        .warning-section {
            margin-bottom: 40px;
        }

        .warning-card {
            background: var(--warning-light);
            border: 1px solid var(--warning-color);
            border-radius: 15px;
            padding: 20px;
            display: flex;
            align-items: center;
            max-width: 800px;
            margin: 0 auto;
            box-shadow: 0 5px 15px rgba(243, 156, 18, 0.1);
        }

        .warning-card i {
            font-size: 2rem;
            color: var(--warning-color);
            margin-right: 20px;
        }

        .warning-content h5 {
            color: var(--secondary-color);
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 1.1rem;
        }

        .warning-content p {
            color: #666;
            margin: 0;
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .konselor-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            overflow: hidden;
            height: 100%;
            border: 2px solid transparent;
        }

        .konselor-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            border-color: var(--primary-color);
        }

        .konselor-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-bottom: 3px solid var(--medium-color);
        }

        .konselor-body {
            padding: 25px;
        }

        .konselor-name {
            color: var(--secondary-color);
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .konselor-type {
            display: inline-block;
            background: var(--primary-color);
            color: white;
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 15px;
        }

        .konselor-description {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 20px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .konselor-time {
            display: flex;
            align-items: center;
            color: var(--dark-color);
            font-size: 0.9rem;
            margin-bottom: 20px;
            padding: 10px;
            background: var(--light-color);
            border-radius: 10px;
        }

        .konselor-time i {
            margin-right: 8px;
            color: var(--primary-color);
        }

        .btn-konsultasi {
            background: linear-gradient(135deg, var(--primary-color), #ff6b7a);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            width: 100%;
            text-align: center;
        }

        .btn-konsultasi:hover {
            background: linear-gradient(135deg, #d52532, var(--primary-color));
            transform: scale(1.05);
            color: white;
            text-decoration: none;
        }

        .no-konselor {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .no-konselor i {
            font-size: 4rem;
            color: var(--medium-color);
            margin-bottom: 20px;
        }

        .no-konselor h3 {
            color: var(--secondary-color);
            margin-bottom: 15px;
        }

        .no-konselor p {
            color: #666;
            font-size: 1.1rem;
        }

        @media (max-width: 768px) {
            .section-title h2 {
                font-size: 2rem;
            }

            .section-title p {
                font-size: 1rem;
                padding: 0 15px;
            }

            .konselor-section {
                padding: 40px 0;
            }

            .konselor-body {
                padding: 20px;
            }

            .warning-card {
                flex-direction: column;
                text-align: center;
                margin: 0 15px;
            }

            .warning-card i {
                margin-right: 0;
                margin-bottom: 15px;
            }

            .warning-content h5 {
                margin-bottom: 10px;
            }
        }
    </style>
</head>

<body>
    @include('frontend.layouts.navbar')

    <div class="konselor-section">
        <div class="container">
            <div class="section-title">
                <h2>Konselor Tersedia</h2>

            </div>

            <!-- Warning Section -->
            <div class="warning-section">
                <div class="warning-card">
                    <i class="fas fa-info-circle"></i>
                    <div class="warning-content">
                        <h5>Informasi Penting</h5>
                        <p>Konselor hanya muncul sesuai dengan jam aktif mereka. Jika konselor yang Anda cari tidak
                            muncul, kemungkinan konselor tersebut sedang tidak aktif saat ini.</p>
                    </div>
                </div>
            </div>

            @if ($konselors->count() > 0)
                <div class="row">
                    @foreach ($konselors as $konselor)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="konselor-card">
                                @if ($konselor->gambar_konselor)
                                    <img src="{{ asset($konselor->gambar_konselor) }}" alt="{{ $konselor->user_name }}"
                                        class="konselor-image">
                                @else
                                    <div class="konselor-image d-flex align-items-center justify-content-center"
                                        style="background: var(--medium-color);">
                                        <i class="fas fa-user-tie fa-4x text-white"></i>
                                    </div>
                                @endif

                                <div class="konselor-body">
                                    <h4 class="konselor-name">{{ $konselor->user_name }}</h4>
                                    <div class="konselor-type">{{ $konselor->jenis_konselor }}</div>
                                    <p class="konselor-description">{{ $konselor->deskripsi }}</p>

                                    <div class="konselor-time">
                                        <i class="fas fa-clock"></i>
                                        <span>Aktif: {{ date('H:i', strtotime($konselor->jam_aktif_awal)) }} -
                                            {{ date('H:i', strtotime($konselor->jam_aktif_akhir)) }}</span>
                                    </div>

                                    <a href="{{ route('konselor.detail', $konselor->id) }}" class="btn-konsultasi">
                                        <i class="fas fa-comments me-2"></i>Mulai Konsultasi
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="no-konselor">
                            <i class="fas fa-clock"></i>
                            <h3>Tidak Ada Konselor Aktif</h3>
                            <p>Saat ini tidak ada konselor yang sedang aktif. Silakan kembali lagi nanti atau hubungi
                                admin untuk informasi lebih lanjut.</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @include('frontend.layouts.footer')
    @include('frontend.layouts.script')
</body>

</html>
