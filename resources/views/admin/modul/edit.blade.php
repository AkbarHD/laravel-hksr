<form action="{{ route('materi.update', $modul->id) }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label class="form-label">Judul</label>
        <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
            value="{{ old('judul', $modul->judul) }}">
        @error('judul')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Category</label>
        <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
            <option value="">Pilih Category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ $category->id == $modul->category_id ? 'selected' : '' }}>
                    {{ $category->nama_category }}
                </option>
            @endforeach
        </select>
        @error('category_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Gambar</label>
        <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror">
        @if ($modul->gambar)
            <img src="{{ asset($modul->gambar) }}" width="100" class="mt-2">
        @endif
        @error('gambar')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Isi</label>
        <textarea name="isi" id="edit_isi" class="form-control @error('isi') is-invalid @enderror">{{ old('isi', $modul->isi) }}</textarea>
        @error('isi')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="text-end">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
            <i class="fa-solid fa-xmark"></i>
            Cancel
        </button>
        <button type="submit" class="btn btn-success">
            <i class="fa-solid fa-floppy-disk"></i>
            Update
        </button>
    </div>
</form>

{{-- CKEditor --}}
<script>
    ClassicEditor
        .create(document.querySelector('#edit_isi'))
        .catch(error => console.error(error));
</script>
