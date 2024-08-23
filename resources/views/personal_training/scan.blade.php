@extends('personal_training.layouts.app')
@section('title')
    Scan
@endsection
@section('css')

<style>
    .qr-reader {
        width: 100%;
        /* height: 100vh; */
        /* Full viewport height */
    }

    #my-qr-reader {
        width: 100%;
        max-width: 100%;
        height: auto;
        overflow: hidden;
    }

    .qr-reader video {
        width: 100%;
        height: auto;
        object-fit: cover;
        /* transform: scaleX(-1); */
    }

    .btn {
        margin-top: 10px;
    }
</style>

@endsection
@section('content')
<h3><b>Scanner</b></h3>
<div id="personalTrainers" data-personal-trainers="{{ $personal_trainers }}"></div>
<div class="row row-cols-1 justify-content-center ">
    <div class="col-12 col-md-6">
        <div class="card rounded-4">
            <div class="row g-0 align-items-center">
                <div class="col-md-12">
                    <div class="card-body">
                        <div id="my-qr-reader" class="qr-reader"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!--end row-->

<!-- Modal -->
<form action="" method="post">
    @csrf
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn_close">Close</button>
                    <button type="subkmit" class="btn btn-primary" id="btn_simpan">Ok</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@push('script')
<!--plugins-->
<script src="{{ URL::asset('build/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ URL::asset('build/plugins/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ URL::asset('build/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('build/js/main.js') }}"></script>
<script src="{{ URL::asset('build/plugins/html5-qrcode.min.js') }}"></script>
<script>
    // Mengambil data JSON dari tag HTML
    var personalTrainersJson = document.getElementById('personalTrainers').getAttribute('data-personal-trainers');

    // Mengonversi data JSON menjadi objek JavaScript
    var personalTrainers = JSON.parse(personalTrainersJson);

    function domReady(fn) {
        if (
            document.readyState === "complete" ||
            document.readyState === "interactive"
        ) {
            setTimeout(fn, 1000);
        } else {
            document.addEventListener("DOMContentLoaded", fn);
        }
    }

    domReady(function() {
        let htmlscanner = new Html5QrcodeScanner(
            "my-qr-reader", {
                fps: 10,
                qrbox: {
                    width: window.innerWidth * 0.8, // 80% dari lebar layar
                    height: window.innerHeight * 0.8 // 80% dari tinggi layar
                }
            }
        );

        // If found your QR code
        function onScanSuccess(decodeText, decodeResult) {
            $('#html5-qrcode-button-camera-stop').click();
            $('#exampleModal').modal('show');
            var formData = {
                qr_code: decodeResult.decodedText,
                _token: '{{ csrf_token() }}' // Ensure you include the CSRF token
            };
            $('.modal-body').html('Loading ...')
            $('#btn_simpan').hide();
            $('#btn_close').hide();

            $.ajax({
                url: `{{ route('pt_scan_ajax_post_attendance')}}`, // The route to your controller
                type: 'POST',
                data: formData,
                success: function(response) {

                    if (response.status == true) {

                        let data = response.absen.end_time;
                        let greating = data ? 'Terimakasih' : 'Selamat Datang';
                        let nilai_end_time = data ? data : '-';
                        let pt_disabled = '';
                        let option = `<option value=''>--select--</option>`
                        personalTrainers.forEach(e => {
                            if (e.id == response.absen.personal_trainer_id) {
                                option += `<option value='${e.id}' selected>${e.name}</option>`
                            } else {
                                option += `<option value='${e.id}'>${e.name}</option>`
                            }
                        });
                        if (response.absen.member.available_personal_trainer_quota < 1 || nilai_end_time != '-') {
                            pt_disabled = 'disabled';
                        }

                        let html = `
                                <h3>${greating}</h3>
                                <input type="hidden" class="form-control" name="id"  value="${response.absen.id}">
                              `


                        if (response.absen.is_using_pt != 1) {
                            html += `<div class="mb-3">
                                    <label for="name" class="form-label">Member</label>
                                    <input type="text" class="form-control" id="name" name="name" disabled value="${response.absen.member.name}">
                                </div>`
                        } else {
                            let member = response.user.map(e => e.name).join(', ');
                            html += `<div class="mb-3">
                                   <label for="exampleFormControlTextarea1">Member</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" disabled rows="3">${member}</textarea>
                                </div>`
                        }
                        html += `<div class="mb-3">
                                    <label for="name" class="form-label">Date</label>
                                    <input type="text" class="form-control" id="name" name="name" disabled value="${response.absen.date}">
                                </div>
                                <div class="mb-3">
                                    <label for="start_time" class="form-label">Start Time</label>
                                    <input type="text" class="form-control" id="start_time" name="start_time" disabled value="${response.absen.start_time}">
                                </div>
                                <div class="mb-3">
                                    <label for="start_time" class="form-label">End Time</label>
                                    <input type="text" class="form-control" id="start_time" name="start_time" disabled value="${nilai_end_time}">
                                </div>
                                <div class="mb-3">
                                    <label for="start_time" class="form-label">Available PT</label>
                                    <input type="text" class="form-control" id="start_time" name="start_time" disabled value="${response.absen.member.available_personal_trainer_quota}">
                                </div>`
                        if (response.absen.is_using_pt == 1) {
                            html += `<div class="mb-3">
                                    <label for="start_time" class="form-label">PT</label>
                                    <select class="form-select" aria-label="Default select example" name="pt" ${pt_disabled} required>
                                        ${option}
                                    </select>
                                </div>
                        `
                        }

                        $('.modal-body').html(html)
                        $('#btn_simpan').show();
                    } else {
                        $('.modal-body').html(response.message)
                        $('#btn_close').show();
                    }
                },
                error: function(xhr, status, error) {
                    $('.modal-body').html('Gagal Memproses Data')
                    $('#btn_close').show();
                }
            });
        }

        // Render the QR code scanner
        htmlscanner.render(onScanSuccess);

        function mirrorCamera() {
            const intervalId = setInterval(() => {
                const videoElement = document.querySelector('.qr-reader video');
                if (videoElement) {
                    $('#html5-qrcode-button-camera-start').addClass('btn  btn-success');
                    $('#html5-qrcode-button-camera-stop').addClass('btn  btn-danger');
                    // videoElement.style.transform = 'scaleX(-1)';
                    clearInterval(intervalId);
                }
            }, 100);
        }
        mirrorCamera();

        $('#btn_close').click(function() {
            $('#html5-qrcode-button-camera-start').click();
            mirrorCamera();
        });
        $('#my-qr-reader').on('click', function(event) {
            if ($(event.target).is('#html5-qrcode-button-camera-start')) {
                mirrorCamera();
            }
        });
    });
</script>
@endpush
@section('javascript')

@endsection