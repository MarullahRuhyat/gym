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
            @if ($membership == null || $enddateformprofile < date('Y-m-d'))
            <div class="justify-content-center text-center">
                <div class="col my-5">
                    <a href="{{ route('member.buy-new-package') }}" class="btn btn-grd btn-grd-deep-blue px-5">Buy
                        Membership</a>
                </div>
            </div>
            <div class="justify-content-center text-center">
                {{-- @foreach ($membership as $membership) --}}
                <div class="card" style="margin:auto; padding-bottom:50px; padding:30px;">
                    <h4 style="padding-bottom:30px;"
                        class="card-title mb-4 fw-bold justify-content-between border-bottom pt-4">Membership Details
                    </h4>
                    <p id="" class="mb-0 fw-bold">
                        You don't have any membership yet
                    </p>
                </div>
                {{-- @endforeach --}}
            </div>
            @else
            <div class="justify-content-center text-center">
                <div class="col" style="margin-top:30px;">
                    <button id="show_qr_member" type="button" class="btn btn-grd btn-grd-deep-blue px-5"
                        data-bs-toggle="modal" data-bs-target="">Show QR Member</button>
                </div>

                @php
                // Cek jika personal trainer quota adalah 0 tapi masih ada member absent dengan end_date null
                    $absentMember = \App\Models\AbsentMember::where('member_id', auth()->user()->id)
                    ->whereNull('end_time')
                    ->whereNotNull('start_time')
                    ->where('is_using_pt', 1)
                    ->first();
                @endphp

                @if (auth()->user()->available_personal_trainer_quota != 0 || $absentMember)
                <div class="col" style="margin-top:30px;">
                    <button id="show_pt_member" type="button" class="btn btn-grd btn-grd-deep-blue px-5"
                        data-bs-toggle="modal" data-bs-target="">Show QR PT</button>
                </div>
                @endif

                <div class="card" style="margin:auto; padding-bottom:50px; padding:30px;">
                    <h4 style="padding-bottom:30px;"
                        class="card-title mb-4 fw-bold justify-content-between border-bottom pt-4">Membership Details
                    </h4>
                    <div>
                        <div class="d-flex justify-content-between">
                            <p class="fw-semi-bold">Membership :</p>
                            <p id="" class="fw-bold">{{ $membership->membership_name }}</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="fw-semi-bold">Membership Period :</p>
                            <p id="" class="text-danger fw-bold">{{ $membership->duration_in_days }} days</p>
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

                    @if ($membership->available_personal_trainer_quota != 0)
                    <div class="d-flex justify-content-between">
                        <p class="fw-semi-bold">Personal Trainer Quota :</p>
                        <p id="" class="fw-bold">{{ $membership->available_personal_trainer_quota }} times</p>
                    </div>
                    @else
                    <div class="d-flex justify-content-between">
                        <p class="fw-semi-bold">Personal Trainer Quota :</p>
                        <p id="" class="fw-bold">
                            you don't have any personal trainer quota
                        </p>
                    </div>

                    @endif

                </div>
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
            <div class="modal-body" style="background-color : #fff">
                <div class="order-summary">
                    {{-- <div class="card mb-0"> --}}
                    <div class="card-body d-flex justify-content-center align-items-center">
                        <!-- Loading Spinner -->
                        <div id="loadingSpinner" style="display:none;">
                            <span>Loading...</span> <!-- You can replace this with an actual spinner -->
                        </div>

                        <!-- QR Code Image -->
                        <img id="qr_code_img" src="" class="w-50 rounded h-50" alt="..." style="display:none;">
                    </div>
                    {{-- </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ConfirmationModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menampilkan QR Code?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="confirmShowQR" class="btn btn-primary">Ya, Tampilkan</button>
            </div>
        </div>
    </div>
</div>



@endsection
@push('script')
<script>
    $(document).ready(function () {
        $('#show_qr_member').click(function () {
            $('#ScrollableModal').modal('show');
            var is_using_pt = 0;

            $.ajax({
                url: "{{ route('member.qr_code') }}",
                type: "POST",
                data: {
                    is_using_pt: is_using_pt,
                    _token: "{{ csrf_token() }}",
                },
                beforeSend: function () {

                    $('#loadingSpinner').show();
                    $('#qr_code_img').hide();
                }
            }).done(function (data) {

                $('#loadingSpinner').hide();
                if (data.qr_code == null) {
                    alert('Please generate your QR code again');
                    $('#ScrollableModal').modal('hide');
                    return;
                }
                $('#qr_code_img').attr('src', 'data:image/png;base64,' + data.qr_code);

                $('#qr_code_img').show();
            }).fail(function () {

                $('#loadingSpinner').hide();
                alert('An error occurred. Please try again.');
            });
        });
    });


    $(document).ready(function () {

        $('#show_pt_member').click(function () {
            $('#ConfirmationModal').modal('show');
        });


        $('#confirmShowQR').click(function () {
            $('#ConfirmationModal').modal('hide');
            $('#ScrollableModal').modal('show');

            var is_using_pt = 1;

            $.ajax({
                url: "{{ route('member.qr_code') }}",
                type: "POST",
                data: {
                    is_using_pt: is_using_pt,
                    _token: "{{ csrf_token() }}",
                },
                beforeSend: function () {

                    $('#loadingSpinner').show();
                    $('#qr_code_img').hide();
                }
            }).done(function (data) {

                $('#loadingSpinner').hide();
                console.log(data);
                if (data.qr_code == null) {
                    alert('Please generate your QR code again');
                    $('#ScrollableModal').modal('hide');
                    return;
                }
                $('#qr_code_img').attr('src', 'data:image/png;base64,' + data.qr_code);
                $('#qr_code_img').show();
            }).fail(function () {

                $('#loadingSpinner').hide();
                console.error("Error details:", jqXHR.responseText);
                alert('Failed to retrieve QR Code. Error: ' + textStatus + ', ' + errorThrown);
                $('#ScrollableModal').modal('hide');
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
