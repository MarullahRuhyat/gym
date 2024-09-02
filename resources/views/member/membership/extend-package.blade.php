@extends('member.layouts.app')
@section('title')
starter Page
@endsection
@section('content')
@if($packages->isEmpty())
<div class="justify-content-center text-center">
    <!-- you don't have any membership yet -->
     <div class="col my-5">
        <p>You don't have any membership yet</p>
     </div>
    <div class="col my-5">
        <a href="{{ route('member.buy-new-package') }}" class="btn btn-grd btn-grd-deep-blue px-5">Buy Membership</a>
    </div>
</div>
@endif
@foreach($packages as $pkg)
<!-- notif response  -->
 @if (session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<h5 class="mb-1">Package Details</h5>
<p class="mb-4">This is details package</p>
<div class="row g-3">
    <div class="col">
        <div class="card">
            <div class="row g-0">
                <div class="col-md-4 border-end">
                    <div class="p-3">
                        <img src="{{ URL::asset('build/images/02.png') }}"
                            class="w-100 rounded h-100" alt="...">
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <input type="hidden" name="package_id" id="package_id" value="{{ $pkg->id }}">
                        <input type="hidden" name="membership_id" id="membership_id" value="{{ $pkg->membership_id }}">
                        <h5 class="card-title mb-3">{{ ucwords($pkg->name) }}</h5>
                        <p class="card-text">{{ $pkg->description }}</p>
                        <h5 class="card-title mb-3">Duration: {{ $pkg->duration_in_days }} Days</h5>
                        <h5 class="card-title mb-3">Price: Rp.{{ number_format($pkg->price, 0, ',', '.') }}</h5>
                    </div>
                    <div class="card-footer">
                        <!-- button onclick with price as parameter  -->
                        <button class="btn btn-primary disabled" onclick="onclickPayNow('{{ $pkg->price }}')">
                        <!-- <button class="btn btn-primary" onclick="onclickPayNow()"> -->
                            Pay Now
                        </button>

                        {{-- button green paycash --}}
                        <button class="btn btn-success" onclick="showCashPaymentModal('{{ $pkg->price }}')">Pay Cash</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!---end row-->

<!-- modal payment  -->
<div class="modal fade" id="modalPayment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Payment Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <!-- <h5 class="mb-1">Payment</h5>
                <p class="mb-4">Payment Details</p> -->
                @foreach ($packages as $pkg)
                <div class="row g-3">
                    <form action="{{ route('member.payment') }}" method="GET">
                        @csrf
                        <input type="hidden" name="payment_phone_number" id="payment_phone_number" value="{{ Auth::user()->phone_number }}">
                        <input type="hidden" name="submit_package_id" id="submit_package_id" value="{{ $pkg->id }}">
                        <input type="hidden" name="payment_amount" id="payment_amount" value="{{ $pkg->price }}">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4 fw-bold">Summary</h4>
                                    <div>
                                        <div class="d-flex justify-content-between">
                                            <p class="fw-semi-bold">Items subtotal :</p>
                                            <p name="payment-item-total" class="fw-semi-bold" id="payment-item-total"> Rp.{{ number_format($pkg->price, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <p class="fw-semi-bold">Fee User Registration :</p>
                                            <p name="payment-user-registered" class="fw-semi-bold">Rp. 0</p>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <p class="fw-semi-bold">Discount :</p>
                                            <p name="payment-discount" class="text-danger fw-semi-bold">Rp.-</p>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <p class="fw-semi-bold">Tax :</p>
                                            <p name="payment-tax" class="fw-semi-bold">Rp.-</p>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between border-top pt-4">
                                        <h5 class="mb-0 fw-bold">Total :</h5>
                                        <h5 name="payment-total" class="mb-0 fw-bold"> Rp.{{ number_format($pkg->price, 0, ',', '.') }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center gap-3">
                                <button type="submit" class="btn btn-primary px-4">Pay</button>
                            </div>
                        </div>
                    </form>
                </div>
                @endforeach
                <!---end row-->
            </div>
        </div>
    </div>
</div>
<!-- end modal payment  -->

<div class="modal fade" id="modalCashPayment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Payment Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda akan melanjutkan pembayaran dengan cash dengan nominal <strong style="font-size: 20px;" id="cash-payment-total"></strong></p>
                    <!-- <h5 name="payment-total" class="mb-0 fw-bold" id="cash-payment-total"></h5>?</span></p> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                <button type="button" class="btn btn-primary" onclick="submitCashPayment()">Ya</button>
            </div>
        </div>
    </div>
</div>

@endforeach

@endsection
@push('script')
<script>
      function showCashPaymentModal(price) {
        // Set the payment total in the modal
        document.getElementById('cash-payment-total').innerText = 'Rp.' + price.toLocaleString('id-ID', {minimumFractionDigits: 0});

        // Show the modal
        $('#modalCashPayment').modal('show');
    }

    function submitCashPayment() {
        $.ajax({
            url: "{{ route('member.submit-cash-extend-payment') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                package_id: $('#package_id').val(),
                amount: $('#cash-payment-total').text().replace('Rp.', '').replace(/\./g, ''), // Remove Rp. and dots
                membership_id: $('#membership_id').val(),
            },
            success: function(data) {
                if(data.status === true) {
                    $('#modalCashPayment').modal('hide');
                    alert(data.message);
                    // Reload the page or redirect to another page
                    window.location.reload();
                } else {
                    alert(data.message);
                }
            },
            error: function(error) {
                console.log(error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            }
        });
    }

    function onclickPayNow(){
        $.ajax({
            url: "{{ route('member.submit-extend-package') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                'membership_id': $('#membership_id').val(),
                'package_id': $('#package_id').val(),
            },
            success: function(data){
                if(data.status == true){
                    $('#modalPayment').modal('show');
                } else {
                    alert(data.message);
                }
            }
        });
    }
</script>

<!--bootstrap js-->
<!-- <script src="{{ URL::asset('build/js/bootstrap.bundle.min.js') }}"></script> -->
<!--plugins-->
<script src="{{ URL::asset('build/js/jquery.min.js') }}"></script>
<!--plugins-->
<script src="{{ URL::asset('build/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ URL::asset('build/plugins/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ URL::asset('build/plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
<script src="{{ URL::asset('build/plugins/bs-stepper/js/main.js') }}"></script>
<script src="{{ URL::asset('build/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('build/js/main.js') }}"></script>
@endpush
