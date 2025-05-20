<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.layouts.head')
    <title>Login Kudaftar</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('style/auth.css') }}">
</head>

<body>
    <div class="login-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7 col-sm-9">
                    <div class="login-card">
                        <div class="login-header">
                            <div class="app-icon">
                                <i class="fas fa-horse fa-3x mb-3 animated-icon"></i>
                            </div>
                            <p class="mb-3">Login</p>

                        </div>
                        <div class="login-body">
                            <form action="{{ route('loginProses') }}" method="post" autocomplete="off">
                                @csrf
                                @error('errors')
                                    <div class="alert alert-danger text-center">
                                        <i class="fas fa-exclamation-triangle me-2"></i>{{ $message }}
                                    </div>
                                @enderror

                                <div class="input-group">
                                    <div class="position-relative w-100">
                                        <i class="fas fa-user input-icon"></i>
                                        <input class="form-control icon-input @error('email') is-invalid @enderror"
                                            type="email" name="email" placeholder="Masukkan email anda"
                                            value="{{ old('email') }}">
                                    </div>
                                    @error('email')
                                        <div class="text-danger mt-2">
                                            <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="input-group">
                                    <div class="position-relative w-100">
                                        <i class="fas fa-lock input-icon @error('password') is-invalid @enderror"></i>
                                        <input class="form-control icon-input" type="password" name="password"
                                            placeholder="Masukkan Password">
                                    </div>
                                    @error('password')
                                        <div class="text-danger mt-2">
                                            <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="d-grid gap-2 mt-4">
                                    <button type="submit" class="btn btn-lg login-btn">
                                        <i class="fas fa-sign-in-alt me-2"></i>Masuk
                                    </button>
                                </div>

                                <div class="action-links">
                                    <a href="javascript:void(0)" class="mx-1">
                                        <i class="fas fa-question-circle me-1 "></i>Lupa Password?
                                    </a>
                                    <a href="{{ route('register') }}">
                                        <i class="fas fa-user-plus me-1"></i>Daftar Baru
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="footer">
                        <p class="mb-0">Kudaftar by Kokitindo &copy; {{ date('Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- sweetalert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.js"></script>
    <script src="js/app.js"></script>
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
