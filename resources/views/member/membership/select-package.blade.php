@extends('member.layouts.app')
@section('title')
starter Page
@endsection
@section('content')
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
                                        @foreach($groupedPackages as $typeName => $packages)
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link @if($loop->first) active @endif" data-bs-toggle="tab"
                                                href="#tab{{ $loop->index }}" role="tab"
                                                aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                                <div class="d-flex align-items-center">
                                                    <div class="tab-icon"><i class="bi bi-person me-1 fs-6"></i></div>
                                                    <div class="tab-title">{{ $typeName }}</div>
                                                </div>
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content py-3">
                                        @foreach($groupedPackages as $typeName => $packages)
                                        <div class="tab-pane fade @if($loop->first) show active @endif"
                                            id="tab{{ $loop->index }}" role="tabpanel">
                                            <div class="row g-3">
                                                <div class="row row-cols-1 row-cols-lg-3 g-4">
                                                    @foreach($packages as $pkg)
                                                    <div class="col-12 col-lg-4">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <h5 class="card-title mb-3">{{ $pkg->name }}</h5>
                                                                <p class="card-text">{{ $pkg->description }}</p>
                                                                <p class="card-text">Duration:
                                                                    {{ $pkg->duration_in_days }} Days</p>
                                                                    <h5>Price:
                                                                        Rp.{{ number_format($pkg->price, 0, ',', '.') }}
                                                                    </h5>
                                                                <div
                                                                    class="mt-3 d-flex align-items-center justify-content-between">
                                                                    <button style="color:white;"
                                                                        class="btn bg-primary border-0 d-flex gap-2 px-3"
                                                                        onclick="SelectPackage('{{ $pkg->id }}')">
                                                                        Select Package
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
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
                                                <img src="{{ URL::asset('build/images/02.png') }}"
                                                    class="w-100 rounded h-100" alt="...">
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <input type="hidden" name="package_id" id="package_id" value="">
                                                <h5 name="stepper2_package_name" id="stepper2_package_name"
                                                    class="card-title mb-3" value="package_name"></h5>
                                                <p name="stepper2_package_description" id="stepper2_package_description"
                                                    class="card-text" value="package_description"></p>
                                                <h5 name="stepper2_package_price"></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center gap-3">
                                    <button class="btn btn-outline-secondary px-4" onclick="stepper1.previous()"><i
                                            class='bx bx-left-arrow-alt me-2'></i>Previous</button>
                                    <button style="color:white;" class="btn bg-primary border-0 d-flex gap-2 px-3"
                                        onclick="SetStartDate('{{ $pkg->id }}')">Next<i
                                            class='bx bx-right-arrow-alt ms-2'></i></button>
                                    <!-- <button class="btn btn-primary px-4" onclick="stepper1.next()">Next<i class='bx bx-right-arrow-alt ms-2'></i></button> -->
                                    <!-- <button class="btn btn-grd-primary px-4" onclick="Stepper3Account()">Next<i class='bx bx-right-arrow-alt ms-2'></i></button> -->
                                </div>
                            </div>
                        </div>
                        <!---end row-->
                    </div>
                    <div id="test-l-3" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger3">
                        <div class="row g-3" style="margin:auto; padding:10px;">
                            <div class="col-md-10">
                                <h5 class="mb-1">Account Details</h5>
                                <p class="mb-4">Enter Your Account Details.</p>
                            </div>
                            <div class="col-md-2" style="align-items: end; justify-content: end;">
                                <input type="hidden" name="package_jumlah_member" id="package_jumlah_member" value=""
                                    disabled>
                                <a id="addForm" class="btn btn-secondary">
                                    <i class="bx bx-plus-circle"></i>
                                    <span>Tambah Anggota</span>
                                </a>
                            </div>
                        </div>
                        <!-- disini  -->
                        <div id="form-container">
                            <!-- <h3>Anggota 1</h3> -->
                            <form id="form-first" class="row g-3 needs-validation" novalidate
                            id="form1">
                            <input type="hidden" class="form-control"
                            placeholder="Phone Number" id="bsValidation2" name="phone_number" value="{{ Auth::user()->phone_number }}">
                            </form>
                            <div id="dynamic-form-id">
                                <!-- form wil added here  -->
                            </div>
                        </div>
                        <!-- end  -->

                        <!-- button  -->
                        <div id="agree-term">
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="agreeTerms" required>
                                    <label class="form-check-label" for="agreeTerms">Agree to terms and
                                        conditions</label>
                                    <div class="invalid-feedback">
                                        You must agree before submitting.
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-12" style="margin-top:20px;">
                            <div class="d-md-flex d-grid align-items-center gap-3">
                                <button class="btn btn-outline-secondary px-4" onclick="stepper1.previous()"><i
                                        class='bx bx-left-arrow-alt me-2'></i>Previous</button>
                                <button id="submit-form" type="submit" class="btn btn-primary px-4">Submit</button>
                            </div>
                        </div>
                        <!-- end button  -->
                    </div>
                    <!---end row-->
            </div>
            <div id="test-l-4" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger4">
                <h5 class="mb-1">Payment</h5>
                <p class="mb-4">Payment Details</p>
                <div class="row g-3">
                    <form action="{{ route('member.payment') }}" method="GET">
                        @csrf
                        <input type="hidden" name="payment_phone_number" id="payment_phone_number" value="">
                        <input type="hidden" name="submit_package_id" id="submit_package_id" value="">
                        <input type="hidden" name="payment_amount" id="payment_amount" value="">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4 fw-bold">Summary</h4>
                                    <div>
                                        <div class="d-flex justify-content-between">
                                            <p class="fw-semi-bold">Items subtotal :</p>
                                            <p id="payment-item-total" class="fw-semi-bold"></p>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <p class="fw-semi-bold">Fee User Registration :</p>
                                            <p id="payment-user-registered" class="fw-semi-bold"></p>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <p class="fw-semi-bold">Discount :</p>
                                            <p id="payment-discount" class="text-danger fw-semi-bold">Rp.-</p>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <p class="fw-semi-bold">Tax :</p>
                                            <p id="payment-tax" class="fw-semi-bold">Rp.-</p>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between border-top pt-4">
                                        <h5 class="mb-0 fw-bold">Total :</h5>
                                        <h5 id="payment-total" class="mb-0 fw-bold"></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center gap-3">
                                <button class="btn btn-outline-secondary px-4" onclick="stepper1.previous()"><i
                                        class='bx bx-left-arrow-alt me-2'></i>Previous</button>
                                <!-- <a type="submit" class="btn btn-grd-primary px-4">Pay<i class='bx bx-right-arrow-alt ms-2'></i></a> -->
                                <button type="submit" class="btn btn-primary px-4">Pay<i
                                        class='bx bx-right-arrow-alt ms-2'></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                <!---end row-->
            </div>
        </div>
    </div>
</div>
<!-- </div> -->
<!--end stepper one-->


<!-- modal start input start_date  if click submit redirect to next modal -->
<div class="modal fade" id="SetStartDate">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-bottom-0 bg-primary py-2">
                <h5 class="modal-title" style="color:white">Set Start Date</h5>
                <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="modal">
                    <i class="material-icons-outlined">close</i>
                </a>
            </div>
            <div class="modal-body">
                <input type="hidden" name="pkg_id" id="pkg_id">
                <div class="col">
                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex justify-content-end mt-4">
                        <button style="color:white;" class="btn bg-primary border-0 d-flex gap-2 px-3"
                            onclick="formDataDiri()">
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="ScrollableModal">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-bottom-0 bg-primary py-2">
                <h5 class="modal-title" style="color:white">Detail Payment</h5>
                <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="modal">
                    <i class="material-icons-outlined">close</i>
                </a>
            </div>
            <div class="modal-body">
                <form action="{{ route('member.payment') }}" method="GET">
                    @csrf
                    <input type="hidden" name="submit_package_id" id="submit_package_id" value="">
                    <!-- <input type="hidden" name="submit_user_id" id="submit_user_id" value="{{ Auth::user()->id }}"> -->
                    <input type="hidden" name="payment_phone_number" id="payment_phone_number" value="{{ Auth::user()->phone_number }}">
                    <input type="hidden" name="submit_start_date" id="submit_start_date" value="">
                    <input type="hidden" name="payment_amount" id="payment_amount" value="">
                    <input type="text" name="status_user" id="status_user" value="{{ Auth::user()->status }}">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4 fw-bold">Summary</h4>
                                <div>
                                    <div class="d-flex justify-content-between">
                                        <p class="fw-semi-bold">Items subtotal :</p>
                                        <p id="payment-item-total" class="fw-semi-bold"></p>
                                    </div>
                                    @if (Auth::user()->status == 'expired' || Auth::user()->status == 'unregistered')
                                        <div class="d-flex justify-content-between">
                                            <p class="fw-semi-bold">Register Fee :</p>
                                            <p id="payment-register" class="fw-semi-bold">Rp.75.000</p>
                                        </div>
                                    @endif
                                    <div class="d-flex justify-content-between">
                                        <p class="fw-semi-bold">Discount :</p>
                                        <p id="payment-discount" class="text-danger fw-semi-bold">Rp.-</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class="fw-semi-bold">Tax :</p>
                                        <p id="payment-tax" class="fw-semi-bold">Rp.-</p>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between border-top pt-4">
                                    <h5 class="mb-0 fw-bold">Total :</h5>
                                    <h5 id="payment-total" class="mb-0 fw-bold"></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-grd-deep-blue px-4">Pay</button>
                        </div>
                    </div>
                </form>
>>>>>>> 19797f7 (merge: fix conflict)
=======
                </div>
>>>>>>> 60d681c (merge: fix conflict)
            </div>
        </div>
    </div>
</div>


@endsection
@push('script')
<script>
    function formDataDiri() {
        var start_date = $('#start_date').val();
        var pkg_id = $('#pkg_id').val();
        if (start_date == '') {
            alert('Start Date is required');
            return;
        }
        if (start_date < "{{ date('Y-m-d') }}") {
            alert('Start Date must be greater than today');
            return;
        }
        $('#submit_user_id').val(pkg_id);
        $('#submit_package_id').val(pkg_id);
        $('#SetStartDate').modal('hide');
        stepper1.next();
    }

    function SetStartDate(id) {
        $('#pkg_id').val(id);
        $('#SetStartDate').modal('show');
    }

    function SelectPackage(packageId) {
        var package_id = packageId;
        $.ajax({
            type: 'POST',
            url: "{{ route('member.get-package-detail') }}",
            data: {
                package_id: package_id,
                _token: "{{ csrf_token() }}"
            },
            success: function (data) {
                if (data.status == true) {
                    stepper1.next();
                    Stepper2DetailsPackage(data.data);
                }
            },
            // success: function(response) {
            //     // $('#payment-item-total').text('Rp.' + response.price);
            //     // format number
            //     $('#payment-item-total').text('Rp.' + response.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
            //     // $('#payment-total').text('Rp.' + response.price);
            //     // format number
            //     // if status user expired or unregistered
            //     // $('#payment-register').text('Rp.' + 75000);
            //     $('#payment-register').text('Rp.' + (75000).toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
            //     $('#payment-total').text('Rp.' + response.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
            //     // $('#payment_amount').val(response.price);
            //     if ($('#status_user').val() == 'expired' || $('#status_user').val() == 'unregistered') {
            //         $('#payment-total').text('Rp.' + (response.price + 75000).toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
            //         $('#payment_amount').val(response.price + 75000);
            //     } else {
            //         $('#payment-total').text('Rp.' + response.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
            //         $('#payment_amount').val(response.price);
            //     }
            // },
            error: function(xhr, status, error) {
                console.log(error);
            }

        });
    }

    function Stepper2DetailsPackage(data) {
        var package_id = data.package[0].id;
        var package_name = data.package[0].name;
        var package_description = data.package[0].description;
        var package_jumlah_member = data.package[0].jumlah_member;
        console.log('oke');
        console.log(data);
        console.log(package_description);
        console.log(package_jumlah_member);
        $('#package_id').val(package_id);
        $('#package_jumlah_member').val(package_jumlah_member);
        $('#stepper2_package_name').text(package_name);
        $('#stepper2_package_description').text(package_description);
        $('#stepper2_package_price').text(data.package[0].price);
        $('#stepper3_package_id').val(package_id);
    }

</script>

<!-- script dinamis add form member -->
<script>
    var formCount = 1;
    $('#addForm').on('click', function () {
        let package_jumlah_member = $('#package_jumlah_member').val();
        if (formCount < package_jumlah_member) {
            formCount++;
            $('#dynamic-form-id').append(`
                <h3>Anggota ${formCount}</h3>
                <div class="row g-3">
                    <div class="col">
                        <div class="card">
                            <div class="card-body p-4">
                                <form id="dynamic-form" class="row g-3 needs-validation" novalidate id="form${formCount}">
                                    <input type="hidden" name="stepper3_package_id" id="stepper3_package_id_${formCount}" value="" disabled>
                                    <div class="col-md-12">
                                        <label for="bsValidation2_${formCount}" class="form-label">Phone Number</label>
                                        <input type="text" class="form-control" id="bsValidation2_${formCount}" name="phone[]" placeholder="Phone" required>
                                        <div class="invalid-feedback">
                                            Please choose a username.
                                        </div>
                                    </div>
                                </form>
                            <div>
                        </div>
                    </div>
                </div>
            `);

            package_jumlah_member--;
            $('#package_jumlah_member').val(package_jumlah_member);

            // scroll to the newly adden form
            $('html, body').animate({
                scrollTop: $(`#form${formCount}`).offset().top
            }, 1000);
        } else {
            alert('You have reached the maximum number of members');
        }
    });

    $('#submit-form').on('click', function () {
        // get data from form 1
        var phone_form_first = $('#bsValidation2').val();
        var form_first = {
            phone_number: phone_form_first,
        };

        // only get data phone number from dynamic form
        var form_dynamic = [];
        var forms = document.querySelectorAll('#dynamic-form');
        forms.forEach(function (form) {
            // phone_number_dynamic.push(form.querySelector('input[name="phone[]"]').value);
            var member = {};
            member.phone_number = form.querySelector('input[name="phone[]"]').value;
            form_dynamic.push(member);
        });

        // combine all data
        var package_id = $('#package_id').val();
        var start_date = $('#start_date').val();
        var form = {
            package_id: package_id,
            start_date: start_date,
            form_first: form_first,
            form_dynamic: form_dynamic
        };

        form = JSON.stringify(form);

        console.log('form');
        console.log(form);

        // ajax header csrf token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Content-Type': 'application/json'
            }
        });

        $.ajax({
            url: "{{ route('member.submit-package') }}",
            method: 'POST',
            data: form,
            success: function (response) {
                if (response.status == true) {
                    stepper1.next();
                    // get response data user_registered
                    var payment_item_total = response.data.payment_item_total;
                    var user_registered = response.data.user_registered;
                    var total = response.data.total;
                    // $('#payment-item-total').text(payment_item_total);
                    $('#payment-item-total').text('Rp.' + payment_item_total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                    $('#payment-user-registered').text('Rp.' + user_registered.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                    $('#payment-total').text('Rp.' + total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                    $('#payment_phone_number').val(response.data.user_phone_number);
                    // $('#payment_phone_number').text('Rp.' + response.data.user_phone_number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                    $('#payment_amount').val(total);
                    // $('#payment_amount').text('Rp.' + total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                } else {
                    alert(response.message);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error saving forms');
            }
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
