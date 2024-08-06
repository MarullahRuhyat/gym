@extends('member.layouts.guest')
@section('title')
starter Page
@endsection
@section('content')
<div class="container-fluid" style="padding-top:10px;">
    <!-- Your car content goes here -->
    <div class="card">
    <div class="card-body">
        <div class="col row-cols-auto g-3 justify-content-center">
            <div class="justify-content-center text-center">
                <div class="card" style="margin:auto; padding-bottom:50px; padding:30px;">
                    <h4 style="padding-bottom:30px;" class="card-title mb-4 fw-bold justify-content-between border-bottom pt-4">REGISTER</h4>
                        <p id="" class="mb-0 fw-bold">
                            You don't have any account or membership
                        </p>
                </div>
            </div>
            <div class="justify-content-center text-center">
                <div class="col" style="margin-bottom:30px;">
                    <a href="{{ route('member.register-get-package') }}" id="show_qr_member" type="button" class="btn btn-grd btn-grd-deep-blue px-5">Buy Package</a>
                </div>
                <div class="col" style="margin-bottom:30px;">
                    <a href="{{ route('member.register-form') }}" type="button" class="btn btn-grd btn-grd-deep-blue px-5">Only Register</a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@push('script')
<!--bootstrap js-->
<script src="{{ URL::asset('build/js/bootstrap.bundle.min.js') }}"></script>
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

