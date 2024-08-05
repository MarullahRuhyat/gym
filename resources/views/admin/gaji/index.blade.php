@extends('admin.layouts.app')
@section('title')
starter Page
@endsection
@section('content')
<h3><b>Gaji</b></h3>
<div class="row">
    <div class="col-md-6">
        <form action="" method="post">
            @csrf
            <input type="hidden" name="bulan_gaji" id="bulan_gaji" value="{{$month}}">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Kirim
            </button>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Apakah anda yakin ingin mengirim gaji?</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-6">
        <div class="row mb-2 justify-content-end">
            <div class="col-md-6 mb-2 col-12 d-flex justify-content-end align-items-center">
                <select class="form-control " aria-label="Default select example" id="month">
                    @foreach($months as $row)
                    @if($row->formatted_bulan_gaji == $month)
                    <option value="{{$row->formatted_bulan_gaji}}" selected>{{$row->formatted_bulan_gaji}}</option>
                    @else
                    <option value="{{$row->formatted_bulan_gaji}}">{{$row->formatted_bulan_gaji}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-2 col-12 d-flex justify-content-end align-items-center">
                <input type="text" class="form-control " id="search_name" placeholder="Search Name">
            </div>
        </div>
    </div>
</div>


<div id="data_gaji">
    @include('admin.gaji.data')
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalLabel">Bonus</h1>
            </div>
            <form id="membershipFormEdit" method="POST" action="{{ route('admin_bonus')}}">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="gaji_personal_trainers_id" id="gaji_id">
                    <div class="row" id="input_bonus">

                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="button" class="btn btn-success w-100" id="add_bonus">Tambah Bonus</button>
                        </div>
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

        $('#data_gaji').on('click', '.button_detail', function() {
            let id = $(this).data('id');
            $.ajax({
                url: `{{ route('admin_ajax_get_bonus')}}?gaji_id=` + id,
                success: function(data) {
                    console.log(data);
                    $('#gaji_id').val(id)
                    let html = ``
                    data.data.forEach(row => {
                        html += ` 
                        <div class="mb-3 col-md-6">
                            <label for="description_${row.id}" class="form-label">Description</label>
                            <input type="text" id="description_${row.id}"  name="description_${row.id}" class="form-control" value="${row.description}" disabled>
                        </div>
                         <div class="mb-3 col-md-6">
                            <label for="amount_${row.id}" class="form-label">Amount</label>
                            <input type="text" id="amount_${row.id}" name="amount_${row.id}" class="form-control" value="${row.amount}">
                        </div>
                        <hr>
                        `
                    });
                    $('#input_bonus').html(html);
                }
            });
        });

        $('#add_bonus').click(function() {
            let html = ` 
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Description</label>
                            <input type="text"  class="form-control"  name="descriptions[]" required>
                        </div>
                         <div class="mb-3 col-md-6">
                            <label  class="form-label">Amount</label>
                            <input type="text"  class="form-control" name="amounts[]" required>
                        </div>
                        <hr>
                        `
            $('#input_bonus').append(html);
        });



        // fetch data
        function fetch_data(page, query, month) {
            $.ajax({
                url: `{{ route('admin_gaji')}}?page=` + page + "&name=" + query + "&month=" + month,
                success: function(data) {
                    $('#data_gaji').html(data);
                }
            });
        }

        // Handle input event
        $('#search_name').on('input', function() {
            let searchQuery = $(this).val();
            let month = $('#month').val();
            fetch_data(1, searchQuery, month); // Fetch data for the first page with search query
        });

        // Handle select event
        $('#month').on('change', function() {
            let searchQuery = $('#search_name').val();
            let month = $(this).val();
            $('#bulan_gaji').val(month);
            fetch_data(1, searchQuery, month); // Fetch data for the first page with search query
        });

        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            let searchQuery = $('#search_name').val();
            let month = $('#month').val();
            fetch_data(page, searchQuery, month);
        });
    });
</script>
@endpush