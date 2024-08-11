@extends('member.layouts.app')
@section('title')
starter Page
@endsection
@section('content')

<div class="card">
    <div class="card-body">
        <ul class="nav nav-tabs nav-primary" role="tablist">
            @foreach($groupedPackages as $typeName => $packages)
                <li class="nav-item" role="presentation">
                    <a class="nav-link @if($loop->first) active @endif" data-bs-toggle="tab" href="#tab{{ $loop->index }}" role="tab" aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                        <div class="d-flex align-items-center">
                            <div class="tab-icon"><i class="bi bi-person me-1 fs-6"></i></div>
                            <div class="tab-title">{{ $typeName }}</div>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
        <div class="tab-content py-3">
            @foreach($groupedPackages as $typeName => $packages)
                <div class="tab-pane fade @if($loop->first) show active @endif" id="tab{{ $loop->index }}" role="tabpanel">
                    <div class="row g-3">
                        <div class="row row-cols-1 row-cols-lg-3 g-4">
                            @foreach($packages as $pkg)
                                <div class="col-12 col-lg-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title mb-3">{{ $pkg->name }}</h5>
                                            <p class="card-text">{{ $pkg->description }}</p>
                                            <p class="card-text">Duration: {{ $pkg->duration_in_days }} Days</p>
                                            <h5>Price:
                                                Rp.{{ number_format($pkg->price, 0, ',', '.') }}
                                            </h5>
                                            <div class="mt-3 d-flex align-items-center justify-content-between">
                                                <button style="color:white;" class="btn bg-primary border-0 d-flex gap-2 px-3" onclick="SetStartDate('{{ $pkg->id }}')">
                                                    Select Package
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- modal start input start_date  if click submit redirect to next modal -->
 <div class="modal fade" id="SetStartDate">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-bottom-0 bg-primary py-2">
                <h5 class="modal-title" style="color:white">Set Start Date</h5>
                <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="modal">
                    <i class="material-icons-outlined">close</i>
                </a>
            </div>
            <div class="modal-body">
                <input type="hidden" name="pkg_id" id="pkg_id">
                    <div class="col">
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-flex justify-content-end mt-4">
                            <button style="color:white;" class="btn bg-primary border-0 d-flex gap-2 px-3" onclick="SelectPackage('{{ $pkg->id }}')">
                                Next
                            </button>
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
            <div class="modal-header border-bottom-0 bg-primary py-2">
                <h5 class="modal-title" style="color:white">Detail Payment</h5>
                <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="modal">
                    <i class="material-icons-outlined">close</i>
                </a>
            </div>
            <div class="modal-body">
                <form action="{{ route('member.payment') }}" method="GET">
                    @csrf
                    <input type="hidden" name="submit_package_id" id="submit_package_id" value="">
                    <!-- <input type="hidden" name="submit_user_id" id="submit_user_id" value="{{ Auth::user()->id }}"> -->
                    <input type="hidden" name="payment_phone_number" id="payment_phone_number" value="{{ Auth::user()->phone_number }}">
                    <input type="hidden" name="submit_start_date" id="submit_start_date" value="">
                    <input type="hidden" name="payment_amount" id="payment_amount" value="">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4 fw-bold">Summary</h4>
                                <div>
                                    <div class="d-flex justify-content-between">
                                        <p class="fw-semi-bold">Items subtotal :</p>
                                        <p id="payment-item-total" class="fw-semi-bold"></p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class="fw-semi-bold">Discount :</p>
                                        <p id="payment-discount" class="text-danger fw-semi-bold">Rp.-</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class="fw-semi-bold">Tax :</p>
                                        <p id="payment-tax" class="fw-semi-bold">Rp.-</p>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between border-top pt-4">
                                    <h5 class="mb-0 fw-bold">Total :</h5>
                                    <h5 id="payment-total" class="mb-0 fw-bold"></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-grd-deep-blue px-4">Pay</button>
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
    function SetStartDate(id) {
        $('#pkg_id').val(id);
        $('#SetStartDate').modal('show');
    }

    function SelectPackage() {
        var start_date = $('#start_date').val();
        var id = $('#pkg_id').val();

        // if start_date is empty show alert message
        if (start_date == '') {
            alert('Start Date is required');
            return;
        }
        if (start_date < "{{ date('Y-m-d') }}") {
            alert('Start Date must be greater than today');
            return;
        }

        $('#SetStartDate').modal('hide');
        $('#ScrollableModal').modal('show');
        $('#submit_package_id').val(id);
        $('#submit_start_date').val(start_date);
        $.ajax({
            type: 'GET',
            url: "/member/package/selected-package-detail/" + id,
            data: {
                id: id,
            },
            success: function(response) {
                // $('#payment-item-total').text('Rp.' + response.price);
                // format number
                $('#payment-item-total').text('Rp.' + response.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                // $('#payment-total').text('Rp.' + response.price);
                // format number
                $('#payment-total').text('Rp.' + response.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                $('#payment_amount').val(response.price);
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }
</script>
<!--plugins-->
<script src="{{ URL::asset('build/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ URL::asset('build/plugins/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ URL::asset('build/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('build/js/main.js') }}"></script>
@endpush
