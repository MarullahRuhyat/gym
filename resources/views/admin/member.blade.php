@extends('admin.layouts.app')
@section('title')
starter Page
@endsection
@section('content')

@section('content')
<h3><b>Member's</b></h3>

<div class="row">
    @foreach ($users as $user)

    <div class="col-md-6">
        <div class="card rounded-4">
            <div class="card-header">
                <div class="row">
                    <div class="col-10">
                        <h3>{{ $user->name }}</h3>
                    </div>
                    <div class="col-2 text-end">
                        <div class="test ">
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                                <span class="visually-hidden">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                                <a class="dropdown-item button_edit" href="javascript:;" data-bs-toggle="modal" data-bs-target="#editModal" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-phone="{{ $user->phone_number }}">Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column gap-3 me-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <h6 class="mb-0">Phone Number</h6>
                        </div>
                        <div class="">
                            <h5 class="mb-0">{{ $user->phone_number }}</h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <h6 class="mb-0">Status</h6>
                        </div>
                        <div class="">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="ada" checked disabled>
                                <label>
                                    <h5> Active</h5>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Modal Edit User -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Member</h5>
            </div>
            <form id="editUserForm" action="" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name_edit" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name_edit" name="name" required>
                        <input type="hidden" id="id_edit" name="id">
                        <input type="hidden" name="edit" value="1">
                    </div>
                    <div class="mb-3">
                        <label for="phone_edit" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone_edit" name="phone_number" required>
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
@endsection
@endsection
@push('script')
<!--plugins-->
<script src="{{ URL::asset('build/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ URL::asset('build/plugins/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ URL::asset('build/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('build/js/main.js') }}"></script>
<script>
    $(document).ready(function() {
        // Populate Edit Modal
        $('.button_edit').click(function() {
            let id = $(this).data('id');
            let name = $(this).data('name');
            let phone = $(this).data('phone');
            $('#name_edit').val(name);
            $('#phone_edit').val(phone);
            $('#id_edit').val(id);
        });

        // Populate Delete Modal
        $('.button_delete').click(function() {
            let id = $(this).data('id');
            let name = $(this).data('name');
            $('#id_delete').val(id);
            $('#deleteModalLabel').html(`Apakah anda ingin mnghapus ${name}?`);
        });
    });
</script>
@endpush