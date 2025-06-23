@extends('admin.layouts.tamplate')

@section('title', 'Management User')

@section('css')
@endsection

@section('content')
    <div class="container mt-1">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between">
                <h4>Management Users</h4>
                <a href="javascript:void(0);" class="btn btn-primary" id="btnTambahManagement"> <i class="fa-solid fa-plus"></i>
                    Tambah User</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover nowrap" id="DataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Gender</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name ?? '-' }}</td>
                                    <td>{{ $user->email ?? '-' }}</td>
                                    <td>
                                        @if ($user->role == 1)
                                            <span class="badge bg-success rounded-pill">Admin</span>
                                        @elseif ($user->role == 2)
                                            <span class="badge bg-warning rounded-pill">Stachholder</span>
                                        @elseif($user->role == 3)
                                            <span class="badge bg-danger rounded-pill">User</span>
                                        @elseif($user->role == 4)
                                            <span class="badge bg-info rounded-pill">Konselor</span>
                                        @else
                                            <span class="badge bg-secondary rounded-pill">Unknown</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->gender ?? '-' }}</td>
                                    <td>{{ $user->created_at ?? '-' }}</td>
                                    <td>

                                        <div class="btn-group">
                                                <form action="{{ route('admin.managament.destroy', $user->id) }}"
                                                    method="POST" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm rounded-pill btn-delete"
                                                        data-name="{{ $user->name }}">
                                                        Delete
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

    {{-- Modal Create --}}
    <div class="modal fade" id="createManagement" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('admin.managament.store') }}" method="POST" id="frmManagement"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Tambah User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama </label>
                            <input type="text" name="name" id="name" placeholder="Nama"
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" id="email" placeholder="Email"
                                class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                autocomplete="off">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" id="password" placeholder="password"
                                class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}"
                                autocomplete="off">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Gambar</label>
                            <input type="file" name="image" id="image" placeholder="image"
                                class="form-control @error('image') is-invalid @enderror" value="{{ old('image') }}">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select name="role" id="role" class="form-control @error('role') is-invalid @enderror"
                                value="{{ old('role') }}">
                                <option value="">Pilih Role</option>
                                <option value="1">Admin</option>
                                <option value="2">StackHolder</option>
                                <option value="3">User</option>
                                <option value="4">Konselor</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Gender</label>
                            <select name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror"
                                value="{{ old('gender') }}">
                                <option value="">Pilih gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" type="button" data-bs-dismiss="modal">
                            <i class="fa-solid fa-xmark"></i>
                            Batal
                        </button>
                        <button class="btn btn-success" type="submit">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function() {

            $('#btnTambahManagement').on('click', function() {
                $('#createManagement').modal('show');
            });

            $('#frmManagement').on('submit', function() {
                var name = $('#name').val();
                var email = $('#email').val();
                var password = $('#password').val();
                var role = $('#role').val();
                var gender = $('#gender').val();
                if (name == "") {
                    $('#name').focus();
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Nama Tidak Boleh Kosong',
                        icon: 'warning',
                    });
                    return false;
                } else if (email == "") {
                    $('#email').focus();
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Email Tidak Boleh Kosong',
                        icon: 'warning',
                    });
                    return false;
                } else if (password == "") {
                    $('#password').focus();
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Password Tidak Boleh Kosong',
                        icon: 'warning',
                    });
                    return false;
                } else if (role == "") {
                    $('#role').focus();
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Role Tidak Boleh Kosong',
                        icon: 'warning',
                    });
                    return false;
                } else if (gender == "") {
                    $('#gender').focus();
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Gender Tidak Boleh Kosong',
                        icon: 'warning',
                    });
                    return false;
                } else {
                    return true;
                }
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
