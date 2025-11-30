@php
    $layout = auth()->user()->role === 'admin' ? 'admin.layouts.app' : 'personal_training.layouts.app';
@endphp
@extends($layout)

@section('title')
OTP MEMBER
@endsection

@section('content')
@push('style')
<!-- Add DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.0/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css">
@endpush
<h3><b> OTP 1 Jam Terakhir </b></h3>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered mb-0">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nomor Telpon</th>
                    <th scope="col">Nama</th>
                    <th scope="col">OTP</th>
                    <th scope="col">Waktu Expired</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($otp_member as $otp)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $otp->phone_number }}</td>
                    <td>{{ $otp->name }}</td>
                    <td>{{ $otp->otp }}</td>
                    <td>{{ \Carbon\Carbon::parse($otp->otp_expired_at)->diffForHumans() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('script')
<!--plugins-->
<script src="{{ URL::asset('build/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ URL::asset('build/plugins/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ URL::asset('build/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('build/js/main.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.3.0/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.0/js/dataTables.bootstrap5.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('.table').DataTable();
    });
</script>

@endpush