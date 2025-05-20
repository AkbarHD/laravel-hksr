<!DOCTYPE html>
<html lang="id">

<head>
    @include('admin.layouts.head')
    <title>Register Kudaftar</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('style/auth.css') }}">
</head>

<body>
    <div class="register-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7 col-sm-9">
                    <div class="register-card">
                        <div class="register-header">
                            <div class="app-icon">
                                <i class="fas fa-horse fa-3x mb-3 animated-icon"></i>
                            </div>
                            <p class="mb-3">Register</p>
                        </div>
                        <div class="register-body">
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

                                <!-- Nama Club -->
                                <div class="input-group">
                                    <div class="position-relative w-100">
                                        <i class="fas fa-building input-icon"></i>
                                        <input class="form-control icon-input @error('nameclub') is-invalid @enderror"
                                            type="text" name="nameclub" placeholder="Nama Club"
                                            value="{{ old('nameclub') }}">
                                    </div>
                                    @error('nameclub')
                                        <div class="text-danger mt-2">
                                            <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Penanggung Jawab -->
                                <div class="input-group">
                                    <div class="position-relative w-100">
                                        <i class="fas fa-user-tie input-icon"></i>
                                        <input
                                            class="form-control icon-input @error('penanggung_jawab') is-invalid @enderror"
                                            type="text" name="penanggung_jawab" placeholder="Penanggung Jawab"
                                            value="{{ old('penanggung_jawab') }}">
                                    </div>
                                    @error('penanggung_jawab')
                                        <div class="text-danger mt-2">
                                            <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Nomor Telepon -->
                                <div class="input-group">
                                    <div class="position-relative w-100">
                                        <i class="fas fa-phone input-icon"></i>
                                        <input class="form-control icon-input @error('phone') is-invalid @enderror"
                                            type="text" name="phone" placeholder="Nomor Telepon"
                                            value="{{ old('phone') }}">
                                    </div>
                                    @error('phone')
                                        <div class="text-danger mt-2">
                                            <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                {{-- Logo --}}
                                <div class="input-group">
                                    <small class="text-danger mb-2">*Logo (optional)</small>
                                    <div class="position-relative w-100">
                                        <i class="fa-solid fa-file-image input-icon"></i>
                                        <input class="form-control icon-input @error('logo') is-invalid @enderror"
                                            type="file" name="logo" id="logo" accept="image/*">
                                    </div>
                                    @error('logo')
                                        <div class="text-danger mt-2">
                                            <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Alamat -->
                                <div class="input-group">
                                    <div class="position-relative w-100">
                                        <i class="fas fa-map-marker-alt input-icon"></i>
                                        <textarea class="form-control icon-input @error('address') is-invalid @enderror" name="address" placeholder="Alamat">{{ old('address') }}</textarea>
                                    </div>
                                    @error('address')
                                        <div class="text-danger mt-2">
                                            <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="input-group">
                                    <div class="position-relative w-100">
                                        <i class="fas fa-envelope input-icon"></i>
                                        <input class="form-control icon-input @error('email') is-invalid @enderror"
                                            type="email" name="email" placeholder="Alamat Email"
                                            value="{{ old('email') }}">
                                    </div>
                                    @error('email')
                                        <div class="text-danger mt-2">
                                            <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div class="input-group">
                                    <div class="position-relative w-100">
                                        <i class="fas fa-lock input-icon"></i>
                                        <input class="form-control icon-input @error('password') is-invalid @enderror"
                                            type="password" name="password" placeholder="Password">
                                    </div>
                                    @error('password')
                                        <div class="text-danger mt-2">
                                            <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Konfirmasi Password -->
                                <div class="input-group">
                                    <div class="position-relative w-100">
                                        <i class="fas fa-lock input-icon"></i>
                                        <input class="form-control icon-input" type="password"
                                            name="password_confirmation" placeholder="Konfirmasi Password">
                                    </div>
                                </div>


                                <div class="d-grid gap-2 mt-4 ">
                                    {{-- <button type="submit" class="btn btn-lg register-btn">
                                        <i class="fas fa-user-plus me-2"></i>Daftar
                                    </button> --}}
                                    <button type="submit" id="submitBtn" class="btn btn-lg register-btn">
                                        <i class="fas fa-user-plus me-2"></i><span id="btnText">Daftar</span>
                                        <span id="btnSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                    </button>
                                </div>

                                <div class="action-links">
                                    <a href="{{ route('login') }}">
                                        <i class="fas fa-sign-in-alt me-1"></i>Sudah punya akun? Login
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="footer">
                        <p class="mb-0">KudaLumping by Kokitindo &copy; {{ date('Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
