@extends('auth.layouts.guest')
@section('title')
Reset Password
@endsection
@section('content')
<div class="section-authentication-cover">
    <div class="">
        <div class="row g-0">

            <div
                class="col-12 col-xl-7 col-xxl-8 auth-cover-left align-items-center justify-content-center d-none d-xl-flex border-end bg-transparent">

                <div class="card rounded-0 mb-0 border-0 shadow-none bg-transparent bg-none">
                    <div class="card-body">
                        <img src="{{ URL::asset('build/images/auth/forgot-password1.png') }}"
                            class="img-fluid auth-img-cover-login" width="550" alt="">
                    </div>
                </div>

            </div>

            <div class="col-12 col-xl-5 col-xxl-4 auth-cover-right align-items-center justify-content-center">
                <div class="card rounded-0 m-3 mb-0 border-0 shadow-none bg-none">
                    <div class="card-body p-5">
                        <img src="{{ URL::asset('build/images/logo1.png') }}" class="mb-4" width="145" alt="">
                        {{-- session success and failed --}}
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif

                        <h4 class="fw-bold">Generate New Password</h4>
                        <p class="mb-0">We received your reset password request. Please enter your new password!</p>
                        <div class="form-body mt-4">
                            <form method="POST" action="{{ route('verify.otp.process') }}" class="row g-3">
                                @csrf
                                <input type="hidden" name="otp" value="{{ $otp }}">

                                <div class="col-12">
                                    <label class="form-label" for="password">Password</label>
                                    <div class="input-group">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="new-password">
                                        <button type="button" class="btn btn-outline-secondary" id="toggle-password">
                                            <i class="bi-eye-slash-fill"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label" for="password-confirm">Confirm Password</label>
                                    <div class="input-group">
                                        <input id="password-confirm" type="password" class="form-control"
                                            name="password_confirmation" required autocomplete="new-password">
                                        <button type="button" class="btn btn-outline-secondary"
                                            id="toggle-password-confirm">
                                            <i class="bi-eye-slash-fill"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-warning">Change Password</button>
                                        <a href="{{ route('auth.login') }}" class="btn btn-primary">Back to Login</a>
                                    </div>
                                </div>
                            </form>
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
    document.getElementById('toggle-password').addEventListener('click', function () {
        var passwordInput = document.getElementById('password');
        var passwordIcon = this.querySelector('i');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            passwordIcon.classList.remove('bi-eye-slash-fill');
            passwordIcon.classList.add('bi-eye-fill');
        } else {
            passwordInput.type = 'password';
            passwordIcon.classList.remove('bi-eye-fill');
            passwordIcon.classList.add('bi-eye-slash-fill');
        }
    });

    document.getElementById('toggle-password-confirm').addEventListener('click', function () {
        var confirmPasswordInput = document.getElementById('password-confirm');
        var confirmPasswordIcon = this.querySelector('i');
        if (confirmPasswordInput.type === 'password') {
            confirmPasswordInput.type = 'text';
            confirmPasswordIcon.classList.remove('bi-eye-slash-fill');
            confirmPasswordIcon.classList.add('bi-eye-fill');
        } else {
            confirmPasswordInput.type = 'password';
            confirmPasswordIcon.classList.remove('bi-eye-fill');
            confirmPasswordIcon.classList.add('bi-eye-slash-fill');
        }
    });

</script>
@endpush
