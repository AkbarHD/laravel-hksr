<div class="row">
    <div class="col-md-6">
        <strong>Judul:</strong><br>
        {{ $modul->judul }}
    </div>
    {{-- <div class="col-md-6">
        <strong>Kategori:</strong><br>
        {{ $modul->nama_category }}
    </div> --}}
    <div class="col-md-12 mt-3">
        <strong>Isi:</strong><br>
        {!! $modul->isi !!}
    </div>
    <div class="col-md-12 mt-3">
        <strong>Gambar:</strong><br>
        @if ($modul->gambar)
            <img src="{{ asset($modul->gambar) }}" class="img-fluid rounded">
        @else
            <em>Tidak ada gambar</em>
        @endif
    </div>
</div>
