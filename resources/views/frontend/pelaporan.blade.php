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

                    <form>
                        <div class="identity-selection mb-4">
                            <label class="form-label">Identitas Pelapor</label>
                            <div class="d-flex">
                                <div class="form-check me-4">
                                    <input class="form-check-input" type="radio" name="identityType" id="anon"
                                        checked>
                                    <label class="form-check-label" for="anon">
                                        Anonim
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="identityType"
                                        id="withIdentity">
                                    <label class="form-check-label" for="withIdentity">
                                        Dengan Identitas
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="reportTitle">Judul Laporan</label>
                            <input type="text" class="form-control" id="reportTitle">
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="eventDescription">Deskripsi Kejadian</label>
                            <textarea class="form-control" id="eventDescription"></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Bukti (Opsional)</label>
                            <div class="upload-area">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p class="mb-0"><a href="#" class="upload-text">Klik untuk upload</a></p>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn-submit">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Status Section -->
            <div class="col-lg-5">
                <div class="status-container">
                    <h5 class="status-title">Status Pelaporan</h5>

                    <div class="report-card">
                        <span class="status-badge status-processing">Diproses</span>
                        <h6 class="report-title">Judul Laporan 1</h6>
                        <p class="report-date">tanggal</p>
                    </div>

                    <div class="report-card">
                        <span class="status-badge status-completed">Selesai</span>
                        <h6 class="report-title">Judul Laporan 2</h6>
                        <p class="report-date">tanggal</p>
                    </div>

                    <div class="report-card">
                        <span class="status-badge status-rejected">Ditolak</span>
                        <h6 class="report-title">Judul Laporan 3</h6>
                        <p class="report-date">tanggal</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('frontend.layouts.footer')
    @include('frontend.layouts.script')
    <script>
        $(document).ready(function() {
            // Upload area click handler
            $('.upload-area').click(function() {
                // Here you would trigger a file upload dialog
                // For a real implementation, you'd create a hidden file input and trigger its click event
                alert('Fitur upload file akan diimplementasikan');
            });

            // Form submission (prevent default for demo)
            $('form').submit(function(e) {
                e.preventDefault();
                alert('Laporan telah dikirim. Terima kasih atas laporan Anda.');
                // Clear form fields
                $('#reportTitle').val('');
                $('#eventDescription').val('');
            });
        });
    </script>
</body>

</html>
