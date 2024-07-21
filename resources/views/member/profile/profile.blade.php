@extends('member.layouts.app')
@section('title')
starter Page
@endsection
@section('content')
@foreach($user as $user)
<div class="row justify-content-center">
    <div class="col-12 col-xl-4">
        <div class="card rounded-4">
            <div class="card-body p-4">
                <div class="position-relative mb-5">
                    <img src="assets/images/gallery/profile-cover.png" class="img-fluid rounded-4 shadow" alt="">
                    <div class="profile-avatar position-absolute top-100 start-50 translate-middle">
                        <!-- <img src="assets/images/avatars/01.png" class="img-fluid rounded-circle p-1 bg-grd-danger shadow" width="170" height="170" alt=""> -->
                        <img src="{{ URL::asset('build/images/member/photo_profile/'.$user->photo_profile ?? 'default.JPEG') }}" class="img-fluid rounded-circle p-1 bg-grd-danger shadow" width="170" height="170" alt="">
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
                        <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">account_circle</span>
                            <p class="mb-0">Nama: {{ $user->name }}</p>
                        </div>
                        <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">done</span>
                            <p class="mb-0">Status: {{ $user->status }}</p>
                        </div>
                        <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">code</span>
                            <p class="mb-0">Role: {{ $user->role }}</p>
                        </div>
                        <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">flag</span>
                            <p class="mb-0">Alamat: {{ $user->address }}</p>
                        </div>
                        <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">language</span>
                            <p class="mb-0">Tanggal Lahir: {{ $user->date_of_birth }}</p>
                        </div>
                        <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">send</span>
                            <p class="mb-0">Email: {{ $user->email }}</p>
                        </div>
                        <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">call</span>
                            <p class="mb-0">Nomor HP: {{ $user->phone_number }}</p>
                        </div>
                    </div>
                    <!-- <div class="col-md-12" style="padding-top:20px;">
                        <div class="d-md-flex d-grid align-items-center gap-3">
                            <a href="{{ route('member.edit_profile') }}" type="button" class="btn btn-primary px-4">Update Profile</a>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div><!--end row-->
@endforeach

@foreach($informasi_fisik as $informasi_fisik)
<div class="row justify-content-center">
    <div class="col-12 col-xl-4">
        <div class="card rounded-4">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div class="">
                        <h5 class="mb-0 fw-bold">Informasi Fisik</h5>
                    </div>
                </div>
                <div class="full-info">
                    <div class="info-list d-flex flex-column gap-3">
                        <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">done</span>
                            <p class="mb-0">Tinggi Badan: {{ $informasi_fisik->tinggi_badan }} cm </p>
                        </div>
                        <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">done</span>
                            <p class="mb-0">Berat Badan: {{ $informasi_fisik->berat_badan }} kg </p>
                        </div>
                        <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">done</span>
                            <p class="mb-0">Massa Otot: {{ $informasi_fisik->massa_otot }} cm </p>
                        </div>
                        <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">done</span>
                            <p class="mb-0">Massa Tulang: {{ $informasi_fisik->massa_tulang }} </p>
                        </div>
                        <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">done</span>
                            <p class="mb-0">Persentase Lemak Tubuh: {{ $informasi_fisik->persentase_lemak_tubuh }} % </p>
                        </div>
                        <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">done</span>
                            <p class="mb-0">Intoleransi Latihan atau Alergi: {{ $informasi_fisik->intoleransi_latihan_atau_alergi }} </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div><!--end row-->
@endforeach

<!-- button  -->
<div class="row justify-content-center">
    <div class="col-12 col-xl-4">
        <div class="col-md-12">
            <div class="d-grid align-items-center">
                <a href="{{ route('member.edit_profile') }}" type="button" class="btn btn-primary px-4">Update Profile</a>
            </div>
        </div>
    </div>
</div>
<!-- button  -->
@endsection
@push('script')
<!--plugins-->
<script src="{{ URL::asset('build/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ URL::asset('build/plugins/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ URL::asset('build/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('build/js/main.js') }}"></script>
@endpush
