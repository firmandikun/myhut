<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel App') }}</title>

    <!-- Remix Icon -->
    <link rel="stylesheet" href="{{ asset('assets/css/remixicon.css') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/bootstrap.min.css') }}">

    <!-- Apex Chart CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/apexcharts.css') }}">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/dataTables.min.css') }}">

    <!-- Text Editor CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/editor-katex.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lib/editor.atom-one-dark.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lib/editor.quill.snow.css') }}">

    <!-- Date Picker CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/flatpickr.min.css') }}">

    <!-- Calendar CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/full-calendar.css') }}">

    <!-- Vector Map CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/jquery-jvectormap-2.0.5.css') }}">

    <!-- Popup CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/magnific-popup.css') }}">

    <!-- Slick Slider CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/slick.css') }}">

    <!-- Prism CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/prism.css') }}">

    <!-- File Upload CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/file-upload.css') }}">

    <!-- Audio Player CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/audioplayer.css') }}">

    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">


    {{-- Tambahkan CSS tambahan jika diperlukan --}}
    @stack('styles')
</head>

<body class="bg-gray-100 text-gray-900">

    {{-- Sidebar --}}
    @include('layouts.sidebar')

    {{-- Navbar --}}

    {{-- Content --}}
    <main class="dashboard-main">
        @include('layouts.header')
        @yield('content')

        {{-- Footer --}}
        {{-- @include('layouts.footer') --}}
    </main>

    <!-- jQuery Library -->
    <script src="{{ asset('assets/js/lib/jquery-3.7.1.min.js') }}"></script>

    <!-- Bootstrap Bundle -->
    <script src="{{ asset('assets/js/lib/bootstrap.bundle.min.js') }}"></script>

    <!-- Apex Charts -->
    <script src="{{ asset('assets/js/lib/apexcharts.min.js') }}"></script>

    <!-- DataTables -->
    <script src="{{ asset('assets/js/lib/dataTables.min.js') }}"></script>

    <!-- Iconify Font -->
    <script src="{{ asset('assets/js/lib/iconify-icon.min.js') }}"></script>

    <!-- jQuery UI -->
    <script src="{{ asset('assets/js/lib/jquery-ui.min.js') }}"></script>

    <!-- Vector Map -->
    <script src="{{ asset('assets/js/lib/jquery-jvectormap-2.0.5.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/jquery-jvectormap-world-mill-en.js') }}"></script>

    <!-- Popup -->
    <script src="{{ asset('assets/js/lib/magnifc-popup.min.js') }}"></script>

    <!-- Slick Slider -->
    <script src="{{ asset('assets/js/lib/slick.min.js') }}"></script>

    <!-- Prism -->
    <script src="{{ asset('assets/js/lib/prism.js') }}"></script>

    <!-- File Upload -->
    <script src="{{ asset('assets/js/lib/file-upload.js') }}"></script>

    <!-- Audio Player -->
    <script src="{{ asset('assets/js/lib/audioplayer.js') }}"></script>

    <!-- Main App JS -->
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <!-- Custom Chart JS -->
    <script src="{{ asset('assets/js/homeOneChart.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Tambahkan di layouts/app.blade.php -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>





    {{-- Tambahkan JS tambahan jika diperlukan --}}
    @stack('scripts')
</body>

</html>
