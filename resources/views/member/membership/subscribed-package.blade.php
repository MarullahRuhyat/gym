@extends('member.layouts.app')
@section('title')
Subscribed Package
@endsection
@section('content')
@foreach($membership as $membership)
<div class="row">
    <div class="col-md-4">
        <div class="card rounded-4">
            <div class="card-header">
                <h5 style="margin-top:10px;" class="card-title mb-3">{{ ucwords($membership->name) }}</h5>
            </div>
            <div class="card-body">
                <div class="row g-0">
                    <div class="col-md-4 border-end">
                        <div class="p-3">
                            <img src="{{ URL::asset('build/images/02.png') }}" class="w-100 rounded h-100" alt="...">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <input type="hidden" name="package_id" id="package_id" value="">
                            <p class="card-text">{{ $membership->description }}</p>
                            <p class="card-text">Duration: {{ $membership->duration_in_days }} Days</p>
                            <p class="card-text">Starting: {{ $membership->start_date }}</p>
                            <p class="card-text">Ending: {{ $membership->end_date }}</p>
                            <p class="card-text">Personal Trainer Qouta: {{ $membership->personal_trainer_quota }} / {{ $membership->personal_trainer_quota }}</p>
                            <p class="card-text">Price: {{ $membership->price }}</p>
                            @if($membership->is_active)
                                <button class="btn btn-primary" disabled>Active</button>
                            @else
                                <button class="btn btn-secondary" disabled>Inactive</button>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
@push('script')
<!--plugins-->
<script src="{{ URL::asset('build/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ URL::asset('build/plugins/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ URL::asset('build/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('build/js/main.js') }}"></script>
@endpush