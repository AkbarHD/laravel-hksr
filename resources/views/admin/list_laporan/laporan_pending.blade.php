@extends('admin.layouts.tamplate')

@section('title', 'List Laporan Pending')

@section('css')
    <link rel="stylesheet" href="{{ asset('style/laporan_pending.css') }}">
@endsection

@section('content')
    <div class="container ">
        <!-- Header Card -->
        <div class="card main-header-card mb-4 fade-in">
            <div class="card-body p-4">
                <div class="header-title">
                    <div class="icon-wrapper">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                    <div>
                        <h3 class="mb-1">List Laporan Pending</h3>
                        <p class="mb-0 opacity-75">
                            <i class="fas fa-info-circle me-2"></i>
                            Kelola laporan yang menunggu verifikasi
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reports Grid -->
        <div class="row">
            @foreach ($laporanPending as $laporan)
                <div class="col-md-6 col-lg-6 fade-in">
                    <div class="card report-card mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <span class="badge badge-warning-custom">
                                    <i class="fas fa-clock me-1"></i>
                                    Menunggu Verifikasi
                                </span>
                            </div>

                            <h5 class="card-title">
                                <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                {{ $laporan->judul }}
                            </h5>

                            <p class="card-text text-muted mb-3" style="line-height: 1.6;">
                                {{ Str::limit($laporan->deskripsi, 150) }}
                            </p>

                            <div class="mb-3">
                                <span class="badge badge-category-custom">
                                    <i class="fas fa-tag category-icon"></i>
                                    {{ $laporan->nama_category }}
                                </span>
                            </div>

                            <div class="date-info">
                                <div class="d-flex align-items-center text-muted">
                                    <i class="mdi mdi-calendar me-2 text-primary"></i>
                                    <strong>Dilaporkan:</strong>
                                    <span
                                        class="ms-2">{{ \Carbon\Carbon::parse($laporan->created_at)->translatedFormat('d M Y') }}</span>
                                </div>
                            </div>

                            <div class="d-flex action-buttons">
                                <button class="btn btn-action btn-success-custom btn-verifikasi"
                                    data-id="{{ $laporan->id }}">
                                    <i class="fas fa-check me-2"></i>Verifikasi
                                </button>

                                <button class="btn btn-action btn-danger-custom btn-tolak" data-id="{{ $laporan->id }}">
                                    <i class="fas fa-times me-2"></i>Tolak
                                </button>
                                <button class="btn btn-action btn-secondary-custom btn-detail" data-id="{{ $laporan->id }}"
                                    data-bs-toggle="modal" data-bs-target="#modalDetail">
                                    <i class="fas fa-eye me-2"></i>Detail
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal Verifikasi -->
    <div class="modal fade" id="verifikasiModal" tabindex="-1" aria-labelledby="verifikasiModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="formVerifikasi" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Verifikasi Laporan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin memverifikasi laporan ini? Laporan yang terverifikasi akan
                            ditindaklanjuti sesuai prosedur.</p>
                        <div class="mb-3">
                            <label for="catatanVerifikasi" class="form-label">Catatan Verifikasi</label>
                            <textarea class="form-control" name="catatan" id="catatanVerifikasi" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary-custom" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success-custom">Verifikasi</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!-- Modal Tolak -->
    <div class="modal fade" id="tolakModal" tabindex="-1" aria-labelledby="tolakModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="formTolak" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tolak Laporan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menolak laporan ini? Harap berikan alasan penolakan yang jelas.</p>
                        <div class="mb-3">
                            <label for="catatanVerifikasi" class="form-label">Catatan Penolakan</label>
                            <textarea class="form-control" name="catatan" id="catatanVerifikasi" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary-custom" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger-custom">Tolak</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Detail -->
    <div class="modal fade modal-detail" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-file-alt me-3"></i>
                        Detail Laporan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Kolom Kiri -->
                        <div class="col-md-6">
                            <!-- ID Pelaporan -->
                            <div class="detail-item left animate-left" style="animation-delay: 0.1s;">
                                <div class="detail-label">
                                    <div class="detail-icon icon-id">
                                        <i class="fas fa-hashtag"></i>
                                    </div>
                                    ID Pelaporan
                                </div>
                                <div class="detail-value" id="detail-id-pelapor">#LP001</div>
                            </div>

                            <!-- Kategori -->
                            <div class="detail-item left animate-left" style="animation-delay: 0.3s;">
                                <div class="detail-label">
                                    <div class="detail-icon icon-category">
                                        <i class="fas fa-tag"></i>
                                    </div>
                                    Kategori
                                </div>
                                <div class="detail-value" id="detail-kategori">Infrastruktur</div>
                            </div>

                            <!-- Status -->
                            <div class="detail-item left animate-left" style="animation-delay: 0.5s;">
                                <div class="detail-label">
                                    <div class="detail-icon icon-status">
                                        <i class="fas fa-info-circle"></i>
                                    </div>
                                    Status
                                </div>
                                <div class="detail-value">
                                    <span class="status-badge status-pending" id="detail-status">Menunggu
                                        Verifikasi</span>
                                </div>
                            </div>

                            <!-- Nama Pelapor -->
                            <div class="detail-item left animate-left" style="animation-delay: 0.7s;">
                                <div class="detail-label">
                                    <div class="detail-icon icon-name">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    Nama Pelapor
                                </div>
                                <div class="detail-value" id="detail-nama">John Doe</div>
                            </div>

                            <!-- Email -->
                            <div class="detail-item left animate-left" style="animation-delay: 0.9s;">
                                <div class="detail-label">
                                    <div class="detail-icon icon-email">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    Email
                                </div>
                                <div class="detail-value" id="detail-email">john@example.com</div>
                            </div>
                        </div>

                        <!-- Kolom Kanan -->
                        <div class="col-md-6">
                            <!-- Judul -->
                            <div class="detail-item right animate-right" style="animation-delay: 0.2s;">
                                <div class="detail-label">
                                    <div class="detail-icon icon-title">
                                        <i class="fas fa-heading"></i>
                                    </div>
                                    Judul Laporan
                                </div>
                                <div class="detail-value" id="detail-judul">Kerusakan Jalan Raya</div>
                            </div>

                            <!-- Detail Kejadian -->
                            <div class="detail-item right animate-right" style="animation-delay: 0.4s;">
                                <div class="detail-label">
                                    <div class="detail-icon icon-description">
                                        <i class="fas fa-align-left"></i>
                                    </div>
                                    Detail Kejadian
                                </div>
                                <div class="detail-value" id="detail-deskripsi">Jalan mengalami kerusakan parah...</div>
                            </div>

                            <!-- Bukti -->
                            <div class="detail-item right animate-right" style="animation-delay: 0.6s;">
                                <div class="detail-label">
                                    <div class="detail-icon icon-evidence">
                                        <i class="fas fa-image"></i>
                                    </div>
                                    Bukti
                                </div>
                                <div class="detail-value" id="detail-bukti">
                                    <span class="no-evidence">Tidak ada bukti</span>
                                </div>
                            </div>

                            <!-- No HP -->
                            <div class="detail-item right animate-right" style="animation-delay: 0.8s;">
                                <div class="detail-label">
                                    <div class="detail-icon icon-phone">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    No HP
                                </div>
                                <div class="detail-value" id="detail-nohp">08123456789</div>
                            </div>

                            <!-- Catatan -->
                            <div class="detail-item right animate-right" style="animation-delay: 1.0s;">
                                <div class="detail-label">
                                    <div class="detail-icon icon-notes">
                                        <i class="fas fa-sticky-note"></i>
                                    </div>
                                    Catatan
                                </div>
                                <div class="detail-value" id="detail-catatan">-</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection

@section('js')
    <script>
        $(document).ready(function() {

            // Tombol Verifikasi
            $('.btn-verifikasi').on('click', function() {
                let id = $(this).data('id');
                $('#formVerifikasi').attr('action', `/laporan/${id}/verifikasi`);
                $('#verifikasiModal').modal('show');
            });

            // Tombol Tolak
            $('.btn-tolak').on('click', function() {
                let id = $(this).data('id');
                $('#formTolak').attr('action', `/laporan/${id}/tolak`);
                $('#tolakModal').modal('show');
            });

            $('.btn-detail').on('click', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: '/laporan/ajax/detail/' + id,
                    type: 'GET',
                    success: function(data) {
                        $('#detail-id-pelapor').text(data.id_pelapor);
                        $('#detail-judul').text(data.judul);
                        $('#detail-kategori').text(data.nama_category);
                        $('#detail-deskripsi').text(data.deskripsi);

                        // Status dengan styling
                        var statusClass = 'status-pending';
                        if (data.status_text === 'Terverifikasi') {
                            statusClass = 'status-verified';
                        } else if (data.status_text === 'Ditolak') {
                            statusClass = 'status-rejected';
                        }

                        $('#detail-status').removeClass(
                                'status-pending status-verified status-rejected')
                            .addClass(statusClass)
                            .text(data.status_text);

                        // Bukti dengan styling
                        if (data.bukti) {
                            $('#detail-bukti').html(
                                `<a href="/storage/${data.bukti}" target="_blank" class="evidence-link">
                            <i class="fas fa-external-link-alt me-2"></i>Lihat Bukti
                        </a>`
                            );
                        } else {
                            $('#detail-bukti').html(
                                '<span class="no-evidence">Tidak ada bukti</span>');
                        }

                        $('#detail-nama').text(data.nama);
                        $('#detail-nohp').text(data.no_hp);
                        $('#detail-email').text(data.email);
                        $('#detail-catatan').text(data.catatan || '-');

                        // Show modal
                        $('#modalDetail').modal('show');
                    },
                    error: function() {
                        alert('Gagal memuat detail laporan.');
                    }
                });
            });
        });
    </script>
@endsection
