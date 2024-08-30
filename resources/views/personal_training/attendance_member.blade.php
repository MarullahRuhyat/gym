@extends('personal_training.layouts.app')
@section('title')
Absensi Member
@endsection
@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">
@endpush
@section('content')
<style>
    .card-body {
        position: relative;
    }

    .test {
        position: absolute;
        top: 10px;
        right: 10px;
        display: none;
    }

    .card:hover .test {
        display: block;
    }

</style>
<h6 class="mb-0 text-uppercase">Absensi
    @if (request()->searchDate == null)
    {{ date('d F Y') }}
    @else
    {{ date('d F Y', strtotime(request()->searchDate)) }}
    @endif
</h6>

<div class="d-flex flex-column flex-md-row justify-content-end align-items-center mb-2 mt-3">
    <form id="searchForm" class="form-inline d-flex flex-column flex-md-row w-100 mb-2 mb-md-0 me-md-1">
        <div class="input-group mb-2 mb-md-0 w-100 me-md-1">
            <input type="text" class="form-control" id="searchName" name="searchName" placeholder="Enter Member Name">
        </div>
        <div class="input-group mb-2 mb-md-0 w-100 me-md-1">
            <input type="date" class="form-control" id="searchDate" name="searchDate" placeholder="Masukkan Tanggal">
        </div>
        <button type="submit" class="btn btn-primary">Cari</button>
    </form>
    <button type="button" class="btn btn-success w-100 w-md-auto ms-md-1">Export</button>
</div>
<hr>

<div class="row" id="memberContainer">
    @foreach ($data_member as $item)
    <div class="col-md-6">
        <div class="card rounded-4">
            <div class="card-header">
                <h3>{{ $item->name }}</h3>
                <div class="test">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="dropdown">
                        <i class="bi bi-three-dots-vertical"></i>
                        <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                        <button type="button" class="btn dropdown-item" data-bs-toggle="modal" data-id="{{ $item->id }}"
                            data-bs-target="#addJenisLatihanModal">Pilih Jenis Latihan</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column gap-3 me-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <h6 class="mb-0">Nomor Whatsapp</h6>
                        </div>
                        <div class="">
                            <h5 class="mb-0">{{ $item->phone_number }}</h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <h6 class="mb-0">Jenis Latihan</h6>
                        </div>
                        <div class="">
                            <h5 class="mb-0">
                                @if ($item->jenis_latihan == null)
                                <button type="button" class="badge bg-danger" style="border: none"
                                    data-id="{{ $item->id }}" data-bs-toggle="modal"
                                    data-bs-target="#addJenisLatihanModal">Belum Memilih</button>
                                @elseif (count(explode(',', $item->jenis_latihan)) > 2)
                                <button type="button" class="badge bg-success open-multiple-jenis-latihan"
                                    style="border: none" data-id="{{ $item->id }}" data data-bs-toggle="modal"
                                    data-namaMember="{{$item->name}}" data-jenisLatihan="{{$item->jenis_latihan}}"
                                    data-bs-target="#openMultipleJenisLatihan">Multiple</button>
                                @else
                                {{ $item->jenis_latihan }}
                                @endif
                            </h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <h6 class="mb-0">Absen Masuk</h6>
                        </div>
                        <div class="">
                            <h5 class="mb-0">
                                @if ($item->start_time == null)
                                <span class="badge bg-danger">Belum Masuk</span>
                                @else
                                @php
                                $start_time_parts = explode('-', $item->start_time);
                                $formatted_start_time = $start_time_parts[0] . ':' . $start_time_parts[1] . ':' .
                                $start_time_parts[2];
                                @endphp
                                {{ $formatted_start_time }}
                                @endif
                            </h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <h6 class="mb-0">Absen Pulang</h6>
                        </div>
                        <div class="">
                            <h5 class="mb-0">
                                @if ($item->end_time == null)
                                <span class="badge bg-danger">Belum Pulang</span>
                                @else
                                @php
                                $end_time_parts = explode('-', $item->end_time);
                                $formatted_end_time = $end_time_parts[0] . ':' . $end_time_parts[1] . ':' .
                                $end_time_parts[2];
                                @endphp
                                {{ $formatted_end_time }}
                                @endif
                            </h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <h6 class="mb-0">Status</h6>
                        </div>
                        <div class="disabled">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="ada" checked disabled>
                                <label class="form-check-label" for="ada"><b> Active</b></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Modal -->
<div class="modal fade" id="addJenisLatihanModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom-0 py-2">
                <h5 class="modal-title">Tambah Jenis Latihan</h5>
                <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="modal">
                    <i class="material-icons-outlined">close</i>
                </a>
            </div>
            <form id="updateJenisLatihanForm" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="multiple-select-field" class="form-label">Jenis Latihan</label>
                        <select class="form-select" id="multiple-select-field" name="jenis_latihan[]"
                            data-placeholder="Pilih Jenis Latihan" multiple>
                            <option value="">Pilih Jenis Latihan</option>
                            @foreach ($dataLatihan as $item)
                            <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="openMultipleJenisLatihan">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom-0 py-2">
                <h5 class="modal-title">Jenis Latihan</h5>
                <a href="javascript:;" class="primary-menu-close" data-bs-dismiss="modal">
                    <i class="material-icons-outlined">close</i>
                </a>
            </div>
            <div class="modal-body" id="modal-body-content">
                {{-- The content will be dynamically filled by JavaScript --}}
            </div>
            <div class="modal-footer border-top-0">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



@endsection
@push('script')
<script src="{{ URL::asset('build/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ URL::asset('build/plugins/metismenu/metisMenu.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ URL::asset('build/plugins/select2/js/select2-custom.js') }}"></script>
<script src="{{ URL::asset('build/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('build/js/main.js') }}"></script>
<script>
    $('#memberContainer').on('click', '.open-multiple-jenis-latihan', function () {
        const memberId = $(this).data('id');
        const jenisLatihan = $(this).data('jenislatihan');
        const dataMember = @json($data_member); // Pass your data from PHP to JavaScript
        const selectedMember = $(this).data('namamember');
        const modalBodyContent = document.getElementById('modal-body-content');
        modalBodyContent.innerHTML = ''; // Clear previous content


        if (jenisLatihan) {
            const jenisLatihanArray = jenisLatihan.split(',');

            if (jenisLatihanArray.length > 2) {
                const nameElement = document.createElement('h6');
                nameElement.textContent = selectedMember;
                modalBodyContent.appendChild(nameElement);

                const ulElement = document.createElement('ul');
                jenisLatihanArray.forEach(jenisLatihan => {
                    const liElement = document.createElement('li');
                    liElement.textContent = jenisLatihan;
                    ulElement.appendChild(liElement);
                });
                modalBodyContent.appendChild(ulElement);
            }
        } else {
            console.error('jenisLatihan is undefined');
        }
    });


    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('addJenisLatihanModal');
        modal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const form = document.getElementById('updateJenisLatihanForm');
            form.setAttribute('action', `/personal-trainer/attendance-member/${id}`);
        });
    });

    document.getElementById('searchForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const searchName = document.getElementById('searchName').value;
        const searchDate = document.getElementById('searchDate').value;

        fetch(`{{ route('personal_trainer.search') }}?searchName=${searchName}&searchDate=${searchDate}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('memberContainer');
                if (container) {
                    container.innerHTML = '';
                    data.forEach(item => {
                        const memberCard = `
                            <div class="col-md-6">
                                <div class="card rounded-4">
                                    <div class="card-header">
                                        <h3>${item.name}</h3>
                                        <div class="test">
                                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots-vertical"></i>
                                                <span class="visually-hidden">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                                                <button type="button" class="btn dropdown-item" data-bs-toggle="modal" data-id="${item.id}"
                                                    data-bs-target="#addJenisLatihanModal">Pilih Jenis Latihan</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex flex-column gap-3 me-3">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0">Nomor Whatsapp</h6>
                                                </div>
                                                <div class="">
                                                    <h5 class="mb-0">${item.phone_number}</h5>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0">Jenis Latihan</h6>
                                                </div>
                                                <div class="">
                                                    <h5 class="mb-0">
                                                        ${item.jenis_latihan == null ? `
                                                        <button type="button" class="badge bg-danger" style="border: none"
                                                            data-id="${item.id}" data-bs-toggle="modal"
                                                            data-bs-target="#addJenisLatihanModal">Belum Memilih</button>
                                                        ` : item.jenis_latihan.split(',').length > 2 ? `
                                                        <button type="button" class="badge bg-success open-multiple-jenis-latihan" style="border: none"
                                                                    data-id="${item.id}" data-jenisLatihan="${item.jenis_latihan}" data-namaMember="${item.name}" data-bs-toggle="modal"
                                                                    data-bs-target="#openMultipleJenisLatihan">Multiple</button>
                                                        ` : item.jenis_latihan}
                                                    </h5>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0">Absen Masuk</h6>
                                                </div>
                                                <div class="">
                                                    <h5 class="mb-0">
                                                        ${item.start_time === null ? '<span class="badge bg-danger">Belum Masuk</span>' : item.start_time.split('-').join(':')}
                                                    </h5>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0">Absen Pulang</h6>
                                                </div>
                                                <div class="">
                                                    <h5 class="mb-0">
                                                        ${item.end_time === null ? '<span class="badge bg-danger">Belum Pulang</span>' : item.end_time.split('-').join(':')}
                                                    </h5>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0">Status</h6>
                                                </div>
                                                <div class="disabled">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" id="ada" checked disabled>
                                                        <label class="form-check-label" for="ada"><b> Active</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        container.innerHTML += memberCard;
                    });
                }
            })
            .catch(error => console.error('Error:', error));
    });

</script>


@endpush
