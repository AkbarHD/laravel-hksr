@extends('admin.layouts.tamplate')

@section('title', 'Edit Konselor')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Edit Konselor</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('list.konselor.update', $konselor->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="user_id" class="form-label">Pilih User Konselor</label>
                                        <select class="form-select @error('user_id') is-invalid @enderror" id="user_id"
                                            name="user_id" required>
                                            <option value="">-- Pilih User --</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}"
                                                    {{ $user->id == $konselor->user_id ? 'selected' : '' }}>
                                                    {{ $user->name }} ({{ $user->email }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('user_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="jenis_konselor" class="form-label">Jenis Konselor</label>
                                        <select class="form-select @error('jenis_konselor') is-invalid @enderror"
                                            id="jenis_konselor" name="jenis_konselor" required>
                                            <option value="">-- Pilih Jenis --</option>
                                            <option value="Konselor HKSR"
                                                {{ $konselor->jenis_konselor == 'Konselor HKSR' ? 'selected' : '' }}>
                                                Konselor HKSR</option>
                                            <option value="Konselor Mental"
                                                {{ $konselor->jenis_konselor == 'Konselor Mental' ? 'selected' : '' }}>
                                                Konselor Mental</option>
                                            <option value="Konselor Sebaya"
                                                {{ $konselor->jenis_konselor == 'Konselor Sebaya' ? 'selected' : '' }}>
                                                Konselor Sebaya</option>
                                        </select>
                                        @error('jenis_konselor')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="gambar_konselor" class="form-label">Gambar Konselor</label>
                                        @if ($konselor->gambar_konselor)
                                            <div class="mb-2">
                                                <img src="{{ asset($konselor->gambar_konselor) }}" alt="Gambar"
                                                    width="150">
                                            </div>
                                        @endif
                                        <input type="file"
                                            class="form-control @error('gambar_konselor') is-invalid @enderror"
                                            id="gambar_konselor" name="gambar_konselor" accept="image/*">
                                        @error('gambar_konselor')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="jam_aktif_awal" class="form-label">Jam Aktif Awal</label>
                                        <input type="time"
                                            class="form-control @error('jam_aktif_awal') is-invalid @enderror"
                                            id="jam_aktif_awal" name="jam_aktif_awal"
                                            value="{{ $konselor->jam_aktif_awal }}" required>
                                        @error('jam_aktif_awal')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="jam_aktif_akhir" class="form-label">Jam Aktif Akhir</label>
                                        <input type="time"
                                            class="form-control @error('jam_aktif_akhir') is-invalid @enderror"
                                            id="jam_aktif_akhir" name="jam_aktif_akhir"
                                            value="{{ $konselor->jam_aktif_akhir }}" required>
                                        @error('jam_aktif_akhir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="deskripsi" class="form-label">Deskripsi</label>
                                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="5"
                                            required>{{ $konselor->deskripsi }}</textarea>
                                        @error('deskripsi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('list.konselor.index') }}" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
