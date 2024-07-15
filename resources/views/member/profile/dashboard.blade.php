@extends('member.layouts.app')
@section('title')
starter Page
@endsection
@section('content')
<div class="card">
    <div class="card-body">
        <div class="col row-cols-auto g-3 justify" style="color:aquamarine">
            <h1>Welcome, </h1>
            <h1 style="padding-bottom:50px; font-size:60px">{{ ucwords(auth()->user()->name) }} </h1>
            <div class="bottom-0 position-absolute m-3">
                  <a href="javascript:;" class="btn text-dark px-3 bg-white d-flex gap-2">Read More<span class="material-icons-outlined">east</span></a>
                </div>
            <div class="justify-content-center text-center">
                <div style="margin-bottom:30px;" class="col">
                    <button type="button" class="btn btn-grd btn-grd-primary px-5">Show QR PT</button>
                </div>
                <div class="col" style="margin-bottom:30px;">
                    <button type="button" class="btn btn-grd btn-grd-primary px-5">Show QR Member</button>
                </div>
                <div class="card" style="margin:auto; padding-bottom:50px; padding:30px;">
                    <h4 style="padding-bottom:30px;" class="card-title mb-4 fw-bold justify-content-between border-bottom pt-4">Membership Details</h4>
                    <div>
                        <div class="d-flex justify-content-between">
                            <p class="fw-semi-bold">Membership :</p>
                            <p id="" class="fw-bold">Couple Package</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="fw-semi-bold">Membership Period :</p>
                            <p id="" class="text-danger fw-bold">1 Month</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="fw-semi-bold">Starting Date :</p>
                            <p id="" class="fw-bold">21/06/2024</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="fw-semi-bold">Ending Date :</p>
                            <p id="" class="fw-bold">21/07/2024</p>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between border-top pt-4">
                        <h5 class="mb-0 fw-bold">Total :</h5>
                        <h5 id="" class="mb-0 fw-bold">IDR.925.44</h5>
                    </div>


                </div>

               
            </div>
        </div>
    </div>
</div>


@endsection
@push('script')
<!--plugins-->
<script src="{{ URL::asset('build/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ URL::asset('build/plugins/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ URL::asset('build/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('build/js/main.js') }}"></script>
@endpush