@extends('layouts.admin.master')
@section('title', 'Quản lý phòng khám')
@section('content')
    <div class="card w-100">
        <div class="card-body p-4">
            <div class="col-md-12 d-flex justify-content-around align-items-center">
                <div class="col-md-12 d-flex justify-content-around align-items-center">
                    <div class="col-md-3">
                        <h5 class="card-title fw-semibold mb-4">Quản lý phòng khám</h5>
                    </div>
                    <div class="col-md-1">
                        <button class="btn btn-success mb-4" onclick="openModalCreate()">Thêm</button>
                    </div>
                    <div class="col-md-5 d-flex justify-content-end mb-4">
                        <div class="w-75 me-1">
                            <input type="text" id="inputName" class="form-control" placeholder="Tìm kiếm phòng khám"
                                name="nameClinic">
                        </div>
                        <div class="w-100 d-flex">
                            <select class="form-select me-1" name="seclectSpecialty" id="seclectSpecialty">
                                <option value="">Chọn chuyên khoa</option>
                                @foreach ($specialties as $specialty)
                                    <option value="{{ $specialty->specialty_id }}">{{ $specialty->name }}</option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-primary" onclick="filterSpecialty()">Lọc</button>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table text-nowrap mb-0 align-middle">
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
                            <h6 class="fw-semibold mb-0">Thao tác</h6>
                        </th>
                    </tr>
                </thead>
                @php
                    $count = 1;
                @endphp
                <tbody id="myTable">
                    @foreach ($clinics as $sclinic)
                        <tr class="text-center">
                            <td class="border-bottom-0">{{ $count++ }}</td>
                            <td class="border-bottom-0">{{ $sclinic->name }}</td>
                            <td class="border-bottom-0">{{ $sclinic->specialtyForgikey->name }}</td>
                            <td class="border-bottom-0">
                                @if ($sclinic->status === 1)
                                    <a href="javascript:void(0)" class="btn btn-primary "
                                    onclick="openModalEdit('{{ $sclinic->sclinic_id }}')"><i class="ti ti-pencil"></i></a>
                                @else
                                    <a href="javascript:void(0)" class="btn btn-danger"
                                    onclick="openModalEdit('{{ $sclinic->sclinic_id }}')"><i class="ti ti-pencil"></i></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
                    <form>
                        <div class="col-md-12 d-flex">
                            <div class="mb-3 col-md-6 pe-1">
                                <label for="recipient-name" class="col-form-label">Tên phòng</label>
                                <input type="text" name="sclinicName" class="form-control" id="sclinicName"
                                    value="">
                                <input type="hidden" name="sclinicId" class="form-control" id="sclinicId" value="">
                                <span class="text-danger" id="name-error"></span>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="recipient-name" class="col-form-label">Chuyên khoa</label>
                                <select name="specialtyName" id="specialtyName" class="form-select">

                                </select>
                                <span class="text-danger" id="name-specialty-error"></span>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="" class="form-label">Mô tả</label>
                            <textarea name="description" id="description" class="form-control"></textarea>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="check" id="confirmationCheck" checked>
                            <label class="form-check-label" for="confirmation-check">
                                Hoạt động
                            </label> <br>
                            <span class="text-danger" id="status-error"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" id="btnRole">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="save-btn">Lưu</button>
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
                                <input type="text" name="sclinicNameEdit" class="form-control" id="sclinicNameEdit"
                                    value="">
                                <span class="text-danger" id="name-sclinic-error-edit"></span>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="recipient-name" class="col-form-label">Chuyên khoa</label>
                                <select name="specialtyNameEdit" id="specialtyNameEdit"
                                    class="form-select specialtyNameEdit">

                                </select>
                                <span class="text-danger" id="name-error-edit"></span>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="" class="form-label">Mô tả</label>
                            <textarea name="descriptionEdit" id="descriptionEdit" class="form-control"></textarea>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="checkEdit" id="confirmationCheckEdit"
                                checked>
                            <label class="form-check-label" for="confirmationCheckEdit">
                                Hoạt động
                            </label><br>
                            <span class="text-danger" id="status-error-edit"></span>
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

        $('#save-btn').click(function() {
            const name = $('#sclinicName').val();
            const specialty_id = $('#specialtyName').val();
            const note = $('#description').val();
            const sclinicStatus = $('#confirmationCheck').is(':checked') ? 1 : 0;
            // console.log(specialtyName);

            // Kiểm tra lỗi
            if (specialtyName === "" || specialty_id === "" || sclinicStatus === "") {
                $('#name-specialty-error').text("Chuyên khoa không được để trống");
                $('#name-error').text("Tên phòng không được để trống");
                $('#status-error').text("Trạng thái không được để trống");
                return;
            } else {
                $('#name-specialty-error').text("");
                $('#name-error').text("");
                $('#status-error').text("");
            }
            $.ajax({
                url: '/system/sclinics/store',
                type: 'POST',
                data: {
                    'name': name,
                    'specialty_id': specialty_id,
                    'status': sclinicStatus,
                    'description': note,
                    '_token': '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#exampleModal').modal('hide');
                    if (response.success) {
                        toastr.success(response.message);
                        location.reload();
                    } else if (response.error) {
                        toastr.error(response.message);
                    }
                },
                error: function(error) {
                    if (error.status === 422) {
                        let errors = error.responseJSON.errors;
                        if (errors.name) {
                            $('#name-error').text(errors.name[0]);
                        }
                    } else {
                        console.error(error);
                    }
                }
            });
        });
        $(document).ready(function() {
            loadSpecialties();
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
                        $('#specialtyNameEdit').val(response.sclinicSpecialty);
                        $('#descriptionEdit').val(response.sclinicNote);
                        $('#confirmationCheckEdit').prop('checked', response.sclinicStatus == 1);
                        $('#exampleModalEdit').data('id', id);
                    } else {
                        // Handle case where data is missing or invalid
                        console.error("Error: Missing or invalid sclinic data.");
                    }

                    loadSpecialties(response.sclinicSpecialty);
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
            const sclinicStatusEdit = $('#confirmationCheckEdit').is(':checked') ? 1 : 0;

            console.log(sclinicStatusEdit);
            if (sclinicNameEdit === "") {
                $('#name-sclinic-error-edit').text("Tên phòng không được để trống");
                return;
            } else if (specialtyIdEdit === "") {
                $('#name-error-edit').text("Chuyên khoa không được để trống");
                return;
            } else if (sclinicStatusEdit === "") {
                $('#status-error-edit').text("Trạng thái không được để trống");
                return;
            }
            $.ajax({
                url: '/system/sclinics/update/' + id,
                type: 'PATCH',
                data: {
                    sclinicName: sclinicNameEdit,
                    sclinicSpecialty: specialtyIdEdit,
                    sclinicNote: noteEdit,
                    sclinicStatus: sclinicStatusEdit,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    
                    $('#exampleModalEdit').modal('hide');
                    if (response.success) {
                        toastr.success(response.message);
                        location.reload();
                    } else if (response.error) {
                        toastr.error(response.message);
                    }
                },
                error: function(err) {
                    console.error("Error updating data:", err);
                    alert('Có lỗi xảy ra: ' + err.responseJSON.error);
                }
            });

        });
    </script>

@endsection
