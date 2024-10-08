@extends('member.layouts.app')
@section('title')
Absensi Member
@endsection
@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">
@endpush
@section('content')
<style>
    .card-body {
        position: relative;
    }

    .test {
        position: absolute;
        top: 10px;
        right: 10px;
        display: none;
    }

    .card:hover .test {
        display: block;
    }
</style>
<h6 class="mb-0 text-uppercase">Absensi
    @if (request()->searchDate == null)
    {{ date('d F Y') }}
    @else
    {{ date('d F Y', strtotime(request()->searchDate)) }}
    @endif
</h6>

<div class="d-flex flex-column flex-md-row justify-content-end align-items-center mb-2 mt-3">
    <form id="searchForm" class="form-inline d-flex flex-column flex-md-row w-100 mb-2 mb-md-0 me-md-1">
        <div class="input-group mb-2 mb-md-0 w-100 me-md-1">
            <input type="text" class="form-control" id="searchName" name="searchName" placeholder="Enter Member Name">
        </div>
        <div class="input-group mb-2 mb-md-0 w-100 me-md-1">
            <input type="date" class="form-control" id="searchDate" name="searchDate" placeholder="Masukkan Tanggal">
        </div>
        <button type="submit" class="btn btn-primary">Cari</button>
    </form>
    <button type="button" class="btn btn-success w-100 w-md-auto ms-md-1" id="export">Export</button>
</div>
<hr>

<div class="row" id="memberContainer">
    @if (count($data_member) == 0)
    <div class="col-md-12">
        <div class="alert alert-danger" role="alert">
            Data member tidak ditemukan
        </div>
    </div>
    @else
    @foreach ($data_member as $item)
    <div class="col-md-6">
        <div class="card rounded-4" id="attendanceTable">
            <div class="card-header">
                <h3>{{ $item->name }}</h3>                
            </div>
            <div class="card-body">
                <div class="d-flex flex-column gap-3 me-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <h6 class="mb-0">Nomor Whatsapp</h6>
                        </div>
                        <div class="">
                            <h5 class="mb-0">{{ $item->phone_number }}</h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <h6 class="mb-0">Jenis Latihan</h6>
                        </div>
                        <div class="">
                            <h5 class="mb-0">
                                @if ($item->jenis_latihan == null)
                                <button type="button" class="badge bg-danger" style="border: none" data-id="{{ $item->id }}" data-bs-toggle="modal" data-bs-target="#addJenisLatihanModal">Belum Memilih</button>
                                @elseif (count(explode(',', $item->jenis_latihan)) > 2)
                                <button type="button" class="badge bg-success open-multiple-jenis-latihan" style="border: none" data-id="{{ $item->id }}" data data-bs-toggle="modal" data-namaMember="{{$item->name}}" data-jenisLatihan="{{$item->jenis_latihan}}" data-bs-target="#openMultipleJenisLatihan">Multiple</button>
                                @else
                                {{ $item->jenis_latihan }}
                                @endif
                            </h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <h6 class="mb-0">Absen Masuk</h6>
                        </div>
                        <div class="">
                            <h5 class="mb-0">
                                @if ($item->start_time == null)
                                <span class="badge bg-danger">Belum Masuk</span>
                                @else
                                @php
                                $start_time_parts = explode('-', $item->start_time);
                                $formatted_start_time = $start_time_parts[0] . ':' . $start_time_parts[1] . ':' .
                                $start_time_parts[2];
                                @endphp
                                {{ $formatted_start_time }}
                                @endif
                            </h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <h6 class="mb-0">Absen Pulang</h6>
                        </div>
                        <div class="">
                            <h5 class="mb-0">
                                @if ($item->end_time == null)
                                <span class="badge bg-danger">Belum Pulang</span>
                                @else
                                @php
                                $end_time_parts = explode('-', $item->end_time);
                                $formatted_end_time = $end_time_parts[0] . ':' . $end_time_parts[1] . ':' .
                                $end_time_parts[2];
                                @endphp
                                {{ $formatted_end_time }}
                                @endif
                            </h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <h6 class="mb-0">Status</h6>
                        </div>
                        <div class="disabled">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="ada" checked disabled>
                                <label class="form-check-label" for="ada"><b> Active</b></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @endif
</div>
@endsection
@push('script')
<!--plugins-->
<script src="{{ URL::asset('build/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ URL::asset('build/plugins/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ URL::asset('build/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('build/js/main.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>

<script>
document.getElementById('export').addEventListener('click', function() {
    // Siapkan array untuk menampung data
    var data = [];

    // Ambil semua card
    var cards = document.querySelectorAll('#memberContainer .card');

    // Loop melalui setiap card dan ambil data
    cards.forEach(function(card) {
        var name = card.querySelector('.card-header h3').innerText;
        var phone = card.querySelector('.card-body .d-flex:nth-child(1) h5').innerText;
        var jenisLatihan = card.querySelector('.card-body .d-flex:nth-child(2) h5').innerText.trim();
        var startTime = card.querySelector('.card-body .d-flex:nth-child(3) h5').innerText.trim();
        var endTime = card.querySelector('.card-body .d-flex:nth-child(4) h5').innerText.trim();
        var status = card.querySelector('.form-check-label b').innerText.trim();

        // Push data ke dalam array
        data.push({
            'Name': name,
            'Phone Number': phone,
            'Jenis Latihan': jenisLatihan,
            'Start Time': startTime,
            'End Time': endTime,
            'Status': status
        });
    });

    // Convert data ke format Excel menggunakan SheetJS
    var worksheet = XLSX.utils.json_to_sheet(data);
    var workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, "Attendance");

    // Simpan file Excel
    XLSX.writeFile(workbook, 'attendance_history.xlsx');
});

</script>

@endpush