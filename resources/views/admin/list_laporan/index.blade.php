@extends('admin.layouts.tamplate')

@section('title', 'List Laporan')

@section('css')
    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #f8fafc;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --text-color: #1f2937;
            --border-color: #e5e7eb;
        }

        .modal-content {
            border: none;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, #6366f1 100%);
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
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="1" fill="white" opacity="0.1"/><circle cx="10" cy="90" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            pointer-events: none;
        }

        .modal-title {
            font-weight: 700;
            font-size: 1.5rem;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            position: relative;
            z-index: 1;
        }

        .modal-title::before {
            content: '\f15c';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            color: rgba(255, 255, 255, 0.9);
        }

        .btn-close {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
        }

        .btn-close:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(90deg);
        }

        .modal-body {
            padding: 2rem;
            background: var(--secondary-color);
        }

        .detail-section {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .detail-section:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px -8px rgba(0, 0, 0, 0.15);
        }

        .section-title {
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 1rem;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e5e7eb;
        }

        .detail-row {
            display: flex;
            margin-bottom: 1rem;
            align-items: flex-start;
        }

        .detail-row:last-child {
            margin-bottom: 0;
        }

        .detail-label {
            font-weight: 600;
            color: var(--text-color);
            min-width: 140px;
            flex-shrink: 0;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .detail-value {
            flex: 1;
            color: #6b7280;
            line-height: 1.6;
            word-break: break-word;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fbbf24;
        }

        .status-verified {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #10b981;
        }

        .status-rejected {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #ef4444;
        }

        .bukti-container {
            margin-top: 0.5rem;
        }

        .bukti-image {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
            cursor: pointer;
            max-height: 250px;
            width: auto;
        }

        .bukti-image:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .pdf-button {
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }

        .pdf-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(220, 38, 38, 0.4);
            color: white;
            text-decoration: none;
        }

        .anonymous-text {
            color: #9ca3af;
            font-style: italic;
            background: #f3f4f6;
            padding: 0.375rem 0.75rem;
            border-radius: 8px;
            display: inline-block;
        }

        .no-content {
            color: #9ca3af;
            font-style: italic;
            background: #f9fafb;
            padding: 0.75rem;
            border-radius: 8px;
            text-align: center;
            border: 1px dashed #d1d5db;
        }

        .modal-dialog-scrollable .modal-body {
            max-height: calc(100vh - 200px);
        }

        @media (max-width: 768px) {
            .modal-body {
                padding: 1rem;
            }

            .detail-section {
                padding: 1rem;
                margin-bottom: 1rem;
            }

            .detail-row {
                flex-direction: column;
                gap: 0.25rem;
            }

            .detail-label {
                min-width: auto;
                font-weight: 700;
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endsection

@section('content')
    <div class="container mt-1">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between">
                <h4>List Laporan Anda</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover nowrap" id="DataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>id Pelapor</th>
                                <th>Judul</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listLaporans as $key => $listLaporan)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $listLaporan->id_pelapor ?? '-' }}</td>
                                    <td>{{ $listLaporan->judul ?? '-' }}</td>
                                    <td>{{ $listLaporan->nama_category ?? '-' }}</td>
                                    <td>
                                        @if ($listLaporan->status == 0)
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif ($listLaporan->status == 1)
                                            <span class="badge bg-success">Diverifikasi</span>
                                        @elseif ($listLaporan->status == 2)
                                            <span class="badge bg-danger">Ditolak</span>
                                        @else
                                            <span class="badge bg-secondary">Unknown</span>
                                        @endif
                                    </td>
                                    <td>

                                        <div class="btn-group">
                                            <a href="javascript:void(0);" class="btn btn-warning btn-detail"
                                                data-id="{{ $listLaporan->id }}">
                                                <i class="mdi mdi-eye me-2"></i> Detail
                                            </a>

                                            <form action="{{ route('list.laporan.destroy', $listLaporan->id) }}"
                                                method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger  btn-delete"
                                                    data-name="{{ $listLaporan->judul }}">
                                                    <i class="mdi mdi-delete me-2"></i> Delete
                                                </button>
                                            </form>
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

    <!-- Modal Detail Laporan -->
    <div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Laporan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <!-- Informasi Utama -->
                    <div class="detail-section fade-in">
                        <div class="section-title">
                            <i class="fas fa-info-circle"></i>
                            Informasi Laporan
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">
                                <i class="fas fa-hashtag"></i>
                                ID Pelapor
                            </div>
                            <div class="detail-value" id="detail-id-pelapor"></div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">
                                <i class="fas fa-heading"></i>
                                Judul
                            </div>
                            <div class="detail-value" id="detail-judul"></div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">
                                <i class="fas fa-tag"></i>
                                Kategori
                            </div>
                            <div class="detail-value" id="detail-kategori"></div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">
                                <i class="fas fa-file-alt"></i>
                                Detail Kejadian
                            </div>
                            <div class="detail-value" id="detail-deskripsi"></div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">
                                <i class="fas fa-flag"></i>
                                Status
                            </div>
                            <div class="detail-value" id="detail-status"></div>
                        </div>
                    </div>

                    <!-- Bukti -->
                    <div class="detail-section fade-in">
                        <div class="section-title">
                            <i class="fas fa-camera"></i>
                            Bukti Pendukung
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">
                                <i class="fas fa-paperclip"></i>
                                Bukti
                            </div>
                            <div class="detail-value bukti-container" id="detail-bukti"></div>
                        </div>
                    </div>

                    <!-- Data Pelapor -->
                    <div class="detail-section fade-in">
                        <div class="section-title">
                            <i class="fas fa-user"></i>
                            Data Pelapor
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">
                                <i class="fas fa-user-circle"></i>
                                Nama
                            </div>
                            <div class="detail-value" id="detail-nama"></div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">
                                <i class="fas fa-phone"></i>
                                No HP
                            </div>
                            <div class="detail-value" id="detail-nohp"></div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">
                                <i class="fas fa-envelope"></i>
                                Email
                            </div>
                            <div class="detail-value" id="detail-email"></div>
                        </div>
                    </div>

                    <!-- Catatan Admin -->
                    <div class="detail-section fade-in">
                        <div class="section-title">
                            <i class="fas fa-sticky-note"></i>
                            Catatan Admin
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">
                                <i class="fas fa-comment"></i>
                                Catatan
                            </div>
                            <div class="detail-value" id="detail-catatan"></div>
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

            $('.btn-detail').on('click', function() {
                let id = $(this).data('id');

                $.ajax({
                    url: `/detail-pelapor/${id}`,
                    method: 'GET',
                    success: function(data) {
                        $('#detail-id-pelapor').text(data.id_pelapor);
                        $('#detail-judul').text(data.judul);
                        $('#detail-kategori').text(data.nama_category);
                        $('#detail-deskripsi').text(data.deskripsi);

                        let statusText = '';
                        switch (data.status) {
                            case 0:
                                statusText = 'Menunggu Verifikasi';
                                break;
                            case 1:
                                statusText = 'Diverifikasi';
                                break;
                            case 2:
                                statusText = 'Ditolak';
                                break;
                            default:
                                statusText = 'Tidak diketahui';
                        }
                        $('#detail-status').text(statusText);

                        // Bukti (gambar atau pdf)
                        let buktiHtml = '';
                        if (data.bukti) {
                            let ext = data.bukti.split('.').pop().toLowerCase();
                            if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
                                buktiHtml =
                                    `<img src="/storage/${data.bukti}" class="img-fluid rounded" alt="Bukti Gambar" style="max-height:300px;">`;
                            } else if (ext === 'pdf') {
                                buktiHtml =
                                    `<a href="/storage/${data.bukti}" target="_blank" class="btn btn-sm btn-primary">Lihat PDF</a>`;
                            } else {
                                buktiHtml =
                                    `<a href="/storage/${data.bukti}" target="_blank">${data.bukti}</a>`;
                            }
                        } else {
                            buktiHtml = 'Tidak ada bukti';
                        }
                        $('#detail-bukti').html(buktiHtml);

                        // Data pribadi
                        $('#detail-nama').text(data.nama ? data.nama : 'Anonim');
                        $('#detail-nohp').text(data.no_hp ? data.no_hp : 'Anonim');
                        $('#detail-email').text(data.email ? data.email : 'Anonim');

                        // Catatan
                        $('#detail-catatan').text(data.catatan ? data.catatan :
                            'Belum ada catatan dari admin');

                        // Tampilkan modal
                        $('#modalDetail').modal('show');
                    },
                    error: function() {
                        alert('Gagal memuat detail laporan');
                    }
                });
            });


            $('.btn-delete').on('click', function(e) {
                e.preventDefault();
                let form = $(this).closest('form');
                let name = $(this).data('name') || 'Category ini';

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: `Data ${name} akan dihapus secara permanen.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection
