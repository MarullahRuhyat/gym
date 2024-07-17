@extends('member.layouts.app')
@section('title')
starter Page
@endsection
@section('content')
<!--start stepper one-->
<h6 class="text-uppercase">Non Linear</h6>
<hr>
<div id="stepper1" class="bs-stepper">
    <div class="card">
        <div class="card-header">
            <div class="d-lg-flex flex-lg-row align-items-lg-center justify-content-lg-between" role="tablist">
                <div class="step" data-target="#test-l-1">
                    <div class="step-trigger" role="tab" id="stepper1trigger1" aria-controls="test-l-1">
                        <div class="bs-stepper-circle">1</div>
                        <div class="">
                            <h5 class="mb-0 steper-title">Package Member</h5>
                            <p class="mb-0 steper-sub-title">Select your package membership</p>
                        </div>
                    </div>
                </div>
                <div class="bs-stepper-line"></div>
                <div class="step" data-target="#test-l-2">
                    <div class="step-trigger" role="tab" id="stepper1trigger2" aria-controls="test-l-2">
                        <div class="bs-stepper-circle">2</div>
                        <div class="">
                            <h5 class="mb-0 steper-title">Details Package</h5>
                            <p class="mb-0 steper-sub-title">This is details package</p>
                        </div>
                    </div>
                </div>
                <div class="bs-stepper-line"></div>
                <div class="step" data-target="#test-l-3">
                    <div class="step-trigger" role="tab" id="stepper1trigger2" aria-controls="test-l-3">
                        <div class="bs-stepper-circle">3</div>
                        <div class="">
                            <h5 class="mb-0 steper-title">Account Details</h5>
                            <p class="mb-0 steper-sub-title">Register your account</p>
                        </div>
                    </div>
                </div>
                <div class="bs-stepper-line"></div>
                <div class="step" data-target="#test-l-4">
                    <div class="step-trigger" role="tab" id="stepper1trigger4" aria-controls="test-l-4">
                        <div class="bs-stepper-circle">4</div>
                        <div class="">
                            <h5 class="mb-0 steper-title">Payment</h5>
                            <p class="mb-0 steper-sub-title">Payment Details</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="bs-stepper-content">
                <form onSubmit="return false">
                    <div id="test-l-1" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger1">
                        <div class="col">
                            <hr>
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
                                                                <h5>Price: ${{ $pkg->price }}</h5>
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
                        </div>

                    </div>
                    <div id="test-l-2" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger2">
                        <h5 class="mb-1">Package Details</h5>
                        <p class="mb-4">This is details package</p>
                        <div class="row g-3">
                            <div class="col">
                                <div class="card">
                                    <div class="row g-0">
                                        <div class="col-md-4 border-end">
                                            <div class="p-3">
                                                <img src="{{ URL::asset('build/images/02.png') }}" class="w-100 rounded h-100" alt="...">
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <input type="hidden" name="package_id" id="package_id" value="">
                                                <h5 name="stepper2_package_name" id="stepper2_package_name" class="card-title mb-3" value="package_name"></h5>
                                                <p name="stepper2_package_description" id="stepper2_package_description" class="card-text" value="package_description"></p>
                                                <h5>Price : $149</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center gap-3">
                                    <button class="btn btn-grey px-4" onclick="stepper1.previous()"><i class='bx bx-left-arrow-alt me-2'></i>Previous</button>
                                    <button class="btn btn-primary px-4" onclick="stepper1.next()">Next<i class='bx bx-right-arrow-alt ms-2'></i></button>
                                    <!-- <button class="btn btn-grd-primary px-4" onclick="Stepper3Account()">Next<i class='bx bx-right-arrow-alt ms-2'></i></button> -->
                                </div>
                            </div>
                        </div>
                        <!---end row-->
                    </div>
                    <div id="test-l-3" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger3">
                        <h5 class="mb-1">Account Details</h5>
                        <p class="mb-4">Enter Your Account Details.</p>
                        <div class="row g-3">
                            <div class="col">
                                <div class="card">
                                    <div class="card-body p-4">
                                        <form class="row g-3 needs-validation" novalidate>
                                            <input type="hidden" name="stepper3_package_id" id="stepper3_package_id" value="" disabled>
                                            <div class="col-md-6">
                                                <label for="bsValidation1" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="bsValidation1" placeholder="First Name" value="Jhon" required>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="bsValidation2" class="form-label">Phone Number</label>
                                                <input type="text" class="form-control" id="bsValidation2" placeholder="Phone" required>
                                                <div class="invalid-feedback">
                                                    Please choose a username.
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="d-flex align-items-center gap-3">
                                                    <label for="bsValidation3" class="form-label">Gender</label>
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" id="bsValidation3" name="radio-stacked" required>
                                                        <label class="form-check-label" for="bsValidation6">Male</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" id="bsValidation3" name="radio-stacked" required>
                                                        <label class="form-check-label" for="bsValidation7">Female</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="bsValidation4" class="form-label">Address</label>
                                                <textarea class="form-control" id="bsValidation4" placeholder="Address ..." rows="3" required></textarea>
                                                <div class="invalid-feedback">
                                                    Please enter a valid address.
                                                </div>
                                            </div>
                                            <!-- insert start date  -->
                                             <div class="col-md-12">
                                                <label for="bsValidation5" class="form-label">Start Date</label>
                                                <input type="date" class="form-control" id="bsValidation5" placeholder="Start Date" required>
                                                <div class="invalid-feedback">
                                                    Please fill your start date.
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="bsValidation6" class="form-label">Password</label>
                                                <input type="password" class="form-control" id="bsValidation6" placeholder="Password" required>
                                                <div class="invalid-feedback">
                                                    Please fill your password.
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="bsValidation7" class="form-label">Confirm Password</label>
                                                <input type="password" class="form-control" id="bsValidation7" placeholder="Confirm Password" required>
                                                <div class="invalid-feedback">
                                                    Please confirm your password.
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="bsValidation7" required>
                                                    <label class="form-check-label" for="bsValidation7">Agree to terms and conditions</label>
                                                    <div class="invalid-feedback">
                                                        You must agree before submitting.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="d-md-flex d-grid align-items-center gap-3">
                                                    <button class="btn btn-grey px-4" onclick="stepper1.previous()"><i class='bx bx-left-arrow-alt me-2'></i>Previous</button>
                                                    <button id="register_submit" type="submit" class="btn btn-primary px-4">Submit</button>
                                                    <!-- <button type="reset" class="btn btn-grd-info px-4">Reset</button> -->
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-12">
                        <div class="d-flex align-items-center gap-3">
                           <button class="btn btn-grd-info px-4" onclick="stepper1.previous()"><i class='bx bx-left-arrow-alt me-2'></i>Previous</button>
                           <button class="btn btn-grd-primary px-4" onclick="stepper1.next()">Next<i class='bx bx-right-arrow-alt ms-2'></i></button>
                        </div>
                     </div> -->
                        </div>
                        <!---end row-->
                    </div>
                    <div id="test-l-4" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger4">
                        <h5 class="mb-1">Payment</h5>
                        <p class="mb-4">Payment Details</p>
                        <div class="row g-3">
                            <form action="{{ route('member.payment') }}" method="GET">
                                @csrf
                                <input type="hidden" name="submit_user_id" id="submit_user_id" value="">
                                <input type="hidden" name="submit_package_id" id="submit_package_id" value="">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title mb-4 fw-bold">Summary</h4>
                                            <div>
                                                <div class="d-flex justify-content-between">
                                                    <p class="fw-semi-bold">Items subtotal :</p>
                                                    <p id="payment-item-total" class="fw-semi-bold">$891</p>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <p class="fw-semi-bold">Discount :</p>
                                                    <p id="payment-discount" class="text-danger fw-semi-bold">-$48</p>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <p class="fw-semi-bold">Tax :</p>
                                                    <p id="payment-tax" class="fw-semi-bold">$156.70</p>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between border-top pt-4">
                                                <h5 class="mb-0 fw-bold">Total :</h5>
                                                <h5 id="payment-total" class="mb-0 fw-bold">$925.44</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex align-items-center gap-3">
                                        <button class="btn btn-grey px-4" onclick="stepper1.previous()"><i class='bx bx-left-arrow-alt me-2'></i>Previous</button>
                                        <!-- <a type="submit" class="btn btn-grd-primary px-4">Pay<i class='bx bx-right-arrow-alt ms-2'></i></a> -->
                                        <button type="submit" class="btn btn-primary px-4">Pay<i class='bx bx-right-arrow-alt ms-2'></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!---end row-->
                    </div>
            </div>
        </div>
    </div>
</div>
<!--end stepper one-->
@endsection
@push('script')
<script>
    function SelectPackage(packageId) {
        var package_id = packageId;
        $.ajax({
            type: 'POST',
            url: "{{ route('member.register.process') }}",
            data: {
                package_id: package_id,
                _token: "{{ csrf_token() }}"
            },
            success: function(data) {
                if (data.status == true) {
                    stepper1.next();
                    Stepper2DetailsPackage(data.data);
                }
            }
        });
    }

    function Stepper2DetailsPackage(data) {
        var package_id = data.package[0].id;
        var package_name = data.package[0].name;
        var package_description = data.package[0].description;
        console.log('oke');
        console.log(package_name);
        $('#package_id').val(package_id);
        $('#stepper2_package_name').text(package_name);
        $('#stepper2_package_description').val(package_description);
        $('#stepper3_package_id').val(package_id);
    }

    $(document).ready(function() {
        $('#register_submit').click(function() {
            var package_id = $('#stepper3_package_id').val();
            var name = $('#bsValidation1').val();
            var phone_number = $('#bsValidation2').val();
            var sex = $('#bsValidation3').val();
            var address = $('#bsValidation4').val();
            var start_date = $('#bsValidation5').val();
            var password = $('#bsValidation6').val();
            var password_confirmation = $('#bsValidation7').val();
            var bsValidation7 = $('#bsValidation8').prop('checked');

            if (bsValidation7 == false) {
                alert('Please agree to terms and conditions');
                return false;
            }

            $.ajax({
                type: 'POST',
                url: "{{ route('member.register.submit') }}",
                data: {
                    package_id: package_id,
                    name: name,
                    phone_number: phone_number,
                    sex: sex,
                    address: address,
                    start_date: start_date,
                    password: password,
                    password_confirmation: password_confirmation,
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    if (data.status == true) {
                        stepper1.next();
                        $('#submit_user_id').val(data.data.user.id);
                        $('#submit_package_id').val(data.data.gym_membership_packages_id);
                    } else {
                        alert(data.message);
                    }
                },
            });
        });
    });
</script>
<!--bootstrap js-->
<script src="{{ URL::asset('build/js/bootstrap.bundle.min.js') }}"></script>
<!--plugins-->
<script src="{{ URL::asset('build/js/jquery.min.js') }}"></script>
<!--plugins-->
<script src="{{ URL::asset('build/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ URL::asset('build/plugins/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ URL::asset('build/plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
<script src="{{ URL::asset('build/plugins/bs-stepper/js/main.js') }}"></script>
<script src="{{ URL::asset('build/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('build/js/main.js') }}"></script>
@endpush