@extends('layouts.admin.master')
@section('Quản lý thuốc')
@section('content')

<!-- Tab nav -->
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
            role="tab" aria-controls="nav-home" aria-selected="true">Thuốc hoạt động</button>
        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button"
            role="tab" aria-controls="nav-profile" aria-selected="false">Thuốc hết</button>
    </div>
</nav>

<!-- Form tìm kiếm -->
<form action="{{ route('system.medicine') }}" method="GET" class="row g-2 py-3">
    <div class="col-md-8">
        <div class="row g-2">
            <div class="col-md-4 col-12">
                <input type="text" id="medicineNameInput" class="form-control" placeholder="Tìm kiếm tên thuốc"
                    name="name" value="{{ request('name') }}">
            </div>
            <div class="col-md-4 col-12">
                <select class="form-select" name="unit_of_measurement">
                    <option value="">Chọn đơn vị thuốc</option>
                    @foreach ($unitOfMeasurements as $unit)
                    <option value="{{ $unit }}" {{ request('unit_of_measurement') == $unit ? 'selected' : '' }}>
                        {{ $unit }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 col-12">
                <select class="form-select" name="medicine_type_id">
                    <option value="">Chọn danh mục thuốc</option>
                    @foreach ($medicineTypes as $type)
                    <option value="{{ $type->medicine_type_id }}" {{ request('medicine_type_id') == $type->medicine_type_id ? 'selected' : '' }}>{{ $type->name }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="row g-2">
            <div class="col-md-6 col-12">
                <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
            </div>
            <div class="col-md-6 col-12">
                <a href="javascript:void(0)" class="btn btn-success w-100" onclick="openAddModal()">Thêm thuốc</a>
            </div>
        </div>
    </div>
</form>


<!-- Tab content -->
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <!-- Thuốc hoạt động -->
        @include('System.medicines.medicine', ['medicines' => $medicine])
    </div>

    <div class="tab-pane fade show" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
        <!-- Thuốc hết -->
        @include('System.medicines.medicineEnd', ['medicines' => $medicineEnd])
    </div>
</div>










{{-- Thêm --}}
<div class="modal fade" id="addMedicineModal" tabindex="-1" aria-labelledby="addMedicineModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMedicineModalLabel">Thêm thuốc</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addMedicineForm">
                    @csrf
                    <div class="col-md-12 row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="medicine_id" class="form-label">Mã thuốc</label>
                                <input type="text" name="medicine_id" id="medicine_id" class="form-control"
                                    value="{{ strtoupper(Str::random(10)) }}" readonly>
                                <div class="invalid-feedback" id="medicine_id_error"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Tên thuốc</label>

                                <input name="name" class="form-control" id="name">
                                <div class="invalid-feedback" id="name_error"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="medicineTypeIdadd" class="form-label">Nhóm</label>
                                <select class="form-select" name="medicine_type_id" id="medicineTypeIdadd">
                                    <option value="">Chọn nhóm thuốc</option>
                                    <!-- Các tùy chọn sẽ được thêm vào bằng AJAX -->
                                </select>
                                <div class="invalid-feedback" id="medicine_type_id_error" style="display: block;"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="active_ingredient" class="form-label">Hoạt tính</label>
                                <textarea name="active_ingredient" class="form-control"
                                    id="active_ingredient"></textarea>
                                <div class="invalid-feedback" id="active_ingredient_error"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="price" class="form-label">Giá thuốc</label>
                                <input name="price" type="number" class="form-control" id="price" step="100">
                                <div class="invalid-feedback" id="price_error"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="amount" class="form-label">Số lượng</label>
                                <input name="amount" type="number" class="form-control" id="amount" min="0">
                                <div class="invalid-feedback" id="amount_error"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="unit_of_measurement" class="form-label">Đơn vị</label>
                                {{-- <select name="unit_of_measurement" class="form-control" id="unit_of_measurement">
                                    <option value="">Chọn đơn vị</option>
                                    @foreach ($unique_units as $units)
                                    <option value="{{ $units }}">{{ $units }}</option>
                                @endforeach
                                </select> --}}
                                <input name="unit_of_measurement" class="form-control" id="unit_of_measurement">
                                <div class="invalid-feedback" id="unit_of_measurement_error"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button class="btn btn-primary" id="addMedicineBtn" type="submit">Thêm</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- Modal cập nhật thuốc -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Chỉnh sửa thuốc</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editMedicineForm">
                    <div class="col-md-12 row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="medicineId" class="form-label">Mã thuốc</label>
                                <input type="text" name="medicine_id" class="form-control" id="medicineId" readonly>
                                <div class="text-danger" id="medicine_idedit_error"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Tên thuốc</label>
                                <input type="text" name="name" class="form-control" id="nameedit">
                                <div class="text-danger" id="nameedit_error"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="medicineTypeId" class="form-label">Nhóm thuốc</label>
                                <select class="form-select" name="medicine_type_id" id="medicineTypeId">
                                    <option value="">Chọn nhóm thuốc</option>
                                    <!-- Các tùy chọn nhóm thuốc -->
                                </select>
                                <div class="text-danger" id="medicine_type_id_error"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                              

                                <label for="price" class="form-label">Giá thuốc</label>
                                <input type="number" name="price" class="form-control" id="priceedit">
                                <div class="invalid-feedback" id="price_error"></div>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="amount" class="form-label">Số lượng</label>
                                <input type="number" name="amount" class="form-control" id="amountedit">
                                <div class="text-danger" id="amount_error"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">Trạng thái</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="1">Hoạt động</option>
                                    <option value="0">Hết</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="activeIngredient" class="form-label">Hoạt tính</label>
                                <textarea name="active_ingredient" class="form-control" id="activeIngredient"></textarea>
                                <div class="text-danger" id="active_ingredientedit_error"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="unitOfMeasurement" class="form-label">Đơn vị</label>
                                <input type="text" name="unit_of_measurement" class="form-control" id="unitOfMeasurement">
                                <div class="text-danger" id="unit_of_measurementedit_error"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary" id="updateMedicineBtn">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
    // --- Thêm thuốc ----
    function openAddModal() {

        $.ajax({
            url: '/system/medicines/create',
            type: 'GET',
            success: function(response) {
                var medicineTypeSelect = $('#medicineTypeIdadd');
                medicineTypeSelect.empty();
                medicineTypeSelect.append(
                    '<option value="">Chọn nhóm thuốc</option>');

                response.medicineType.forEach(function(item) {
                    medicineTypeSelect.append('<option value="' + item.medicine_type_id + '">' +
                        item.name + '</option>');
                });

                $('#addMedicineModal').modal('show');
            },
            error: function(err) {
                console.error("Lỗi khi lấy dữ liệu thuốc:", err);
            }
        });
    }

    $(document).ready(function() {
        $('#addMedicineForm').on('submit', function(e) {
            e.preventDefault();

            var formData = $(this).serialize();
            // console.log(formData);

            $.ajax({
                url: '/system/medicines/store',
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        $('#addMedicineModal').modal('hide');
                        location.reload();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(err) {
                    console.error("Lỗi khi thêm thuốc:", err);

                    // Kiểm tra xem có lỗi không
                    if (err.responseJSON && err.responseJSON.errors) {
                        var errors = err.responseJSON.errors;
                        console.log(errors);

                        $('.invalid-feedback').text('');
                        $('.form-control').removeClass('is-invalid');

                        // Hiển thị lỗi mới
                        $.each(errors, function(key, value) {
                            $('#' + key).addClass('is-invalid');
                            $('#' + key + '_error').text(value[0]);
                        });
                    } else {
                        alert('Có lỗi xảy ra, vui lòng kiểm tra console.');
                    }
                }

            });
        });
    });



    // Cập nhật 

    $(document).ready(function() {
        $("#inputName").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });

    // cập nhật

    function openEditModalMedicine(id) {
        
        $.ajax({
            url: '/system/medicines/edit/' + id,
            type: 'GET',
            success: function(response) {
                        console.log(response);
                if (response.success) {
                    // Set các trường dữ liệu thuốc
                    $('#medicineId').val(response.medicine.medicine_id);
                    $('#nameedit').val(response.medicine.name);
                    $('#status').val(response.medicine.status);
                    $('#activeIngredient').val(response.medicine.active_ingredient);
                    $('#unitOfMeasurement').val(response.medicine.unit_of_measurement);
                    $('#priceedit').val(response.medicine.price); // Set giá thuốc
                    $('#amountedit').val(response.medicine.amount); // Set số lượng

                    // Cập nhật các nhóm thuốc vào select box
                    var medicineTypeSelect = $('#medicineTypeId');
                    medicineTypeSelect.empty();
                    medicineTypeSelect.append('<option value="">Chọn nhóm thuốc</option>');
                    response.medicineType.forEach(function(item) {
                        medicineTypeSelect.append('<option value="' + item.medicine_type_id + '">' + item.name + '</option>');
                    });

                    // Set nhóm thuốc đã chọn
                    medicineTypeSelect.val(response.medicine.medicine_type_id);

                    // Hiển thị modal
                    $('#exampleModal').modal('show');
                }
            },
            error: function(err) {
                console.error("Lỗi khi lấy dữ liệu thuốc:", err);
            }
        });
    }

    // $('#updateMedicineBtn').on('click', function() {
    //     $('#editMedicineForm').submit();
    // });

    let isSubmitting = false;

    $('#editMedicineForm').on('submit', function(e) {
        e.preventDefault();

        if (isSubmitting) return;
        isSubmitting = true;

        var id = $('#medicineId').val();
        var formData = {
            medicine_id: id,
            name: $('#nameedit').val(),
            medicine_type_id: $('#medicineTypeId').val(),
            status: $('#status').val(),
            active_ingredient: $('#activeIngredient').val(),
            unit_of_measurement: $('#unitOfMeasurement').val(),
            price: $('#priceedit').val(), // Gửi giá thuốc
            amount: $('#amountedit').val(), // Gửi số lượng thuốc
            _token: '{{ csrf_token() }}'
        };

        console.log(formData);
        

        $.ajax({
            url: '/system/medicines/update/' + id,
            type: 'PATCH',
            data: JSON.stringify(formData),
            contentType: 'application/json',
            processData: false,
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    $('#exampleModal').modal('hide');
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                } else if (response.error) {
                    toastr.error(response.message);
                }
            },
            error: function(err) {
                console.error("Lỗi khi cập nhật thuốc:", err);

                if (err.responseJSON && err.responseJSON.errors) {
                    var errors = err.responseJSON.errors;

                    $('.text-danger').text('');
                    $('.form-control').removeClass('is-invalid');

                    $.each(errors, function(key, value) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key + 'edit_error').text(value);
                    });
                } else {
                    alert('Có lỗi xảy ra, vui lòng kiểm tra console.');
                }
            },
            complete: function() {
                isSubmitting = false;
            }
        });
    });
</script>


@endsection