@extends('layouts.admin.master')
@section('Quản lý sản phẩm')
@section('content')

    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link  active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
                role="tab" aria-controls="nav-home" aria-selected="true">Hoạt động
            </button>
            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button"
                role="tab" aria-controls="nav-profile" aria-selected="false">Hết
            </button>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="d-flex align-items-center justify-content-between py-3">
            <div class="col-md-6 d-flex">
                <form action="" class="col-md-12 row">
                    <div class="col-md-6">
                        <input type="text" id="inputName" class="form-control" placeholder="Tên thuốc" name="name">
                    </div>
                </form>
            </div>
            <div class="">
                <a href="javascript:void(0)" class="btn btn-success me-1" onclick='openAddModal()'>Thêm sản phẩm</a>
            </div>

        </div>
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

            @include('System.products.product')

        </div>


        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">

            @include('System.products.productEnd')

        </div>
    </div>


    {{-- Thêm  --}}
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
                                    <input type="text" class="form-control" name="name" id="name">
                                    <div class="invalid-feedback" id="name_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="categorySelect" class="form-label">Nhóm</label>
                                    <select class="form-select"
                                    name="category_type_id" id="categorySelect">
                                    <option value="">Chọn nhóm thuốc</option>
                                    <!-- Các tùy chọn sẽ được thêm vào bằng AJAX -->
                                </select>
                                    <div class="invalid-feedback" id="category_id" style="display: block;"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="active_ingredient" class="form-label">Hoạt tính</label>
                                    <textarea name="active_ingredient" class="form-control" id="active_ingredient"></textarea>
                                    <div class="invalid-feedback" id="active_ingredient_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="unit_of_measurement" class="form-label">Đơn vị</label>
                                    <input type="text" class="form-control" name="unit_of_measurement" id="unit_of_measurement">
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

    {{-- <!-- Modal cập nhật thuốc -->
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
                                    <input type="text" name="medicine_id" class="form-control" id="medicineId"
                                        readonly>
                                    <div class="text-danger" id="medicine_id_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Tên thuốc</label>
                                    <input type="text" name="name" class="form-control" id="nameedit" readonly>
                                    <div class="text-danger" id="name_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Nhóm</label>
                                    <select class="form-select" name="medicine_type_id" id="medicineTypeId" required>
                                        <option value="">Chọn nhóm thuốc</option>
                                        <!-- Các tùy chọn sẽ được thêm vào bằng AJAX -->
                                    </select>
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
                                    <textarea name="active_ingredient" class="form-control" id="activeIngredient" readonly></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="unitOfMeasurement" class="form-label">Đơn vị</label>
                                    <input type="text" name="unit_of_measurement" class="form-control"
                                        id="unitOfMeasurement" readonly>
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
    </div> --}}







    <script>
        // --- Thêm thuốc ----
        function openAddModal() {

            $.ajax({
                url: '/system/product/create',
                type: 'GET',
                success: function(response) {
                    var categorySelect = $('#categorySelect');
                    categorySelect.empty();
                    categorySelect.append(
                        '<option value="">Chọn nhóm</option>');

                    response.category.forEach(function(item) {
                        categorySelect.append('<option value="' + item.medicine_type_id + '">' +
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
                    url: '/system/product/store',
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
                            
                            // Xóa lỗi cũ
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
    </script>


    {{-- Cập nhật --}}
    <script>
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
                    console.log(response.medicine.name);

                    if (response.success) {
                        $('#medicineId').val(response.medicine.medicine_id);
                        $('#nameedit').val(response.medicine.name);
                        $('#status').val(response.medicine.status);
                        $('#activeIngredient').val(response.medicine.active_ingredient);
                        $('#unitOfMeasurement').val(response.medicine.unit_of_measurement);

                        var medicineTypeSelect = $('#medicineTypeId');
                        medicineTypeSelect.empty();
                        medicineTypeSelect.append(
                            '<option value="">Chọn nhóm thuốc</option>');

                        response.medicineType.forEach(function(item) {
                            medicineTypeSelect.append('<option value="' + item.medicine_type_id + '">' +
                                item.name + '</option>');
                        });

                        medicineTypeSelect.val(response.medicine.medicine_type_id);

                        $('#exampleModal').modal('show');
                    }
                },
                error: function(err) {
                    console.error("Lỗi khi lấy dữ liệu thuốc:", err);
                }
            });
        }
        $('#updateMedicineBtn').on('click', function() {
            $('#editMedicineForm').submit();
        });

        let isSubmitting = false;

        $('#editMedicineForm').on('submit', function(e) {
            e.preventDefault(); // Ngăn chặn hành vi mặc định của form

            if (isSubmitting) return; // Nếu đã gửi rồi thì không gửi thêm
            isSubmitting = true;

            var id = $('#medicineId').val();
            var formData = {
                medicine_id: id,
                name: $('#nameedit').val(),
                medicine_type_id: $('#medicineTypeId').val(),
                status: $('#status').val(),
                active_ingredient: $('#activeIngredient').val(),
                unit_of_measurement: $('#unitOfMeasurement').val(),
                _token: '{{ csrf_token() }}'
            };

            $.ajax({
                url: '/system/medicines/update/' + id,
                type: 'PATCH',
                data: JSON.stringify(formData), // Dữ liệu gửi đi
                contentType: 'application/json',
                processData: false,
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        $('#exampleModal').modal('hide');
                        window.location.href = '/system/medicines'; // Chuyển hướng về trang table
                    } else if (response.error) {
                        toastr.error(response.message);
                    }
                },
                error: function(err) {
                    alert('Có lỗi xảy ra: ' + (err.responseJSON ? err.responseJSON.error :
                        'Không xác định'));
                },
                complete: function() {
                    isSubmitting = false; // Đặt lại cờ sau khi hoàn thành
                }
            });
        });
    </script>


@endsection
