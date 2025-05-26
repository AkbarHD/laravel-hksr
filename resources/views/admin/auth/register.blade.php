<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modul</title>
    @include('frontend.layouts.head')
    <link rel="stylesheet" href="{{ asset('style/auth.css') }}">
    @include('frontend.layouts.style')
</head>

<body>
    @include('frontend.layouts.navbar')
    <div class="page-register" id="registerPage">
        <div class="auth-container">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-8 col-sm-10">
                        <div class="auth-card">
                            <div class="auth-header">
                                <div class="app-icon">
                                    <i class="fas fa-user-shield"></i>
                                </div>
                                <h2 class="auth-title">Daftar</h2>
                                <p class="auth-subtitle">Bergabung dalam Sistem Pelaporan</p>
                            </div>
                            <div class="auth-body">
                                <form id="registerForm" action="{{ route('registerProses') }}" method="post"
                                    autocomplete="off" enctype="multipart/form-data">
                                    @csrf

                                    @if (session('success'))
                                        <div class="alert alert-success text-center">
                                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                        </div>
                                    @endif

                                    @if (session('error'))
                                        <div class="alert alert-danger text-center mb-3">
                                            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                                        </div>
                                    @endif

                                    <!-- Nama Lengkap -->
                                    <div class="input-group">
                                        <div class="position-relative w-100">
                                            <i class="fas fa-user input-icon"></i>
                                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name"
                                                placeholder="Nama Lengkap" required>
                                        </div>
                                    </div>
                                    @error('name')
                                        <div class="text-danger mt-2">
                                            <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                        </div>
                                    @enderror

                                    <!-- Email -->
                                    <div class="input-group">
                                        <div class="position-relative w-100">
                                            <i class="fas fa-envelope input-icon"></i>
                                            <input class="form-control @error('email') is-invalid @enderror" type="email" name="email"
                                                placeholder="Alamat Email" required>
                                        </div>
                                    </div>
                                     @error('email')
                                        <div class="text-danger mt-2">
                                            <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                        </div>
                                    @enderror

                                    <!-- Jenis Kelamin -->
                                    <div class="input-group">
                                        <div class="position-relative w-100">
                                            <i class="fas fa-venus-mars input-icon"></i>
                                            <select class="form-select @error('gender') is-invalid @enderror" name="gender" required>
                                                <option value="">Pilih Jenis Kelamin</option>
                                                <option value="male">male</option>
                                                <option value="female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                     @error('gender')
                                        <div class="text-danger mt-2">
                                            <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                        </div>
                                    @enderror

                                    <!-- Photo Profile (Optional) -->
                                    <div class="input-group">
                                        <small class="text-muted mb-2">*Foto Profil (opsional)</small>
                                        <div class="position-relative w-100">
                                            <i class="fas fa-camera input-icon"></i>
                                            <input class="form-control" type="file" name="image" accept="image/*">
                                        </div>
                                    </div>

                                    <!-- Password -->
                                    <div class="input-group">
                                        <div class="position-relative w-100">
                                            <i class="fas fa-lock input-icon @error('password') is-invalid @enderror"></i>
                                            <input class="form-control" type="password" name="password"
                                                placeholder="Password" required>
                                        </div>
                                    </div>
                                     @error('password')
                                        <div class="text-danger mt-2">
                                            <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                        </div>
                                    @enderror

                                    <!-- Konfirmasi Password -->
                                    <div class="input-group">
                                        <div class="position-relative w-100">
                                            <i class="fas fa-lock input-icon"></i>
                                            <input class="form-control" type="password" name="password_confirmation"
                                                placeholder="Konfirmasi Password" required>
                                        </div>
                                    </div>

                                    <div class="d-grid gap-2 mt-4">
                                        <button type="submit" id="submitBtn" class="btn btn-lg auth-btn text-white">
                                            <i class="fas fa-user-plus me-2"></i>
                                            <span id="btnText">Daftar</span>
                                            <span id="btnSpinner" class="spinner-border spinner-border-sm d-none ms-2"
                                                role="status" aria-hidden="true"></span>
                                        </button>
                                    </div>

                                    <div class="action-links">
                                        <a href="{{ route('login') }}">
                                            <i class="fas fa-sign-in-alt me-1"></i>Sudah punya akun? Masuk
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('frontend.layouts.footer')
    @include('frontend.layouts.script')
    <script>
        document.getElementById('registerForm').addEventListener('submit', function() {
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const btnSpinner = document.getElementById('btnSpinner');

            // buttonya di disabled dan spennernya tampil
            submitBtn.disabled = true;
            btnText.textContent = 'Mendaftar...';
            btnSpinner.classList.remove('d-none');
        });
    </script>
</body>

</html>
