@extends('member.layouts.app')
@section('title')
Subscribed Package
@endsection
@section('content')
<div class="row justify-content-center" style="margin-bottom:20px;">
    <div class="col-12 col">
        <a href="{{ route('member.package') }}" class="btn btn-grd-deep-blue">Buy Membership</a>
    </div>
</div>
<div class="row">
    @if(count($packages_membership_payments) == null)
    <div class="col-md-12">
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
                                <p class="card-text">Personal Trainer Quota: {{ $membership->personal_trainer_quota }} / {{ $membership->personal_trainer_quota }}</p>
                                <p class="card-text">Price: Rp.{{ $membership->price }}</p>
                                @if($membership->is_active == 1)
                                    <button class="btn btn-outline-info px-5" disabled>Active</button>
                                @else
                                    <button class="btn btn-outline-secondary px-5" disabled>Inactive</button>
                                @endif
                                @if($membership->status == 'pending')
                                <button class="btn btn-warning" id="checkPaymentBtn" style="color:white">Check Payment</button>
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
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="YOUR_CLIENT_KEY"></script>
<script>
    document.getElementById('checkPaymentBtn').addEventListener('click', function() {
        const orderId = "{{ $membership->order_id ?? '' }}";

        if (!orderId) {
            alert('Order ID tidak tersedia.');
            return;
        }

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
                window.snap.pay(data.token);
            } else {
                alert('Payment status: ' + data.status);
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>
<!--plugins-->
<script src="{{ URL::asset('build/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ URL::asset('build/plugins/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ URL::asset('build/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('build/js/main.js') }}"></script>
@endpush
