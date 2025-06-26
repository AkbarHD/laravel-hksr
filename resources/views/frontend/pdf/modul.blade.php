<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $modul->judul }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; line-height: 1.5; }
        h1 { font-size: 24px; }
        .category { font-size: 14px; color: gray; }
    </style>
</head>
<body>
    <h1>{{ $modul->judul }}</h1>
    {{-- <div class="category"><strong>Kategori:</strong> {{ $modul->nama_category }}</div> --}}
    <p><strong>Dipublikasi:</strong> {{ \Carbon\Carbon::parse($modul->created_at)->format('d F Y') }}</p>
    <hr>
    <div>{!! $modul->isi !!}</div>
</body>
</html>
