@extends('personal_training.layouts.app')
@section('title')
User Profile
@endsection
@section('content')
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item active" aria-current="page">User Profile</li>
            </ol>
        </nav>
    </div>
</div>
<div class="card rounded-4">
    <div class="card-body p-4">
        <div class="position-relative mb-5">
            <div class="profile-avatar position-absolute top-100 start-50 translate-middle">
                <img src="
                    @if($data_user->photo_profile)
                        {{asset('assets/images/avatars/'.$data_user->photo_profile)}}
                    @else
                        {{asset('assets/images/avatars/avatars.jpg')}}
                    @endif
                " class="img-fluid rounded-circle p-1 bg-grd-primary shadow" width="170" height="170" alt="">
            </div>
        </div>
        <div class="profile-info pt-5 d-flex align-items-center justify-content-center">
            <div class="justify-content-center">
                <h3 class="text-center">{{$data_user->name}}</h3>
                <p class="mb-0">{{$data_user->role}}</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-xl-8">
        <div class="card rounded-4 border-top border-4 border-primary border-gradient-1">
            <div class="card-body p-4">
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div class="">
                        <h5 class="mb-0 fw-bold">Edit Profile</h5>
                    </div>
                </div>
                <form action="{{route('personal_trainer.edit_profile')}}" class="row g-4" method="post" 
                {{-- acc untuk form --}}
                enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-12">
                        <label for="inputName" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" id="inputName" value="{{$data_user->name}}" required placeholder="Name">
                    </div>
                    <div class="col-md-12">
                        <label for="inputPhone" class="form-label">Phone</label>
                        <input type="text" class="form-control" name="phone" id="inputPhone" value="{{$data_user->phone_number}}" required placeholder="Phone" oninput="this.value = this.value.replace(/\+62/, '0').replace(/[^0-9]/g, '');">
                    </div>
                    <div class="col-md-12">
                        <label for="inputEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="inputEmail" value="{{$data_user->email}}" required placeholder="Email">
                    </div>
                    <div class="col-md-12">
                        <label for="inputPhotoProfile" class="form-label">Photo Profile</label>
                        <input type="file" class="form-control" name="photo_profile" id="inputPhotoProfile" accept="image/*">
                    </div>
                    <div class="col-md-12">
                        <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                            <button type="submit" class="btn btn-primary px-4 float-end">Update Profile</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12 col-xl-4">
        <div class="card rounded-4">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div class="">
                        <h5 class="mb-0 fw-bold">About</h5>
                    </div>
                </div>
                <div class="full-info">
                    <div class="info-list d-flex flex-column gap-3">
                        <div class="info-list-item d-flex align-items-center gap-3"><span
                                class="material-icons-outlined">account_circle</span>
                            <p class="mb-0">Full Name: {{$data_user->name}}</p>
                        </div>
                        <div class="info-list-item d-flex align-items-center gap-3"><span
                                class="material-icons-outlined">done</span>
                            <p class="mb-0">Status: {{$data_user->status}}</p>
                        </div>
                        <div class="info-list-item d-flex align-items-center gap-3"><span
                                class="material-icons-outlined">send</span>
                            <p class="mb-0">Email: 
                                {{-- jika kosong akan "" jika ada tampilkan --}}
                                @if ($data_user->email)
                                    {{$data_user->email}}
                                @else
                                    
                                @endif
                            </p>
                        </div>
                        <div class="info-list-item d-flex align-items-center gap-3"><span
                                class="material-icons-outlined">call</span>
                            <p class="mb-0">Phone: {{$data_user->phone_number}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="col-12 col-xl-8">
        <div class="card rounded-4 border-top border-4 border-primary border-gradient-1">
            <div class="card-body p-4">
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div class="">
                        <h5 class="mb-0 fw-bold">Update Password</h5>
                    </div>
                </div>
                <form action="{{ route('personal_trainer.change_password') }}" class="row g-4" method="post">
                    @csrf
                    <div class="col-md-12">
                        <label for="inputOldPassword" class="form-label">Old Password</label>
                        <div class="input-group" id="show_hide_old_password">
                            <input type="password" class="form-control border-end-0" name="old_password" id="inputOldPassword" required placeholder="Old Password">
                            <a href="javascript:;" class="input-group-text bg-transparent"><i class="bi bi-eye-slash-fill"></i></a>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="inputNewPassword" class="form-label">New Password</label>
                        <div class="input-group" id="show_hide_new_password">
                            <input type="password" class="form-control border-end-0" name="new_password" id="inputNewPassword" required placeholder="New Password">
                            <a href="javascript:;" class="input-group-text bg-transparent"><i class="bi bi-eye-slash-fill"></i></a>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="inputConfirmPassword" class="form-label">Confirm Password</label>
                        <div class="input-group" id="show_hide_confirm_password">
                            <input type="password" class="form-control border-end-0" name="confirm_password" id="inputConfirmPassword" required placeholder="Confirm Password">
                            <a href="javascript:;" class="input-group-text bg-transparent"><i class="bi bi-eye-slash-fill"></i></a>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                            <button type="submit" class="btn btn-primary px-4 float-end">Update Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</div>
<!--end row-->

@endsection
@push('script')
<script src="{{ URL::asset('build/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ URL::asset('build/plugins/metismenu/metisMenu.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ URL::asset('build/plugins/select2/js/select2-custom.js') }}"></script>
<script src="{{ URL::asset('build/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('build/js/main.js') }}"></script>
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
        });
    @endif

    @if ($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            html: '<ul>' +
            @foreach ($errors->all() as $error)
                '<li>{{ $error }}</li>' +
            @endforeach
                '</ul>',
        });
    @endif

    $(document).ready(function () {
        $("#show_hide_old_password a").on('click', function (event) {
            event.preventDefault();
            if ($('#show_hide_old_password input').attr("type") == "text") {
                $('#show_hide_old_password input').attr('type', 'password');
                $('#show_hide_old_password i').addClass("bi-eye-slash-fill");
                $('#show_hide_old_password i').removeClass("bi-eye-fill");
            } else if ($('#show_hide_old_password input').attr("type") == "password") {
                $('#show_hide_old_password input').attr('type', 'text');
                $('#show_hide_old_password i').removeClass("bi-eye-slash-fill");
                $('#show_hide_old_password i').addClass("bi-eye-fill");
            }
        });

        $("#show_hide_new_password a").on('click', function (event) {
            event.preventDefault();
            if ($('#show_hide_new_password input').attr("type") == "text") {
                $('#show_hide_new_password input').attr('type', 'password');
                $('#show_hide_new_password i').addClass("bi-eye-slash-fill");
                $('#show_hide_new_password i').removeClass("bi-eye-fill");
            } else if ($('#show_hide_new_password input').attr("type") == "password") {
                $('#show_hide_new_password input').attr('type', 'text');
                $('#show_hide_new_password i').removeClass("bi-eye-slash-fill");
                $('#show_hide_new_password i').addClass("bi-eye-fill");
            }
        });

        $("#show_hide_confirm_password a").on('click', function (event) {
            event.preventDefault();
            if ($('#show_hide_confirm_password input').attr("type") == "text") {
                $('#show_hide_confirm_password input').attr('type', 'password');
                $('#show_hide_confirm_password i').addClass("bi-eye-slash-fill");
                $('#show_hide_confirm_password i').removeClass("bi-eye-fill");
            } else if ($('#show_hide_confirm_password input').attr("type") == "password") {
                $('#show_hide_confirm_password input').attr('type', 'text');
                $('#show_hide_confirm_password i').removeClass("bi-eye-slash-fill");
                $('#show_hide_confirm_password i').addClass("bi-eye-fill");
            }
        });
    });
</script>
@endpush
