@extends('layouts.admin.master')
@section('Quản lí danh mục dịch vụ')
@section('content')
    <div class="card w-100">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center m-1 mb-2">
                <a href="{{ route('system.serviceTypes.resetsearch') }}" class="card-title">
                    <h3>Quản lý danh mục dịch vụ</h3>
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
            <div class="row align-items-center me-0 mb-3">
                <!-- Tìm kiếm và nút xóa -->
                <div class="col-12 col-md-6 col-sm-2 d-flex align-items-center mb-3 mb-md-0">
                    <form id="searchForm" action="{{ route('system.serviceTypes.search') }}" method="GET"
                        class="d-flex align-items-center">
                        <div class="w-40">
                            <input type="text" name="search" id="searchInput" class="form-control"
                                value="{{ request('search', $search) }}" placeholder="Nhập tên danh mục dịch vụ">
                        </div>
                        <input type="hidden" name="tab" class="tab" id="tabInput" value="0">
                        <button type="submit" class="btn btn-success" id="searchButton">
                            <i class="ti ti-search"></i>
                        </button>
                    </form>
                    {{-- <button type="button" id="deleteButton" class="btn btn-danger ms-2 multiple-delete">
                        <i class="ti ti-trash"></i>
                    </button> --}}
                </div>

                <!-- Chọn số lượng hiển thị nằm trên cùng một hàng -->
                {{-- <div class="col-auto ms-auto d-flex align-items-center">
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
                </div> --}}
            </div>

            <div class="tab-content" id="nav-tabContent">
                <!-- Tab Dịch vụ hoạt động -->
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="table-responsive ">
                        <table class="table table-bordered text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr class="text-center">
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Mã nhóm dịch vụ</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Tên nhóm dịch vụ</h6>
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
                                @if ($serviceType->isEmpty())
                                <div id="noResults" class="alert alert-warning">Không tìm thấy dữ liệu.</div>
                                @else
                                    @foreach ($serviceType as $data)
                                        <tr class="order-row text-center">
                                            <td class="border-bottom-0">
                                                <p class="fw-semibold mb-0">{{ $data->directory_id }}</p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-semibold"
                                                    style="word-wrap: break-word; overflow-wrap: break-word;
                                                    white-space: normal; max-width: 100%; word-break: normal;">
                                                    {{ $data->name }}
                                                </p>
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
                                                    data-name="{{ $data->name }}" data-status="{{ $data->status }}">
                                                    <i class="ti ti-pencil"></i>
                                                </a>
                                                <a data-id="{{ $data->row_id }}"
                                                    data-direcrtory="{{ $data->directory_id }}"
                                                    class="btn btn-danger me-1">
                                                    <i class="ti ti-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>

                        <div class="mt-3 d-flex justify-content-center">
                            {{ $serviceType->links() }}
                        </div>
                    </div>
                </div>

                <!-- Tab Dịch vụ không hoạt động -->
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <div class="table-responsive ">
                        <table class="table table-bordered text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr class="text-center">
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Mã nhóm dịch vụ</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Tên nhóm dịch vụ</h6>
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
                                @if ($serviceTypeInactive->isEmpty())
                                <div id="noResults" class="alert alert-warning">Không tìm thấy dữ liệu.</div>
                                @else
                                    @foreach ($serviceTypeInactive as $data)
                                        <tr class="order-row text-center">
                                            <td class="border-bottom-0">
                                                <p class="fw-semibold mb-0">{{ $data->directory_id }}</p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-semibold"
                                                    style="word-wrap: break-word; overflow-wrap: break-word;
                                                    white-space: normal; max-width: 100%; word-break: normal;">
                                                    {{ $data->name }}
                                                </p>
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
                                                    data-name="{{ $data->name }}" data-status="{{ $data->status }}">
                                                    <i class="ti ti-pencil"></i>
                                                </a>
                                                <a data-id="{{ $data->row_id }}"
                                                    data-direcrtory="{{ $data->directory_id }}"
                                                    class="btn btn-danger me-1">
                                                    <i class="ti ti-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>

                        <div class="mt-3 d-flex justify-content-center">
                            {{ $serviceTypeInactive->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addNewModal" tabindex="-1" aria-labelledby="addNewModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addNewModalLabel">Thêm Mới</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Nội dung của modal -->
                        <form id="addNewForm" method="POST" action="{{ route('system.serviceTypes.store') }}">
                            @csrf <!-- CSRF token cần thiết cho request POST -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Tên nhóm dịch vụ</label>
                                <input type="text" name="name" id="name" class="form-control">
                                <div class="text-danger" id="nameError"></div> <!-- Thêm div để hiển thị lỗi -->
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Trạng thái</label>
                                <select class="form-select" id="statusSelect" name="status">
                                    <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Ngừng hoạt động
                                    </option>
                                    <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Hoạt động</option>
                                </select>
                                <div class="text-danger" id="statusError"></div> <!-- Thêm div để hiển thị lỗi -->
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

        <!-- Modal Chỉnh Sửa -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Chỉnh Sửa Nhóm Dịch Vụ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editForm" method="POST" action="">
                            @csrf
                            @method('PATCH')

                            <!-- Tên nhóm dịch vụ -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Tên nhóm dịch vụ</label>
                                <input type="text" name="name" class="form-control" id="name_servicetype">
                                <input type="hidden" name="old_name" id="old_name">
                                <div class="text-danger" id="nameError1"></div>
                            </div>

                            <!-- Trạng thái -->
                            <div class="mb-3">
                                <label for="status" class="form-label">Trạng thái</label>
                                <select class="form-select" name="status" id="status">
                                    <option value="0">Hoạt động</option>
                                    <option value="1">Ngừng hoạt động</option>
                                </select>
                                <div class="text-danger" id="statusError1"></div>
                            </div>

                            <input type="hidden" name="directory_id" id="directory_id">
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
            {{-- <script>
                document.getElementById('deleteButton').addEventListener('click', function(e) {
                    e.preventDefault();

                    // Lấy danh sách các checkbox đã chọn
                    var selectedCheckboxes = document.querySelectorAll('input[name="row_id[]"]:checked');
                    var selectedIds = [];
                    var directoryIds = [];

                    selectedCheckboxes.forEach(function(checkbox) {
                        selectedIds.push(checkbox.value);
                        // Tìm đến input hidden chứa directory_id tương ứng với checkbox đã chọn
                        var directoryInput = checkbox.closest('tr').querySelector('input[name="directory_id[]"]');
                        if (directoryInput) {
                            directoryIds.push(directoryInput.value);
                        }
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
                                    url: './serviceTypes/multipledelete', // Đường dẫn tới route xóa
                                    type: 'POST', // Sử dụng POST
                                    data: {
                                        _token: '{{ csrf_token() }}', // Token CSRF
                                        row_id: selectedIds,
                                        directory_id: directoryIds // Thêm directory_id vào dữ liệu gửi đi
                                    },
                                    success: function(response) {
                                        toastr.success('Các dịch vụ đã được xóa thành công.');

                                        location
                                            .reload(); // Tải lại trang sau khi xóa thành công

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
            </script> --}}
            {{-- <script>
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
            </script> --}}
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
                                const directoryId = deleteButton.getAttribute('data-direcrtory');

                                // Tạo URL xóa chính xác
                                const deleteUrl = '/system/serviceTypes/delete/' + rowId + '/' + directoryId;

                                // Điều hướng đến URL để thực hiện xóa
                                window.location.href = deleteUrl;
                            }
                        });
                    }
                });
            </script>
            <script>
                $(document).ready(function() {
                    $('#addNewForm').on('submit', function(event) {
                        event.preventDefault();

                        $.ajax({
                            url: $(this).attr('action'), // Lấy URL từ thuộc tính action của form
                            method: "POST",
                            data: $(this).serialize(), // Serialize dữ liệu form
                            success: function(response) {
                                $('#addNewModal').modal('hide');
                                toastr.success(response.message);

                                location.reload();

                            },
                            error: function(response) {
                                // Xóa thông báo lỗi cũ
                                $('#nameError').text('');
                                $('#statusError').text('');

                                // Hiển thị lỗi xác thực từ Laravel ValidationRequest
                                if (response.status === 422) {
                                    const errors = response.responseJSON.errors;
                                    if (errors.name) {
                                        $('#nameError').text(errors.name[0]);
                                    }
                                    if (errors.status) {
                                        $('#statusError').text(errors.status[0]);
                                    }
                                }
                            }
                        });
                    });
                });
            </script>
            <script>
                $(document).ready(function() {
                    // Khi người dùng nhấn vào nút chỉnh sửa
                    $('.edit-btn').on('click', function() {
                        var id = $(this).data('id'); // Lấy id từ thuộc tính data-id
                        $.ajax({
                            url: '/system/serviceTypes/edit/' + id, // URL lấy thông tin chỉnh sửa
                            type: 'GET',
                            success: function(response) {
                                console.log(response); // Kiểm tra xem dữ liệu có đúng không
                                if (response && response.success && response.servicetype) {
                                    // Điền dữ liệu vào form trong modal
                                    $('#name_servicetype').val(response.servicetype.name);
                                    $('#status').val(response.servicetype.status);
                                    $('#editForm').attr('action', '/system/serviceTypes/update/' +
                                        response.servicetype.row_id);

                                    // Gán old_name bằng giá trị ban đầu của tên dịch vụ để kiểm tra unique
                                    $('#old_name').val(response.servicetype.name);

                                    // Mở modal
                                    $('#editModal').modal('show');
                                } else {
                                    toastr.error("Không thể lấy dữ liệu chỉnh sửa.");
                                }
                            },
                            error: function() {
                                toastr.error("Có lỗi xảy ra khi lấy dữ liệu");
                            }
                        });
                    });
                });


                // Khi người dùng nhấn nút lưu
                $('#editForm').on('submit', function(event) {
                    event.preventDefault(); // Ngừng hành động mặc định của form (tránh reload trang)

                    // Gửi AJAX request để cập nhật dữ liệu
                    $.ajax({
                        url: $(this).attr('action'), // URL lấy từ thuộc tính action của form
                        method: 'POST',
                        data: $(this).serialize(), // Serialize form data
                        success: function(response) {
                            $('#editModal').modal('hide');
                            if (response.success) {
                                toastr.success(response.message);
                                setTimeout(() => {
                                    location.reload();
                                }, 1500);
                            } else {
                                toastr.error('Cập nhóm dịch vụ thất bại');
                            }
                        },
                        error: function(response) {

                            $('#nameError1').text('');
                            $('#statusError1').text('');

                            if (response.status === 422) {
                                const errors = response.responseJSON.errors;
                                if (errors.name) {
                                    $('#nameError1').text(errors.name[0]);
                                }
                                if (errors.status) {
                                    $('#statusErro1r').text(errors.status[0]);
                                }
                            }
                        }
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
        @endpush
    @endsection
