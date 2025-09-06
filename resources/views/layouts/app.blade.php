<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Bootstrap Icons CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <link rel="stylesheet" href="{{ asset('assets/css/dashlitee1e3.css?ver=3.2.4') }}">
    <link id="skin-default" rel="stylesheet" href="{{ asset('assets/css/themee1e3.css?ver=3.2.4') }}">
</head>

<body class="nk-body bg-lighter npc-general has-sidebar ">
    <div class="nk-app-root">
        <div class="nk-main ">
            <div class="nk-wrap ">
                @include('layouts.navigation')

                <!-- Page Content -->
                <div class="nk-content ">
                    @yield('content')
                </div>
            </div>

            <div class="nk-footer">
                <div class="container-fluid">
                    <div class="nk-footer-wrap">
                        <div class="nk-footer-copyright float-center"> &copy; 2025 {{ config('app.name') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/bundlee1e3.js?ver=3.2.4') }}"></script>
    <script src="{{ asset('assets/js/scriptse1e3.js?ver=3.2.4') }}"></script>
    <script src="{{ asset('assets/js/demo-settingse1e3.js?ver=3.2.4') }}"></script>
    <script src="{{ asset('assets/js/charts/gd-defaulte1e3.js?ver=3.2.4') }}"></script>
    <script src="{{ asset('assets/js/libs/datatable-btnse1e3.js?ver=3.2.4') }}"></script>
</body>

</html>