@extends('member.layouts.app')
@section('title')
starter Page
@endsection
@section('content')
<div class="pay"></div>
@endsection
@push('script')
<!-- custom script  -->
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
    pay();
});
function pay() {
    // var payButton = document.getElementById('pay-button');
    // payButton.disabled = true;

    snap.pay('{{ $snapToken }}', {
        onSuccess: function(result) {
            console.log(result);
            // Handle success callback
            window.location.href = "{{ route('member.send-otp') }}";
        },
        onPending: function(result) {
            console.log(result);
            // Handle pending callback
        },
        onError: function(result) {
            console.log(result);
            // Handle error callback
        }
    });
}
</script>
<!--plugins-->
<script src="{{ URL::asset('build/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ URL::asset('build/plugins/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ URL::asset('build/plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
<script src="{{ URL::asset('build/plugins/bs-stepper/js/main.js') }}"></script>
<script src="{{ URL::asset('build/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('build/js/main.js') }}"></script>
@endpush
