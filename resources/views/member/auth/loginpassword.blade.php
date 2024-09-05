@extends('auth.layouts.guest')
@section('title')
Login
@endsection
@section('content')
<!--authentication-->
<style>
    .fade-out {
        transition: opacity 0.5s;
        opacity: 0;
    }

</style>

<div class="mx-3 mx-lg-0">
    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show my-5 col-xl-9 col-xxl-8 mx-auto overflow-hidden p-4" role="alert">
        <div>
            <strong>Error!</strong> {{ session('error') }}
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="card my-5 col-xl-9 col-xxl-8 mx-auto rounded-4 overflow-hidden p-4">
        <div class="row g-4">
            <div class="col-lg-6 d-flex">
                <div class="card-body">
                    <img src="{{ URL::asset('build/images/logo1.png') }}" class="mb-4" width="145" alt="">
                    <h4 class="fw-bold">Login</h4>
                    <p class="mb-0">Enter your credentials to login your account</p>
                    <div class="form-body mt-4">
                        <form class="row g-3" method="post" action="{{route('member.login_with_password')}}">
                            @csrf
                            <div class="col-12">
                                <label for="inputPhoneNumber" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" name="phone_number" id="inputPhoneNumber"
                                    placeholder="Input Your Phone Number" value="{{ $phone_number ?? '' }}"
                                    oninput="this.value = this.value.replace(/\+62/, '0').replace(/[^0-9]/g, '');">
                            </div>
                            <div class="col-12">
                                <label for="inputChoosePassword" class="form-label">Password</label>
                                <div class="input-group" id="show_hide_password">
                                    <input type="password" class="form-control border-end-0" name="password" value="{{ $password ?? '' }}"
                                        id="inputChoosePassword" placeholder="Enter Password">
                                    <a href="javascript:;" class="input-group-text bg-transparent"><i
                                            class="bi bi-eye-slash-fill"></i></a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" value="1" name="remember_me" checked>
                                    <label class="form-check-label" for="flexSwitchCheckChecked">Remember Me</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary ">Login</button>
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

    document.addEventListener('DOMContentLoaded', function () {
        const alert = document.querySelector('.alert');
        if (alert) {
            setTimeout(() => {
                alert.classList.add('fade-out');
                setTimeout(() => {
                    alert.style.display = 'none';
                }, 500); // Match this duration with the fade-out animation duration
            }, 5000); // 5 seconds
        }
    });

</script>
@endpush
