<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @include('frontend.layouts.head')
</head>
<style>
    .content-container {
        padding: 20px;
    }

    .form-container,
    .status-container {
        background-color: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.4);
    }

    .form-title {
        font-weight: 600;
        margin-bottom: 15px;
    }

    .form-instruction {
        font-size: 0.9rem;
        margin-bottom: 20px;
    }

    .identity-selection {
        margin-bottom: 20px;
    }

    .form-check-input {
        width: 18px;
        height: 18px;
    }

    .form-label {
        font-weight: 600;
        margin-bottom: 8px;
    }

    .form-control {
        border-radius: 5px;
        border: 1px solid #ced4da;
        padding: 10px;
    }

    textarea.form-control {
        min-height: 120px;
    }

    .upload-area {
        background-color: #e9ecef;
        border-radius: 5px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        margin-bottom: 20px;
    }

    .upload-area i {
        font-size: 1.5rem;
        margin-bottom: 10px;
    }

    .upload-text {
        color: #0d6efd;
        text-decoration: none;
    }

    .btn-submit {
        background-color: #6c757d;
        color: white;
        border: none;
        border-radius: 20px;
        padding: 8px 25px;
        font-weight: 500;
        float: right;
    }

    .status-title {
        font-weight: 600;
        margin-bottom: 20px;
    }

    .report-card {
        background-color: white;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 15px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid #f0f0f0;
    }

    .report-title {
        font-weight: 600;
        margin-bottom: 5px;
    }

    .report-date {
        font-size: 0.8rem;
        color: #6c757d;
    }

    .status-badge {
        font-size: 0.75rem;
        font-weight: 500;
        padding: 4px 10px;
        border-radius: 12px;
        float: right;
    }

    .status-processing {
        background-color: #ffc107;
        color: #856404;
    }

    .status-completed {
        background-color: #d4edda;
        color: #155724;
    }

    .status-rejected {
        background-color: #f8d7da;
        color: #721c24;
    }
</style>

<body>
    @include('frontend.layouts.navbar')

    <!-- Content -->
    <div class="content-container">
        <div class="row g-4">
            <!-- Form Section -->
            <div class="col-lg-7">
                <div class="form-container">
                    <h5 class="form-title">Form Pelaporan</h5>
                    <p class="form-instruction">Silahkan isi form berikut untuk melaporkan kejadian kekerasan seksual.
                    </p>

                    <form method="POST" action="{{ route('pelaporan.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="identity-selection mb-4">
                            <label class="form-label">Identitas Pelapor</label>
                            <div class="d-flex">
                                <div class="form-check me-4">
                                    <input class="form-check-input" type="radio" name="identityType" id="anon"
                                        value="anonim" checked>
                                    <label class="form-check-label" for="anon">
                                        Anonim
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="identityType" id="withIdentity"
                                        value="identitas">
                                    <label class="form-check-label" for="withIdentity">
                                        Dengan Identitas
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div id="identityFields" class="mb-4 d-none">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" name="nama" id="nama">
                            </div>
                            <div class="mb-3">
                                <label for="no_hp" class="form-label">No HP</label>
                                <input type="text" class="form-control" name="no_hp" id="no_hp">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="reportTitle">Judul Laporan <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                name="judul" id="reportTitle" value="{{ old('judul') }}" required>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="category_id">Kategori Laporan <span
                                    class="text-danger">*</span></label>
                            <select name="category_id" id="category_id"
                                class="form-control @error('category_id') is-invalid @enderror" required>
                                <option value="">Pilih Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->nama_category }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="deskripsi">Deskripsi Kejadian <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi" rows="4"
                                required>{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Bukti (Opsional)</label>
                            <input type="file" class="form-control @error('bukti') is-invalid @enderror"
                                name="bukti" accept=".jpg,.jpeg,.png,.pdf">
                            <div class="form-text">Format yang diizinkan: JPG, PNG, PDF. Maksimal 5MB</div>
                            @error('bukti')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Status Section -->
            <div class="col-lg-5">
                <div class="status-container">
                    <h5 class="status-title">Status Pelaporan</h5>

                    @forelse ($pelapors as $pelapor)
                        <div class="report-card">
                            @if ($pelapor->status == 0)
                                <span class="status-badge status-processing">Diproses</span>
                            @elseif ($pelapor->status == 1)
                                <span class="status-badge status-completed">Selesai</span>
                            @else
                                <span class="status-badge status-rejected">Ditolak</span>
                            @endif
                            <h6 class="report-title">{{ $pelapor->judul }}</h6>
                            <p class="report-date mt-3">
                                {{ \Carbon\Carbon::parse($pelapor->created_at)->diffForHumans() }}
                            </p>


                        </div>
                    @empty
                        <p>Tidak ada laporan.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @include('frontend.layouts.footer')
    @include('frontend.layouts.script')
    <script>
        $(document).ready(function() {
            $('input[name="identityType"]').on('change', function() {
                if ($(this).val() === 'identitas') {
                    $('#identityFields').removeClass('d-none');
                } else {
                    $('#identityFields').addClass('d-none');
                    // Kosongkan nilai agar tidak ikut dikirim jika anonim
                    $('#identityFields input').val('');
                }
            });
        });
    </script>
</body>

</html>
