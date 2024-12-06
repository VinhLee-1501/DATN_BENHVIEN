@extends('layouts.admin.master')
@section('Quản lí mã giảm giá')
@section('content')
    <div class="card w-100">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center m-1 mb-4">
                <a href="{{ route('system.coupon.resetsearch') }}" class="card-title">
                    <h3>Quản lý mã giảm giá</h3>
                </a>
                <div>
                    <a href="{{ route('system.coupons.create') }}" class="btn btn-success">Thêm mới</a>
                </div>
            </div>
            <nav class="mb-4">
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                        type="button" role="tab" aria-controls="nav-home" aria-selected="true">Còn hạn</button>
                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                        type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Hết hạn</button>
                </div>
            </nav>
            <div class="row align-items-center me-0 mb-3">
                <!-- Tìm kiếm và nút xóa -->
                <div class="col-12 col-md-6 col-sm-2 d-flex align-items-center mb-3 mb-md-0">
                    <form id="searchForm" action="{{ route('system.coupons.search') }}" method="GET"
                        class="d-flex align-items-center">
                        <div class="w-40">
                            <input type="text" name="search" id="searchInput" class="form-control"
                                value="{{ request('search', $search) }}" placeholder="Nhập mã">
                        </div>
                        <input type="hidden" name="tab" class="tab" id="tabInput" value="0">
                        <button type="submit" class="btn btn-success" id="searchButton">
                            <i class="ti ti-search"></i>
                        </button>
                    </form>
                </div>
            </div>

            <div class="tab-content" id="nav-tabContent">
                <!-- Tab Dịch vụ hoạt động -->
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="table-responsive ">
                        <table class="table table-bordered text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr class="text-center">
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Mã giảm giá</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Mô tả</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Ngày bắt đầu</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Ngày kết thúc</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Thao tác</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($couponsActive->isEmpty())
                                    <div id="noResults" class="alert alert-warning">Không tìm thấy dữ liệu.</div>
                                @else
                                    @foreach ($couponsActive as $data)
                                        <tr class="order-row text-center">
                                            <td class="border-bottom-0">
                                                <p class="fw-semibold mb-0">{{ $data->discount_code }}</p>
                                            </td>
                                            <td class="border-bottom-0 ">
                                                <p class="mb-0 fw-semibold"
                                                    style="word-wrap: break-word; overflow-wrap: break-word;
                                                    white-space: normal; max-width: 100%; word-break: normal;">
                                                    {{ $data->note }}
                                                </p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-semibold">
                                                    {{ Carbon\Carbon::parse($data->time_start)->format('d/m/Y') }}</p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-semibold">
                                                    {{ Carbon\Carbon::parse($data->time_end)->format('d/m/Y') }}</p>
                                            </td>
                                            <td class="border-bottom-0 d-flex justify-content-center align-items-center">
                                                <a href="{{ route('system.coupons.edit', $data->discount_code) }}"
                                                    class="btn btn-primary me-1">
                                                    <i class="ti ti-pencil"></i>
                                                </a>
                                                <a data-id="{{ $data->coupon_id }}" class="btn btn-danger me-1">
                                                    <i class="ti ti-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>

                        <div class="mt-3 d-flex justify-content-center">
                            {{ $couponsActive->links() }}
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
                                        <h6 class="fw-semibold mb-0">Mã giảm giá</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Mô tả</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Ngày bắt đầu</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Ngày kết thúc</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Thao tác</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($couponsExpired->isNotEmpty())
                                    @foreach ($couponsExpired as $data)
                                        <tr class="order-row text-center">
                                            <td class="border-bottom-0">
                                                <p class="fw-semibold mb-0">{{ $data->discount_code }}</p>
                                            </td>
                                            <td class="border-bottom-0 ">
                                                <p class="mb-0 fw-semibold"
                                                    style="word-wrap: break-word; overflow-wrap: break-word;
                                                    white-space: normal; max-width: 100%; word-break: normal;">
                                                    {{ $data->note }}
                                                </p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-semibold">
                                                    {{ Carbon\Carbon::parse($data->time_start)->format('d/m/Y') }}</p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-semibold">
                                                    {{ Carbon\Carbon::parse($data->time_end)->format('d/m/Y') }}t</p>
                                            </td>
                                            <td class="border-bottom-0 d-flex justify-content-center align-items-center">
                                                <a href="{{ route('system.coupons.edit', $data->discount_code) }}"
                                                    class="btn btn-primary me-1">
                                                    <i class="ti ti-pencil"></i>
                                                </a>
                                                <a data-id="{{ $data->coupon_id }}" class="btn btn-danger me-1">
                                                    <i class="ti ti-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <div id="noResults" class="alert alert-warning">Không tìm thấy dữ liệu.</div>
                                @endif
                            </tbody>
                        </table>
                        <div class="mt-3 d-flex justify-content-center">
                            {{ $couponsExpired->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
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
                            const couponId = deleteButton.getAttribute('data-id');
                            const deleteUrl = '/system/coupons/delete/' + couponId;
                            window.location.href = deleteUrl;
                        }
                    });
                }
            });
        </script>
        {{-- <script>
            document.getElementById('deleteButton').addEventListener('click', function(e) {
                e.preventDefault();

                // Lấy danh sách các checkbox đã chọn
                var selectedCheckboxes = document.querySelectorAll('input[name="coupon_id[]"]:checked');
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
                                url: './coupons/multipledelete', // Đường dẫn tới route xóa
                                type: 'POST', // Sử dụng POST
                                data: {
                                    _token: '{{ csrf_token() }}', // Token CSRF
                                    coupon_id: selectedIds
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
        </script> --}}
    @endpush
@endsection
