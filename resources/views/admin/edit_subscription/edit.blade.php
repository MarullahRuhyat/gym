@extends('admin.layouts.app')
@section('title')
Edit Subscription - {{ $user->name }}
@endsection
@section('content')

<h3><b>Edit Subscription</b></h3>
<p class="text-muted">Manage subscription for: {{ $user->name }}</p>

<div class="card">
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card bg-light">
                    <div class="card-body">
                        <h6 class="card-title">Member Information</h6>
                        <p><strong>Name:</strong> {{ $user->name }}</p>
                        <p><strong>Phone:</strong> {{ $user->phone_number }}</p>
                        <p><strong>Status:</strong> 
                            @if($user->status == 'active')
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            @if($membership)
            <div class="col-md-6">
                <div class="card bg-light">
                    <div class="card-body">
                        <h6 class="card-title">Current Subscription</h6>
                        <p><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($membership->start_date)->format('d-m-Y') }}</p>
                        <p><strong>End Date:</strong> {{ \Carbon\Carbon::parse($membership->end_date)->format('d-m-Y') }}</p>
                        <p><strong>Status:</strong> 
                            @if($membership->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <form action="{{ route('admin_edit_subscription_update', $user->id) }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="start_date" name="start_date" 
                               value="{{ $membership ? \Carbon\Carbon::parse($membership->start_date)->format('Y-m-d') : old('start_date') }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="end_date" name="end_date" 
                               value="{{ $membership ? \Carbon\Carbon::parse($membership->end_date)->format('Y-m-d') : old('end_date') }}" required>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Subscription Status <span class="text-danger">*</span></label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="is_active" id="is_active_true" value="1" 
                               {{ ($membership && $membership->is_active == 1) || old('is_active') == 1 ? 'checked' : '' }} required>
                        <label class="form-check-label" for="is_active_true">
                            Active
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="is_active" id="is_active_false" value="0" 
                               {{ ($membership && $membership->is_active == 0) || old('is_active') == 0 ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active_false">
                            Inactive
                        </label>
                    </div>
                </div>
            </div>

            @if($packages->count() > 0)
            <div class="mb-3">
                <label for="gym_membership_package_id" class="form-label">Package Reference (Optional)</label>
                <select class="form-select" id="gym_membership_package_id" name="gym_membership_package_id">
                    <option value="">-- Select Package --</option>
                    @foreach($packages as $package)
                        <option value="{{ $package->id }}" 
                                {{ $membership && $membership->gym_membership_packages == $package->id ? 'selected' : '' }}>
                            {{ $package->name }} - {{ $package->duration_in_days }} days
                        </option>
                    @endforeach
                </select>
                <div class="form-text">This is for reference only. The actual dates will be set above.</div>
            </div>
            @endif

            <div class="mb-3">
                <a href="{{ route('admin_edit_subscription') }}" class="btn btn-secondary">
                    <i class="material-icons-outlined" style="font-size: 16px; vertical-align: middle;">arrow_back</i> Back
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="material-icons-outlined" style="font-size: 16px; vertical-align: middle;">save</i> Save Changes
                </button>
            </div>
        </form>
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
    $(document).ready(function () {
        // Ensure end date is after start date
        $('#start_date').on('change', function () {
            let startDate = $(this).val();
            $('#end_date').attr('min', startDate);
        });

        // Calculate duration when dates are changed
        function calculateDuration() {
            let startDate = $('#start_date').val();
            let endDate = $('#end_date').val();
            
            if (startDate && endDate) {
                let start = new Date(startDate);
                let end = new Date(endDate);
                let diffTime = Math.abs(end - start);
                let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                
                if (diffDays >= 0) {
                    $('#duration_display').text(diffDays + ' days');
                } else {
                    $('#duration_display').text('Invalid dates');
                }
            }
        }

        $('#start_date, #end_date').on('change', calculateDuration);
    });
</script>
@endpush
