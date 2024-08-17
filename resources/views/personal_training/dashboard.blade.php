@extends('personal_training.layouts.app')
@section('title')
starter Page
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 d-flex align-items-stretch">
        <div class="card w-100 rounded-4">
            <div class="card-body">
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="">
                            <h5 class="mb-0">Member</h5>
                        </div>
                    </div>
                    <div class="position-relative">
                        <div class="piechart-legend">
                        </div>
                        <div id="member" style="min-height: 30px !important"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<!--plugins-->
<script src="{{ URL::asset('build/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ URL::asset('build/plugins/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ URL::asset('build/plugins/apexchart/apexcharts.min.js') }}"></script>
<script src="{{ URL::asset('build/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('build/plugins/peity/jquery.peity.min.js') }}"></script>
<script>
    $(".data-attributes span").peity("donut")
</script>
<script src="{{ URL::asset('build/js/main.js') }}"></script>
<script>
    // Fungsi untuk menghasilkan warna acak dalam format hexadecimal
    function getRandomColor() {
        const letters = '0123456789ABCDEF';
        let color = '#';
        for (let i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    // Membuat array warna acak berdasarkan jumlah data
    var colors = @json($series).map(() => getRandomColor());

    var options = {
        chart: {
            type: 'bar',
            height: 300 // Sesuaikan tinggi chart sesuai keinginan
        },
        series: [{
            name: 'Active Members',
            data: @json($series)
        }],
        xaxis: {
            categories: @json($labels)
        },
        colors: colors, // Menggunakan warna acak yang dihasilkan
        plotOptions: {
            bar: {
                distributed: true // Ini akan mendistribusikan warna ke setiap bar
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#member"), options);
    chart.render();
</script>
@endpush