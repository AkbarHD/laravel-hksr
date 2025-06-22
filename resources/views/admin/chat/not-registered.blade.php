@extends('admin.layouts.tamplate')

@section('title', 'List Chat')

@section('css')
    <style>

    </style>
@endsection

@section('content')
    <div class="container py-5 text-center">
        <h3>Anda Belum Terdaftar sebagai Konselor</h3>
        <p class="text-muted">Untuk menggunakan fitur dashboard ini, silakan lengkapi profil Anda sebagai konselor terlebih
            dahulu.</p>
        <a href="{{ route('list.konselor.create') }}" class="btn btn-primary mt-3">
            Bikin Konselor
        </a>
    </div>


@endsection

@section('js')

@endsection
