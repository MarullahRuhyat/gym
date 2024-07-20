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
                            <h5 class="mb-0">Member</h5>
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
                            <h2 class="mb-1" id="total_member"></h2>
                            <h6 class="mb-0">Total Member</h6>
                        </div>
                        <div id="member"></div>
                    </div>
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="mb-0 d-flex align-items-center gap-2 w-25"><span class="material-icons-outlined fs-6 text-success">fiber_manual_record</span>Active</p>
                            <div class="">
                                <p class="mb-0" id="active_member"></p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="mb-0 d-flex align-items-center gap-2 w-25"><span class="material-icons-outlined fs-6 text-danger">fiber_manual_record</span>Inactive</p>
                            <div class="">
                                <p class="mb-0" id="inactive_member"></p>
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
                            <h5 class="mb-0">Personal Trainer</h5>
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
                            <h2 class="mb-1" id="total_pt"></h2>
                            <h6 class="mb-0">Total PT</h6>
                        </div>
                        <div id="pt"></div>
                    </div>
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="mb-0 d-flex align-items-center gap-2 w-25"><span class="material-icons-outlined fs-6 text-success">fiber_manual_record</span>Active</p>
                            <div class="">
                                <p class="mb-0" id="active_pt"></p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="mb-0 d-flex align-items-center gap-2 w-25"><span class="material-icons-outlined fs-6 text-danger">fiber_manual_record</span>Inactive</p>
                            <div class="">
                                <p class="mb-0" id="inactive_pt"></p>
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
                    <h6 class="mb-0">Absent Member</h6>
                </div>
                <div class="mt-4" id="absent"></div>
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
        var formData = {
            _token: '{{ csrf_token() }}' // Ensure you include the CSRF token
        };

        $.ajax({
            url: `{{ route('admin_ajax_dashboard')}}`, // The route to your controller
            type: 'POST',
            data: formData,
            success: function(response) {
                chart_member(parseInt(response['memberStatus']['active']), parseInt(response['memberStatus']['inactive']));
                chart_pt(parseInt(response['trainerStatus']['active']), parseInt(response['trainerStatus']['inactive']));
                chart_absent(response['absent'])
            },
            error: function(xhr, status, error) {
                console.log('error');
            }
        });

        function chart_member(active, inactive) {
            $('#total_member').html(active + inactive);
            $('#active_member').html(active);
            $('#inactive_member').html(inactive)
            var options = {
                series: [active, inactive],
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
                        gradientToColors: ['#17ad37', '#ee0979', '#ec6ead'],
                        shadeIntensity: 1,
                        type: 'vertical',
                        opacityFrom: 1,
                        opacityTo: 1,
                    },
                },
                colors: ["#98ec2d", "#ff6a00", "#3494e6"],
                dataLabels: {
                    enabled: !1
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: "75%"
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(value, {
                            seriesIndex
                        }) {
                            return seriesIndex === 0 ? 'Active: ' + value : 'Inactive: ' + value;
                        }
                    },
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

            var chart = new ApexCharts(document.querySelector("#member"), options);
            chart.render();
        }

        function chart_pt(active, inactive) {
            $('#total_pt').html(active + inactive);
            $('#active_pt').html(active);
            $('#inactive_pt').html(inactive);
            var options = {
                series: [active, inactive],
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
                        gradientToColors: ['#17ad37', '#ee0979', '#ec6ead'],
                        shadeIntensity: 1,
                        type: 'vertical',
                        opacityFrom: 1,
                        opacityTo: 1,
                    },
                },
                colors: ["#98ec2d", "#ff6a00", "#3494e6"],
                dataLabels: {
                    enabled: !1
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: "75%"
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(value, {
                            seriesIndex
                        }) {
                            return seriesIndex === 0 ? 'Active: ' + value : 'Inactive: ' + value;
                        }
                    },
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

            var chart = new ApexCharts(document.querySelector("#pt"), options);
            chart.render();
        }


        function chart_absent(results) {
            let bulan = []
            let data = []
            results.forEach(row => {
                bulan.push(row['bulan']);
                data.push(row['jumlah_latihan']);
            });
            // chart 5
            var options = {
                series: [{
                    name: "Total",
                    data: data
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
                    categories: bulan,
                },
                tooltip: {
                    theme: "dark",
                    marker: {
                        show: !1
                    }
                },
            };

            var chart = new ApexCharts(document.querySelector("#absent"), options);
            chart.render();
        }

    });
</script>
@endpush