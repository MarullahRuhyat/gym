@extends('personal_training.layouts.app')
@section('title')
Gaji Trainer
@endsection
@push('css')
<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
@endpush
@section('content')
<h6 class="mb-0 text-uppercase">Gaji (nanti Bulan di sini)</h6>
<div class="d-flex flex-column flex-md-row justify-content-end align-items-center mb-2 mt-3">
    <form action="" method="get" class="form-inline d-flex flex-column flex-md-row w-100 mb-2 mb-md-0 ms-md-1">
        <input type="text" class="form-control date-format" placeholder="Masukkan Tanggal">
    </form>
</div>
<hr>

<div class="card radius-10">
    <div class="card-header py-3">
        <div class="row align-items-center g-3">
            <div class="col-12 col-lg-6">
                <h5 class="mb-0">Flozor's Gym</h5>
            </div>
            <div class="col-12 col-lg-6 text-md-end">
                <a href="javascript:;" class="btn btn-danger btn-sm me-2"><i
                        class="bi bi-file-earmark-pdf me-2"></i>Export as PDF</a>
            </div>
        </div>
    </div>
    <div class="card-header py-2">
        <div class="row row-cols-1 row-cols-lg-3">
            <div class="col">
                <div class="">
                    <small>from</small>
                    <address class="m-t-5 m-b-5">
                        <strong class="text-inverse">Flozor's Gym</strong><br> 
                        Jl. Puspowarno Tengah No.6<br>
                        Kec. Semarang Barat, Kota Semarang
                        <br>
                        Jawa Tengah,Salamanmloyo, 50149<br>
                        Phone: (+62) 8170706999<br>
                    </address>
                </div>
            </div>
            <div class="col">
                <div class="">
                    <small>to</small>
                    <address class="m-t-5 m-b-5">
                        <strong class="text-inverse">
                            {{ $user->name }}    
                        </strong><br>
                    </address>
                </div>
            </div>
            <div class="col">
                <div class="">
                    <small>Invoice / July period</small>
                    <div class=""><b>August 3,2012</b></div>
                    <div class="invoice-detail">
                        Invoice #<br>
                        Gaji Trainer
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-invoice">
                <thead>
                    <tr>
                        <th>Gaji Description</th>
                        <th class="text-center" style="width: 10%;">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <span class="text-inverse">Gaji Pokok</span><br>
                        </td>
                        <td class="text-center">
                            Rp.{{ $gaji_pokok->salary }}
                        </td>
                    </tr>
                    @foreach ($bonus as $bonusItem)
                    <tr>
                        <td>
                            <span class="text-inverse">{{ $bonusItem->description }}</span><br>
                        </td>
                        <td class="text-center">Rp.{{ $bonusItem->amount }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="row bg-light align-items-center m-0">
            <div class="col bg-primary col-auto p-4" style="margin-left:auto;">
                <p class="mb-0 text-white">TOTAL</p>
                <h4 class="mb-0 text-white">
                    Rp.{{ $total }}
                </h4>
            </div>
        </div><!--end row-->
        

        <hr>
    </div>

    <div class="card-footer py-3 bg-transparent">
        <p class="text-center mb-2">
            THANK YOU FOR YOUR SERVICE
        </p>
        <p class="text-center d-flex align-items-center gap-3 justify-content-center mb-0">
            <span class=""><i class="bi bi-globe"></i> www.domain.com</span>
            <span class=""><i class="bi bi-telephone-fill"></i> (+62) 8170706999</span>
            <span class=""><i class="bi bi-envelope-fill"></i> flozorsgym@gmail.com</span>
        </p>
    </div>
</div>


@endsection
@push('script')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    $(".date-format").flatpickr({
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
    });

</script>
@endpush
