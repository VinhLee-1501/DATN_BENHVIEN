@extends('layouts.admin.master')
@section('Quản lý thuốc')
@section('content')

    <div class="card w-100">
        <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-4">Quản lý thuốc</h5>

            <form action="" class="col-md-12 row">
                    <div class="col-md-8 d-flex gap-3 mb-3">
                        <a href="javascript:void(0)" class="btn btn-success" onclick='openAddModal()'>Thêm thuốc</a>
                        <a href="{{ route('system.medicines.end') }}" class="btn btn-danger">Thuốc hết</a>
                        <a href="{{ route('system.medicine') }}" class="btn btn-primary">Thuốc hoạt động</a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <input type="text" id="inputName" class="form-control" placeholder="Nhập tên thuốc">
                    </div>

                </form>

            <div class="table-responsive">
                <table class="table text-nowrap mb-0 align-middle">
                <thead class="text-dark fs-4">
                        <tr>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Mã thuốc</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Tên thuốc</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Ngày thêm</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Trạng thái</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Hành động</h6>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="myTable">
                        @php
                            $count = 1;
                        @endphp
                        @foreach ($medicine as $data)
                            <tr>
                                <td class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">{{ $count++ }}</h6>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-semibold">{{ $data->name }}</p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-semibold">
                                        {{ Carbon\Carbon::parse($data->created_at)->format('d/m/Y') }}</p>
                                </td>
                                <td class="border-bottom-0">
                                    @if ($data->status == 1)
                                        <span class="badge bg-success">Hoạt động </span>
                                    @else
                                        <span class="badge bg-danger">Hết</span>
                                    @endif
                                </td>
                                <td class="border-bottom-0 d-flex">
                                    <a href="javascript:void(0)" class="btn btn-primary me-1"
                                        onclick="openEditModal('{{ $data->medicine_id }}')">
                                        <i class="ti ti-pencil"></i>
                                    </a>
                                    <form action="{{ route('system.medicines.delete', $data->medicine_id) }}"
                                        id="form-delete{{ $data->medicine_id }}" method="post">
                                        @method('delete')
                                        @csrf
                                    </form>
                                    <button type="submit" class="btn btn-danger btn-delete"
                                        data-id="{{ $data->medicine_id }}">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                    <a class="btn btn-warning ms-1" data-bs-toggle="collapse"
                                        href="#collapse{{ $data->medicine_id }}" role="button" aria-expanded="false"
                                        aria-controls="collapse{{ $data->medicine_id }}">
                                        Chi tiết
                                    </a>
                                </td>
                            </tr>
                            <tr id="show">
                                <td colspan="5">
                                    <div class="collapse" id="collapse{{ $data->medicine_id }}">
                                        <div class="card card-body ">
                                            <h6 class="fw-semibold mb-2 fs-5">Thông tin chi tiết:</h6>
                                            <div class="col-md-12 d-flex mt-1">
                                                <div class="col-md-6">
                                                    <p><strong>Mã thuốc:</strong> {{ $data->medicine_id }}</p>
                                                    <p><strong>Tên thuốc:</strong> {{ $data->name }}</p>
                                                    <p><strong>Hoạt tính:</strong> {{ $data->active_ingredient }}</p>
                                                    <p><strong>Đơn vị:</strong> {{ $data->unit_of_measurement }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p><strong>Nhóm thuốc:</strong> {{ $data->medicine_types_name }}</p>
                                                    <p><strong>Ngày thêm thuốc:</strong>
                                                        {{ Carbon\Carbon::parse($data->created_at)->format('H:i d/m/Y ') }}
                                                    </p>
                                                    <p><strong>Ngày cập nhật:</strong>
                                                        {{ Carbon\Carbon::parse($data->updated_at)->format(' H:i d/m/Y ') }}
                                                    </p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- {!! $medicine->links() !!} -->
            </div>
            <div class="">
                <a href="javascript:void(0)" class="btn btn-success me-1" onclick='openAddModal()'>Thêm thuốc</a>
            </div>

        </div>
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

            @include('System.medicines.medicine')
        </div>


        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">

            @include('System.medicines.medicineEnd')

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
                                    <select name="name" class="form-control" id="name">
                                        <option value="">Chọn tên thuốc</option>
                                        @foreach ($unique_medicine_names as $medicine_name)
                                            <option value="{{ $medicine_name }}">{{ $medicine_name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" id="name_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="medicineTypeIdadd" class="form-label">Nhóm</label>
                                    <select class="form-select"
                                        name="medicine_type_id" id="medicineTypeIdadd">
                                        <option value="">Chọn nhóm thuốc</option>
                                        <!-- Các tùy chọn sẽ được thêm vào bằng AJAX -->
                                    </select>
                                    <div class="invalid-feedback" id="medicine_type_id_error" style="display: block;"></div>
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
                                    <select name="unit_of_measurement" class="form-control" id="unit_of_measurement">
                                        <option value="">Chọn đơn vị</option>
                                        @foreach ($unique_units as $units)
                                            <option value="{{ $units }}">{{ $units }}</option>
                                        @endforeach
                                    </select>
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
