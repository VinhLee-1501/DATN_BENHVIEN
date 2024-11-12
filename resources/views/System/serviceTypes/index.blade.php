@extends('layouts.admin.master')

@section('content')
    <div class="card w-100">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center m-1 mb-2">
                <a href="{{ route('system.serviceTypes.resetsearch') }}" class="card-title">
                    <h3>Quản lý nhóm dịch vụ</h3>
                </a>
                <div>
                    <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addNewModal">Thêm mới</a>
                </div>
            </div>
            <div class="nav nav-tabs mb-2" id="nav-tab" role="tablist">
                <a class="nav-link {{ request()->routeIs('system.serviceType') ? 'active' : '' }}" id="nav-home-tab"
                    href="{{ route('system.serviceType') }}">
                    Hoạt động
                </a>

                <a class="nav-link {{ request()->routeIs('system.serviceTypes.inactive') ? 'active' : '' }}"
                    id="nav-profile-tab" href="{{ route('system.serviceTypes.inactive') }}">
                    Dừng
                </a>
            </div>
            <div class="table">
                @if (isset($serviceType))
                    <form id="searchForm" action="{{ route('system.serviceType') }}" method="get"
                        class="d-flex position-relative">
                    @else
                        <form id="searchForm" action="{{ route('system.serviceTypes.inactive') }}" method="get"
                            class="d-flex position-relative">
                @endif
                <input type="text" name="search" id="searchInput" class="form-control"
                    value="{{ request('search', $search) }}" placeholder="Nhập mã"
                    style="border-top-right-radius: 0; border-bottom-right-radius: 0; width:214px;">
                <button type="submit" class="btn btn-success position-absolute px-0"
                    style="top: 50%; right: 75%; transform: translateY(-50%); z-index: 1; border-top-left-radius: 0; border-bottom-left-radius: 0;">
                    <i class="ti ti-search"></i>
                </button>
                <button type="button" id="deleteButton" class="btn btn-danger position-absolute px-0"
                    style="left: 27%; top: 50%; transform: translateY(-50%);">
                    <i class="ti ti-trash"></i>
                </button>
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

                <form id="deleteForm" action="{{ route('system.serviceTypes.multipledelete') }}" method="POST">
                    @csrf
                    @method('delete')
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th></th>
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
                                    <h6 class="fw-semibold mb-0">Hành động</h6>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            @if (isset($serviceType))
                                @if ($serviceType->isEmpty())
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <h5 class="text-muted">Không tìm thấy kết quả nào</h5>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($serviceType as $data)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="row_id[]" value="{{ $data->row_id }}"
                                                    class="blogCheckbox">
                                                <input type="hidden" name="directory_id[]"
                                                    value="{{ $data->directory_id }}">
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="fw-semibold mb-0">{{ $data->directory_id }}</p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-semibold text-break w-100">{{ $data->name }}</p>
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
                                                    data-name="{{ $data->name }}" data-status="{{ $data->status }}">
                                                    <i class="ti ti-pencil"></i>
                                                </a>
                                                <a href="{{ route('system.serviceTypes.delete', ['row_id' => $data->row_id, 'directory_id' => $data->directory_id]) }}"
                                                    class="btn btn-danger me-1">
                                                    <i class="ti ti-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endif

                            @if (isset($serviceType_inactive))
                                @if ($serviceType_inactive->isEmpty())
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <h5 class="text-muted">Không tìm thấy kết quả nào</h5>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($serviceType_inactive as $data)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="row_id[]" value="{{ $data->row_id }}"
                                                    class="blogCheckbox">
                                                <input type="hidden" name="directory_id[]"
                                                    value="{{ $data->directory_id }}">
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="fw-semibold mb-0">{{ $data->directory_id }}</p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-semibold text-break w-100">{{ $data->name }}</p>
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
                                                    data-name="{{ $data->name }}" data-status="{{ $data->status }}">
                                                    <i class="ti ti-pencil"></i>
                                                </a>
                                                <a href="{{ route('system.serviceTypes.delete', ['row_id' => $data->row_id, 'directory_id' => $data->directory_id]) }}"
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
                    @if (isset($serviceType))
                        {{ $serviceType->links() }}
                    @else
                        {{ $serviceType_inactive->links() }}
                    @endif
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
                                <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Dừng</option>
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
                                <option value="1">Dừng</option>
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
        <script>
            document.getElementById('deleteButton').addEventListener('click', function() {
                var selectedCheckboxes = document.querySelectorAll('input[name="row_id[]"]:checked');
                var selectedIds = [];
                var directoryId = [];

                // Lấy tất cả row_id đã chọn
                selectedCheckboxes.forEach(function(checkbox) {
                    selectedIds.push(checkbox.value);

                    // Lấy directory_id từ checkbox đầu tiên được chọn
                    if (!directoryId) {
                        directoryId = checkbox.closest('tr').querySelector('.directory_id').value;
                    }
                });

                // Kiểm tra nếu có ít nhất một checkbox được chọn
                if (selectedIds.length > 0) {
                    var form = document.getElementById('deleteForm');

                    // Thêm row_id vào form
                    selectedIds.forEach(function(id) {
                        var input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'row_id[]';
                        input.value = id;
                        form.appendChild(input);
                    });

                    // Thêm directory_id vào form nếu có
                    if (directoryId) {
                        var directoryInput = document.createElement('input');
                        directoryInput.type = 'hidden';
                        directoryInput.name = 'directory_id';
                        directoryInput.value = directoryId;
                        form.appendChild(directoryInput);
                    }

                    // Gửi form
                    form.submit();
                } else {
                    toastr.error('Vui lòng chọn ít nhất một nhóm dịch vụ để xóa.');
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
            document.addEventListener('DOMContentLoaded', function() {
                // Lấy tất cả các thẻ a có class 'nav-link'
                const tabLinks = document.querySelectorAll('.nav-link');

                tabLinks.forEach(tabLink => {
                    tabLink.addEventListener('click', function() {
                        // Loại bỏ class 'active' khỏi tất cả các thẻ a
                        tabLinks.forEach(link => link.classList.remove('active'));
                        // Thêm class 'active' vào thẻ a được nhấn
                        this.classList.add('active');
                    });
                });
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
                            setTimeout(() => {
                                location.reload();
                            }, 3000);
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
                            }, 3000);
                        }else{
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
    @endpush
@endsection
