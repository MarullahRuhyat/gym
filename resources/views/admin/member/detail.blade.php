@extends('admin.layouts.app')
@section('title')
starter Page
@endsection
@section('content')
@foreach($profile as $profile)
<div class="row justify-content-center">
    <div class="col-12 col-xl-4">
        <div class="card rounded-4">
            <div class="card-body p-4">
                <div class="position-relative mb-5">
                    <img src="assets/images/gallery/profile-cover.png" class="img-fluid rounded-4 shadow" alt="">
                    <div class="profile-avatar position-absolute top-100 start-50 translate-middle">
                        <!-- <img src="assets/images/avatars/01.png" class="img-fluid rounded-circle p-1 bg-grd-danger shadow" width="170" height="170" alt=""> -->
                        <img src="{{ URL::asset('build/images/member/photo_profile/'.$profile->photo_profile ?? 'default.JPEG') }}" class="img-fluid rounded-circle p-1 bg-grd-danger shadow" width="170" height="170" alt="">
                    </div>
                </div>
                <div class="profile-info pt-5 d-flex align-items-center justify-content-between">
                    <div class="">
                        <h3>{{ $profile->name }}</h3>
                        <p class="mb-0">{{ $profile->address }}</p>
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
                            <p class="mb-0">Nama: {{ $profile->name }}</p>
                        </div>
                        <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">done</span>
                            <p class="mb-0">Status: {{ $profile->status }}</p>
                        </div>
                        <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">code</span>
                            <p class="mb-0">Role: {{ $profile->role }}</p>
                        </div>
                        <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">flag</span>
                            <p class="mb-0">Alamat: {{ $profile->address }}</p>
                        </div>
                        <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">language</span>
                            <p class="mb-0">Tanggal Lahir: {{ $profile->date_of_birth }}</p>
                        </div>
                        <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">send</span>
                            <p class="mb-0">Email: {{ $profile->email }}</p>
                        </div>
                        <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">call</span>
                            <p class="mb-0">Nomor HP: {{ $profile->phone_number }}</p>
                        </div>
                        <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">call</span>
                            <p class="mb-0">Jenis Kelamin: @if($profile->gender == 'L') Laki-laki @else Perempuan @endif</p>
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
                            <p class="mb-0">Tinggi Badan: {{ $profile->tinggi_badan }} cm </p>
                        </div>
                        <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">done</span>
                            <p class="mb-0">Berat Badan: {{ $profile->berat_badan }} kg </p>
                        </div>
                        <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">done</span>
                            <p class="mb-0">Leher: {{ $profile->leher }} cm </p>
                        </div>
                        <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">done</span>
                            <p class="mb-0">Bahu: {{ $profile->bahu }} cm </p>
                        </div>
                        <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">done</span>
                            <p class="mb-0">Dada: {{ $profile->dada }} cm </p>
                        </div>
                        <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">done</span>
                            <p class="mb-0">Lengan Kanan: {{ $profile->lengan_kanan }} cm </p>
                        </div>
                        <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">done</span>
                            <p class="mb-0">Lengan Kiri: {{ $profile->lengan_kiri }} cm </p>
                        </div>
                        <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">done</span>
                            <p class="mb-0">Fore Arm Kanan: {{ $profile->fore_arm_kanan }} cm </p>
                        </div>
                        <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">done</span>
                            <p class="mb-0">Fore Arm Kiri: {{ $profile->fore_arm_kiri }} cm </p>
                        </div>
                        <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">done</span>
                            <p class="mb-0">Perut: {{ $profile->perut }} cm </p>
                        </div>
                        <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">done</span>
                            <p class="mb-0">Pinggang: {{ $profile->pinggang }} cm </p>
                        </div>
                        <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">done</span>
                            <p class="mb-0">Paha Kanan: {{ $profile->paha_kanan }} cm </p>
                        </div>
                        <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">done</span>
                            <p class="mb-0">Paha Kiri: {{ $profile->paha_kiri }} cm </p>
                        </div>
                        <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">done</span>
                            <p class="mb-0">Betis Kanan: {{ $profile->betis_kanan }} cm </p>
                        </div>
                        <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">done</span>
                            <p class="mb-0">Betis Kiri: {{ $profile->betis_kiri }} cm </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div><!--end row-->

<div class="row justify-content-center">
    <div class="col-12 col-xl-4">
        <div class="card rounded-4">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div class="">
                        <h5 class="mb-0 fw-bold">Membership Details</h5>
                    </div>
                </div>
                <!-- tampilkan paket membership  -->
                @if ($membership == null)
                <div class="justify-content-center text-center">
                    <div class="card" style="margin:auto; padding-bottom:50px; padding:30px;">
                        <p id="" class="mb-0 fw-bold">You don't have any membership yet</p>
                    </div>
                </div>
                @else
                <div class="justify-content-center text-center">
                    <div class="card" style="margin:auto; padding-bottom:50px; padding:5px;">
                        <div>
                            <div class="d-flex justify-content-between">
                                <p class="fw-semi-bold">Membership :</p>
                                <p id="" class="fw-bold">{{ $membership->name }}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="fw-semi-bold">Membership Period :</p>
                                <p id="" class="text-danger fw-bold">{{ $membership->duration_in_days }} days</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="fw-semi-bold">Starting Date :</p>
                                <p id="" class="fw-bold">{{ $membership->start_date }}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="fw-semi-bold">Ending Date :</p>
                                <p id="" class="fw-bold">{{ $membership->end_date }}</p>
                            </div>

                            <h5>History Member With PT</h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Nama PT</th>
                                        <th scope="col">Jam Mulai</th>
                                        <th scope="col">Jam Selesai</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($absent_members as $key => $history)
                                    <tr>
                                        <td>{{ $history->pt_name }}</td>
                                        <td>{{ $history->start_time }}</td>
                                        <td>{{ $history->end_time }}</td>
                                        <td>{{ $history->date }}</td>
                                        <td>
                                            <a href="{{ route('admin_absen_delete', $history->id) }}" class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <form action="{{ route('admin_update_available_personal_trainer_quota', $profile->id) }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="available_personal_trainer_quota" class="form-label">Available Personal Trainer Quota</label>
                                    <input type="number" class="form-control" id="available_personal_trainer_quota" aria-describedby="available_personal_trainer_quota" name="available_personal_trainer_quota" value="{{ $available_personal_trainer_quota }}">
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
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
                <a href="{{ route('admin_member') }}" type="button" class="btn btn-primary px-4">Kembali</a>
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