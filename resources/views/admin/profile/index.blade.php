@extends('admin.layouts.tamplate')

@section('title', 'Edit Profile')

@section('content')
    <div class="container">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <!-- Kiri: Foto Logo -->
                <div class="col-md-4 mb-3">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <h5 class="mb-3">Foto Profil</h5>
                            @if ($user->image)
                                <img id="preview-image" src="{{ asset($user->image) }}" width="150" height="120"
                                    class="img-thumbnail mb-2" alt="Foto Logo">
                            @else
                                <img id="preview-image" src="{{ asset('no_images.jpg') }}" width="150" height="120"
                                    class="img-thumbnail mb-2" alt="No Image">
                            @endif
                            <input type="file" name="image" class="form-control" onchange="previewImage(event)">
                        </div>
                    </div>
                </div>

                <!-- Kanan: Form -->
                <div class="col-md-8 mb-3">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="mb-3">Edit Profil</h5>

                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="name" class="form-control" value="{{ $user->name }}"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ $user->email }}"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="gender" class="form-control" required>
                                    <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Male
                                    </option>
                                    <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Female
                                    </option>
                                </select>
                            </div>

                            @php
                                $roleText = '';
                                if ($user->role == 1) {
                                    $roleText = 'Admin';
                                } elseif ($user->role == 2) {
                                    $roleText = 'Stackholder';
                                } elseif ($user->role == 3) {
                                    $roleText = 'User';
                                }
                            @endphp

                            <div class="mb-3">
                                <label class="form-label">Role</label>
                                <input type="text" class="form-control" value="{{ $roleText }}" readonly>
                            </div>


                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('js')
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                document.getElementById('preview-image').src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection
