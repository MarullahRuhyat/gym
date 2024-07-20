@extends('member.layouts.app')
@section('title')
starter Page
@endsection
@section('css')
<style>
    .container {
        width: 150px;
        height: 150px;
        display: block;
        margin: 0 auto;
    }

    .outer {
        width: 100% !important;
        /* height: 100% !important; */
        max-width: 150px !important;
        /* any size */
        max-height: 150px !important;
        /* any size */
        margin: auto;
        background-color: #6eafd4;
        border-radius: 100%;
        position: relative;
    }

    .inner {
        background-color: #ff1414;
        width: 50px;
        height: 50px;
        border-radius: 100%;
        position: absolute;
        bottom: 0;
        right: 0;
    }

    .inner:hover {
        background-color: #5555ff;
    }

    .inputfile {
        opacity: 0;
        overflow: hidden;
        position: absolute;
        z-index: 1;
        width: 50px;
        height: 50px;
    }

    .inputfile+label {
        font-size: 1.25rem;
        text-overflow: ellipsis;
        white-space: nowrap;
        display: inline-block;
        overflow: hidden;
        width: 50px;
        height: 50px;
        pointer-events: none;
        cursor: pointer;
        line-height: 50px;
        text-align: center;
    }

    .inputfile+label svg {
        fill: #fff;
    }
</style>
@endsection
@section('content')
@foreach($user as $user)

<div class="row justify-content-center">
    <div class="col-12 col-xl-8">
        <div class="card rounded-4">
            <div class="card-body p-4">
                <div class="position-relative mb-5">
                    <img src="assets/images/gallery/profile-cover.png" class="img-fluid rounded-4 shadow" alt="">
                    <div class="profile-avatar position-absolute top-100 start-50 translate-middle">
                        <!-- <img src="assets/images/avatars/01.png" class="img-fluid rounded-circle p-1 bg-grd-danger shadow" width="170" height="170" alt=""> -->
                        <div class="container">
                            <div class="outer">
                                <img src="{{ URL::asset('build/images/member/photo_profile/'.$user->photo_profile) }}" class="img-fluid rounded-circle p-1 bg-grd-danger shadow" width="150" height="150" alt="">
                                <div class="inner">
                                    <input class="inputfile" type="file" name="pic" accept="image/*">
                                    <label><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                            <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path>
                                        </svg></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="profile-info pt-5 d-flex align-items-center justify-content-between">
                    <div class="">
                        <h3>{{ $user->name }}</h3>
                        <p class="mb-0">{{ $user->address }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-xl-8">
        <div class="card rounded-4 border-top border-4 border-primary border-gradient-1">
            <div class="card-body p-4">
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div class="">
                        <h5 class="mb-0 fw-bold">Edit Profile</h5>
                    </div>
                    <div class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle-nocaret options dropdown-toggle" data-bs-toggle="dropdown">
                            <span class="material-icons-outlined fs-5">more_vert</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="javascript:;">Action</a></li>
                            <li><a class="dropdown-item" href="javascript:;">Another action</a></li>
                            <li><a class="dropdown-item" href="javascript:;">Something else here</a></li>
                        </ul>
                    </div>
                </div>
                <form class="row g-4">
                    <input type="hidden" id="user_id" name="user_id" value="{{ $user->id }}">
                    <div class="col-md-12">
                        <label for="input1" class="form-label">Name</label>
                        <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Full Name" value="{{ $user->name }}">
                    </div>
                    <div class="col-md-12">
                        <label for="input2" class="form-label">Address</label>
                        <input type="text" class="form-control" id="user_address" name="user_address" placeholder="Address" value="{{ $user->address }}">
                    </div>
                    <div class="col-md-12">
                        <label for="input3" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="user_phone_number" name="user_phone_number" placeholder="Phone Number" value="{{ $user->phone_number }}">
                    </div>
                    <div class="col-md-12">
                        <label for="input4" class="form-label">Email</label>
                        <input type="email" class="form-control" id="user_email" name="user_email" placeholder="Email" value="{{ $user->email }}">
                    </div>
                    <div class="col-md-12">
                        <label for="input5" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" id="user_date_of_birth" name="user_date_of_birth" value="{{ $user->date_of_birth }}">
                    </div>
                    <div class="col-md-12">
                        <label for="input6" class="form-label">Password</label>
                        <input type="password" class="form-control" id="user_password" name="user_password" placeholder="Password">
                    </div>
                    <div class="col-md-12">
                        <label for="input7" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="user_password_confirmation" name="user_password_confirmation" placeholder="Confirm Password">
                    </div>
                    <div class="col-md-12">
                        <div class="d-md-flex d-grid align-items-center gap-3">
                            <button id="submit-update-profile" type="submit" class="btn btn-primary px-4">Update Profile</button>
                            <button type="reset" class="btn btn-light px-4">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><!--end row-->
@endforeach
@endsection
@push('script')
<!-- custom script  -->
<script>
    $(document).ready(function() {
        $('#submit-update-profile').click(function(e) {
            e.preventDefault();
            // Get the selected file
            var photo_profile = $('.inputfile')[0].files[0];
            var user_id = $('#user_id').val();
            var user_name = $('#user_name').val();
            var user_address = $('#user_address').val();
            var user_phone_number = $('#user_phone_number').val();
            var user_email = $('#user_email').val();
            var user_date_of_birth = $('#user_date_of_birth').val();
            var user_password = $('#user_password').val();
            // Create a FormData object to store the file and other form data
            var formData = new FormData();
            formData.append('photo_profile', photo_profile);
            formData.append('_token', "{{ csrf_token() }}");
            formData.append('user_id', user_id);
            formData.append('user_name', user_name);
            formData.append('user_address', user_address);
            formData.append('user_phone_number', user_phone_number);
            formData.append('user_email', user_email);
            formData.append('user_date_of_birth', user_date_of_birth);
            formData.append('user_password', user_password);

            // Send the AJAX request with the updated form data
            $.ajax({
                type: "POST",
                url: "{{ route('member.edit-profile.process', $user->id) }}",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status) {
                        alert(response.message);
                        window.location.href = "{{ route('member.profile') }}";
                    } else {
                        alert(response.message);
                    }
                }
            });

            // var user_id = $('#user_id').val();
            // var user_name = $('#user_name').val();
            // var user_address = $('#user_address').val();
            // var user_phone_number = $('#user_phone_number').val();
            // var user_email = $('#user_email').val();
            // var user_date_of_birth = $('#user_date_of_birth').val();
            // var user_password = $('#user_password').val();
            // var user_password_confirmation = $('#user_password_confirmation').val();

            // if (user_password != user_password_confirmation) {
            //     alert('Password and Confirm Password must be the same');
            //     return;
            // }

            // $.ajax({
            //     type: "POST",
            //     url: "{{ route('member.edit-profile.process', $user->id) }}",
            //     data: {
            //         _token: "{{ csrf_token() }}",
            //         user_name: user_name,
            //         user_address: user_address,
            //         user_phone_number: user_phone_number,
            //         user_email: user_email,
            //         user_date_of_birth: user_date_of_birth,
            //         user_password: user_password,
            //     },
            //     success: function(response) {
            //         if (response.status) {
            //             alert(response.message);
            //             window.location.href = "{{ route('member.profile') }}";
            //         } else {
            //             alert(response.message);
            //         }
            //     }
            // })
        })

    })
</script>
<!-- end custom script  -->
<!--plugins-->
<script src="{{ URL::asset('build/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ URL::asset('build/plugins/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ URL::asset('build/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('build/js/main.js') }}"></script>
@endpush
