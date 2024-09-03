@extends('admin.layouts.app')
@section('title')
starter Page
@endsection
@section('content')
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
                <h3>{{ $item->member_name }}</h3>
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
                                    data-id="{{ $item->id }}">Belum Memilih</button>
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
                            <h6 class="mb-0">Nama PT</h6>
                        </div>
                        <div class="">
                            <h5 class="mb-0">
                                {{ $item->trainer_name }}
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
                    {{-- <div class="d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <button class="btn btn-primary members" data-id="{{$item->id}}" data-bs-toggle="modal" data-bs-target="#membersModal">Members</button>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

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



<!-- Modal -->
<div class="modal fade" id="membersModal" tabindex="-1" aria-labelledby="membersModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="membersModalLabel">Detail Members</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal_body_membersModal">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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


<script>
    $('#memberContainer').on('click', '.open-multiple-jenis-latihan', function() {
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


    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('addJenisLatihanModal');
        modal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const form = document.getElementById('updateJenisLatihanForm');
            form.setAttribute('action', `/admin/attendance-member/${id}`);
        });
    });

    document.getElementById('searchForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const searchName = document.getElementById('searchName').value;
        const searchDate = document.getElementById('searchDate').value;

        fetch(`{{ route('admin_search') }}?searchName=${searchName}&searchDate=${searchDate}`, {
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
                                        <h3>${item.member_name}</h3>
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
                                                    <h6 class="mb-0">Nama PT</h6>
                                                </div>
                                                <div class="">
                                                    <h5 class="mb-0">
                                                        ${item.trainer_name}
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
    $(document).on('click', '.members', function() {
        let id = $(this).data('id');
        var formData = {
            id: id,
            _token: '{{ csrf_token() }}' // Ensure you include the CSRF token
        };

        $.ajax({
            url: `{{ route('admin_ajax_detail_members')}}`, // The route to your controller
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.status == true) {
                    console.log(response.status);

                    let data = response.absen.end_time;
                    let nilai_end_time = data ? data : '-';
                    let pt_disabled = '';
                    let option = `<option value=''>--select--</option>`


                    let html = `
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
           <label for="exampleFormControlTextarea1">Members</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" disabled rows="3">${member}</textarea>
        </div>`
                    }

                    $('#modal_body_membersModal').html(html)
                    $('#btn_simpan').show();
                } else {
                    $('#modal_body_membersModal').html(response.message)
                    $('#btn_close').show();
                }

            },
            error: function(xhr, status, error) {
                console.log(error);

            }
        });
    });
</script>
@endpush