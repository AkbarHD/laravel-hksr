@extends('admin.layouts.tamplate')

@section('title', 'List Chat')

@section('css')
    <style>
        .border-left-primary {
            border-left: 4px solid #007bff;
        }

        .card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Dashboard Konselor - {{ Auth::user()->name }}</h4>
                        <small class="text-muted">{{ $konselor->jenis_konselor }}</small>
                    </div>

                    <div class="card-body">
                        <h5>Sesi Konsultasi Aktif</h5>

                        @if ($sessions->count() > 0)
                            <div class="row">
                                @foreach ($sessions as $session)
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="card border-left-primary">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-2">
                                                    @if ($session->user_image)
                                                        <img src="{{ asset('storage/' . $session->user_image) }}"
                                                            class="rounded-circle me-2" width="40" height="40">
                                                    @else
                                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2"
                                                            style="width: 40px; height: 40px;">
                                                            <i class="fas fa-user text-white"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-0">{{ $session->user_name }}</h6>
                                                        <small class="text-muted">
                                                            {{ $session->created_at ? date('d M Y, H:i', strtotime($session->created_at)) : '' }}
                                                        </small>
                                                    </div>
                                                </div>

                                                @if ($session->last_message)
                                                    <p class="text-muted small mb-2">
                                                        <strong>Pesan terakhir:</strong><br>
                                                        {{ Str::limit($session->last_message, 60) }}
                                                    </p>
                                                    <small class="text-muted">
                                                        {{ $session->last_message_time ? date('H:i', strtotime($session->last_message_time)) : '' }}
                                                    </small>
                                                @else
                                                    <p class="text-muted small">Belum ada pesan</p>
                                                @endif

                                                <div class="mt-3">
                                                    <a href="{{ route('konselor-dashboard.chat', $session->id) }}"
                                                        class="btn btn-primary btn-sm">
                                                        <i class="fas fa-comment"></i> Buka Chat
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum Ada Sesi Konsultasi</h5>
                                <p class="text-muted">Tunggu hingga ada klien yang memulai konsultasi dengan Anda.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')

@endsection
