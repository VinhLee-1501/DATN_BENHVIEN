@extends('layouts.admin.master')

@section('content')
<div class="card w-100">
    <div class="card-body p-4">
        <h5 class="card-title fw-semibold mb-4">Quản lý danh mục thuốc</h5>

        <form action="{{ route('system.medicineType') }}" method="GET" class="row align-items-center g-2">
            <div class="col-md-3 col-12">
                <input type="text" id="inputName" class="form-control" placeholder="Nhập tên thuốc" name="name"
                    value="{{ request('name') }}">
            </div>
            <div class="col-md-3 col-12">
                <select class="form-select" name="status">
                    <option value="">Chọn trạng thái</option>
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Hoạt động</option>
                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Không hoạt động</option>
                </select>
            </div>
            <div class="col-md-3 col-12">
                <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>

            </div>
            <div class="col-md-3 col-12">
                <a href="javascript:void(0)" class="btn btn-success w-100" onclick="openAddModal()">Thêm</a>

            </div>

        </form>


        <div class="table-responsive">
            <table class="table table-bordered text-nowrap mb-0 align-middle">
                <div class="mt-3">
                    {!! $medicineType->links() !!}
                </div>
                <thead class="text-dark fs-4">
                    <tr class="text-center">
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">STT</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Tên nhóm thuốc</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Ngày thêm</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Trạng thái</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Thao tác</h6>
                        </th>
                    </tr>
                </thead>
                <tbody id="myTable">
                    @php
                        $count = 1;
                    @endphp
                    @foreach ($medicineType as $data)
                        <tr class="text-center">
                            <!-- Cột STT -->
                            <td class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">{{ $count++ }}</h6>
                            </td>

                            <!-- Cột Tên nhóm thuốc -->
                            <td class="border-bottom-0">
                                <p class="mb-0 fw-semibold">{{ Str::limit($data->name, 40) }}</p>
                            </td>

                            <!-- Cột Ngày thêm -->
                            <td class="border-bottom-0">
                                <p class="mb-0 fw-semibold">
                                    {{ Carbon\Carbon::parse($data->created_at)->format('d/m/Y') }}
                                </p>
                            </td>

                            <!-- Cột Trạng thái -->
                            <td class="border-bottom-0">
                                @if ($data->status == 1)
                                    <span class="badge bg-success"> Hoạt động </span>
                                @else
                                    <span class="badge bg-danger">Không Hoạt động </span>
                                @endif
                            </td>

                            <!-- Cột Thao tác -->
                            <td class="border-bottom-0 d-flex justify-content-center align-items-center">
                                <a href="javascript:void(0)" class="btn btn-primary me-1"
                                    onclick="openEditModal('{{ $data->medicine_type_id }}')">
                                    <i class="ti ti-pencil"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $medicineType->links() !!}
        </div>

    </div>
</div>

{{-- --- Modal thêm loại thuốc --}}
<div class="modal fade" id="addMedicineTypeModal" tabindex="-1" aria-labelledby="addMedicineTypeModal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMedicineTypeModal">Thêm danh mục thuốc</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addMedicineTypeForm" medthod="post">
                    @csrf
                    <div class="col-md-12 row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="code" class="form-label">Mã nhóm thuốc</label>
                                <input type="text" name="code" class="form-control " id="code"
                                    value="{{ strtoupper(Str::random(10)) }}">
                                <div class="invalid-feedback" id="code_error"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="medicine" class="form-label">Tên danh mục</label>
                                <input type="text" name="name" class="form-control " id="name">
                                {{-- <select name="name" class="form-control" id="name">
                                    <option value="">Chọn tên thuốc</option>
                                    @foreach ($unique_categories as $category)
                                    <option value="{{ $category }}">{{ $category }}</option>
                                    @endforeach
                                </select> --}}
                                <div class="invalid-feedback" id="name_error"></div>
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


{{-- --- Modal cập nhật loại thuốc --}}
<div class="modal fade" id="updateMedicineTypeModal" tabindex="-1" aria-labelledby="updateMedicineTypeModal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateMedicineTypeModal">Cập nhật danh mục thuốc</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateMedicineTypeForm">
                    <div class="col-md-12 row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="medicine_type_id" class="form-label">Mã nhóm thuốc</label>
                                <input type="text" name="code" class="form-control" id="medicine_type_id">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Tên danh mục</label>
                                <input type="text" name="name" class="form-control" id="nametype">
                                <div class="text-danger" id="nameedit_error"></div>
                            </div>
                            <div class="col-md-12 d-flex">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Trạng thái</label>
                                    <select class="form-select" id="status" name="status">

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button class="btn btn-primary" id="updateMedicineTypeBtn" type="submit">Cập
                                nhật</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>




<script>
    // Thêm danh mục 
    function openAddModal() {
        $('#addMedicineTypeModal').modal('show');
    }

    $(document).ready(function () {
        $('#addMedicineTypeForm').on('submit', function (e) {
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                url: '/system/medicineTypes/store',
                type: 'POST',
                data: formData,

                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message);
                        $('#addMedicineTypeModal').modal('hide');
                        location.reload();
                    } else if (response.error) {
                        toastr.error(response.message);
                    }
                },
                error: function (err) {
                    console.error("Lỗi khi cập nhật danh mục:", err);

                    var errors = err.responseJSON.errors;

                    $('.invalid-feedback').text('');
                    $('.form-control').removeClass('is-invalid');

                    $.each(errors, function (key, value) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key + '_error').text(value[0]);
                    });
                }
            });
        });
    });



    // cập nhật danh mục 
    function openEditModal(id) {
        $.ajax({
            url: '/system/medicineTypes/edit/' + id,
            type: 'GET',
            success: function (response) {

                if (response.success) {
                    $('#medicine_type_id').val(response.medicineType.medicine_type_id);
                    $('#nametype').val(response.medicineType.name);


                    var getstatus = $('#status');
                    getstatus.empty();

                    if (response.medicineType.status == 1) {
                        getstatus.append('<option value="1" selected>Hoạt động</option>');
                        getstatus.append('<option value="0">Hết</option>');
                    } else {
                        getstatus.append('<option value="0" selected>Hết</option>');
                        getstatus.append('<option value="1">Hoạt động</option>');
                    }

                    $('#updateMedicineTypeModal').modal('show');
                }
            },
            error: function (err) {
                console.error("Lỗi khi lấy dữ liệu nhóm thuốc:", err);
            }
        });
    }

    $('#updateMedicineTypeForm').on('submit', function (e) {
        e.preventDefault();
        var id = $('#medicine_type_id').val();

        $.ajax({
            url: '/system/medicineTypes/update/' + id,
            type: 'PATCH',
            data: {
                // medicine_type_id: id,
                name: $('#nametype').val(),
                status: $('#status').val(),
                _token: '{{ csrf_token() }}'
            },

            success: function (response) {
                // console.log(response);

                if (response.success) {
                    toastr.success(response.message);
                    $('#updateMedicineTypeModal').modal('hide');
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                } else if (response.error) {
                    toastr.error(response.message);
                }
            },
            error: function (err) {

                if (err.responseJSON && err.responseJSON.errors) {
                    var errors = err.responseJSON.errors;

                    $('.text-danger').text('');
                    $('.form-control').removeClass('is-invalid');

                    $.each(errors, function (key, value) {

                        $('#' + key).addClass('is-invalid');
                        $('#' + key + 'edit_error').text(value);

                    });

                } else {
                    alert('Có lỗi xảy ra, vui lòng kiểm tra console.');
                }
            }
        });
    });


    // $('#updateMedicineTypeBtn').on('click', function() {
    //     $('#updateMedicineTypeForm').submit();
    // });
</script>
@endsection