@extends('layouts.admin.master')
@section('title', 'Quản lý chuyên khoa')
@section('content')
    <div class="card w-100">
        <div class="card-body p-4">
            <div class="col-md-12 d-flex justify-content-around align-items-center">
                <div class="col-md-12 d-flex justify-content-around align-items-center">
                    <div class="col-md-3">
                        <h5 class="card-title fw-semibold mb-4">Quản lý phòng khám</h5>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-success mb-4" onclick="openModalCreate()">Thêm</button>
                    </div>
                    <div class="col-md-4 d-flex justify-content-end mb-4">
                        <div class="w-100 me-1">
                            <input type="text" id="inputName" class="form-control" placeholder="Tìm kiếm phòng khám"
                                name="nameClinic">
                        </div>
                        <div class="w-100">
                            <select class="form-select" name="seclectSpecialty" id="seclectSpecialty">
                                <option value="">Chọn chuyên khoa</option>
                                @foreach ($specialties as $specialty)
                                    <option value="{{ $specialty->specialty_id }}">{{ $specialty->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="statusActive-tab" data-bs-toggle="tab"
                        data-bs-target="#statusActive" type="button" role="tab" aria-controls="statusActive"
                        aria-selected="true">Hoạt động</button>
                    <button class="nav-link" id="statusUnactive-tab" data-bs-toggle="tab" data-bs-target="#statusUnactive"
                        type="button" role="tab" aria-controls="statusUnactive" aria-selected="false">Ngừng hoạt
                        động</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="statusActive" role="tabpanel" aria-labelledby="statusActive-tab">
                    @include('System.clinic.status-active')
                </div>
                <div class="tab-pane fade" id="statusUnactive" role="tabpanel" aria-labelledby="statusUnactive-tab">
                    @include('System.clinic.status-unactive')
                </div>
            </div>

        </div>
    </div>
    <script src="{{ asset('backend/assets/js/listClinic.js') }}"></script>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm chuyên khoa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="specialty-form">
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Tên chuyên khoa:</label>
                            <input type="text" name="name" class="form-control" id="specialtyName" value="">
                            <span class="text-danger" id="name-error"></span>
                        </div>
                        <div class="mb-3">
                            <input class="form-check-input" type="checkbox" value="" name="status"
                                id="specialtyStatus">
                            <label class="form-check-label" for="confirmation-check">Xác nhận</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary" id="save-btn">Lưu</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm chuyên khoa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="specialty-form">
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Tên chuyên khoa:</label>
                            <input type="text" name="nameEdit" class="form-control" id="specialtyNameEdit"
                                value="">
                            <input type="text" name="specialty_id" id="specialty_id" hidden>
                            <span class="text-danger" id="name-error"></span>
                        </div>
                        <div class="mb-3">
                            <input class="form-check-input" type="checkbox" value="" name="statusEdit"
                                id="specialtyStatusEdit">
                            <label class="form-check-label" for="confirmation-check">Xác nhận</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="save-btn-edit">Lưu</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openModalCreate() {
            $('#exampleModal').modal('show');
        }

        $('#save-btn').click(function() {
            const specialtyName = $('#specialtyName').val();
            const specialtyStatus = $('#specialtyStatus').is(':checked') ? 1 : 0;
            // console.log(specialtyName);

            // Kiểm tra lỗi
            if (specialtyName === "") {
                $('#name-error').text("Tên chuyên khoa không được để trống");
                return;
            } else {
                $('#name-error').text("");
            }
            $.ajax({
                url: '/system/specialties/create',
                type: 'POST',
                data: {
                    'name': specialtyName,
                    'status': specialtyStatus,
                    '_token': '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log(response);
                    $('#exampleModal').modal('hide');
                    location.reload();
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

        });

        function openModalEdit(id) {
            $('#exampleModalEdit').modal('show');
            console.log(id);
            $.ajax({
                url: '/system/specialties/edit/' + id,
                type: 'GET',
                success: function(response) {
                    if (response.nameEdit && response.statusEdit) {
                        console.log(response)
                        $('#specialtyNameEdit').val(response.nameEdit);
                        $('#specialtyStatusEdit').prop('checked', response.statusEdit == 1);
                        $('#exampleModalEdit').data('id', id);
                    } else {
                        console.error('Missing data in response:', response);
                    }
                },
                error: function(error) {
                    console.error(error);
                }
            })
        }

        $('#save-btn-edit').click(function() {
            var id = $('#exampleModalEdit').data('id');
            // console.log('Đây là id:',id);
            const specialtyName = $('#specialtyNameEdit').val();
            const specialtyStatus = $('#specialtyStatusEdit').is(':checked') ? 1 : 0;

            console.log(specialtyName, specialtyStatus);

            $.ajax({
                url: '/system/specialties/update/' + id,
                type: 'PATCH',
                data: {
                    nameEdit: specialtyName,
                    statusEdit: specialtyStatus,
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
