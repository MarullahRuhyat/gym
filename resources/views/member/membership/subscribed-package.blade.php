@extends('member.layouts.app')
@section('title')
Subscribed Package
@endsection
@section('content')
<div class="row justify-content-center" style="margin-bottom:20px;">
    <div class="col-12 col">
        <a href="{{ route('member.buy-new-package') }}" class="btn btn-grd-deep-blue">Buy New Membership</a>
        @if($membership->extend_package < 2)
            <a href="{{ route('member.extend-package') }}" class="btn btn-grd-deep-blue">Extend Membership</a>
        @endif
    </div>
</div>
<div class="row">
    {{-- @if(count($membership_payments) == null) --}}
    <div class="col-md-12 mb-5 row">
    @if($packages_membership_payments == null)
    <div class="col-md-12 mb-5">
        <p>No Subscribed Package</p>
    </div>
    @else

    @foreach($packages_membership_payments as $membership)
    <div class="col-md-4">
        <div class="card rounded-4">
            <div class="card-header">
                <h5 style="margin-top:10px;" class="card-title mb-3">{{ ucwords($membership->name) }}</h5>
            </div>
            <div class="card-body">
                <div class="row g-0">
                    <div class="col-md-4 border-end">
                        <div class="p-3">
                            <img src="{{ URL::asset('build/images/02.png') }}" class="w-100 rounded h-100" alt="...">
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card-body">
                            <input type="hidden" name="package_id" id="package_id" value="">
                            <p class="card-text">{{ $membership->description }}</p>
                            <p class="card-text">Duration: {{ $membership->duration_in_days }} Days</p>
                            <p class="card-text">Starting: {{ $membership->start_date }}</p>
                            <p class="card-text">Ending: {{ $membership->end_date }}</p>
                            <!-- <p class="card-text">Personal Trainer Quota: {{ $membership->personal_trainer_quota }} </p> -->
                            <p class="card-text">Personal Trainer Quota: {{ $membership->available_personal_trainer_quota }} </p>
                            <p class="card-text">
                                Price:
                                Rp.{{ number_format($membership->price, 0, ',', '.') }}
                            </p>
                            @if($membership->is_active == 1)
                            <button class="btn btn-outline-info" disabled>Active</button>
                            @else
                            <button class="btn btn-outline-secondary" disabled>Inactive</button>
                            @endif
                            @if($membership->status == 'pending')
                            <button class="btn btn-warning checkPaymentBtn" data-id="{{ $membership->order_id }}" style="color:white">Check Payment</button>

                            @endif
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
<script type="text/javascript" src="https://app.midtrans.com/snap/snap.js"
    data-client-key="Mid-client-wMJpUxtO3cbG92Xu"></script>
    
    <script type="text/javascript">
    document.querySelectorAll('.checkPaymentBtn').forEach(button => {
        button.addEventListener('click', function () {

            const orderId = this.getAttribute('data-id');
            // alert(orderId);
            alert('{{ config('services.midtrans.client_key') }}');

            // alert service.midtrans.client_key
            fetch('{{ route("member.check_payment_status") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ order_id: orderId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'pending') {
                    pay(data.token);
                } else {
                    alert('Payment status: ' + data.status);
                    location.reload();
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });

    function pay(snapToken) {
        snap.pay(snapToken, {
            onSuccess: function (result) {
                // Handle payment success
                fetch("{{ route('member.payment.callback') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify(result)
                }).then(() => {
                    // reload page
                    location.reload();

                });
            },
            onPending: function (result) {
                // Handle payment pending
                alert('Payment pending');
                fetch("{{ route('member.payment.callback') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify(result)
                }).then(() => {
                    location.reload();
                });
            },
            onError: function (result) {
                // Handle payment error
                alert('Payment failed');
                fetch("{{ route('member.payment.callback') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify(result)
                }).then(() => {
                    location.reload();
                });
            },
            onClose: function () {
                location.reload();
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
