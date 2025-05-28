@extends('admin.layouts.tamplate')

@section('title', 'Laporan Masuk')

@section('css')
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #64748b;
            --success-color: #059669;
            --warning-color: #d97706;
            --light-bg: #f8fafc;
            --border-color: #e2e8f0;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
        }

        /* Modal Content */
        .modal-content {
            border: none;
            border-radius: 16px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
        }

        /* Modal Header */
        .modal-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, #3b82f6 100%);
            color: white;
            border: none;
            padding: 1.5rem 2rem;
            position: relative;
        }

        .modal-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.1;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 0;
            position: relative;
            z-index: 1;
        }

        .btn-close {
            filter: brightness(0) invert(1);
            opacity: 0.8;
            position: relative;
            z-index: 1;
        }

        .btn-close:hover {
            opacity: 1;
        }

        /* Modal Body */
        .modal-body {
            padding: 2rem;
            background-color: #ffffff;
        }

        /* Styling untuk Section 1 - Info */
        .modal-body .mb-3:first-child {
            background: var(--light-bg);
            border-radius: 12px;
            padding: 1.5rem;
            border-left: 4px solid var(--primary-color);
            line-height: 1.8;
        }

        .modal-body .mb-3:first-child strong {
            color: var(--text-primary);
            font-weight: 600;
            display: inline-block;
            min-width: 80px;
        }

        /* HR Styling */
        .modal-body hr {
            border: none;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--border-color), transparent);
            margin: 2rem 0;
        }

        /* Description Box - yang ada class border rounded p-2 */
        .border.rounded.p-2 {
            background: #ffffff !important;
            border: 2px solid var(--border-color) !important;
            border-radius: 12px !important;
            padding: 1.25rem !important;
            font-size: 0.95rem;
            line-height: 1.6;
            color: var(--text-primary);
            position: relative;
            transition: border-color 0.3s ease;
        }

        /* Form Check Styling */
        .form-check {
            margin-bottom: 0.75rem !important;
            padding: 0.75rem;
            background: var(--light-bg);
            border-radius: 8px;
            border: 1px solid transparent;
            transition: all 0.3s ease;
        }

        .form-check:hover {
            background: #f1f5f9;
            border-color: var(--border-color);
        }

        .form-check-input:checked {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
        }

        .form-check-label {
            font-size: 0.95rem;
            color: var(--text-primary);
            cursor: pointer;
            font-weight: 500;
        }

        /* Form Control */
        .form-control {
            border-radius: 8px !important;
            border: 2px solid var(--border-color) !important;
            padding: 0.75rem 1rem !important;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.15) !important;
        }

        .form-label {
            font-weight: 600 !important;
            color: var(--text-primary) !important;
            margin-bottom: 0.75rem !important;
            font-size: 0.95rem;
        }

        /* Modal Footer */
        .modal-footer {
            background: var(--light-bg) !important;
            border: none !important;
            padding: 1.5rem 2rem !important;
        }

        /* Button Styling */
        .modal-footer .btn {
            padding: 0.75rem 1.5rem !important;
            font-weight: 500 !important;
            border-radius: 8px !important;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, #3b82f6 100%) !important;
            border: none !important;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4) !important;
            background: linear-gradient(135deg, #1d4ed8 0%, var(--primary-color) 100%) !important;
        }

        .btn-secondary {
            background: #ffffff !important;
            border: 2px solid var(--border-color) !important;
            color: var(--text-secondary) !important;
        }

        .btn-secondary:hover {
            background: var(--light-bg) !important;
            border-color: var(--secondary-color) !important;
            color: var(--text-primary) !important;
        }

        /* Badge Styling */
        .badge {
            padding: 0.5rem 1rem !important;
            font-size: 0.8rem !important;
            font-weight: 500 !important;
            border-radius: 20px !important;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .bg-warning {
            background: linear-gradient(135deg, #f59e0b 0%, var(--warning-color) 100%) !important;
        }

        .bg-success {
            background: linear-gradient(135deg, #10b981 0%, var(--success-color) 100%) !important;
        }

        /* Untuk Modal Detail - styling khusus hasil tindak lanjut */
        #modalDetailLaporan .modal-body .mb-3:last-child {
            background: #f0f9ff;
            border-radius: 12px;
            padding: 1.5rem;
            border-left: 4px solid var(--success-color);
            margin-top: 1rem;
        }

        #modalDetailLaporan .modal-body .mb-3:last-child strong {
            color: var(--text-primary);
            font-weight: 600;
            display: inline-block;
            min-width: 140px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .modal-dialog {
                margin: 1rem !important;
            }

            .modal-body {
                padding: 1.5rem !important;
            }

            .modal-body .mb-3:first-child {
                padding: 1rem !important;
            }
        }

        /* Styling untuk textarea yang sudah ada */
        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        /* Styling untuk radio button container */
        .modal-body .mb-3:has(.form-check) {
            background: #ffffff;
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid var(--border-color);
            margin-bottom: 1.5rem;
        }

        /* Label untuk radio buttons */
        .modal-body .form-label:has(+ br) {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1rem;
        }
    </style>
@endsection

@section('content')
    <div class="container mt-1">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between">
                <h4>Laporan Masuk</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover nowrap" id="DataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>id Pelapor</th>
                                <th>Tanggal</th>
                                <th>Pelapor</th>
                                <th>Jenis Kasus</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($laporanMasuk as $key => $laporan)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $laporan->id_pelapor ?? '-' }}</td>
                                    <td>{{ $laporan->created_at ?? '-' }}</td>
                                    <td>{{ $laporan->nama ?? 'Anonim' }}</td>
                                    <td>{{ $laporan->judul ?? '-' }}</td>
                                    <td>
                                        @if ($laporan->status_jawab == 0)
                                            <span class="badge bg-warning text-white">Proses</span>
                                        @else
                                            <span class="badge bg-success text-white">Selesai</span>
                                        @endif
                                    </td>
                                    <td>

                                        <div class="btn-group">
                                            @if ($laporan->status_jawab == 0)
                                                <button class="btn btn-warning btn-sm rounded-pill btn-tindaklanjut"
                                                    data-id="{{ $laporan->jawab_id }}">Tindak Lanjuti</button>
                                            @else
                                                <button class="btn btn-success btn-sm rounded-pill btn-detail"
                                                    data-id="{{ $laporan->jawab_id }}">Detail</button>
                                            @endif
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalTindakLanjut" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="formTindakLanjut">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Laporan: <span id="modal-id-pelapor"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Section 1 -->
                        <div class="mb-3">
                            <strong>Nama:</strong> <span id="modal-nama"></span><br>
                            <strong>No HP:</strong> <span id="modal-nohp"></span><br>
                            <strong>Email:</strong> <span id="modal-email"></span><br>
                            <strong>Judul:</strong> <span id="modal-judul"></span><br>
                            <strong>Status:</strong> <span class="badge bg-warning">Proses</span>
                        </div>
                        <hr>
                        <!-- Section 2 -->
                        <div class="mb-3">
                            <strong>Detail Kejadian:</strong>
                            <div class="border rounded p-2" id="modal-deskripsi" style="min-height:100px"></div>
                        </div>
                        <hr>
                        <!-- Section 3 -->
                        <div class="mb-3">
                            <label class="form-label">Tindak Lanjut:</label><br>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tindak_lanjut" value="Konseling"
                                    required>
                                <label class="form-check-label">Konseling</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tindak_lanjut"
                                    value="Rujukan ke Klinik">
                                <label class="form-check-label">Rujukan ke Klinik</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tindak_lanjut" value="Bantuan Hukum">
                                <label class="form-check-label">Bantuan Hukum</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="catatan_tindak_lanjut" class="form-label">Catatan Tindak Lanjut:</label>
                            <textarea name="catatan_tindak_lanjut" class="form-control" rows="3" required></textarea>
                        </div>
                        <input type="hidden" name="jawab_id" id="jawab-id-hidden">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- detail laporan --}}
    <div class="modal fade" id="modalDetailLaporan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Laporan: <span id="detail-id-pelapor"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <!-- Section 1 -->
                    <div class="mb-3">
                        <strong>Nama:</strong> <span id="detail-nama"></span><br>
                        <strong>No HP:</strong> <span id="detail-nohp"></span><br>
                        <strong>Email:</strong> <span id="detail-email"></span><br>
                        <strong>Judul:</strong> <span id="detail-judul"></span><br>
                        <strong>Status:</strong> <span id="detail-status"></span>
                    </div>
                    <hr>
                    <!-- Section 2 -->
                    <div class="mb-3">
                        <strong>Detail Kejadian:</strong>
                        <div class="border rounded p-2" id="detail-deskripsi" style="min-height:100px"></div>
                    </div>
                    <hr>
                    <!-- Section 3 -->
                    <div class="mb-3">
                        <strong>Tindak Lanjut:</strong> <span id="detail-tindak-lanjut"></span><br>
                        <strong>Catatan Tindak Lanjut:</strong>
                        <div class="border rounded p-2 mt-1" id="detail-catatan-tindak-lanjut" style="min-height:80px">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('js')
    <script>
        $(document).ready(function() {

            $('.btn-tindaklanjut').click(function() {
                let id = $(this).data('id');
                $.get('/stackholder/laporan/' + id, function(data) {
                    $('#modal-id-pelapor').text(data.id_pelapor);
                    $('#modal-nama').text(data.nama ?? 'Anonim');
                    $('#modal-nohp').text(data.no_hp ?? 'Anonim');
                    $('#modal-email').text(data.email ?? 'Anonim');
                    $('#modal-judul').text(data.judul);
                    $('#modal-deskripsi').text(data.deskripsi);
                    $('#jawab-id-hidden').val(id);
                    $('#modalTindakLanjut').modal('show');
                });
            });

            // Submit form tindak lanjut
            $('#formTindakLanjut').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: '/stackholder/tindaklanjut/simpan',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(res) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Tindak lanjut berhasil disimpan.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            $('#modalTindakLanjut').modal('hide');
                            location.reload();
                        });
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Gagal menyimpan data. Coba lagi.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            $('.btn-detail').click(function() {
                let id = $(this).data('id');
                $.get('/stackholder/laporan/detail/' + id, function(data) {
                    $('#detail-id-pelapor').text(data.id_pelapor);
                    $('#detail-nama').text(data.nama ?? 'Anonim');
                    $('#detail-nohp').text(data.no_hp ?? 'Anonim');
                    $('#detail-email').text(data.email ?? 'Anonim');
                    $('#detail-judul').text(data.judul);
                    $('#detail-deskripsi').text(data.deskripsi);
                    $('#detail-tindak-lanjut').text(data.tindak_lanjut ?? '-');
                    $('#detail-catatan-tindak-lanjut').text(data.catatan_tindak_lanjut ?? '-');

                    const statusBadge = data.status_jawab == 0 ?
                        '<span class="badge bg-warning">Proses</span>' :
                        '<span class="badge bg-success">Selesai</span>';
                    $('#detail-status').html(statusBadge);

                    $('#modalDetailLaporan').modal('show');
                });
            });


        });
    </script>
@endsection
