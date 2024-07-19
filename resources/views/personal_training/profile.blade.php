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
                <img src="https://placehold.co/110x110/png" class="img-fluid rounded-circle p-1 bg-grd-primary shadow"
                    width="170" height="170" alt="">
            </div>
        </div>
        <div class="profile-info pt-5 d-flex align-items-center justify-content-center">
            <div class="justify-content-center">
                <h3 class="text-center">Jhon Deo</h3>
                <p class="mb-0">Engineer at BB Agency Industry
                    New York, United States</p>
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
                    <div class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle-nocaret options dropdown-toggle"
                            data-bs-toggle="dropdown">
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
                    <div class="col-md-6">
                        <label for="input1" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="input1" placeholder="First Name">
                    </div>
                    <div class="col-md-6">
                        <label for="input2" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="input2" placeholder="Last Name">
                    </div>
                    <div class="col-md-12">
                        <label for="input3" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="input3" placeholder="Phone">
                    </div>
                    <div class="col-md-12">
                        <label for="input4" class="form-label">Email</label>
                        <input type="email" class="form-control" id="input4">
                    </div>
                    <div class="col-md-12">
                        <label for="input5" class="form-label">Password</label>
                        <input type="password" class="form-control" id="input5">
                    </div>
                    <div class="col-md-12">
                        <label for="input6" class="form-label">DOB</label>
                        <input type="date" class="form-control" id="input6">
                    </div>
                    <div class="col-md-12">
                        <label for="input7" class="form-label">Country</label>
                        <select id="input7" class="form-select">
                            <option selected="">Choose...</option>
                            <option>One</option>
                            <option>Two</option>
                            <option>Three</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="input8" class="form-label">City</label>
                        <input type="text" class="form-control" id="input8" placeholder="City">
                    </div>
                    <div class="col-md-4">
                        <label for="input9" class="form-label">State</label>
                        <select id="input9" class="form-select">
                            <option selected="">Choose...</option>
                            <option>One</option>
                            <option>Two</option>
                            <option>Three</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="input10" class="form-label">Zip</label>
                        <input type="text" class="form-control" id="input10" placeholder="Zip">
                    </div>
                    <div class="col-md-12">
                        <label for="input11" class="form-label">Address</label>
                        <textarea class="form-control" id="input11" placeholder="Address ..." rows="4"
                            cols="4"></textarea>
                    </div>
                    <div class="col-md-12">
                        <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                            <button type="button" class="btn btn-primary px-4 float-end">Update Profile</button>
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
                    <div class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle-nocaret options dropdown-toggle"
                            data-bs-toggle="dropdown">
                            <span class="material-icons-outlined fs-5">more_vert</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="javascript:;">Action</a></li>
                            <li><a class="dropdown-item" href="javascript:;">Another action</a></li>
                            <li><a class="dropdown-item" href="javascript:;">Something else here</a></li>
                        </ul>
                    </div>
                </div>
                <div class="full-info">
                    <div class="info-list d-flex flex-column gap-3">
                        <div class="info-list-item d-flex align-items-center gap-3"><span
                                class="material-icons-outlined">account_circle</span>
                            <p class="mb-0">Full Name: Jhon Deo</p>
                        </div>
                        <div class="info-list-item d-flex align-items-center gap-3"><span
                                class="material-icons-outlined">done</span>
                            <p class="mb-0">Status: active</p>
                        </div>
                        <div class="info-list-item d-flex align-items-center gap-3"><span
                                class="material-icons-outlined">send</span>
                            <p class="mb-0">Email: jhon.xyz</p>
                        </div>
                        <div class="info-list-item d-flex align-items-center gap-3"><span
                                class="material-icons-outlined">call</span>
                            <p class="mb-0">Phone: (124) 895-6724</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!--end row-->

@endsection
@push('script')

@endpush
