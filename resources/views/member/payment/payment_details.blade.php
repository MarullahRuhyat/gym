@extends('member.layouts.app')
@section('title')
starter Page
@endsection
@section('content')
<div class="pay"></div>
@endsection
@push('script')
<!-- custom script  -->
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        pay();
    });

    function pay() {
    snap.pay('{{ $snapToken }}', {
        onSuccess: function (result) {
            // Handle payment success
            fetch("{{ route('member.payment.callback') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify(result)
            });
            window.location.href = '/member/package/subscribed-package';

        },
        onPending: function (result) {
            // Handle payment pending
            // alert('Payment pending');
            fetch("{{ route('member.payment.callback') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify(result)
            });
            window.location.href = '/member/package/subscribed-package';

        },
        onError: function (result) {
            // Handle payment error
            // alert('Payment failed');
            fetch("{{ route('member.payment.callback') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify(result)
            });
            window.location.href = '/member/package/subscribed-package';

        },
        onClose: function () {
            // alert('Payment closed');
            // Redirect when the Snap modal is closed
            window.location.href = '/member/package/subscribed-package';
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
