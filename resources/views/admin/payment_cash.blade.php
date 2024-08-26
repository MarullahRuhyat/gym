@extends('admin.layouts.app')
@section('title')
CASH
@endsection
@section('content')

<h4>Cash Payment From User</h4>
<div class="row">
    @foreach ($data_cash as $item)
    <div class="col-md-6">
        <div class="card rounded-4">
            <div class="card-body">
                <table class="table mb-4">
                    <tbody>
                        <tr>
                            <th scope="row">Nama :</th>
                            <td>{{$item->user_name}}</td>
                        </tr>
                        <tr>
                            <th scope="row">No Telpon :</th>
                            <td>{{$item->user_phone}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Nominal : </th>
                            <td>
                                <h2 class="badge bg-primary">Rp. {{number_format($item->amount,0,',','.')}}</h2>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <form action="{{ route('admin_cash_acc') }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="payment_id" value="{{$item->payment_id}}">
                    <input type="hidden" name="id_membership" value="{{$item->id_membership}}">
                    <input type="hidden" name="user_id" value="{{$item->user_id}}">
                    <input type="hidden" name="end_date" value="{{$item->end_date}}">
                    <input type="hidden" name="start_date" value="{{$item->start_date}}">
                    <input type="hidden" name="user_name" value="{{$item->user_name}}">
                    <input type="hidden" name="user_phone" value="{{$item->user_phone}}">
                    <input type="hidden" name="amount" value="{{$item->amount}}">
                    <button type="submit" class="btn btn-primary">Accept</button>
                </form>
                <form action="{{ route('admin_cash_rej') }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="payment_id" value="{{$item->payment_id}}">
                    <input type="hidden" name="id_membership" value="{{$item->id_membership}}">
                    <input type="hidden" name="user_id" id="{{$item->user_id}}">
                    <input type="hidden" name="user_name" value="{{$item->user_name}}">
                    <input type="hidden" name="user_phone" value="{{$item->user_phone}}">
                    <input type="hidden" name="amount" value="{{$item->amount}}">
                    <button type="submit" class="btn btn-danger">Reject</button>
                </form>
            </div>
        </div>
    </div>
    
    @endforeach
</div>



@endsection
@push('script')
<!--plugins-->
<script src="{{ URL::asset('build/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ URL::asset('build/plugins/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ URL::asset('build/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('build/js/main.js') }}"></script>
@endpush
