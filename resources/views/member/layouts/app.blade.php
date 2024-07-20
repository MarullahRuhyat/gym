<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light-theme">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | Laravel 11 & Bootstrap 5 member Dashboard Template</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ URL::asset('build/images/favicon-32x32.png') }}" type="image/png">

    @include('member.layouts.head-css')
    @yield('css')
    <style>
        .gray-color {
            color: #a2a2a2;
        }
    </style>
</head>

<body>

    @include('member.layouts.topbar')

    <!--start main wrapper-->
    <main class="main-wrapper" style="margin-left: 0;">
        <div class="main-content">
            @yield('content')
        </div>
    </main>

    <!--start overlay-->
    <div class="overlay btn-toggle"></div>
    <!--end overlay-->    

    @include('member.layouts.common-scripts')
    @include('member.layouts.footer')
    @include('member.layouts.extra')
</body>

</html>
