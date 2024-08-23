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
    <div class="col-md-6">
        <div class="card rounded-4">
            <div class="card-body">
                <p class="mb-4">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of
                    classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor
                    at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a
                    Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the
                    undoubtable source.</p>
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
