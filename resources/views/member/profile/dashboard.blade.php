@extends('member.layouts.app')
@section('title')
starter Page
@endsection
@section('content')
<div class="card">
    <div class="card-body">
        <div class="col row-cols-auto g-3 justify-content-center">
            <h1 class="text-center">Welcome, {{ ucwords(auth()->user()->name) }}</h1>
            <!-- <h1 style="padding-bottom:50px; font-size:60px"> </h1> -->
            @if ($membership->isEmpty())
            <div class="justify-content-center text-center">
                <div class="col my-5">
                    <a href="{{ route('member.package') }}" class="btn btn-grd btn-grd-deep-blue px-5">Buy Membership</a>
                </div>
            </div>
            <div class="justify-content-center text-center">
                {{-- @foreach ($membership as $membership) --}}
                <div class="card" style="margin:auto; padding-bottom:50px; padding:30px;">
                    <h4 style="padding-bottom:30px;" class="card-title mb-4 fw-bold justify-content-between border-bottom pt-4">Membership Details</h4>
                        <p id="" class="mb-0 fw-bold">
                            You don't have any membership yet
                        </p>
                </div>
                {{-- @endforeach --}}
            </div>
            @else
            <div class="justify-content-center text-center">
                <div class="col" style="margin-top:30px;">
                    <button id="show_qr_member" type="button" class="btn btn-grd btn-grd-deep-blue px-5" data-bs-toggle="modal" data-bs-target="">Show QR Member</button>
                </div>
                <div class="col" style="margin-top:30px;">
                    <button id="show_pt_member" type="button" class="btn btn-grd btn-grd-deep-blue px-5" data-bs-toggle="modal" data-bs-target="">Show QR PT</button>
                </div>
                @foreach ($membership as $membership)
                <div class="card" style="margin:auto; padding-bottom:50px; padding:30px;">
                    <h4 style="padding-bottom:30px;" class="card-title mb-4 fw-bold justify-content-between border-bottom pt-4">Membership Details</h4>
                    <div>
                        <div class="d-flex justify-content-between">
                            <p class="fw-semi-bold">Membership :</p>
                            <p id="" class="fw-bold">{{ $membership->name }}</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="fw-semi-bold">Membership Period :</p>
                            <p id="" class="text-danger fw-bold">{{ $membership->duration_in_days }}</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="fw-semi-bold">Starting Date :</p>
                            <p id="" class="fw-bold">{{ $membership->start_date }}</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="fw-semi-bold">Ending Date :</p>
                            <p id="" class="fw-bold">{{ $membership->end_date }}</p>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between border-top pt-4">
                        <h5 class="mb-0 fw-bold">Total :</h5>
                        <h5 id="" class="mb-0 fw-bold">Rp.{{ $membership->price }}</h5>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="ScrollableModal">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-bottom-0 bg-grd-deep-blue py-2">
                <h5 class="modal-title">QR</h5>
                <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="modal">
                    <i class="material-icons-outlined">close</i>
                </a>
            </div>
            <div class="modal-body">
                <div class="order-summary">
                    <div class="card mb-0">
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <div class="card border bg-transparent shadow-none mb-3" style="width: fit-content;">
                                <div class="card-body">
                                    <img id="qr_code_img" src="" class="w-150 rounded h-150" alt="...">
                                </div>
                            </div>
                            <div class="card border bg-transparent shadow-none">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@push('script')
<script>
    $(document).ready(function() {
        $('#show_qr_member').click(function() {
            $('#ScrollableModal').modal('show');
            var is_using_pt = 0;
            $.ajax ({
                url: "{{ route('member.qr_code') }}",
                type: "POST",
                data: {
                    is_using_pt: is_using_pt,
                    _token: "{{ csrf_token() }}",
                }
            }).done(function(data) {
                $('#qr_code_img').attr('src', '{{ URL::asset("build/images/member/qr_code/") }}' + '/' + data.qr_code);
            });
        });
    });

    $(document).ready(function() {
        $('#show_pt_member').click(function() {
            $('#ScrollableModal').modal('show');
            var is_using_pt = 1;
            $.ajax ({
                url: "{{ route('member.qr_code') }}",
                type: "POST",
                data: {
                    is_using_pt: is_using_pt,
                    _token: "{{ csrf_token() }}",
                }
            }).done(function(data) {
                $('#qr_code_img').attr('src', '{{ URL::asset("build/images/member/qr_code/") }}' + '/' + data.qr_code);
            });
        });
    });
</script>
<!--plugins-->
<script src="{{ URL::asset('build/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ URL::asset('build/plugins/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ URL::asset('build/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('build/js/main.js') }}"></script>
@endpush
