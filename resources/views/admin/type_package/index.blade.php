@extends('admin.layouts.app')

@section('title')
Starter Page
@endsection

@section('content')
<h3><b> Tipe Paket</b></h3>


<div class="row">
    <div class="col-md-6">
        <div class="row justify-content-start">
            <div class="col-md-2 mb-2 col-3">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add</button>
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

<div id="data_type_package">
    @include('admin.type_package.data')
</div>


<!-- Modal add -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Tipe Paket</h1>
            </div>
            <form id="membershipForm" method="POST" action="">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nama Tipe Paket</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="max_user">Max User</label>
                        <input type="text" class="form-control" id="max_user" name="max_user" required>
                    </div>
                    <div class="form-group">
                        <label for="bonus">Bonus</label>
                        <input type="text" class="form-control angka-rupiah" id="bonus" name="bonus" required>
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



<!-- Modal edit -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalEditLabel">Edit Latihan</h1>
            </div>
            <form id="membershipForm" method="POST" action="">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="id" id="id_edit">
                    <input type="hidden" name="edit" value="1">
                    <div class="form-group">
                        <label for="name">Nama Latihan</label>
                        <input type="text" class="form-control" id="name_edit" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="max_user_edit">Max User</label>
                        <input type="text" class="form-control" id="max_user_edit" name="max_user" required>
                    </div>
                    <div class="form-group">
                        <label for="bonus_edit">Bonus</label>
                        <input type="text" class="form-control angka-rupiah" id="bonus_edit" name="bonus" required>
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

@push('script')
<!--plugins-->
<script src="{{ URL::asset('build/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ URL::asset('build/plugins/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ URL::asset('build/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('build/js/main.js') }}"></script>
<script>
    $(document).ready(function() {
        $(document).on('click', '.button_edit', function() {
            let id = $(this).data('id');
            let name = $(this).data('name');
            let bonus = $(this).data('bonus');
            let max_user = $(this).data('max_user');
            $('#name_edit').val(name);
            $('#bonus_edit').val(formatRupiah(`${bonus}`, false));
            $('#max_user_edit').val(max_user);
            $('#id_edit').val(id);
        });

        // fetch data
        function fetch_data(page, query) {
            $.ajax({
                url: `{{ route('admin_type_package')}}?page=` + page + "&name=" + query,
                success: function(data) {
                    $('#data_type_package').html(data);
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