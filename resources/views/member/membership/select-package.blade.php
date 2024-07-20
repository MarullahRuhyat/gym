@extends('member.layouts.app')
@section('title')
starter Page
@endsection
@section('content')

<div class="card">
    <div class="card-body">
        <ul class="nav nav-tabs nav-primary" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" data-bs-toggle="tab" href="#primaryhome" role="tab" aria-selected="true">
                    <div class="d-flex align-items-center">
                        <div class="tab-icon"><i class="bi bi-person me-1 fs-6"></i>
                        </div>
                        <div class="tab-title">Harian</div>
                    </div>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" data-bs-toggle="tab" href="#primaryprofile" role="tab" aria-selected="false">
                    <div class="d-flex align-items-center">
                        <div class="tab-icon"><i class="bi bi-person me-1 fs-6"></i>
                        </div>
                        <div class="tab-title">Mandiri</div>
                    </div>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" data-bs-toggle="tab" href="#primarycontact" role="tab" aria-selected="false">
                    <div class="d-flex align-items-center">
                        <div class="tab-icon"><i class='bi bi-person me-1 fs-6'></i>
                        </div>
                        <div class="tab-title">PT</div>
                    </div>
                </a>
            </li>
        </ul>
        <div class="tab-content py-3">
            <div class="tab-pane fade show active" id="primaryhome" role="tabpanel">
                <div class="row g-3">
                    <div class="row row-cols-1 row-cols-lg-3 g-4">
                        @foreach($package as $pkg)
                        @if($pkg->type == 'harian')
                        <div class="col-12 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">{{ $pkg->name }}</h5>
                                    <p class="card-text">{{ $pkg->description }}</p>
                                    <h5>Price: ${{ $pkg->price }}</h5>
                                    <div class="mt-3 d-flex align-items-center justify-content-between">
                                        <button style="color:white;" class="btn bg-primary border-0 d-flex gap-2 px-3" onclick="SelectPackage('{{ $pkg->id }}')">
                                            <!-- <i class="material-icons-outlined">shopping_cart</i> -->
                                            Select Package
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="primaryprofile" role="tabpanel">
                <div class="row g-3">
                    <div class="row row-cols-1 row-cols-lg-3 g-4">
                        @foreach($package as $pkg)
                        @if($pkg->type == 'mandiri')
                        <div class="col-12 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">{{ $pkg->name }}</h5>
                                    <p class="card-text">{{ $pkg->description }}</p>
                                    <h5>Price: ${{ $pkg->price }}</h5>
                                    <div class="mt-3 d-flex align-items-center justify-content-between">
                                        <button style="color:white;" class="btn bg-primary border-0 d-flex gap-2 px-3" onclick="SelectPackage('{{ $pkg->id }}')">
                                            <!-- <i class="material-icons-outlined">shopping_cart</i> -->
                                            Select Package
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach

                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="primarycontact" role="tabpanel">
                <div class="row g-3">
                    <div class="row row-cols-1 row-cols-lg-3 g-4">
                        @foreach($package as $pkg)
                        @if($pkg->type == 'pt')
                        <div class="col-12 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">{{ $pkg->name }}</h5>
                                    <p class="card-text">{{ $pkg->description }}</p>
                                    <h5>Price: Rp.{{ $pkg->price }}</h5>
                                    <div class="mt-3 d-flex align-items-center justify-content-between">
                                        <button style="color:white;" class="btn btn-primary border-0 d-flex gap-2 px-3" onclick="SelectPackage('{{ $pkg->id }}')">
                                            <!-- <i class="material-icons-outlined">shopping_cart</i> -->
                                            Select Package
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="ScrollableModal">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-bottom-0 bg-grd-primary py-2">
                <h5 class="modal-title">Detail Payment</h5>
                <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="modal">
                    <i class="material-icons-outlined">close</i>
                </a>
            </div>
            <div class="modal-body">
                <form action="{{ route('member.payment') }}" method="GET">
                    @csrf
                    <input type="hidden" name="submit_user_id" id="submit_user_id" value="">
                    <input type="hidden" name="submit_package_id" id="submit_package_id" value="">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <input type="text" name="package_id" id="package_id" value="">
                                <h4 class="card-title mb-4 fw-bold">Summary</h4>
                                <div>
                                    <div class="d-flex justify-content-between">
                                        <p class="fw-semi-bold">Items subtotal :</p>
                                        <p id="payment-item-total" class="fw-semi-bold">$891</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class="fw-semi-bold">Discount :</p>
                                        <p id="payment-discount" class="text-danger fw-semi-bold">-$48</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class="fw-semi-bold">Tax :</p>
                                        <p id="payment-tax" class="fw-semi-bold">$156.70</p>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between border-top pt-4">
                                    <h5 class="mb-0 fw-bold">Total :</h5>
                                    <h5 id="payment-total" class="mb-0 fw-bold">$925.44</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary px-4" onclick="Pay()">Pay</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script>
    function SelectPackage(id) {
        $('#ScrollableModal').modal('show');
        $('#package_id').val(id);
    }

    function Pay() {
        var user_id = '{{ Auth::user()->id }}';
        var package_id = $('#package_id').val();
        $.ajax({
            type: 'POST',
            url: "{{ route('member.select.package') }}",
            data: {
                user_id: user_id,
                package_id: package_id,
                _token: '{{ csrf_token() }}'
            },
        });
    }
</script>
<!--plugins-->
<script src="{{ URL::asset('build/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ URL::asset('build/plugins/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ URL::asset('build/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('build/js/main.js') }}"></script>
@endpush