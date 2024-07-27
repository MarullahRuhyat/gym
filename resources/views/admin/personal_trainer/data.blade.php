<div class="row">
    @foreach ($results as $user)
    <div class="col-md-6">
        <div class="card rounded-4">
            <div class="card-header">
                <div class="row">
                    <div class="col-10">
                        <h3>{{ $user->name }}</h3>
                    </div>
                    <div class="col-2 text-end">
                        <div class="test ">
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                                <span class="visually-hidden">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                                <a class="dropdown-item button_edit" href="javascript:;" data-bs-toggle="modal" data-bs-target="#editModal" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-phone="{{ $user->phone_number }}" data-status="{{ $user->status }}" data-salary="{{ $user->salary_pt }}">Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column gap-3 me-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <h6 class="mb-0">Phone Number</h6>
                        </div>
                        <div class="">
                            <h5 class="mb-0">{{ $user->phone_number }}</h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <h6 class="mb-0">Salary</h6>
                        </div>
                        <div class="">
                            <h5 class="mb-0">{{ $user->salary_pt }}</h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <h6 class="mb-0">Status</h6>
                        </div>
                        <div class="">
                            <div class="form-check form-switch">
                                <label>
                                    @if($user->status == 'active')
                                    <input class="form-check-input" type="checkbox" role="switch" id="ada" checked disabled>
                                    <h5> Active</h5>
                                    @else
                                    <input class="form-check-input" type="checkbox" role="switch" id="ada" disabled>
                                    <h5> InActive</h5>
                                    @endif
                                </label>
                            </div>
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
            @if ($total_page == 1)
            <li class="page-item disabled" style="background-color: white;border-radius: 5px;">
                <a class="page-link" href="#" tabindex="-1">&laquo;</a>
            </li>
            @elseif ($results->currentPage() == 1)
            <li class="page-item disabled" style="background-color: white; border-radius: 5px;">
                <a class="page-link" href="#" tabindex="-1">&laquo;</a>
            </li>
            @else
            <li class="page-item" style="background-color: white; border-radius: 5px;">
                <a class="page-link" href="{{ $results->url($results->currentPage() - 1) }}" tabindex="-1">&laquo;</a>
            </li>
            @endif
            @for ($i = max(1, $results->currentPage() - 2); $i <= min($results->currentPage() + 2, $total_page); $i++)
                @if ($results->currentPage() == $i)
                <li class="page-item active">
                    <a class="page-link" href="#">{{ $i }}</a>
                </li>
                @else
                <li class="page-item"><a class="page-link" href="{{ $results->url($i) }}" style="background-color: white">{{ $i }}</a></li>
                @endif
                @endfor
                @if ($total_page == 1)
                <li class="page-item disabled" style="background-color: white;border-radius: 5px;">
                    <a class="page-link" href="#" tabindex="-1">&raquo;</a>
                </li>
                @elseif ($results->currentPage() == $total_page)
                <li class="page-item disabled" style="background-color: white;border-radius: 5px;">
                    <a class="page-link" href="#" tabindex="-1">&raquo;</a>
                </li>
                @else
                <li class="page-item" style="background-color: white;border-radius: 5px;">
                    <a class="page-link" href="{{ $results->url($results->currentPage() + 1) }}" tabindex="-1">&raquo;</a>
                </li>
                @endif
        </ul>
    </nav>
</div>