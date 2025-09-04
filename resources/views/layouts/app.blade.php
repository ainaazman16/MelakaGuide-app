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

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    {{-- Top Navbar --}}
    @include('vendor.adminlte.partials.navbar.navbar')

    {{-- Sidebar --}}
    @include('vendor.adminlte.partials.sidebar.left-sidebar')

    {{-- Page Content Wrapper --}}
    <div class="content-wrapper">
        <!-- Page Header -->
        @isset($header)
            <section class="content-header">
                <div class="container-fluid">
                    <h1>{{ $header }}</h1>
                </div>
            </section>
        @endisset

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </section>
    </div>

    {{-- Footer (optional, AdminLTE has one too) --}}
    @includeIf('vendor.adminlte.partials.footer.footer')

</div>
</body>
</html>
