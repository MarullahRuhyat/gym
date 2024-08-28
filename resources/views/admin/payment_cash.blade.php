@extends('admin.layouts.app')
@section('title')
    CASH
@endsection
@section('content')

<h4>Cash Payment From User</h4>
<div class="row">
    <div class="col-md-6">
        <div class="card rounded-4">
            <div class="card-body">
                {{-- membuat table dengan row nama dan nominal --}}
                <table class="table mb-4">
                    <tbody>
                        <tr>
                            <th scope="row">Nama :</th>
                            <td>Arief</td>
                        </tr>
                        <tr>
                            <th scope="row">Nominal : </th>
                            <td>Rp. 200.000</td>
                        </tr>
                    </tbody>
                </table>
                <button class="btn btn-primary">Accept</button>
                <button class="btn btn-danger">Reject</button>
            </div>

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
@endpush
