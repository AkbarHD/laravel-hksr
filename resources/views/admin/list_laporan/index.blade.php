@extends('admin.layouts.tamplate')

@section('title', 'Category')

@section('css')
@endsection

@section('content')
    <div class="container mt-1">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between">
                <h4>Category</h4>
                <a href="javascript:void(0);" class="btn btn-primary" id="btnTambahCategory"> <i class="fa-solid fa-plus"></i>
                    Tambah Category</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover nowrap" id="DataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Category</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $key => $category)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $category->nama_category ?? '-' }}</td>
                                    <td>

                                        <div class="btn-group">
                                            <button class="btn p-0 px-1 dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <li>
                                                    <a class="dropdown-item edit" data-id="{{ $category->id }}"
                                                        href="javascript:void(0);">
                                                        <i class="mdi mdi-pencil me-2"></i>
                                                        Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('category.destroy', $category->id) }}"
                                                        method="POST" class="delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="dropdown-item text-danger btn-delete"
                                                            data-name="{{ $category->nama_category }}">
                                                            <i class="mdi mdi-delete me-2"></i> Delete
                                                        </button>
                                                    </form>
                                                </li>

                                            </ul>
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
    <div class="modal fade" id="createCategory" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('category.store') }}" method="POST" id="frmCategory">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Tambah Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Category</label>
                            <input type="text" name="nama_category" id="nama_category" placeholder="nama_category"
                                class="form-control @error('nama_category') is-invalid @enderror"
                                value="{{ old('nama_category') }}">
                            @error('nama_category')
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

    {{-- modal edit --}}
    <div class="modal modal-blur fade" id="modal-editCategory" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="loadedEditCategoryForm">
                    {{-- isi form akan dimuat lewat AJAX --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {

            $('#btnTambahCategory').on('click', function() {
                $('#createCategory').modal('show');
            });

            $('#frmCategory').on('submit', function() {
                var nama_category = $('#nama_category').val();
                if (nama_category == "") {
                    $('#nama_category').focus();
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Nama Category Tidak Boleh Kosong',
                        icon: 'warning',
                    });
                    return false;
                }
            });

            $('.edit').on('click', function(e) {
                e.preventDefault();
                var id = $(this).attr('data-id');
                $.ajax({
                    type: 'GET',
                    url: '{{ route('category.edit') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id
                    },
                    success: function(response) {
                        $('#loadedEditCategoryForm').html(response);
                        $('#modal-editCategory').modal('show');

                        initDatepicker();
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseJSON.error);
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
