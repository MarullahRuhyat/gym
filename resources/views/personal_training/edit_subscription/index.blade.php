@extends('personal_training.layouts.app')
@section('title')
Edit Subscription
@endsection

@section('content') 
@push('style')
<!-- Add DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.0/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css">
@endpush

<h3><b>Edit Member Subscription</b></h3>
<p class="text-muted">Manage member subscription periods</p>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered mb-0">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Name</th>
                    <th scope="col">Phone Number</th>
                    <th scope="col">Status</th>
                    <th scope="col">Current Package</th>
                    <th scope="col">Start Date</th>
                    <th scope="col">End Date</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($results as $member)
                    @php
                        $membership = \App\Models\Membership::where('user_id', $member->id)
                            ->orderBy('created_at', 'desc')
                            ->first();
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $member->name }}</td>
                        <td>{{ $member->phone_number }}</td>
                        <td>
                            @if($member->status == 'active')
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                        <td>
                            @if($membership)
                                @if($membership->gym_membership_packages)
                                    @php
                                        $package = \DB::table('gym_membership_packages')->where('id', $membership->gym_membership_packages)->first();
                                    @endphp
                                    @if($package)
                                        {{ $package->name }}
                                    @else
                                        -
                                    @endif
                                @else
                                    -
                                @endif
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($membership)
                                {{ \Carbon\Carbon::parse($membership->start_date)->format('d-m-Y') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($membership)
                                {{ \Carbon\Carbon::parse($membership->end_date)->format('d-m-Y') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('pt_edit_subscription_edit', $member->id) }}" class="btn btn-sm btn-primary">
                                <i class="material-icons-outlined" style="font-size: 16px;">edit</i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('script')
<!--plugins-->
<script src="{{ URL::asset('build/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ URL::asset('build/plugins/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ URL::asset('build/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('build/js/main.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.3.0/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.0/js/dataTables.bootstrap5.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('.table').DataTable();
    });
</script>

@endpush
