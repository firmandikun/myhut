<!DOCTYPE html>
<html lang="en">

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

<body>
    <section class="auth bg-base d-flex flex-wrap align-items-center justify-content-center">

            <div class="max-w-464-px mx-auto w-100">
                <div>

                    <h4 class="mb-12">Sign In to your Account</h4>
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
    </section>
</body>

</html>
