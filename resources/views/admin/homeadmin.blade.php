@extends('admin.layouts.tamplate')

@section('title', 'Dashboard')
@section('content')

@section('css')
    <link rel="stylesheet" href="{{ asset('style/homeadmin.css') }}">
@endsection

<div class="dashboard-container">
    <div class="welcome-section">
        <h2 class="text-success">{{ __('Halo, selamat datang') }} <span class="user-name">{{ Auth::user()->name }}</span>!
        </h2>
        <p>
            {{ __('Senang bertemu kembali. Anda kini berada di dashboard sistem manajemen. Berikut ringkasan aktivitas Anda hari ini.') }}
        </p>
    </div>
</div>
@if (auth()->user()->role == 2)
    <div class="container-fluid dashboard-container">
        <div class="row">

            <!-- Statistik Ringkasan -->
            <div class="col-md-6">
                <div class="card chart-card category-card">
                    <div class="card-header card-header-custom">
                        <h5>
                            <i class="fas fa-tags chart-icon"></i>
                            Statistik Ringkasan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Total Laporan -->
                            <div class="col-md-6 mb-3">
                                <div class="card stats-card total-laporan">
                                    <div class="card-body text-center">
                                        <div class="stats-icon mb-3">
                                            <i class="fas fa-file-alt"></i>
                                        </div>
                                        <h3 class="stats-value">{{ $totalLaporan ?? 0 }}</h3>
                                        <p class="stats-title">Total Laporan</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Dalam Proses -->
                            <div class="col-md-6 mb-3">
                                <div class="card stats-card dalam-proses">
                                    <div class="card-body text-center">
                                        <div class="stats-icon mb-3">
                                            <i class="fas fa-hourglass-half"></i>
                                        </div>
                                        <h3 class="stats-value">{{ $totalDalamProses ?? 0 }}</h3>
                                        <p class="stats-title">Dalam Proses</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Selesai Ditangani -->
                            <div class="col-md-6 mb-3">
                                <div class="card stats-card selesai">
                                    <div class="card-body text-center">
                                        <div class="stats-icon mb-3">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <h3 class="stats-value">{{ $totalSelesai ?? 0 }}</h3>
                                        <p class="stats-title">Selesai Ditangani</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Ditolak -->
                            <div class="col-md-6 mb-3">
                                <div class="card stats-card ditolak">
                                    <div class="card-body text-center">
                                        <div class="stats-icon mb-3">
                                            <i class="fas fa-times-circle"></i>
                                        </div>
                                        <h3 class="stats-value">{{ $totalDitolak ?? 0 }}</h3>
                                        <p class="stats-title">Ditolak</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category Report Chart -->
            <div class="col-md-6 mb-4">
                <div class="card chart-card category-card">
                    <div class="card-header card-header-custom">
                        <h5>
                            <i class="fas fa-tags chart-icon"></i>
                            Laporan per Kategori
                        </h5>
                    </div>
                    <div class="card-body card-body-custom">
                        <div class="chart-container">
                            <canvas id="categoryChart"></canvas>
                        </div>
                        <div class="stats-info">
                            <div class="stats-item">
                                <div class="stats-number">{{ $categoryData->count() }}</div>
                                <div class="stats-label">Kategori</div>
                            </div>
                            <div class="stats-item">
                                <div class="stats-number">{{ $categoryData->sum('total') }}</div>
                                <div class="stats-label">Total Laporan</div>
                            </div>
                            <div class="stats-item">
                                <div class="stats-number">
                                    {{ $categoryData->count() > 0 ? round($categoryData->sum('total') / $categoryData->count()) : 0 }}
                                </div>
                                <div class="stats-label">Rata-rata</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gender Distribution Chart -->
            <div class="col-md-6 mb-4">
                <div class="card chart-card gender-card">
                    <div class="card-header card-header-custom">
                        <h5>
                            <i class="fas fa-venus-mars chart-icon"></i>
                            Distribusi Gender User
                        </h5>
                    </div>
                    <div class="card-body card-body-custom">
                        <div class="chart-container">
                            <canvas id="genderChart"></canvas>
                        </div>
                        <div class="stats-info">
                            <div class="stats-item">
                                <div class="stats-number" id="totalGender">{{ $genderData->sum('total') }}</div>
                                <div class="stats-label">Total User</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Monthly Trend Chart -->
            <div class="col-md-6">
                <div class="card chart-card monthly-card">
                    <div class="card-header card-header-custom">
                        <h5>
                            <i class="fas fa-calendar-alt chart-icon"></i>
                            Tren Laporan Bulanan
                        </h5>
                    </div>
                    <div class="card-body card-body-custom">
                        <div class="chart-container">
                            <canvas id="monthlyChart"></canvas>
                        </div>
                        <div class="stats-info">
                            <div class="stats-item">
                                <div class="stats-number">{{ $monthlyData->count() }}</div>
                                <div class="stats-label">Bulan Tercatat</div>
                            </div>
                            <div class="stats-item">
                                <div class="stats-number">
                                    @if ($monthlyData->count() > 0)
                                        {{ \Carbon\Carbon::create()->month($monthlyData->sortByDesc('total')->first()->bulan)->format('M') }}
                                    @else
                                        -
                                    @endif
                                </div>
                                <div class="stats-label">Bulan Tertinggi</div>
                            </div>
                            <div class="stats-item">
                                <div class="stats-number">
                                    {{ $monthlyData->count() > 0 ? round($monthlyData->sum('total') / $monthlyData->count()) : 0 }}
                                </div>
                                <div class="stats-label">Rata-rata/Bulan</div>
                            </div>
                            <div class="stats-item">
                                <div class="stats-number">
                                    @php
                                        $trend = '📊';
                                        if ($monthlyData->count() >= 2) {
                                            $last = $monthlyData->last()->total;
                                            $prev = $monthlyData->slice(-2, 1)->first()->total ?? $last;
                                            $trend = $last > $prev ? '📈' : ($last < $prev ? '📉' : '📊');
                                        }
                                    @endphp
                                    {{ $trend }}
                                </div>
                                <div class="stats-label">Tren</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endif


@endsection

@section('js')
<script>
    const genderChart = new Chart(document.getElementById('genderChart'), {
        type: 'pie',
        data: {
            labels: {!! json_encode($genderData->pluck('gender')) !!},
            datasets: [{
                data: {!! json_encode($genderData->pluck('total')) !!},
                backgroundColor: ['#36A2EB', '#FF6384']
            }]
        }
    });

    // Category Chart
    const categoryChart = new Chart(document.getElementById('categoryChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($categoryData->pluck('nama_category')) !!},
            datasets: [{
                label: 'Jumlah Laporan',
                data: {!! json_encode($categoryData->pluck('total')) !!},
                backgroundColor: '#4BC0C0'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Monthly Chart
  const monthlyChart = new Chart(document.getElementById('monthlyChart'), {
    type: 'line',
    data: {
        labels: {!! json_encode(
            $monthlyData->pluck('bulan')->map(function ($m) {
                return \Carbon\Carbon::create()->month($m)->format('M');
            }),
        ) !!},
        datasets: [{
            label: 'Jumlah Laporan',
            data: {!! json_encode($monthlyData->pluck('total')) !!},
            fill: false,
            borderColor: 'purple',
            backgroundColor: 'purple',
            borderWidth: 2,
            tension: 0.4,
            pointBackgroundColor: 'white',
            pointBorderColor: 'purple',
            pointBorderWidth: 2,
            pointRadius: 4
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: true,
                labels: {
                    boxWidth: 12
                }
            }
        },
        scales: {
            x: {
                grid: {
                    display: true,
                    color: '#e0e0e0'
                }
            },
            y: {
                beginAtZero: true,
                grid: {
                    display: true,
                    color: '#e0e0e0'
                }
            }
        }
    }
});

</script>
@endsection
