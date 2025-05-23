@extends('admin.layouts.app')
@section('title')
starter Page
@endsection
@section('content')

@section('content')
<h3><b>Member's</b></h3>
<div class="row mb-2 justify-content-end">
    <div class="col-md-4 d-flex justify-content-end align-items-center">
        <input type="text" class="form-control " id="search_name" placeholder="Search Name">
    </div>
</div>

<div id="data_member">
    @include('admin.member.data')
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
                    <div class="mb-3">
                        <label for="phone_edit" class="form-label">Status</label>
                        <div id="status_edit">
                        </div>
                    </div>
                    {{-- sisa pt --}}
                    <div class="mb-3">
                        <label for="sisa_pt" class="form-label">Sisa PT</label>
                        <input type="number" class="form-control" id="sisa_pt" name="available_personal_trainer_quota" required>
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
    $(document).ready(function () {
        // Populate Edit Modal
        $(document).on('click', '.button_edit', function () {
            let id = $(this).data('id');
            let name = $(this).data('name');
            let phone = $(this).data('phone');
            let status = $(this).data('status');
            let sisa_pt = $(this).data('sisa_pt');
            // alert(sisa_pt);
            $('#name_edit').val(name);
            $('#phone_edit').val(phone);
            $('#id_edit').val(id);
            $('#sisa_pt').val(sisa_pt);
            if (status == "active") {
                $('#status_edit').html(`
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" value="active" id="statusActive" checked>
                        <label class="form-check-label" for="statusActive">
                            Active
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" value="inactive" id="statusInactive">
                        <label class="form-check-label" for="statusInactive">
                            Inactive
                        </label>
                    </div>
                `);
            } else {
                $('#status_edit').html(`
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" value="active" id="statusActive">
                        <label class="form-check-label" for="statusActive">
                            Active
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" value="inactive" id="statusInactive" checked>
                        <label class="form-check-label" for="statusInactive">
                            Inactive
                        </label>
                    </div>
                `);
            }

        });

        // Populate Delete Modal
        $(document).on('click', '.button_delete', function () {
            let id = $(this).data('id');
            let name = $(this).data('name');
            $('#id_delete').val(id);
            $('#deleteModalLabel').html(`Apakah anda ingin mnghapus ${name}?`);
        });

        // fetch data
        function fetch_data(page, query) {
            $.ajax({
                url: `{{ route('admin_member')}}?page=` + page + "&name=" + query,
                success: function (data) {
                    $('#data_member').html(data);
                }
            });
        }

        // Handle input event
        $('#search_name').on('input', function () {
            let searchQuery = $(this).val();
            fetch_data(1, searchQuery); // Fetch data for the first page with search query
        });

        $(document).on('click', '.pagination a', function (event) {
            event.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            let searchQuery = $('#search_name').val();
            fetch_data(page, searchQuery);
        });


    });

</script>
@endpush
