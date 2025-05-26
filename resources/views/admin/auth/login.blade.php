<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login | Pelaporan Kekerasan Seksual</title>
    @include('frontend.layouts.head')
    <link rel="stylesheet" href="{{ asset('style/auth.css') }}">
    @include('frontend.layouts.style')
</head>

<body>
    @include('frontend.layouts.navbar')

    {{-- SweetAlert CSS --}}

    <div class="switch-page">
        <button class="btn switch-btn" onclick="switchPage()">1
            <i class="fas fa-exchange-alt me-2"></i>
            <span id="switch-text">Ke Register</span>
        </button>
    </div>

    <div class="page-login active" id="loginPage">
        <div class="auth-container">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-7 col-sm-9">
                        <div class="auth-card">
                            <div class="auth-header">
                                <div class="app-icon">
                                    <i class="fas fa-shield-heart"></i>
                                </div>
                                <h2 class="auth-title">Masuk</h2>
                                <p class="auth-subtitle">Sistem Pelaporan Kekerasan Seksual</p>
                            </div>
                            <div class="auth-body">
                                <form action="{{ route('loginProses') }}" method="post" autocomplete="off">
                                    @csrf
                                    @error('errors')
                                        <div class="alert alert-danger text-center">
                                            <i class="fas fa-exclamation-triangle me-2"></i>{{ $message }}
                                        </div>
                                    @enderror

                                    <div class="input-group">
                                        <div class="position-relative w-100">
                                            <i class="fas fa-envelope input-icon"></i>
                                            <input class="form-control @error('email') is-invalid @enderror" type="email" name="email"
                                                placeholder="Masukkan alamat email" value="{{ old('email') }}" required>
                                        </div>
                                    </div>

                                    <div class="input-group">
                                        <div class="position-relative w-100">
                                            <i class="fas fa-lock input-icon"></i>
                                            <input class="form-control @error('password') is-invalid @enderror" type="password" name="password"
                                                placeholder="Masukkan password" value="{{ old('password') }}" required>
                                        </div>
                                    </div>

                                    <div class="d-grid gap-2 mt-4">
                                        <button type="submit" class="btn btn-lg auth-btn text-white">
                                            <i class="fas fa-sign-in-alt me-2"></i>Masuk
                                        </button>
                                    </div>

                                    <div class="action-links">

                                        <a href="{{ route('register') }}" class="ms-2">
                                            <i class="fas fa-user-plus me-1"></i>Belum punya akun? Daftar
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
        document.addEventListener('DOMContentLoaded', function() {

            // SweetAlert untuk success
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#38c172',
                    timer: 3000,
                    timerProgressBar: true,
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    }
                });
            @endif
        });
    </script>

</body>

</html>
