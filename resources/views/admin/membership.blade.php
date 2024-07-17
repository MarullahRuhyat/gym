@extends('admin.layouts.app')
@section('title')
starter Page
@endsection
@section('content')
<h3><b>Gym Membership Packages</b></h3>
<div class="row justify-content-start">
    <div class="col-md-2 mb-3 col-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">Add</button>
    </div>
</div>

<div class="row">
    @foreach ($packages as $package)
    <div class="col-md-6">
        <div class="card rounded-4">
            <div class="card-header">
                <div class="row">
                    <div class="col-10">
                        <h3>{{ $package->name }}</h3>
                    </div>
                    <div class="col-2 text-end">
                        <div class="test ">
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                                <span class="visually-hidden">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                                <a class="dropdown-item button_edit" href="javascript:;" data-bs-toggle="modal" data-bs-target="#editModal" data-id="{{ $package->id }}" data-name="{{ $package->name }}" data-price="{{ $package->price }}" data-duration="{{ $package->duration_in_days }}" data-trainer="{{ $package->personal_trainer_quota }}">Edit</a>
                                <a class="dropdown-item button_delete" href="javascript:;" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $package->id }}" data-name="{{ $package->name }}">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column gap-3 me-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <h6 class="mb-0">Price</h6>
                        </div>
                        <div class="">
                            <h5 class="mb-0">{{ $package->price }}</h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <h6 class="mb-0">Duration (Days)</h6>
                        </div>
                        <div class="">
                            <h5 class="mb-0">{{ $package->duration_in_days }}</h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <h6 class="mb-0">Personal Trainer</h6>
                        </div>
                        <div class="">
                            <h5 class="mb-0">{{ $package->personal_trainer_quota }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Modal Add -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addModalLabel">Add Package</h1>
            </div>
            <form id="membershipFormAdd" method="POST" action="">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" class="form-control" id="price" name="price" required>
                    </div>
                    <div class="form-group">
                        <label for="duration_in_days">Duration (Days)</label>
                        <input type="number" class="form-control" id="duration_in_days" name="duration_in_days" required>
                    </div>
                    <div class="form-group">
                        <label for="personal_trainer_quota">Personal Trainer</label>
                        <input type="number" class="form-control" id="personal_trainer_quota" name="personal_trainer_quota" value="0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalLabel">Edit Package</h1>
            </div>
            <form id="membershipFormEdit" method="POST" action="">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name_edit" name="name" required>
                        <input type="hidden" name="id" id="id_edit">
                        <input type="hidden" name="edit" value="1">
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" class="form-control" id="price_edit" name="price" required>
                    </div>
                    <div class="form-group">
                        <label for="duration_in_days">Duration (Days)</label>
                        <input type="number" class="form-control" id="duration_in_days_edit" name="duration_in_days" required>
                    </div>
                    <div class="form-group">
                        <label for="personal_trainer_quota_edit">Personal Trainer</label>
                        <input type="number" class="form-control" id="personal_trainer_quota_edit" name="personal_trainer_quota" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="membershipFormDelete" method="POST" action="">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteModalLabel">Delete Package</h1>
                    <input type="hidden" name="id" id="id_delete">
                    <input type="hidden" name="delete" value="1">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@push('script')
<!--plugins-->
<script src="{{ URL::asset('build/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ URL::asset('build/plugins/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ URL::asset('build/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('build/js/main.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.button_edit').click(function() {
            let id = $(this).data('id');
            let name = $(this).data('name');
            let price = $(this).data('price');
            let duration = $(this).data('duration');
            let trainer = $(this).data('trainer');
            console.log(trainer);

            $('#name_edit').val(name);
            $('#price_edit').val(price);
            $('#duration_in_days_edit').val(duration);
            $('#personal_trainer_quota_edit').val(trainer);
            $('#id_edit').val(id);
        });
        $('.button_delete').click(function() {
            let id = $(this).data('id');
            let name = $(this).data('name');
            $('#id_delete').val(id);
            $('#deleteModalLabel').html(`Apakah anda ingin mnghapus ${name}?`);
        });
    });
</script>
@endpush