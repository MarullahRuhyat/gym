@extends('member.layouts.guest')
@section('title')
Login
@endsection
@section('content')
<style>
    input[type="text"] {
        width: 40px;
        height: 40px;
        font-size: 24px;
    }

    #otp {
        display: flex;
        align-items: center;
        /* Ensures vertical centering of elements */
        justify-content: center;
        /* Centers the elements horizontally */
    }

    #otp input {
        width: 40px;
        height: 40px;
        font-size: 24px;
        text-align: center;
        /* Center the text inside input */
        margin: 0 5px;
        /* Adjust space between inputs and dashes */
    }

    #otp span {
        user-select: none;
        /* Prevents selection of the dash */
        font-size: 24px;
    }

</style>
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
                                <div id="otp" class="inputs d-flex justify-content-center mb-2">
                                    <input class="m-2 text-center form-control rounded" type="text" id="otp1"
                                        maxlength="1">
                                    <span>-</span>

                                    <input class="m-2 text-center form-control rounded" type="text" id="otp2"
                                        maxlength="1">
                                    <span>-</span>

                                    <input class="m-2 text-center form-control rounded" type="text" id="otp3"
                                        maxlength="1">
                                    <span>-</span>

                                    <input class="m-2 text-center form-control rounded" type="text" id="otp4"
                                        maxlength="1">

                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-grid">
                                    <button id="submit-otp-code" type="submit" class="btn btn-grd-deep-blue ">Login</button>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="d-grid">
                                    <a href="" id="resend-otp">Resend OTP</a>
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

        </div>
        <!--end row-->
    </div>

</div>
@endsection
@push('script')
<!-- custom script  -->
<script>
    // resend-otp
    $(document).on('click', '#resend-otp', function(e) {
        e.preventDefault();
        var phone_number = window.location.href.substring(window.location.href.lastIndexOf('/') + 1);
        $.ajax({
            url: "{{ route('member.get-otp') }}",
            type: "POST",
            data: {
                phone_number: phone_number,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                $('.alert').addClass('alert-success').html(
                    '<button type="button" class="btn-close me-3" data-bs-dismiss="alert" aria-label="Close"></button>' +
                    response.message);
            },
            error: function(xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                $('.alert').addClass('alert-danger').html(
                    '<button type="button" class="btn-close me-3" data-bs-dismiss="alert" aria-label="Close"></button>' +
                    response.message);
            }
        });
    });
    const inputs = document.querySelectorAll('#otp input');

    inputs.forEach((input, index) => {
        input.addEventListener('input', (e) => {
            if (input.value.match(/[^0-9]/g)) {
                input.value = input.value.replace(/[^0-9]/g, ''); // Remove non-numeric characters
            } else if (input.value) {
                // Move to next input if there is a value and it's a valid number
                const nextInput = inputs[index + 1];
                if (nextInput) {
                    nextInput.focus();
                }
            }
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === "Backspace" && !input.value && index > 0) {
                // Move focus to previous input on backspace if current is empty
                const prevInput = inputs[index - 1];
                prevInput.focus();
            }
        });
    });


    $(document).on('click', '#submit-otp-code', function (e) {
        e.preventDefault();
        var otp = $('#otp1').val() + $('#otp2').val() + $('#otp3').val() + $('#otp4')
    .val(); // Concatenate all OTP parts

        if (otp.length < 4) { // Check if the OTP is complete
            $('.alert').addClass('alert-danger').text('Please enter a complete OTP.');
            $('#otp1').focus(); // Focus the first input for user correction
            return false;
        }

        var phone_number = window.location.href.substring(window.location.href.lastIndexOf('/') + 1);

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
                var response = JSON.parse(xhr.responseText);
                $('.alert').addClass('alert-danger').html(
                    '<button type="button" class="btn-close me-3" data-bs-dismiss="alert" aria-label="Close"></button>' +
                    response.message);
            }
        });
    });

</script>
<!-- end custom script  -->
<!--plugins-->
<script src="{{ URL::asset('build/js/jquery.min.js') }}"></script>

<script>
    $(document).ready(function () {
        $("#show_hide_password a").on('click', function (event) {
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
