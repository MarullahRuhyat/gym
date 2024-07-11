@extends('personal_training.layouts.app')
@section('title')
Absensi Member
@endsection
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
<h6 class="mb-0 text-uppercase">Absensi (nanti tanggal di sini)</h6>
<div class="d-flex flex-column flex-md-row justify-content-end align-items-center mb-2 mt-3">
    <form action="" method="get" class="form-inline d-flex flex-column flex-md-row w-100 mb-2 mb-md-0 me-md-1">
        <div class="input-group mb-2 mb-md-0 w-100 me-md-1">
            <input type="text" class="form-control" id="searchName" name="searchName"
                placeholder="Masukkan Nama Member">
            <button type="submit" class="btn btn-primary">Cari</button>
        </div>
    </form>
    <form action="" method="get" class="form-inline d-flex flex-column flex-md-row w-100 mb-2 mb-md-0 ms-md-1">
        <div class="input-group mb-2 mb-md-0 w-100 me-md-1">
            <input type="date" class="form-control" id="searchDate" name="searchDate"
                placeholder="Masukkan Nama Member">
            <button type="submit" class="btn btn-primary">Cari</button>
        </div>
    </form>
    <button type="button" class="btn btn-success w-100 w-md-auto ms-md-1">Export</button>
</div>
<hr>

<div class="row">

    <div class="col-md-6">
        <div class="card rounded-4">
            <div class="card-header">
                <h3>Heru Budi</h3>
                <div class="test">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="dropdown">
                        <i class="bi bi-three-dots-vertical"></i>
                        <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                        <a class="dropdown-item" href="javascript:;">Edit</a>
                        <a class="dropdown-item" href="javascript:;">Delete</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column gap-3 me-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <h6 class="mb-0">Nomor Whatsapp</h6>
                        </div>
                        <div class="">
                            <h5 class="mb-0">08994668927</h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <h6 class="mb-0">Jenis Latihan</h6>
                        </div>
                        <div class="">
                            <h5 class="mb-0">Kaki</h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <h6 class="mb-0">Status</h6>
                        </div>
                        <div class="">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="ada">
                                <label class="form-check-label" for="ada"><b> Active</b></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card rounded-4">
            <div class="card-header">
                <h3>Heru Budi</h3>
                <div class="test">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="dropdown">
                        <i class="bi bi-three-dots-vertical"></i>
                        <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                        <a class="dropdown-item" href="javascript:;">Edit</a>
                        <a class="dropdown-item" href="javascript:;">Delete</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column gap-3 me-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <h6 class="mb-0">Nomor Whatsapp</h6>
                        </div>
                        <div class="">
                            <h5 class="mb-0">08994668927</h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <h6 class="mb-0">Jenis Latihan</h6>
                        </div>
                        <div class="">
                            <h5 class="mb-0">Kaki</h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <h6 class="mb-0">Status</h6>
                        </div>
                        <div class="">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="ada">
                                <label class="form-check-label" for="ada"><b> Active</b></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@push('script')

@endpush
