@extends('admin.layouts.tamplate')

@section('title', 'Product')

@section('css')
@endsection

@section('content')
    <div class="container mt-1">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between">
                <h4>Modul</h4>
                <a href="javascript:void(0);" class="btn btn-primary" id="btnTambahModul"> <i class="fa-solid fa-plus"></i>
                    Tambah Modul</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover nowrap" id="DataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Category</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($moduls as $key => $modul)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $modul->judul ?? '-' }}</td>
                                    <td>{{ $modul->nama_category ?? '-' }}</td>
                                    <td>

                                        <div class="btn-group">
                                            <a class="btn btn-success edit" data-id="{{ $modul->id }}"
                                                href="javascript:void(0);">
                                                <i class="mdi mdi-pencil me-2"></i>
                                                Edit
                                            </a>
                                            <a href="javascript:void(0);" class="btn btn-warning btn-detail"
                                                data-id="{{ $modul->id }}">
                                                <i class="mdi mdi-eye me-2"></i> Detail
                                            </a>

                                            <form action="{{ route('materi.destroy', $modul->id) }}" method="POST"
                                                class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger  btn-delete"
                                                    data-name="{{ $modul->judul }}">
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

    {{-- Modal Create --}}
    <div class="modal fade" id="createModul" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('materi.store') }}" method="POST" enctype="multipart/form-data" id="frmModul">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Tambah modul</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Judul Materi</label>
                            <input type="text" name="judul" id="judul" placeholder="Judul"
                                class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul') }}">
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" id="category_id" class="form-control">
                                <option value="" hidden>Pilih Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->nama_category }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Gambar</label>
                            <input type="file" name="gambar" id="gambar" placeholder="gambar"
                                class="form-control @error('gambar') is-invalid @enderror" value="{{ old('gambar') }}">
                            @error('gambar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">isi</label>
                            <textarea name="isi" id="isi" class="form-control @error('isi') is-invalid @enderror">{{ old('isi') }}</textarea>
                            @error('isi')
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
    <div class="modal modal-blur fade" id="modal-editModul" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="loadedEditModulForm">
                    {{-- isi form akan dimuat lewat AJAX --}}
                </div>
            </div>
        </div>
    </div>

    {{-- modal detail --}}
    <div class="modal fade" id="modal-detailModul" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Modul</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="loadedDetailModul">
                    {{-- akan diisi via AJAX --}}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        let editorIsi; // simpan instance CKEditor

        ClassicEditor
            .create(document.querySelector('#isi'), {
                toolbar: [
                    'heading', '|',
                    'bold', 'italic', 'underline', 'link', 'bulletedList', 'numberedList', '|',
                    'blockQuote', 'insertTable', 'undo', 'redo'
                ],
            })
            .then(editor => {
                editorIsi = editor; // simpan ke variabel
            })
            .catch(error => {
                console.error(error);
            });

        $(document).ready(function() {

            $('#btnTambahModul').on('click', function() {
                $('#frmModul')[0].reset();

                // Reset konten CKEditor tanpa membuat ulang
                if (editorIsi) {
                    editorIsi.setData('');
                }

                $('#createModul').modal('show');
            });


            $('#frmProduct').on('submit', function() {
                var judul = $('#judul').val();
                var category_id = $('#category_id').val();
                var gambar = $('#gambar').val();
                var isi = $('#isi').val();
                if (judul == "") {
                    $('#judul').focus();
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Nama Product Tidak Boleh Kosong',
                        icon: 'warning',
                    });
                    return false;
                } else if (category_id == "") {
                    $('#category_id').focus();
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Category Tidak Boleh Kosong',
                        icon: 'warning',
                    });
                    return false;
                } else if (gambar == "") {
                    $('#gambar').focus();
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Gambar Tidak Boleh Kosong',
                        icon: 'warning',
                    });
                    return false;
                } else if (isi == "") {
                    $('#isi').focus();
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Keterangan Tidak Boleh Kosong',
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
                    url: '{{ route('materi.edit') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id
                    },
                    success: function(response) {
                        $('#loadedEditModulForm').html(response);
                        $('#modal-editModul').modal('show');

                        initDatepicker();
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseJSON.error);
                    }
                });
            });

            $('.btn-detail').on('click', function(e) {
                e.preventDefault();

                const id = $(this).data('id');

                $.ajax({
                    url: '{{ route('materi.detail') }}',
                    type: 'GET',
                    data: {
                        id
                    },
                    success: function(res) {
                        $('#loadedDetailModul').html(res);
                        $('#modal-detailModul').modal('show');
                    },
                    error: function() {
                        Swal.fire('Gagal', 'Data tidak ditemukan', 'error');
                    }
                });
            });

            $('.btn-delete').on('click', function(e) {
                e.preventDefault();
                let form = $(this).closest('form');
                let name = $(this).data('name') || 'modul ini';

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
