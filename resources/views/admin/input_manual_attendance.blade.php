@extends('admin.layouts.app')
@section('title')
starter Page
@endsection
@section('content')

@section('content')
<h3><b>Input manual attendance</b></h3>

{{-- center card for input manual attendance --}}
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Input manual attendance</h5>
                <form action="" method="post">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="user_id">User</label>
                        <select name="user_id" id="user_id" class="form-control select2">
                            @foreach ($user as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        
                    </div>

                    <div class="form-group mb-3">
                        <label for="pt_id">Personal Trainer</label>
                        <select name="pt_id" id="pt_id" class="form-control">
                            @foreach ($pt as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="date">Date</label>
                        <input type="date" name="date" id="date" class="form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label for="time_in">Time in</label>
                        <input type="time" name="time_in" id="time_in" class="form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label for="time_out">Time out</label>
                        <input type="time" name="time_out" id="time_out" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('#user_id').select2({
            placeholder: "Pilih User",
            allowClear: true
        });
    });
</script>
@endpush
