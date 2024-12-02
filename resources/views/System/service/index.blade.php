@extends('layouts.admin.master')
@section('Quản lí dịch vụ')
@section('content')
    <style>
        .select2-container--default .select2-selection--single {
            height: calc(1.7em + 0.75rem + 2px);
            padding: 0.2rem 0.4rem 0.75rem;
            font-size: 0.9rem;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
        }

        .select2-container {
            width: 100% !important;
        }

        .select2-dropdown {
            z-index: 9999 !important;
        }
    </style>
    <div class="card w-100">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center m-1 mb-4">
                <a href="{{ route('system.services.resetsearch') }}" class="card-title">
                    <h3>Quản lý dịch vụ</h3>
                </a>
                <div>
                    <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addNewModal">Thêm mới</a>
                </div>
            </div>
            <nav class="mb-4">
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                        type="button" role="tab" aria-controls="nav-home" aria-selected="true">Hoạt động</button>
                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                        type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Không hoạt
                        động</button>
                </div>
            </nav>
            <div class="row align-items-center me-0">
                <!-- Tìm kiếm và nút xóa -->
                <div class="col-12 col-md-6 col-sm-2 d-flex align-items-center mb-3 mb-md-0">
                    <form id="searchForm" action="{{ route('system.services.search') }}" method="GET"
                        class="d-flex align-items-center">
                        <div class="w-40">
                            <input type="text" name="search" id="searchInput" class="form-control"
                                value="{{ request('search', $search) }}" placeholder="Nhập tên dịch vụ">
                        </div>
                        <input type="hidden" name="tab" class="tab" id="tabInput" value="0">
                        <button type="submit" class="btn btn-success" id="searchButton">
                            <i class="ti ti-search"></i>
                        </button>
                    </form>
                    <button type="button" id="deleteButton" class="btn btn-danger ms-2 multiple-delete">
                        <i class="ti ti-trash"></i>
                    </button>
                </div>

                <div class="col-auto ms-auto d-flex align-items-center">
                    <span class="me-2 d-none d-sm-inline">Hiển thị:</span>
                    <select class="form-select d-none d-sm-inline" style="width: 75px" id="itemsPerPage"
                        aria-label="Items per page">
                        <option value="5" {{ request()->input('itemsPerPage', 5) == 5 ? 'selected' : '' }}>
                            5
                        </option>
                        <option value="10" {{ request()->input('itemsPerPage', 5) == 10 ? 'selected' : '' }}>10
                        </option>
                        <option value="15" {{ request()->input('itemsPerPage', 5) == 15 ? 'selected' : '' }}>15
                        </option>
                        <option value="20" {{ request()->input('itemsPerPage', 5) == 20 ? 'selected' : '' }}>20
                        </option>
                    </select>
                </div>
            </div>
            <!-- Nội dung của 2 tab -->
            <div class="tab-content" id="nav-tabContent">
                <!-- Tab Dịch vụ hoạt động -->
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="table-responsive ">
                        <table class="table table-bordered text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th></th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Mã dịch vụ</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Tên dịch vụ</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Giá tiền</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Nhóm dịch vụ</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Trạng thái</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Thao tác</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="activeTable">
                                @if ($service->isNotEmpty())
                                    @foreach ($service as $data)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="row_id[]" value="{{ $data->row_id }}"
                                                    class="blogCheckbox">
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="fw-semibold mb-0">{{ $data->service_id }}</p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-semibold"
                                                    style="word-wrap: break-word; overflow-wrap: break-word;
                                                    white-space: normal; max-width: 150px; word-break: normal;">
                                                    {{ $data->name }}
                                                </p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="fw-semibold mb-0">
                                                    {{ number_format($data->price * 1000, 0, ',', '.') }} VND
                                                </p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="fw-semibold mb-0">
                                                    {{ $data->serviceDirectoryForeignKey->name }}</p>
                                            </td>
                                            <td class="border-bottom-0">
                                                @if ($data->status == 0)
                                                    <p class="badge bg-success mb-0 fw-semibold">Hoạt động</p>
                                                @else
                                                    <p class="badge bg-danger mb-0 fw-semibold">Không hoạt động</p>
                                                @endif
                                            </td>
                                            <td class="border-bottom-0 d-flex">
                                                <a class="btn btn-primary me-1 edit-btn" data-id="{{ $data->row_id }}"
                                                    data-name="{{ $data->name }}" data-status="{{ $data->status }}"
                                                    data-price="{{ $data->price }}"
                                                    data-directory-id="{{ $data->directory_id }}">
                                                    <i class="ti ti-pencil"></i>
                                                </a>
                                                <a data-id="{{ $data->row_id }}" class="btn btn-danger me-1">
                                                    <i class="ti ti-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <h5 class="text-muted">Không tìm thấy kết quả nào</h5>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                        <div class="mt-3 d-flex justify-content-center">
                            {{ $service->links() }}
                        </div>
                    </div>
                </div>

                <!-- Tab Dịch vụ không hoạt động -->
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <div class="table-responsive ">
                        <table class="table table-bordered text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr class="text-center">
                                    <th></th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Mã dịch vụ</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Tên dịch vụ</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Giá tiền</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Nhóm dịch vụ</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Trạng thái</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Thao tác</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="activeTable">
                                @if ($service_inactive->isNotEmpty())
                                    @foreach ($service_inactive as $data)
                                        <tr class="text-center">
                                            <td>
                                                <input type="checkbox" name="row_id[]" value="{{ $data->row_id }}"
                                                    class="blogCheckbox">
                                            </td>
                                            <td class="border-bottom-0 text-center">
                                                <p class="fw-semibold mb-0">{{ $data->service_id }}</p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-semibold"
                                                    style="word-wrap: break-word; overflow-wrap: break-word;
                                                    white-space: normal; max-width: 150px; word-break: normal;">
                                                    {{ $data->name }}
                                                </p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="fw-semibold mb-0">
                                                    {{ number_format($data->price * 1000, 0, ',', '.') }} VND
                                                </p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="fw-semibold mb-0">
                                                    {{ $data->serviceDirectoryForeignKey->name }}</p>
                                            </td>
                                            <td class="border-bottom-0">
                                                @if ($data->status == 0)
                                                    <p class="badge bg-success mb-0 fw-semibold">Hoạt động</p>
                                                @else
                                                    <p class="badge bg-danger mb-0 fw-semibold">Không hoạt động</p>
                                                @endif
                                            </td>
                                            <td class="border-bottom-0 d-flex justify-content-center align-items-center">
                                                <a class="btn btn-primary me-1 edit-btn" data-id="{{ $data->row_id }}"
                                                    data-name="{{ $data->name }}" data-status="{{ $data->status }}"
                                                    data-price="{{ $data->price }}"
                                                    data-directory-id="{{ $data->directory_id }}">
                                                    <i class="ti ti-pencil"></i>
                                                </a>
                                                <a data-id="{{ $data->row_id }}" class="btn btn-danger me-1">
                                                    <i class="ti ti-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <h5 class="text-muted">Không tìm thấy kết quả nào</h5>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                        <div class="mt-3 d-flex justify-content-center">
                            {{ $service_inactive->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addNewModal" aria-labelledby="addNewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewModalLabel">Thêm Mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addNewForm" method="POST" action="{{ route('system.services.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="serviceName" class="form-label">Tên dịch vụ</label>
                                    <input type="text" name="name" class="form-control" id="serviceName"
                                        placeholder="Nhập tên dịch vụ" value="{{ old('name') }}">
                                    <div class="text-danger" id="nameError"></div> <!-- Thêm div để hiển thị lỗi -->
                                </div>
                                <div class="mb-3">
                                    <label for="servicePrice" class="form-label">Giá tiền</label>
                                    <input data-intro="Giá tiền phải có dạng 100000" autocomplete="off" type="text"
                                        aria-label="price" name="price" class="form-control priceInput"
                                        id="servicePrice" placeholder="Nhập giá tiền" value="{{ old('price') }}">
                                    <div class="text-danger" id="priceError"></div> <!-- Thêm div để hiển thị lỗi -->
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="category-select" class="form-label">Nhóm dịch vụ</label>
                                    <select name="directory" id="category-select" class="form-control">
                                    </select>
                                    <div class="text-danger" id="directoryError"></div> <!-- Thêm div để hiển thị lỗi -->
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Trạng thái</label>
                                    <select class="form-select" id="statusSelect" name="status">
                                        <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Ngừng hoạt động
                                        </option>
                                        <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Hoạt động
                                        </option>
                                    </select>
                                    <div class="text-danger" id="statusError"></div> <!-- Thêm div để hiển thị lỗi -->
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="code" class="form-control"
                            value="{{ strtoupper(Str::random(10)) }}">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" form="addNewForm" class="btn btn-primary">Lưu</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="editModal" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Chỉnh Sửa Dịch Vụ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="POST" action="">
                        @csrf
                        @method('PATCH')

                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="serviceName" class="form-label">Tên dịch vụ</label>
                                    <input type="hidden" name="old_name" id="old_name">
                                    <input type="text" name="name" class="form-control" id="serviceNameUpdate"
                                        placeholder="Nhập tên dịch vụ" value="{{ old('name') }}">
                                    <div class="text-danger" id="nameErrorUpdate"></div>
                                </div>

                                <div class="mb-3">
                                    <label for="servicePrice" class="form-label">Giá tiền</label>
                                    <input data-intro="Giá tiền phải có dạng 100000" autocomplete="off" type="text"
                                        name="price" autocomplete="off" class="form-control priceInput"
                                        id="servicePriceUpdate" placeholder="Nhập giá tiền" aria-label="price"
                                        value="{{ old('price') }}">
                                    <div class="text-danger" id="priceErrorUpdate"></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="category-select" class="form-label">Nhóm dịch vụ</label>
                                    <select name="directory" id="category-selectUpdate" class="form-control"></select>
                                    <div class="text-danger" id="directoryErrorUpdate"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Trạng thái</label>
                                    <select class="form-select" id="statusSelectUpdate" name="status">
                                        <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Ngừng hoạt động
                                        </option>
                                        <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Hoạt động
                                        </option>
                                    </select>
                                    <div class="text-danger" id="statusErrorUpdate"></div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="service_id" id="service_id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" form="editForm" class="btn btn-primary">Lưu</button>
                </div>
            </div>
        </div>
    </div>


    @push('scripts')
        <script>
            $(document).ready(function() {
                // Gắn sự kiện onchange cho select
                $('#itemsPerPage').on('change', function() {
                    // Lấy giá trị của select
                    var itemsPerPage = $(this).val();

                    // Lấy URL hiện tại
                    var url = new URL(window.location.href);

                    // Thêm hoặc cập nhật tham số itemsPerPage trong URL
                    url.searchParams.set('itemsPerPage', itemsPerPage);

                    // Thực hiện điều hướng (reload trang với tham số itemsPerPage mới)
                    window.location.href = url.toString();
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                // Cấu hình Select2 cho modal thêm mới
                $('#category-select').select2({
                    dropdownParent: $('#addNewModal'),
                    ajax: {
                        url: '/system/services/listservice',
                        type: 'get',
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                searchItem: params.term,
                                page: params.page || 1
                            };
                        },
                        processResults: function(data, params) {
                            params.page = params.page || 1;
                            return {
                                results: data.data.map(function(item) {
                                    return {
                                        id: item.directory_id, // id từ dữ liệu
                                        text: item.name // Hiển thị tên danh mục
                                    };
                                }),
                                pagination: {
                                    more: data.last_page != params.page
                                }
                            };
                        },
                        cache: true
                    },
                    placeholder: 'Chọn danh mục',
                    minimumInputLength: 0,
                    width: '100%',
                    allowClear: true
                });
                const oldDirectoryValue = "{{ old('directory') }}"; // Lấy giá trị old của trường 'directory'
                if (oldDirectoryValue) {
                    $('#category-select').val(oldDirectoryValue).trigger('change'); // Gán giá trị old vào select2
                }
                // Cấu hình Select2 cho modal chỉnh sửa
                $('#category-selectUpdate').select2({
                    dropdownParent: $('#editModal'),
                    ajax: {
                        url: '/system/services/listservice',
                        type: 'get',
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                searchItem: params.term,
                                page: params.page || 1
                            };
                        },
                        processResults: function(data, params) {
                            params.page = params.page || 1;
                            return {
                                results: data.data.map(function(item) {
                                    return {
                                        id: item.directory_id, // id từ dữ liệu
                                        text: item.name // Hiển thị tên danh mục
                                    };
                                }),
                                pagination: {
                                    more: data.last_page != params.page
                                }
                            };
                        },
                        cache: true
                    },
                    placeholder: 'Chọn danh mục',
                    minimumInputLength: 0,
                    width: '100%',
                    allowClear: true
                });

                // Khi người dùng nhấn vào nút chỉnh sửa
                $('.edit-btn').on('click', function() {
                    var id = $(this).data('id'); // Lấy id từ thuộc tính data-id của nút chỉnh sửa

                    $.ajax({
                        url: '/system/services/edit/' + id, // URL lấy thông tin dịch vụ
                        type: 'GET',
                        success: function(response) {
                            if (response.success && response.service) {
                                // Điền dữ liệu vào form trong modal
                                $('#serviceNameUpdate').val(response.service.name);
                                $('#servicePriceUpdate').val(response.service.price);
                                $('#category-selectUpdate').append(new Option(response.service
                                    .service_directory_foreign_key.name, response.service
                                    .directory_id, true, true)).trigger('change');
                                $('#statusSelectUpdate').val(response.service.status);
                                $('#service_id').val(response.service.row_id);
                                $('#old_name').val(response.old_name);
                                // Mở modal chỉnh sửa
                                $('#editModal').modal('show');
                            } else {
                                alert("Không thể lấy dữ liệu dịch vụ.");
                            }
                        },
                        error: function() {
                            alert("Có lỗi xảy ra khi lấy dữ liệu.");
                        }
                    });
                });

                // Khi người dùng nhấn nút lưu (thêm mới dịch vụ)
                $('#addNewForm').on('submit', function(event) {
                    event.preventDefault();

                    $.ajax({
                        url: $(this).attr('action'),
                        method: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            $('#addNewModal').modal('hide'); // Đóng modal sau khi cập nhật
                                window.location.reload();
                            if (response.success) {
                                toastr.success(response.message);
                                setTimeout(() => {
                                    location.reload();
                                }, 2000);
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function(xhr) {
                            $('#nameError').text('');
                            $('#priceError').text('');
                            $('#directoryError').text('');
                            $('#statusError').text('');

                            let errors = xhr.responseJSON.errors;
                            if (errors.name) {
                                $('#nameError').text(errors.name[0]);
                            }
                            if (errors.price) {
                                $('#priceError').text(errors.price[0]);
                            }
                            if (errors.directory) {
                                $('#directoryError').text(errors.directory[0]);
                            }
                            if (errors.status) {
                                $('#statusError').text(errors.status[0]);
                            }
                        }
                    });


                });


                $('#editForm').on('submit', function(event) {
                    event.preventDefault();

                    var serviceId = $('#service_id').val();
                    var oldName = $('#serviceNameUpdate').val();

                    if (!serviceId) {
                        alert('ID dịch vụ không hợp lệ!');
                        return;
                    }

                    $(this).attr('action', '/system/services/update/' + serviceId);



                    $.ajax({
                        url: $(this).attr('action'),
                        method: 'PATCH',
                        data: $(this).serialize(),
                        success: function(response) {
                            $('#editModal').modal('hide');
                            if (response.success) {
                                toastr.success(response.message);

                                location.reload();

                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function(xhr) {

                            $('#nameErrorUpdate').text('');
                            $('#priceErrorUpdate').text('');
                            $('#directoryErrorUpdate').text('');
                            $('#statusErrorUpdate').text('');

                            let errors = xhr.responseJSON.errors;

                            if (errors.name) {
                                $('#nameErrorUpdate').text(errors.name[0]);
                            }
                            if (errors.price) {
                                $('#priceErrorUpdate').text(errors.price[0]);
                            }
                            if (errors.directory) {
                                $('#directoryErrorUpdate').text(errors.directory[0]);
                            }
                            if (errors.status) {
                                $('#statusErrorUpdate').text(errors.status[0]);
                            }
                        }
                    });
                });

            });
        </script>
        <script>
            document.addEventListener('click', function(e) {
                const deleteButton = e.target.closest('.btn-danger');

                // Bỏ qua nếu nút là nút "Xóa nhiều"
                if (deleteButton && !deleteButton.classList.contains('multiple-delete')) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Bạn có chắc chắn muốn xóa?',
                        text: "Hành động này không thể hoàn tác!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Xóa',
                        cancelButtonText: 'Hủy'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const rowId = deleteButton.getAttribute('data-id');
                            const deleteUrl = '/system/services/delete/' + rowId;
                            window.location.href = deleteUrl;
                        }
                    });
                }
            });
        </script>
        <script>
            document.getElementById('deleteButton').addEventListener('click', function(e) {
                e.preventDefault();

                // Lấy danh sách các checkbox đã chọn
                var selectedCheckboxes = document.querySelectorAll('input[name="row_id[]"]:checked');
                var selectedIds = [];

                selectedCheckboxes.forEach(function(checkbox) {
                    selectedIds.push(checkbox.value);
                });

                if (selectedIds.length > 0) {
                    Swal.fire({
                        title: 'Bạn có chắc chắn muốn xóa?',
                        text: "Hành động này không thể hoàn tác!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Xóa',
                        cancelButtonText: 'Hủy'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: './services/multipledelete', // Đường dẫn tới route xóa
                                type: 'POST', // Sử dụng POST
                                data: {
                                    _token: '{{ csrf_token() }}', // Token CSRF
                                    row_id: selectedIds
                                },
                                success: function(response) {
                                    toastr.success('Các dịch vụ đã được xóa thành công.');

                                    location.reload();

                                },
                                error: function(xhr, status, error) {
                                    toastr.error('Đã xảy ra lỗi khi xóa dịch vụ.');
                                }
                            });
                        }
                    });
                } else {
                    toastr.error('Vui lòng chọn ít nhất một dịch vụ để xóa');
                }
            });
        </script>
        <script>
            $(document).ready(function() {
                // Khi người dùng chuyển tab, cập nhật giá trị của input ẩn "tabInput"
                $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
                    const activeTab = $(e.target).attr('id');
                    if (activeTab === 'nav-home-tab') {
                        $('#tabInput').val(0); // Tab "Hoạt động"
                    } else if (activeTab === 'nav-profile-tab') {
                        $('#tabInput').val(1); // Tab "Không hoạt động"
                    }
                });

                // Sự kiện khi nhấn nút tìm kiếm
                $('#searchButton').on('click', function() {
                    // Trước khi gửi form, đảm bảo giá trị của "tabInput" đã được cập nhật đúng
                    $('#searchForm').submit();
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                // Tạo khóa lưu trữ duy nhất dựa trên đường dẫn URL hiện tại để tránh xung đột
                const uniqueKey = 'activeTabId_' + window.location.pathname;

                // Khi người dùng click vào tab, lưu trạng thái của tab vào sessionStorage với tên khóa duy nhất
                $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
                    const activeTabId = $(e.target).attr('id'); // Lấy ID của tab đang hoạt động
                    sessionStorage.setItem(uniqueKey,
                        activeTabId); // Lưu ID của tab vào sessionStorage với khóa duy nhất
                });

                // Khi trang được tải lại, kiểm tra sessionStorage và kích hoạt tab đã lưu trong đó
                const activeTabId = sessionStorage.getItem(uniqueKey);
                if (activeTabId) {
                    $('#' + activeTabId).tab('show'); // Kích hoạt tab được lưu trong sessionStorage
                }
            });
        </script>
        <script>
            // Lắng nghe sự kiện focus cho tất cả các phần tử có class "priceInput"
            document.querySelectorAll('.priceInput').forEach(function(element) {
                element.addEventListener('focus', function() {
                    // Chỉ gọi introJs khi input này được focus (con trỏ chuột vào input)
                    introJs()
                        .setOptions({
                            steps: [{
                                element: '#' + element.id, // Lấy ID của input hiện tại
                                intro: 'Giá tiền cần đúng định dạng VD 1000.',
                                position: 'bottom'
                            }],
                            showStepNumbers: false, // Tắt số bước
                            exitOnEsc: true, // Cho phép thoát tour khi nhấn ESC
                            hidePrev: true, // Ẩn nút "Quay lại"
                            hideNext: true, // Ẩn nút "Tiếp theo"
                            doneLabel: 'Hoàn thành', // Tùy chỉnh nhãn nút "Hoàn thành"
                            showBullets: false, // Ẩn các điểm bullets
                            overlayOpacity: 0.8, // Độ mờ nền overlay
                            disableInteraction: true // Ngừng tương tác cho đến khi tour hoàn tất
                        })
                        .oncomplete(function() {
                            // Bạn có thể thêm logic sau khi tour hoàn tất
                            console.log('Tour hoàn tất!');
                        })
                        .start();
                });
            });
        </script>
    @endpush
@endsection
