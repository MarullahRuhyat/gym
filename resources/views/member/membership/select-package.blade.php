@extends('member.layouts.app')
@section('title')
starter Page
@endsection
@section('content')

<div class="card">
                                <div class="card-body">
                                    <ul class="nav nav-tabs nav-primary" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#primaryhome" role="tab" aria-selected="true">
                                                <div class="d-flex align-items-center">
                                                    <div class="tab-icon"><i class="bi bi-person me-1 fs-6"></i>
                                                    </div>
                                                    <div class="tab-title">Harian</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" data-bs-toggle="tab" href="#primaryprofile" role="tab" aria-selected="false">
                                                <div class="d-flex align-items-center">
                                                    <div class="tab-icon"><i class="bi bi-person me-1 fs-6"></i>
                                                    </div>
                                                    <div class="tab-title">Mandiri</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" data-bs-toggle="tab" href="#primarycontact" role="tab" aria-selected="false">
                                                <div class="d-flex align-items-center">
                                                    <div class="tab-icon"><i class='bi bi-person me-1 fs-6'></i>
                                                    </div>
                                                    <div class="tab-title">PT</div>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content py-3">
                                        <div class="tab-pane fade show active" id="primaryhome" role="tabpanel">
                                            <div class="row g-3">
                                                <div class="row row-cols-1 row-cols-lg-3 g-4">
                                                    @foreach($package as $pkg)
                                                    @if($pkg->type == 'harian')
                                                    <div class="col-12 col-lg-4">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <h5 class="card-title mb-3">{{ $pkg->name }}</h5>
                                                                <p class="card-text">{{ $pkg->description }}</p>
                                                                <h5>Price: ${{ $pkg->price }}</h5>
                                                                <div class="mt-3 d-flex align-items-center justify-content-between">
                                                                    <button style="color:white;" class="btn bg-primary border-0 d-flex gap-2 px-3" onclick="SelectPackage('{{ $pkg->id }}')">
                                                                        <!-- <i class="material-icons-outlined">shopping_cart</i> -->
                                                                        Select Package
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="primaryprofile" role="tabpanel">
                                            <div class="row g-3">
                                                <div class="row row-cols-1 row-cols-lg-3 g-4">
                                                    @foreach($package as $pkg)
                                                    @if($pkg->type == 'mandiri')
                                                    <div class="col-12 col-lg-4">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <h5 class="card-title mb-3">{{ $pkg->name }}</h5>
                                                                <p class="card-text">{{ $pkg->description }}</p>
                                                                <h5>Price: ${{ $pkg->price }}</h5>
                                                                <div class="mt-3 d-flex align-items-center justify-content-between">
                                                                    <button style="color:white;" class="btn bg-primary border-0 d-flex gap-2 px-3" onclick="SelectPackage('{{ $pkg->id }}')">
                                                                        <!-- <i class="material-icons-outlined">shopping_cart</i> -->
                                                                        Select Package
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="primarycontact" role="tabpanel">
                                            <div class="row g-3">
                                                <div class="row row-cols-1 row-cols-lg-3 g-4">
                                                    @foreach($package as $pkg)
                                                    @if($pkg->type == 'pt')
                                                    <div class="col-12 col-lg-4">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <h5 class="card-title mb-3">{{ $pkg->name }}</h5>
                                                                <p class="card-text">{{ $pkg->description }}</p>
                                                                <h5>Price: Rp.{{ $pkg->price }}</h5>
                                                                <div class="mt-3 d-flex align-items-center justify-content-between">
                                                                    <button style="color:white;" class="btn btn-primary border-0 d-flex gap-2 px-3" onclick="SelectPackage('{{ $pkg->id }}')">
                                                                        <!-- <i class="material-icons-outlined">shopping_cart</i> -->
                                                                        Select Package
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @endforeach

                                                </div>
                                            </div>
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
