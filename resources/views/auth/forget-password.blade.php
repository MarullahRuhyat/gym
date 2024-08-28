@extends('auth.layouts.guest')
@section('title')
    Forget Password
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
                            <img src="{{ URL::asset('build/images/logo1.png') }}" class="mb-4" width="145"
                                alt="">
                            {{-- session success dan failed --}}
                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <h4 class="fw-bold">Generate New Password</h4>
                            <p class="mb-3">We received your reset password request. Please enter your new password!</p>

                            <div class="form-body mt-4">
                                <form method="POST" action="{{ route('auth.forgot_password.process') }}" class="row g-3">
                                    @csrf

                                    <div class="col-12">
                                        <label class="form-label" for="phone_number">Phone number<span
                                                class="text-danger">*</span></label>
                                        <input id="phone_number" type="phone_number"
                                            class="form-control @error('phone_number') is-invalid @enderror" name="phone_number"
                                            value="{{ old('phone_number') }}" required autocomplete="phone_number" autofocus
                                            placeholder="Enter your Phone number">

                                        @error('phone_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-success">Send Password Reset
                                                Link</button>
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
