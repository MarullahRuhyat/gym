@extends('auth.layouts.guest')
@section('title')
    Login
@endsection
@section('content')
    <div class="mx-3 mx-lg-0">
    <div class="alert"></div>
        <div class="card my-5 col-xl-9 col-xxl-8 mx-auto rounded-4 overflow-hidden p-4">
            <div class="row g-4">
                <div class="col-lg-6 d-flex">
                    <div class="card-body">
                        <img src="{{ URL::asset('build/images/logo1.png') }}" class="mb-4" width="145" alt="">
                        <h4 class="fw-bold">Verify OTP</h4>
                        <p class="mb-0">Enter your OTP to verify your account</p>
                        <div class="form-body mt-4">
                            <form class="row g-3">
                                <div class="col-12">
                                    <label for="inputOtp" class="form-label">Kode OTP</label>
                                    <input type="text" class="form-control" id="inputOtp"
                                        placeholder="Input Your OTP Number">
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button id="submit-otp-code" type="submit" class="btn btn-primary ">Login</button>
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
        $(document).on('click', '#submit-otp-code', function (e) {
            e.preventDefault();
            var phone_number =  window.location.href.substring(window.location.href.lastIndexOf('/') + 1);
            var otp = $('#inputOtp').val();
            if (otp == '') {
                $('#inputOtp').addClass('border border-danger');
                $('#inputOtp').focus();
                return false;
            } else {
                $('#inputOtp').removeClass('border border-danger');
                $.ajax({
                    url: "{{ route('member.login') }}",
                    type: "POST",
                    data: {
                        phone_number: phone_number,
                        otp: otp,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if (response.status == true) {
                            window.location.href = "{{ route('member.dashboard') }}";
                        }
                    },
                    error: function (xhr, status, error) {
                        // alert (xhr.responseText);
                        $('.alert').addClass('alert alert-danger border-0 bg-grd-danger alert-dismissible fade show');
                        // $('.alert').html('<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' + xhr.responseText);
                        let response = JSON.parse(xhr.responseText);
                        let message = response.message;
                        $('.alert').html('<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' + message);
                    },
                })
            }
        })
    </script>
    <!-- end custom script  -->
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
