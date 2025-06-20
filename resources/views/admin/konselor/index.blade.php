@extends('admin.layouts.tamplate')

@section('title', 'List konselor')

@section('css')
@endsection

@section('content')
    <div class="container mt-1">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between">
                <h4>List Konselor</h4>
                <a href="{{ route('list.konselor.create') }}" class="btn btn-primary" id="btnTambahModul"> <i
                        class="fa-solid fa-plus"></i>
                    Tambah Konselor</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover nowrap" id="DataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar</th>
                                <th>Nama Konselor</th>
                                <th>Jenis Konselor</th>
                                <th>Jam Aktif</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($konselors as $index => $konselor)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if ($konselor->gambar_konselor)
                                            <img src="{{ asset($konselor->gambar_konselor) }}" alt="Gambar Konselor"
                                                style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                        @else
                                            <div class="bg-secondary d-flex align-items-center justify-content-center"
                                                style="width: 50px; height: 50px; border-radius: 5px;">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $konselor->user_name }}</td>
                                    <td><span class="badge bg-info">{{ $konselor->jenis_konselor }}</span></td>
                                    <td>{{ date('H:i', strtotime($konselor->jam_aktif_awal)) }} -
                                        {{ date('H:i', strtotime($konselor->jam_aktif_akhir)) }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#modalDetail{{ $konselor->id }}">
                                                <i class="fas fa-eye"></i>

                                            </button>
                                            <a href="{{ route('list.konselor.edit', $konselor->id) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger"
                                                onclick="confirmDelete({{ $konselor->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>

                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal Detail -->
                                <div class="modal fade" id="modalDetail{{ $konselor->id }}" tabindex="-1"
                                    aria-labelledby="detailLabel{{ $konselor->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="detailLabel{{ $konselor->id }}">Detail Konselor
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Tutup"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        @if ($konselor->gambar_konselor)
                                                            <img src="{{ asset($konselor->gambar_konselor) }}"
                                                                alt="Gambar Konselor" class="img-fluid rounded">
                                                        @else
                                                            <p><i>Tidak ada gambar</i></p>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-8">
                                                        <p><strong>Nama:</strong> {{ $konselor->user_name }}</p>
                                                        <p><strong>Email:</strong> {{ $konselor->email }}</p>
                                                        <p><strong>Jenis Konselor:</strong> {{ $konselor->jenis_konselor }}
                                                        </p>
                                                        <p><strong>Jam Aktif:</strong> {{ $konselor->jam_aktif_awal }} -
                                                            {{ $konselor->jam_aktif_akhir }}</p>
                                                        <p><strong>Deskripsi:</strong> {{ $konselor->deskripsi }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada data konselor</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus konselor ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        function confirmDelete(id) {
            const form = document.getElementById('deleteForm');
            form.action = `/list-konselor/delete/${id}`;
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }
    </script>
@endsection
