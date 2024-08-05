@extends('admin.layouts.app')

@section('title')
Starter Page
@endsection

@section('content')
<h3><b> Tipe Paket</b></h3>
<div class="row justify-content-start">
    <div class="col-md-2 mb-2 col-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add</button>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <table class="table table-bordered mb-0">
            <thead>
                <tr>
                    <th scope="col">Nama Tipe Paket</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($type_package as $row)
                <tr>
                    <td>{{ $row->name }}</td>
                    <td>
                        <!-- Contoh tombol aksi -->
                        <button class="btn btn-sm btn-primary button_edit" data-bs-toggle="modal" data-bs-target="#modalEdit" data-id="{{$row->id}}" data-name="{{$row->name}}">Edit</button>
                        <button class="btn btn-sm btn-danger button_delete" data-bs-toggle="modal" data-bs-target="#modalDelete" data-id="{{$row->id}}" data-name="{{$row->name}}">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
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
                    <div class="form-group">
                        <label for="name">Nama Latihan</label>
                        <input type="text" class="form-control" id="name_edit" name="name" required>
                        <input type="hidden" name="id" id="id_edit">
                        <input type="hidden" name="edit" value="1">
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



<!-- Modal delete -->
<div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="membershipForm" method="POST" action="">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalDeleteLabel">Tambah Latihan</h1>
                    <input type="hidden" name="id" id="id_delete">
                    <input type="hidden" name="name" id="name_delete">
                    <input type="hidden" name="delete" value="1">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Save</button>
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
            $('#name_edit').val(name);
            $('#id_edit').val(id);
        });
        $('.button_delete').click(function() {
            let id = $(this).data('id');
            let name = $(this).data('name');
            $('#name_delete').val(name);
            $('#id_delete').val(id);
            $('#modalDeleteLabel').html(`Apakah anda ingin mnghapus ${name}?`);
        });
    });
</script>
@endpush