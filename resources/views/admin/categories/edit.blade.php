<form action="{{ route('category.update', $category->id) }}" method="POST">
    @csrf
    <div class="mb-3">
        <label class="form-label">Nama Category</label>
        <input type="text" name="nama_category" class="form-control @error('nama_category') is-invalid @enderror"
            value="{{ old('nama_category', $category->nama_category) }}">
        @error('nama_category')
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
