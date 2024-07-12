@extends('admin.layouts.app')
@section('title')
starter Page
@endsection
@section('css')

<style>
    .qr-reader {
        width: 100%;
        height: 100vh;
        /* Full viewport height */
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
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn_close">Close</button>
                <button type="button" class="btn btn-primary" id="btn_simpan">ok</button>
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
@section('javascript')
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    // Mengambil data JSON dari tag HTML
    var personalTrainersJson = document.getElementById('personalTrainers').getAttribute('data-personal-trainers');

    // Mengonversi data JSON menjadi objek JavaScript
    var personalTrainers = JSON.parse(personalTrainersJson);
    console.log(personalTrainers);

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
                    width: window.innerWidth * 0.8,
                    height: window.innerHeight * 1
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
                url: `{{ route('admin_ajax_post_attendance')}}`, // The route to your controller
                type: 'POST',
                data: formData,
                success: function(response) {
                    console.log('aaa', response);
                    if (response.status == true) {

                        let data = response.absen.end_time;
                        let h3 = data ? 'Terimakasih' : 'Selamat Datang';
                        let nilai_end_time = data ? data : '-';


                        let html = `
                                <h3>${h3}</h3>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" readonly value="${response.absen.member.name}">
                                </div>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Date</label>
                                    <input type="text" class="form-control" id="name" name="name" readonly value="${response.absen.date}">
                                </div>
                                <div class="mb-3">
                                    <label for="start_time" class="form-label">Start Time</label>
                                    <input type="text" class="form-control" id="start_time" name="start_time" readonly value="${response.absen.start_time}">
                                </div>
                                <div class="mb-3">
                                    <label for="start_time" class="form-label">End Time</label>
                                    <input type="text" class="form-control" id="start_time" name="start_time" readonly value="${nilai_end_time}">
                                </div>
                                <div class="mb-3">
                                    <label for="start_time" class="form-label">Available PT</label>
                                    <input type="text" class="form-control" id="start_time" name="start_time" readonly value="${response.absen.member.available_personal_trainer_quota}">
                                </div>
                        `
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
                    videoElement.style.transform = 'scaleX(-1)';
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
@endsection