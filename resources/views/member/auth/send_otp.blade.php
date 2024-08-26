@extends('member.layouts.guest')
@section('title')
    Login
@endsection
@section('content')
    <!--authentication-->
    <!-- add message from controller success register  -->
    @if (session('success'))
        <div class="alert alert-success border-0 bg-grd-success alert-dismissible fade show">
            <div class="d-flex align-items-center">
                <div class="font-35 text-white">
                    <span class="material-icons-outlined fs-2">done</span>
                </div>
                <div class="ms-3">
                    <h6 class="mb-0 text-white">{{ session('success') }}</h6>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="mx-3 mx-lg-0">
        <div class="alert"></div>
        <div class="card my-5 col-xl-9 col-xxl-8 mx-auto rounded-4 overflow-hidden p-4">
            <div class="row g-4">
                <div class="col-lg-6 d-flex">
                    <div class="card-body">
                        <img src="{{ URL::asset('build/images/logo1.png') }}" class="mb-4" width="145" alt="">
                        <h4 class="fw-bold">Login</h4>
                        <p class="mb-0">Enter your phone number to login your account</p>
                        <div class="form-body mt-4">
                            <form class="row g-3">
                                @csrf
                                <div class="col-12">
                                    <label for="inputPhoneNumber" class="form-label">Phone Number</label>
                                    <input type="text" class="form-control" name="phone_number" id="inputPhoneNumber"
                                    placeholder="Input Your Phone Number" value="{{ $phone_number ?? '' }}"
                                    oninput="this.value = this.value.replace(/\+62/, '0').replace(/[^0-9]/g, '');">
                                    {{-- <input type="text" class="form-control" id="inputPhoneNumber" placeholder="Input Your Phone Number" value="{{ $phone_number ?? '' }}" oninput="this.value = this.value.replace(/\+62/, '0').replace(/[^0-9]/g, '');"> --}}
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button id="submit-phone-number" type="submit" class="btn btn-grd-deep-blue ">Get OTP</button>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <a href="{{ route('member.register_select')}}">Don't have an account? <span><strong>Register</strong></span></a>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="d-grid">
                                        <a href="{{ route('member.with_password')}}">forgot bring phone? <span><strong>With Password</strong></span></a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 d-lg-flex d-none">
                    <div class="p-3 rounded-4 w-100 d-flex align-items-center justify-content-center bg-grd-primary">
                        <img src="{{ URL::asset('build/images/auth/login1.png') }}" class="img-fluid" alt="">
                    </div>
                </div>

            </div><!--end row-->
        </div>

    </div>
@endsection
@push('script')
    <!-- custom script  -->
     <script>
        // on click submit phone number
        $(document).on('click', '#submit-phone-number', function(e) {
            e.preventDefault();
            var phone_number = $('#inputPhoneNumber').val();
            if (phone_number == '') {
                // return class=""alert alert-danger border-0 bg-grd-danger alert-dismissible fade show"
                $('#inputPhoneNumber').addClass('border border-danger');
                $('#inputPhoneNumber').focus();
                return false;
            } else {
                $('#inputPhoneNumber').removeClass('border border-danger');
                // ajax request
                $.ajax({
                    // url route to api.php
                    url: "{{ route('member.get-otp') }}",
                    type: "POST",
                    data: {
                        phone_number: phone_number,
                        _token: $('input[name="_token"]').val()
                    },
                    success: function(response) {
                        if(response.status == true) {
                            console.log(response);
                            $phone_number = phone_number;
                            window.location.href = '/member/verify-otp/' + $phone_number;
                        } else {
                            $('.alert').html('<div class="alert alert-danger border-0 bg-grd-danger alert-dismissible fade show"><div class="d-flex align-items-center"><div class="font-35 text-white"><span class="material-icons-outlined fs-2">report_gmailerrorred</span></div><div class="ms-3"><h6 class="mb-0 text-white">' + response.message + '</h6></div></div><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                        }
                    },
                    error : function(response) {
                        $('.alert').html('<div class="alert alert-danger border-0 bg-grd-danger alert-dismissible fade show"><div class="d-flex align-items-center"><div class="font-35 text-white"><span class="material-icons-outlined fs-2">report_gmailerrorred</span></div><div class="ms-3"><h6 class="mb-0 text-white">Something went wrong</h6></div></div><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');

                    }
                });
            }
        })
     </script>
    <!-- end custom scripts  -->
    <!--plugins-->
    <script src="{{ URL::asset('build/js/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("bi-eye-slash-fill");
                    $('#show_hide_password i').removeClass("bi-eye-fill");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("bi-eye-slash-fill");
                    $('#show_hide_password i').addClass("bi-eye-fill");
                }
            });
        });
    </script>
@endpush
