@extends('admin.layouts.tamplate')

@section('title', 'Dashboard')
@section('content')

@section('css')
<link rel="stylesheet" href="{{ asset('style/homeadmin.css') }}">
@endsection

<div class="dashboard-container py-4">
        <div class="welcome-section">
            <h2 class="text-success">{{ __('Halo, selamat datang') }} <span class="user-name">{{ Auth::user()->name }}</span>!</h2>
            <p>
                {{__('Senang bertemu kembali. Anda kini berada di dashboard sistem manajemen. Berikut ringkasan aktivitas Anda hari ini.')}}
            </p>
        </div>
</div>


@endsection

@section('js')

@endsection
