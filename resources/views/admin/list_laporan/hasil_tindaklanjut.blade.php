@extends('admin.layouts.tamplate')

@section('title', 'List Laporan Terjawab')

@section('css')
@endsection

@section('content')
    <div class="container mt-1">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between">
                <h4>List Laporan Anda yang sudah terjawab</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover nowrap" id="DataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>id Pelapor</th>
                                <th>Jenis Kasus</th>
                                <th>Tindak Lanjut</th>
                                <th>Catatan Tindak Lanjut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hasilTindakLanjut as $key => $hasil)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $hasil->id_pelapor ?? '-' }}</td>
                                    <td>{{ $hasil->judul ?? '-' }}</td>
                                    <td>{{ $hasil->tindak_lanjut ?? '-' }}</td>
                                    <td>{{ $hasil->catatan_tindak_lanjut ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function() {
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
