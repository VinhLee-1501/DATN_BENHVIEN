@extends('layouts.admin.master')

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
            <div class="nav nav-tabs mb-2" id="nav-tab" role="tablist">
                <a class="nav-link {{ request()->routeIs('system.service') ? 'active' : '' }}" id="nav-home-tab"
                    href="{{ route('system.service') }}">
                    Hoạt động
                </a>
                <a class="nav-link {{ request()->routeIs('system.services.inactive') ? 'active' : '' }}"
                    id="nav-profile-tab" href="{{ route('system.services.inactive') }}">
                    Dừng
                </a>
            </div>
            <div class="table">
                @if (isset($service))
                    <form id="searchForm" action="{{ route('system.service') }}" class="d-flex position-relative"
                        method="get">
                    @else
                        <form id="searchForm" action="{{ route('system.services.inactive') }}"
                            class="d-flex position-relative" method="get">
                @endif
                <input type="text" name="search" id="searchInput" class="form-control"
                    value="{{ request('search', $search) }}" placeholder="Nhập mã"
                    style="border-top-right-radius: 0; border-bottom-right-radius: 0; width:214px;">
                <!-- Nút tìm kiếm -->
                <button type="submit" class="btn btn-success position-absolute px-0"
                    style="top: 50%; right: 75%; transform: translateY(-50%); z-index: 1; border-top-left-radius: 0; border-bottom-left-radius: 0;">
                    <i class="ti ti-search"></i>
                </button>
                <button type="button" id="deleteButton" class="btn btn-danger position-absolute px-0"
                    style="left: 27%; top: 50%; transform: translateY(-50%);"><i class="ti ti-trash"></i></button>
                <div class="position-absolute" style="right: 0%; top: 50%; transform: translateY(-50%);">
                    <div class="d-flex ">
                        <span class="me-2 mt-2">Hiển thị:</span>
                        <select class="form-select" id="itemsPerPage" aria-label="Items per page" style="width: auto;">
                            <option value="5" {{ request()->input('itemsPerPage', 5) == 5 ? 'selected' : '' }}>5
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

                </form>

                <!-- Form Xóa Bài Viết -->
                {{-- <form id="deleteForm" action="{{ route('system.services.multipledelete') }}" method="POST"> --}}
                    @csrf
                    @method('delete')
                    <table class="table text-nowrap mb-0 align-middle">
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
                                    <h6 class="fw-semibold mb-0">Hành động</h6>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            @if (isset($service))
                                @if ($service->isEmpty())
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <h5 class="text-muted">Không tìm thấy kết quả nào
                                            </h5>
                                        </td>
                                    </tr>
                                @else
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
                                                <p class="mb-0 fw-semibold text-break w-100">{{ $data->name }}</p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="fw-semibold mb-0">
                                                    {{ number_format($data->price * 1000, 0, ',', '.') }} VND</p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="fw-semibold mb-0">{{ $data->serviceDirectoryForeignKey->name }}
                                                </p>
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
                                                <form action="{{ route('system.services.delete', $data->row_id) }}"
                                                    id="form-delete{{ $data->row_id }}" method="post">
                                                    @method('delete')
                                                    @csrf
                                                </form>
                                                <button type="submit" class="btn btn-danger btn-delete"
                                                    data-id="{{ $data->row_id  }}">
                                                    <i class="ti ti-trash"></i>
                                                </button>

                                            
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            @else
                                @if ($service_inactive->isEmpty())
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <h5 class="text-muted">Không tìm thấy kết quả nào
                                            </h5>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($service_inactive as $data)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="row_id[]" value="{{ $data->row_id }}"
                                                    class="blogCheckbox">
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="fw-semibold mb-0">{{ $data->service_id }}</p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-semibold text-break w-100">{{ $data->name }}</p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="fw-semibold mb-0">
                                                    {{ number_format($data->price * 1000, 0, ',', '.') }} VND</p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="fw-semibold mb-0">{{ $data->serviceDirectoryForeignKey->name }}
                                                </p>
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
                                                <a href="{{ route('system.services.delete', $data->row_id) }}"
                                                    class="btn btn-danger me-1">
                                                    <i class="ti ti-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endif
                        </tbody>
                    </table>
                </form>
                <div class="mt-3 d-flex justify-content-center">
                    @if (isset($service))
                        {{ $service->links() }}
                    @else
                        {{ $service_inactive->links() }}
                    @endif
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
                                    <input type="text" name="price" class="form-control" id="servicePrice"
                                        placeholder="Nhập giá tiền" aria-label="price" value="{{ old('price') }}">
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
                                        <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Dừng</option>
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
                                    <input type="text" name="price" class="form-control" id="servicePriceUpdate"
                                        placeholder="Nhập giá tiền" aria-label="price" value="{{ old('price') }}">
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
                                        <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Dừng</option>
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
            document.getElementById('deleteButton').addEventListener('click', function() {
                var selectedCheckboxes = document.querySelectorAll('input[name="row_id[]"]:checked');
                var selectedIds = [];

                // Lấy tất cả row_id đã chọn
                selectedCheckboxes.forEach(function(checkbox) {
                    selectedIds.push(checkbox.value);
                });

                // Kiểm tra nếu có ít nhất một checkbox được chọn
                if (selectedIds.length > 0) {
                    // Thêm các row_id đã chọn vào form
                    var form = document.getElementById('deleteForm');
                    form.innerHTML += selectedIds.map(id => `<input type="hidden" name="row_id[]" value="${id}">`)
                        .join('');

                    // Gửi form
                    form.submit();
                } else {
                    toastr.error('Vui lòng chọn ít nhất một dịch vụ để xóa.');
                }
            });
        </script>
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
                            $('#addNewModal').modal('hide');
                            if (response.success) {
                                toastr.success(response.message);
                                setTimeout(() => {
                                    location.reload();
                                }, 3000);
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function(xhr) {
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

                    $('#nameErrorUpdate').text('');
                    $('#priceErrorUpdate').text('');
                    $('#directoryErrorUpdate').text('');
                    $('#statusErrorUpdate').text('');


                    $.ajax({
                        url: $(this).attr('action'),
                        method: 'PATCH',
                        data: $(this).serialize(),
                        success: function(response) {
                            $('#editModal').modal('hide');
                            if (response.success) {
                                toastr.success(response.message);
                                setTimeout(() => {
                                    location.reload();
                                }, 3000);
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function(xhr) {
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
    @endpush
@endsection
