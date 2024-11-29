@extends('layouts.admin.master')
@section('title', 'Quản lý phòng khám')
@section('content')
<div class="card w-100">
    <div class="card-body p-4">
        <h5 class="card-title fw-semibold mb-4">Quản lý phòng khám</h5>

        <form action="{{ route('system.sclinic') }}" method="GET" class="row g-2 d-flex justify-content-between align-items-center">
            <div class="col-md-4 col-12">
                <input type="text" id="inputName" class="form-control" placeholder="Tìm kiếm phòng khám" name="nameClinic" value="{{ request('nameClinic') }}">
            </div>

            <!-- Chọn chuyên khoa -->
            <div class="col-md-4 col-12">
                <select class="form-select" name="seclectSpecialty" id="seclectSpecialty">
                    <option value="">Chọn chuyên khoa</option>
                    @foreach ($specialties as $specialty)
                    <option value="{{ $specialty->specialty_id }}" {{ request('seclectSpecialty') == $specialty->specialty_id ? 'selected' : '' }}>
                        {{ $specialty->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Tìm kiếm và Thêm -->
            <div class="col-md-4 col-12">
                <div class="row g-2">
                    <div class="col-6">
                        <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
                    </div>
                    <div class="col-6">
                        <a class="btn btn-success w-100" onclick="openModalCreate()">Thêm</a>
                    </div>
                </div>
            </div>
        </form>



        <div class="table-responsive">
            <div class="mt-3">
                {!! $clinics->links() !!}

            </div>

            <table class="table table-bordered text-nowrap mb-0 align-middle">
                <thead class="text-dark fs-4">
                    <tr class="text-center">
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">ID</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Số phòng</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Chuyên khoa</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Ngày tạo</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Thao tác</h6>
                        </th>
                    </tr>
                </thead>
                @php
                $count = 1;
                @endphp
                <tbody id="myTable">
                    @if($clinics->isEmpty())
                    <div id="noResults" class="alert alert-warning">Không tìm thấy dữ liệu.</div>
                    @else
                    @foreach ($clinics as $sclinic)
                    <tr class="text-center">
                        <td class="border-bottom-0">{{ $count++ }}</td>
                        <td class="border-bottom-0">{{ $sclinic->name }}</td>
                        <td class="border-bottom-0">{{ $sclinic->specialtyForgikey->name }}</td>
                        <td class="border-bottom-0">{{ $sclinic->created_at->format('d/m/Y') }}</td>
                        <td class="border-bottom-0">
                            @if ($sclinic->status === 1)
                            <a href="javascript:void(0)" class="btn btn-primary "
                                onclick="openModalEdit('{{ $sclinic->sclinic_id }}')"><i
                                    class="ti ti-pencil"></i></a>
                            @else
                            <a href="javascript:void(0)" class="btn btn-danger"
                                onclick="openModalEdit('{{ $sclinic->sclinic_id }}')"><i
                                    class="ti ti-pencil"></i></a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        {!! $clinics->links() !!}

    </div>
</div>

{{-- Start modal create --}}
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cập nhật phòng khám</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addClinicForm">
                    @csrf
                    <div class="col-md-12 d-flex">
                        <div class="mb-3 col-md-6 pe-1">
                            <label for="recipient-name" class="col-form-label">Tên phòng</label>
                            <input type="text" name="sclinicName" class="form-control" id="sclinicName"
                                value="">
                            <input type="hidden" name="sclinicId" class="form-control" id="sclinicId" value="">
                            <span class="invalid-feedback" id="sclinicName_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="recipient-name" class="col-form-label">Chuyên khoa</label>
                            <select name="specialtyName" id="specialtyName" class="form-select">

                            </select>
                            <span class="invalid-feedback" id="specialtyName_error"></span>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="" class="form-label">Mô tả</label>
                        <textarea name="description" id="description" class="form-control"></textarea>
                        <span class="invalid-feedback" id="description_error"></span>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="statusSclinic" id="statusSclinic"
                            checked>
                        <label class="form-check-label" for="confirmation-check">
                            Hoạt động
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer" id="btnRole">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="addClinic">Lưu</button>
            </div>
        </div>
    </div>
</div>
{{-- End modal create --}}

{{-- Start modal edit --}}
<div class="modal fade" id="exampleModalEdit" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cập nhật phòng khám</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="col-md-12 d-flex">
                        <div class="mb-3 col-md-6 pe-1">
                            <label for="recipient-name" class="col-form-label">Tên phòng</label>
                            <input type="text" name="sclinicName" class="form-control" id="sclinicNameEdit"
                                value="">
                            <span class="invalid-feedback" id="sclinicName_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="recipient-name" class="col-form-label">Chuyên khoa</label>
                            <select name="specialtyName" id="specialtyNameEdit"
                                class="form-select specialtyNameEdit">

                            </select>
                            <span class="invalid-feedback" id="specialtyName_error"></span>

                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="" class="form-label">Mô tả</label>
                        <textarea name="sclinicNote" id="descriptionEdit" class="form-control"></textarea>
                        <span class="invalid-feedback" id="sclinicNote_error"></span>

                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="statusSclinic" id="statusSclinicEdit"
                            checked>
                        <label class="form-check-label" for="statusSclinicEdit">
                            Hoạt động
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer" id="btnRole">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="save-btn-edit">Lưu</button>
            </div>
        </div>
    </div>
</div>


<script>
    function filterSpecialty() {

        const specialtyId = $('#seclectSpecialty').val();
        // const inputName = $('#inputName').val();

        $.ajax({
            url: '/system/sclinics/',
            type: 'GET',
            data: {
                specialty_id: specialtyId,
            },
            success: function(response) {
                console.log(response);
                const tableBody = $('#myTable');
                tableBody.empty();

                let count = 1;
                if (Array.isArray(response
                        .clinics)) {
                    let count = 1;
                    response.clinics.forEach(function(sclinic) {
                        const row = `
                            <tr class="text-center">
                                <td class="border-bottom-0">${count++}</td>
                                <td class="border-bottom-0">${sclinic.name}</td>
                                <td class="border-bottom-0">${sclinic.specialtyName}</td>
                                <td class="border-bottom-0">
                                    <a href="javascript:void(0)" class="btn btn-primary"
                                    onclick="openModalEdit('${sclinic.sclinic_id}')">
                                    <i class="ti ti-pencil"></i>
                                    </a>
                                </td>
                            </tr>`;
                        tableBody.append(row); // Append new rows
                    });
                } else {
                    console.error('response.clinics is not an array:', response.clinics);
                }
            },
            error: function(xhr) {
                console.error('Error fetching clinics:', xhr);
                // Handle error case, e.g., show a notification to the user
            }
        });
    }


    function openModalCreate() {
        $('#exampleModal').modal('show');
    }

    function loadSpecialties(selectedSpecialtyId = null) { // Thêm tham số mặc định
        $.ajax({
            url: '/system/sclinics/create/',
            type: 'GET',
            success: function(response) {
                const select = $('.specialtyNameEdit, #specialtyName');
                select.empty();
                select.append(`<option value="">-- Chọn chuyên khoa --</option>`);

                response.specialties.forEach(function(specialty) {
                    // Kiểm tra nếu specialty_id hiện tại có bằng với specialty_id của chuyên khoa
                    const isSelected = (selectedSpecialtyId && specialty.specialty_id ==
                        selectedSpecialtyId) ? 'selected' : '';
                    select.append(
                        `<option value="${specialty.specialty_id}" ${isSelected}>${specialty.name}</option>`
                    );
                });
            },
            error: function(xhr) {
                console.error('Error fetching specialties:', xhr);
                // Handle error case, e.g., show a notification to the user
            }
        });
    }


    $(document).ready(function() {
        loadSpecialties();

        $('#addClinic').click(function(e) {
            e.preventDefault();
            if ($('#statusSclinic').is(':checked')) {
                $('#statusSclinic').val(1);
            } else {
                $('#statusSclinic').val(0);
            }
            var formData = $('#addClinicForm').serialize();

            console.log(formData);

            $.ajax({
                url: '/system/sclinics/store',
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#exampleModal').modal('hide');
                    if (response.success) {
                        toastr.success(response.message);
                        setTimeout(() => {
                            location.reload();
                        }, 3000);
                    } else if (response.error) {
                        toastr.error(response.message);
                    }
                },
                error: function(error) {
                    if (error.responseJSON && error.responseJSON.errors) {
                        let errors = error.responseJSON.errors;
                        $('.invalid-feedback').text('');
                        $('.form-control').removeClass('is-invalid');
                        $.each(errors, function(key, value) {
                            $('#' + key).addClass('is-invalid');
                            $('#' + key + '_error').text(value[0]);
                        });
                    } else {
                        console.error(error);
                    }
                }
            });
        });
    });

    function openModalEdit(id) {
        $('#exampleModalEdit').modal('show');
        // console.log(id);
        $.ajax({
            url: '/system/sclinics/edit/' + id,
            type: 'GET',
            success: function(response) {
                console.log(response)
                if (response.sclinic && response.sclinicId) {
                    $('#sclinicNameEdit').val(response.sclinicName);
                    $('#specialtyNameEdit').val(response.specialtyName);
                    $('#descriptionEdit').val(response.sclinicNote);
                    $('#confirmationCheckEdit').prop('checked', response.statusSclinic == 1);
                    $('#exampleModalEdit').data('id', id);
                } else {
                    console.error("Error: Missing or invalid sclinic data.");
                }
                loadSpecialties(response.specialtyName);
            },
            error: function(error) {
                console.error(error);
            }
        })
    }

    $('#save-btn-edit').click(function() {
        var id = $('#exampleModalEdit').data('id');
        // console.log('Đây là id:',id);
        const sclinicNameEdit = $('#sclinicNameEdit').val();
        const specialtyIdEdit = $('#specialtyNameEdit').val();
        const noteEdit = $('#descriptionEdit').val();
        const sclinicStatusEdit = $('#statusSclinicEdit').is(':checked') ? 1 : 0;

        $.ajax({
            url: '/system/sclinics/update/' + id,
            type: 'PATCH',
            data: {
                sclinicName: sclinicNameEdit,
                specialtyName: specialtyIdEdit,
                sclinicNote: noteEdit,
                statusSclinic: sclinicStatusEdit,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {

                $('#exampleModalEdit').modal('hide');
                if (response.success) {
                    toastr.success(response.message);
                    setTimeout(() => {
                        location.reload();
                    }, 3000);
                } else if (response.error) {
                    toastr.error(response.message);
                }
            },
            error: function(err) {
                if (err.responseJSON && err.responseJSON.errors) {
                    let errors = err.responseJSON.errors;

                    $('.invalid-feedback').text('');
                    $('.form-control').removeClass('is-invalid');
                    $.each(errors, function(key, value) {
                        $('[name="' + key + '"]').addClass('is-invalid');
                        $('#' + key + '_error').text(value[0]);
                    });
                } else {
                    console.error(error);
                }
            }
        });

    });
</script>

@endsection