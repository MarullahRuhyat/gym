@extends('member.layouts.guest')
@section('title')
starter Page
@endsection
@section('content')
<!--start main wrapper-->
<div class="main-content">
    <div class="row">
        <div class="col-xl-6 mx-auto">
            <div class="card">
                <div class="card-header px-4 py-3">
                    <h5 class="mb-1">Account Details</h5>
                    <p class="mb-4">Enter Your Account Details.</p>
                </div>
                <div class="card-body p-4">
                    <form class="row g-3 needs-validation" novalidate action="{{ route('member.register-form.process') }}" method="POST">
                        @csrf
                        <div class="col-md-12">
                            <label for="bsValidation1" class="form-label">Name</label>
                            <input type="text" class="form-control" id="bsValidation1" name="name" placeholder="Name" required>
                            <div class="valid-feedback">
                                Looks good!
                                </div>
                        </div>
                        <div class="col-md-12">
                            <label for="bsValidation2" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="bsValidation2" placeholder="Phone Number" name="phone_number" required>
                            <div class="invalid-feedback">
                                Please fill a phone number.
                                </div>
                        </div>
                        <div class="col-md-12">
                            <label for="bsValidation3" class="form-label">Gender</label>
                            <select class="form-select" id="bsValidation3" name="gender" required>
                                <option selected disabled value="">Choose...</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a valid gender.
                                </div>
                        </div>
                        <div class="col-md-12">
                            <label for="bsValidation4" class="form-label">Address</label>
                            <input type="text" class="form-control" id="bsValidation4" name="address" placeholder="Address" required>
                            <div class="invalid-feedback">
                                Please fill address.
                                </div>
                        </div>
                        <div class="col-md-12">
                            <label for="bsValidation5" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="bsValidation5" name="start_date" required>
                            <div class="invalid-feedback">
                                Please fill your start date.
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="bsValidation6" class="form-label">Password</label>
                            <input type="password" class="form-control" id="bsValidation6" name="password" required>
                            <div class="invalid-feedback">
                                Please fill your password.
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="bsValidation7_${formCount}" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="bsValidation7" name="password_confirmation" required>
                            <div class="invalid-feedback">
                                Confirmation password is required and must be same as password.
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="bsValidation14" required>
                                <label class="form-check-label" for="bsValidation14">Agree to terms and conditions</label>
                                <div class="invalid-feedback">
                                    You must agree before submitting.
                                    </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-md-flex d-grid align-items-center gap-3">
                                <button type="submit" class="btn btn-primary px-4">Submit</button>
                                <button type="reset" class="btn btn-outline-secondary px-4">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end row-->
</div>
@endsection
@push('script')
<!-- validate  -->
<script src="{{ URL::asset('build/plugins/validation/jquery.validate.min.js') }}"></script>
<script src="{{ URL::asset('build/plugins/validation/validation-script.js') }}"></script>
<script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }

            form.classList.add('was-validated')
            }, false)
        })
    })()

    // check password and confirm password
    $(document).ready(function() {
        $('#bsValidation6').keyup(function() {
            var password = $('#bsValidation6').val();
            var confirmPassword = $('#bsValidation7').val();
            if (password != confirmPassword) {
                $('#bsValidation7').addClass('is-invalid');
                $('#bsValidation7').removeClass('is-valid');
            } else {
                $('#bsValidation7').addClass('is-valid');
                $('#bsValidation7').removeClass('is-invalid ');
            }
        });

        $('#bsValidation7').keyup(function() {
            var password = $('#bsValidation6').val();
            var confirmPassword = $('#bsValidation7').val();
            if (password != confirmPassword) {
                $('#bsValidation7').addClass('is-invalid');
                $('#bsValidation7').removeClass('is-valid');
            } else {
                $('#bsValidation7').addClass('is-valid');
                $('#bsValidation7').removeClass('is-invalid');
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
