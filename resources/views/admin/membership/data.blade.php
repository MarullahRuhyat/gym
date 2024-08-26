@if($results->isNotEmpty())
<div class="row">
    @foreach ($results as $package)
    <div class="col-md-6">
        <div class="card rounded-4">
            <div class="card-header">
                <div class="row">
                    <div class="col-10">
                        <h3>{{ $package->name }}</h3>
                    </div>
                    <div class="col-2 text-end">
                        <div class="test ">
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                                <span class="visually-hidden">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                                <a class="dropdown-item button_edit" href="javascript:;" data-bs-toggle="modal" data-bs-target="#editModal" data-id="{{ $package->id }}" data-name="{{ $package->name }}" data-price="{{ $package->price }}" data-duration="{{ $package->duration_in_days }}" data-trainer="{{ $package->personal_trainer_quota }}" data-type="{{ $package->type_packages_id }}">Edit</a>
                                <!-- <a class="dropdown-item button_delete" href="javascript:;" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $package->id }}" data-name="{{ $package->name }}">Delete</a> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column gap-3 me-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <h6 class="mb-0">Tipe Paket</h6>
                        </div>
                        <div class="">
                            <h5 class="mb-0">{{ $package->type_package_name }}</h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <h6 class="mb-0">Price</h6>
                        </div>
                        <div class="">
                            <h5 class="mb-0 rupiah">{{ $package->price }}</h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <h6 class="mb-0">Duration (Days)</h6>
                        </div>
                        <div class="">
                            <h5 class="mb-0">{{ $package->duration_in_days }}</h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <h6 class="mb-0">Kuota Personal Trainer</h6>
                        </div>
                        <div class="">
                            <h5 class="mb-0">{{ $package->personal_trainer_quota }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
<div class="d-flex justify-content-start">
    <nav aria-label="..." class="mt-2">
        <ul class="pagination">
            @if ($results->lastPage() == 1)
            <li class="page-item disabled" style="background-color: white;border-radius: 5px;">
                <a class="page-link" href="#" tabindex="-1">&laquo;</a>
            </li>
            @elseif ($results->currentPage() == 1)
            <li class="page-item disabled" style="background-color: white; border-radius: 5px;">
                <a class="page-link" href="#" tabindex="-1">&laquo;</a>
            </li>
            @else
            <li class="page-item" style="background-color: white; border-radius: 5px;">
                <a class="page-link" href="{{ $results->previousPageUrl() }}" tabindex="-1">&laquo;</a>
            </li>
            @endif
            @for ($i = max(1, $results->currentPage() - 2); $i <= min($results->currentPage() + 2, $results->lastPage()); $i++)
                @if ($results->currentPage() == $i)
                <li class="page-item active">
                    <a class="page-link" href="#">{{ $i }}</a>
                </li>
                @else
                <li class="page-item"><a class="page-link" href="{{ $results->url($i) }}" style="background-color: white">{{ $i }}</a></li>
                @endif
                @endfor
                @if ($results->lastPage() == 1)
                <li class="page-item disabled" style="background-color: white;border-radius: 5px;">
                    <a class="page-link" href="#" tabindex="-1">&raquo;</a>
                </li>
                @elseif ($results->currentPage() == $results->lastPage())
                <li class="page-item disabled" style="background-color: white;border-radius: 5px;">
                    <a class="page-link" href="#" tabindex="-1">&raquo;</a>
                </li>
                @else
                <li class="page-item" style="background-color: white;border-radius: 5px;">
                    <a class="page-link" href="{{ $results->nextPageUrl() }}" tabindex="-1">&raquo;</a>
                </li>
                @endif
        </ul>
    </nav>
</div>
@else
<div class="d-flex justify-content-center">
    Tidak ada data.
</div>
@endif