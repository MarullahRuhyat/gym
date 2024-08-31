@extends('admin.layouts.app')
@section('title')
starter Page
@endsection
@section('content')

@section('content')
<h3><b>Personal Trainer</b></h3>

<div class="row">
    <div class="col-md-6">
        <div class="row justify-content-start">
            <div class="col-md-2 mb-2 col-3">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">Add</button>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row mb-2 justify-content-end">
            <div class="col-md-8 d-flex justify-content-end align-items-center">
                <input type="text" class="form-control " id="search_name" placeholder="Search Name">
            </div>
        </div>
    </div>
</div>


<div id="data_pt">
    @include('admin.personal_trainer.data')
</div>

<!-- Modal Add User -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Add Personal Trainer</h5>
            </div>
            <form id="addUserForm" action="" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                    </div>
                    <div class="mb-3">
                        <label for="salary" class="form-label ">Salary</label>
                        <input type="text" class="form-control angka-rupiah" id="salary" name="salary_pt" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" aria-label="Default select example" required name="status">
                            <option value="" selected>-- select --</option>
                            <option value="active">active</option>
                            <option value="inactive">inactive</option>
                        </select>
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

<!-- Modal Edit User -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Personal Trainer</h5>
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
                    <div class="mb-3">
                        <label for="salary_edit" class="form-label">Salary</label>
                        <input type="text" class="form-control angka-rupiah" id="salary_edit" name="salary_pt" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" aria-label="Default select example" required name="status" id="status_edit">
                            <option value="" selected>-- select --</option>
                            <option value="active">active</option>
                            <option value="inactive">inactive</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="desc" class="form-label">Desc</label>
                        <textarea  class="form-control" id="desc" name="desc">
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

<!-- Modal Delete User -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form id="deleteUserForm" action="" method="POST">
                @csrf
                <input type="hidden" id="id_delete" name="id">
                <input type="hidden" name="delete" value="1">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete User</h5>
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
        $(document).on('click', '.button_edit', function(event) {
            let id = $(this).data('id');
            let name = $(this).data('name');
            let phone = $(this).data('phone');
            let status = $(this).data('status');
            let salary = $(this).data('salary');
            salary = formatRupiah(`${salary}`, false)

            $('#name_edit').val(name);
            $('#phone_edit').val(phone);
            $('#id_edit').val(id);
            $('#status_edit').val(status);
            $('#salary_edit').val(salary);
            $('#desc').val(desc);
        });

        // Populate Delete Modal
        $(document).on('click', '.button_delete', function(event) {
            let id = $(this).data('id');
            let name = $(this).data('name');
            $('#id_delete').val(id);
            $('#deleteModalLabel').html(`Apakah anda ingin mnghapus ${name}?`);
        });

        // fetch data
        function fetch_data(page, query) {
            $.ajax({
                url: `{{ route('admin_personal_trainer')}}?page=` + page + "&name=" + query,
                success: function(data) {
                    $('#data_pt').html(data);
                    updateRupiahElements();
                }
            });
        }

        // Handle input event
        $('#search_name').on('input', function() {
            let searchQuery = $(this).val();
            fetch_data(1, searchQuery); // Fetch data for the first page with search query
        });

        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            let searchQuery = $('#search_name').val();
            fetch_data(page, searchQuery);
        });


    });
</script>
@endpush
