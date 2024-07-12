@extends('admin.layouts.app')
@section('title')
starter Page
@endsection
@section('content')
<div class="row">
    <div class="col-md-6 d-flex align-items-stretch">
        <div class="card w-100 rounded-4">
            <div class="card-body">
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="">
                            <h5 class="mb-0">Device Type</h5>
                        </div>
                        <div class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle-nocaret options dropdown-toggle" data-bs-toggle="dropdown">
                                <span class="material-icons-outlined fs-5">more_vert</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="javascript:;">Action</a></li>
                                <li><a class="dropdown-item" href="javascript:;">Another action</a></li>
                                <li><a class="dropdown-item" href="javascript:;">Something else here</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="position-relative">
                        <div class="piechart-legend">
                            <h2 class="mb-1">68%</h2>
                            <h6 class="mb-0">Total Views</h6>
                        </div>
                        <div id="chart7"></div>
                    </div>
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="mb-0 d-flex align-items-center gap-2 w-25"><span class="material-icons-outlined fs-6 text-primary">desktop_windows</span>Desktop</p>
                            <div class="">
                                <p class="mb-0">35%</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="mb-0 d-flex align-items-center gap-2 w-25"><span class="material-icons-outlined fs-6 text-danger">tablet_mac</span>Tablet</p>
                            <div class="">
                                <p class="mb-0">48%</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="mb-0 d-flex align-items-center gap-2 w-25"><span class="material-icons-outlined fs-6 text-success">phone_android</span>Mobile</p>
                            <div class="">
                                <p class="mb-0">27%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 d-flex align-items-stretch">
        <div class="card w-100 rounded-4">
            <div class="card-body">
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="">
                            <h5 class="mb-0">Device Type</h5>
                        </div>
                        <div class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle-nocaret options dropdown-toggle" data-bs-toggle="dropdown">
                                <span class="material-icons-outlined fs-5">more_vert</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="javascript:;">Action</a></li>
                                <li><a class="dropdown-item" href="javascript:;">Another action</a></li>
                                <li><a class="dropdown-item" href="javascript:;">Something else here</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="position-relative">
                        <div class="piechart-legend">
                            <h2 class="mb-1">68%</h2>
                            <h6 class="mb-0">Total Views</h6>
                        </div>
                        <div id="chart6"></div>
                    </div>
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="mb-0 d-flex align-items-center gap-2 w-25"><span class="material-icons-outlined fs-6 text-primary">desktop_windows</span>Desktop</p>
                            <div class="">
                                <p class="mb-0">35%</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="mb-0 d-flex align-items-center gap-2 w-25"><span class="material-icons-outlined fs-6 text-danger">tablet_mac</span>Tablet</p>
                            <div class="">
                                <p class="mb-0">48%</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="mb-0 d-flex align-items-center gap-2 w-25"><span class="material-icons-outlined fs-6 text-success">phone_android</span>Mobile</p>
                            <div class="">
                                <p class="mb-0">27%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 d-flex align-items-stretch">
        <div class="card w-100 rounded-4">
            <div class="card-body">
                <div class="text-center">
                    <h6 class="mb-0">Monthly Revenue</h6>
                </div>
                <div class="mt-4" id="chart5"></div>
                <p>Avrage monthly sale for every author</p>
                <div class="d-flex align-items-center gap-3 mt-4">
                    <div class="">
                        <h1 class="mb-0 text-primary">68.9%</h1>
                    </div>
                    <div class="d-flex align-items-center align-self-end">
                        <p class="mb-0 text-success">34.5%</p>
                        <span class="material-icons-outlined text-success">expand_less</span>
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
<!-- <script src="{{ URL::asset('build/js/dashboard1.js') }}"></script> -->
<script>
    new PerfectScrollbar(".user-list")
</script>
<script>
    $(document).ready(function() {

        // chart 7
        var options = {
            series: [58, 25, 25],
            chart: {
                height: 290,
                type: 'donut',
            },
            legend: {
                position: 'bottom',
                show: !1
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    gradientToColors: ['#ee0979', '#17ad37', '#ec6ead'],
                    shadeIntensity: 1,
                    type: 'vertical',
                    opacityFrom: 1,
                    opacityTo: 1,
                    //stops: [0, 100, 100, 100]
                },
            },
            colors: ["#ff6a00", "#98ec2d", "#3494e6"],
            dataLabels: {
                enabled: !1
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: "85%"
                    }
                }
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        height: 270
                    },
                    legend: {
                        position: 'bottom',
                        show: !1
                    }
                }
            }]
        };

        var chart = new ApexCharts(document.querySelector("#chart7"), options);
        chart.render();


        // chart 6
        var options = {
            series: [58, 25, 25],
            chart: {
                height: 290,
                type: 'donut',
            },
            legend: {
                position: 'bottom',
                show: !1
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    gradientToColors: ['#ee0979', '#17ad37', '#ec6ead'],
                    shadeIntensity: 1,
                    type: 'vertical',
                    opacityFrom: 1,
                    opacityTo: 1,
                    //stops: [0, 100, 100, 100]
                },
            },
            colors: ["#ff6a00", "#98ec2d", "#3494e6"],
            dataLabels: {
                enabled: !1
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: "85%"
                    }
                }
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        height: 270
                    },
                    legend: {
                        position: 'bottom',
                        show: !1
                    }
                }
            }]
        };

        var chart = new ApexCharts(document.querySelector("#chart6"), options);
        chart.render();


        // chart 5

        var options = {
            series: [{
                name: "Desktops",
                data: [14, 41, 35, 51, 25, 18, 21, 35, 15]
            }],
            chart: {
                foreColor: "#9ba7b2",
                height: 280,
                type: 'bar',
                toolbar: {
                    show: !1
                },
                sparkline: {
                    enabled: !1
                },
                zoom: {
                    enabled: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                width: 1,
                curve: 'smooth'
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    borderRadius: 4,
                    borderRadiusApplication: 'around',
                    borderRadiusWhenStacked: 'last',
                    columnWidth: '45%',
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    gradientToColors: ['#009efd'],
                    shadeIntensity: 1,
                    type: 'vertical',
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 100, 100, 100]
                },
            },
            colors: ["#2af598"],
            grid: {
                show: true,
                borderColor: 'rgba(255, 255, 255, 0.1)',
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
            },
            tooltip: {
                theme: "dark",
                marker: {
                    show: !1
                }
            },
        };

        var chart = new ApexCharts(document.querySelector("#chart5"), options);
        chart.render();
    })
</script>
@endpush