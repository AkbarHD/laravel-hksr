<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @include('frontend.layouts.head')
</head>
<style>
    body {
        background-color: #f8f9fa;
    }

    .main-content {
        padding: 2rem 0;
    }

    .card {
        border: none;
        transition: transform 0.3s;
        margin-bottom: 1.5rem;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .card-img-top {
        height: 180px;
        background-color: #e9ecef;
    }

    .card-body {
        padding: 1.25rem;
    }

    .search-container {
        position: relative;
        margin-bottom: 2rem;
    }

    .search-container .btn {
        position: absolute;
        right: 0;
        top: 0;
        border-radius: 0 30px 30px 0;
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .search-input {
        border-radius: 30px;
        padding-right: 50px;
        background-color: #e9ecef;
        border: none;
    }

    .page-title {
        margin-bottom: 0.5rem;
        font-weight: bold;
    }

    .page-subtitle {
        color: #6c757d;
        margin-bottom: 2rem;
    }

    .chatbot-btn {
        background-color: #343a40;
        color: white;
        border-radius: 30px;
        padding: 0.5rem 1rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s;
    }

    .chatbot-btn:hover {
        background-color: #212529;
        color: white;
    }

    .chatbot-btn i {
        margin-right: 0.5rem;
    }

    .read-more {
        color: #0d6efd;
        text-decoration: none;
        font-weight: bold;
    }

    .modul-card {
        text-align: center;
        overflow: hidden;
    }

    .modul-card .card-title {
        background-color: white;
        padding: 1rem;
        font-size: 0.9rem;
        min-height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .module-img-container {
        background-color: black;
        width: 100%;
        height: 10px;
    }

    .module-placeholder {
        background-color: #ddd;
        height: 30px;
        margin-top: 0;
    }
</style>

<body>
    @include('frontend.layouts.navbar')


    <!-- Main content area -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="page-title">Materi HKSR</h1>
                    <p class="page-subtitle">Artikel, video, atau modul pembelajaran terkait Kesehatan Seksual dan
                        Reproduksi</p>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-lg-4 col-md-6">
                    <div class="search-container">
                        <input type="text" class="form-control search-input" placeholder="Cari modul">
                        <button class="btn btn-dark">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-search" viewBox="0 0 16 16">
                                <path
                                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="col-lg-8 col-md-6 d-flex justify-content-md-end align-items-center mb-3 mb-md-0">
                    <a href="#" class="chatbot-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-chat-dots me-2" viewBox="0 0 16 16">
                            <path
                                d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                            <path
                                d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9.06 9.06 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.437 10.437 0 0 1-.524 2.318l-.003.011a10.722 10.722 0 0 1-.244.637c-.079.186.074.394.273.362a21.673 21.673 0 0 0 .693-.125zm.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6c0 3.193-3.004 6-7 6a8.06 8.06 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a10.97 10.97 0 0 0 .398-2z" />
                        </svg>
                        Chatbot HKSR
                    </a>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card modul-card">
                        <img src="{{ asset('assets/images/frontend/modul-1.jpg') }}" class="card-img-top"
                            alt="Modul 1">
                        <div class="card-body">
                            <h5 class="card-title">Pengenalan Kekerasan Seksual</h5>
                            <p class="card-text">Memahami berbagai bentuk kekerasan seksual dan dampaknya pada korban.
                            </p>
                            <a href="#" class="btn btn-primary">Pelajari Modul</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card modul-card">
                        <img src="{{ asset('assets/images/frontend/modul-2.jpg') }}" class="card-img-top"
                            alt="Modul 2">
                        <div class="card-body">
                            <h5 class="card-title">Pencegahan Kekerasan Seksual</h5>
                            <p class="card-text">Strategi dan praktik terbaik untuk mencegah terjadinya kekerasan
                                seksual.</p>
                            <a href="#" class="btn btn-primary">Pelajari Modul</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card modul-card">
                        <img src="{{ asset('assets/images/frontend/modul-3.jpg') }}" class="card-img-top"
                            alt="Modul 3">
                        <div class="card-body">
                            <h5 class="card-title">Aspek Hukum dan Pelaporan</h5>
                            <p class="card-text">Memahami proses hukum dan cara melaporkan kasus kekerasan seksual.</p>
                            <a href="#" class="btn btn-primary">Pelajari Modul</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="#" class="btn btn-outline-primary rounded-pill px-4">Lihat Semua Modul</a>
            </div>
        </div>
    </section>


    @include('frontend.layouts.footer')
    @include('frontend.layouts.script')

</body>

</html>
