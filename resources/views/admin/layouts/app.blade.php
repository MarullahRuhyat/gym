<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light-theme">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | Laravel 11 & Bootstrap 5 Admin Dashboard Template</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ URL::asset('build/images/favicon-32x32.png') }}" type="image/png">

    @include('admin.layouts.head-css')
    <style>
        .gray-color {
            color: #a2a2a2;
        }
    </style>
</head>

<body>

    @include('admin.layouts.topbar')

    @include('admin.layouts.sidebar')

    <!--start main wrapper-->
    <main class="main-wrapper">
        <div class="main-content">
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif
            @yield('content')
        </div>
    </main>

    <!--start overlay-->
    <div class="overlay btn-toggle"></div>
    <!--end overlay-->

    @include('admin.layouts.extra')

    @include('admin.layouts.common-scripts')
    <script>
        // format rupiah
        function formatRupiah(angka, prefix) {
            var numberString = angka.replace(/[^,\d]/g, '').toString(),
                split = numberString.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix ? 'Rp. ' + rupiah : rupiah;
        }


        function updateRupiahElements(usePrefix = true) {
            var elements = document.getElementsByClassName('rupiah');
            for (var i = 0; i < elements.length; i++) {
                var originalValue = elements[i].innerText || elements[i].textContent;
                elements[i].innerText = formatRupiah(originalValue, usePrefix);
            }
        }

        $(document).ready(function() {
            updateRupiahElements();

            $(document).on('input', '.angka-rupiah', function() {
                let nilai = $(this).val()
                nilai = formatRupiah(nilai, false)
                $(this).val(nilai)
            });
        });
    </script>
    @yield('javascript')
</body>

</html>