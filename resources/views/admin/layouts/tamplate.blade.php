<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>Halaman | @yield('title')</title>
    @include('admin.layouts.head')
    @yield('css')
</head>
<style>
    body {
        font-family: 'Poppins', sans-serif;
    }
</style>

<body>
    <div class="wrapper">
        {{-- sidebar --}}
        @include('admin.layouts.sidebar')

        <div class="main">
            {{-- header --}}
            @include('admin.layouts.header')

            <main class="content">
                <div class="container-fluid p-0">
                    {{-- content --}}
                    @yield('content')

                </div>
            </main>

            @include('admin.layouts.footer')

        </div>
    </div>

    <input type="hidden" id="urlnotifikasi" value="{{ url('/notifikasilonceng') }}">
    @include('admin.layouts.js')
    @yield('js')

</body>

</html>
