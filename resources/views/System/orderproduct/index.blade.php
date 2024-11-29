@extends('layouts.admin.master')

@section('content')
    <div class="card w-100">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center m-1 mb-4">
                <a href="{{ route('system.orderproduct.resetsearch') }}" class="card-title">
                    <h3>Quản lý hóa đơn mua hàng</h3>
                </a>
            </div>

            <nav class="mb-4">
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                        type="button" role="tab" aria-controls="nav-home" aria-selected="true">Chờ xác nhận</button>
                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                        type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Đang giao</button>
                    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact"
                        type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Đã giao</button>
                </div>
            </nav>
            <div class="row align-items-center me-0">
                <!-- Tìm kiếm và nút xóa -->
                <div class="col-12 col-md-6 col-sm-2 d-flex align-items-center mb-3 mb-md-0">
                    <form id="searchForm" action="{{ route('system.orderproduct') }}" method="GET"
                        class="d-flex align-items-center">
                        <div class="w-40">
                            <input type="text" name="search" id="searchInput" class="form-control" value=""
                                value="{{ request('search', $search) }}" placeholder="Nhập mã">
                        </div>
                        <input type="hidden" name="tab" class="tab" id="tabInput" value="0">
                        <button type="submit" class="btn btn-success" id="searchButton">
                            <i class="ti ti-search"></i>
                        </button>
                    </form>
                    <button type="button" id="deleteButton" class="btn btn-danger ms-2 multiple-delete"
                        style="display: none;">
                        <i class="ti ti-trash"></i>
                    </button>
                </div>

                <!-- Chọn số lượng hiển thị nằm trên cùng một hàng -->
                <div class="col-auto ms-auto d-flex align-items-center">
                    <span class="me-2 d-none d-sm-inline">Hiển thị:</span>
                    <select class="form-select d-none d-sm-inline" style="width: 75px" id="itemsPerPage" aria-label="Items per page">
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
            <div class="tab-content" id="nav-tabContent">
                <!-- Tab Dịch vụ hoạt động -->
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="table-responsive ">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Mã hóa đơn</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Khách hàng</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Ngày xuất bản</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Tổng tiền</h6>
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
                                @if ($ordersPendings->isEmpty())
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <h5 class="text-muted">Không tìm thấy kết quả nào</h5>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($ordersPendings as $data)
                                        <tr class="order-row">
                                            <td class="border-bottom-0">
                                                <p class="fw-semibold mb-0">{{ $data->order_id }}</p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-semibold">{{ $data->order_username }}
                                                </p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-semibold">
                                                    {{ Carbon\Carbon::parse($data->created_at)->format('d/m/Y | h:m:s') }}
                                                </p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-semibold">
                                                    @if (is_null($data->price_old))
                                                        {{ number_format($data->price_sale, 0, ',', '.') }} VND
                                                    @else
                                                        {{ number_format($data->price_old, 0, ',', '.') }} VND
                                                    @endif
                                                </p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="badge bg-danger mb-0 fw-semibold">Chưa xác nhận</p>
                                            </td>
                                            <td class="border-bottom-0 d-flex">
                                                <a href="{{ route('system.orderproduct.updateStatus', $data->order_id) }}"
                                                    class="btn btn-success me-1">
                                                    <i class="ti ti-check"></i>
                                                </a>
                                                <a class="btn btn-warning me-1" data-bs-toggle="collapse"
                                                    href="#collapse{{ $data->order_id }}" role="button"
                                                    aria-expanded="false" aria-controls="collapse{{ $data->order_id }}">
                                                    <i class="ti ti-arrow-narrow-down"></i>
                                                </a>
                                                <a data-id="{{ $data->order_id }}" class="btn btn-danger cancal me-1">
                                                    <i class="ti ti-ban"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr id="show">
                                            <td colspan="6">
                                                <div class="collapse" id="collapse{{ $data->order_id }}">
                                                    <div class="card card-body m-0">
                                                        <h6 class="fw-semibold mb-2 fs-5">Thông tin chi tiết:</h6>
                                                        <div class="col-md-12 d-flex mt-1">
                                                            <div class="col-md-6">
                                                                <p><strong>Mã đơn hàng:</strong> {{ $data->order_id }}</p>
                                                                <p><strong>Khách hàng:</strong> {{ $data->order_username }}</p>
                                                                <p><strong>Sđt:</strong> {{ $data->order_phone }}</p>
                                                                 <p><strong>Email</strong> {{ $data->email }}</p>
                                                                <p><strong>Địa chỉ:</strong> {{ $data->order_address }}</p>
                                                            </div>
                                                            @php
                                                                $product_names = explode(',', $data->product_names);
                                                            @endphp
                                                            <div class="col-md-6">
                                                                <p><strong>Số lượng:</strong> {{ $data->total_quantity }}
                                                                </p>
                                                                <p><strong>Hình thức thanh toán:</strong>
                                                                    @if ($data->payment_method == 0)
                                                                        Tiền mặt
                                                                    @elseif($data->payment_method == 1)
                                                                        Momo
                                                                    @elseif($data->payment_method == 2)
                                                                        VNpay
                                                                    @elseif($data->payment_method == 3)
                                                                        Zalopay
                                                                    @endif
                                                                </p>
                                                                <span class="d-flex"><strong>Sản phẩm:</strong>
                                                                    <ul>
                                                                        @foreach ($product_names as $data)
                                                                            <li
                                                                                style="word-wrap: break-word; overflow-wrap: break-word;
                                                                                white-space: normal; max-width: 100%; word-break: normal;">
                                                                                {{ trim($data) }}.</li>
                                                                        @endforeach
                                                                    </ul>
                                                                </span>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>

                        <div class="mt-3 d-flex justify-content-center">
                            {{ $ordersPendings->links() }}
                        </div>
                    </div>
                </div>

                <!-- Tab Dịch vụ không hoạt động -->
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <div class="table-responsive ">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Mã hóa đơn</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Khách hàng</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Ngày xuất bản</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Tổng tiền</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Trạng thái</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Thao tác</h6>
                                    </th>
                                </tr>
                            </thead>
                            @if ($ordersShippings->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <h5 class="text-muted">Không tìm thấy kết quả nào</h5>
                                    </td>
                                </tr>
                            @else
                                @foreach ($ordersShippings as $data)
                                    <tr class="order-row">
                                        <td class="border-bottom-0">
                                            <p class="fw-semibold mb-0">{{ $data->order_id }}</p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-semibold">{{ $data->order_username }}
                                            </p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-semibold">
                                                {{ Carbon\Carbon::parse($data->created_at)->format('d/m/Y | h:m:s') }}
                                            </p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-semibold">
                                                @if (is_null($data->price_old))
                                                    {{ number_format($data->price_sale, 0, ',', '.') }} VND
                                                @else
                                                    {{ number_format($data->price_old, 0, ',', '.') }} VND
                                                @endif
                                            </p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="badge bg-warning mb-0 fw-semibold">Đang giao</p>
                                        </td>
                                        <td class="border-bottom-0 d-flex">
                                            <a href="{{ route('system.orderproduct.updateStatus', $data->order_id) }}"
                                                class="btn btn-success me-1">
                                                <i class="ti ti-check"></i>
                                            </a>
                                            <a class="btn btn-warning " data-bs-toggle="collapse"
                                                href="#collapse{{ $data->order_id }}" role="button"
                                                aria-expanded="false" aria-controls="collapse{{ $data->order_id }}">
                                                <i class="ti ti-arrow-narrow-down"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr id="show">
                                        <td colspan="6">
                                            <div class="collapse" id="collapse{{ $data->order_id }}">
                                                <div class="card card-body m-0">
                                                    <h6 class="fw-semibold mb-2 fs-5">Thông tin chi tiết:</h6>
                                                    <div class="col-md-12 d-flex mt-1">
                                                        <div class="col-md-6">
                                                            <p><strong>Mã đơn hàng:</strong> {{ $data->order_id }}</p>
                                                            <p><strong>Khách hàng:</strong> {{ $data->order_username }}</p>
                                                            <p><strong>Sđt:</strong> {{ $data->order_phone }}</p>
                                                             <p><strong>Email</strong> {{ $data->email }}</p>
                                                            <p><strong>Địa chỉ:</strong> {{ $data->order_address }}</p>
                                                        </div>
                                                        @php
                                                            $product_names = explode(',', $data->product_names);
                                                        @endphp
                                                        <div class="col-md-6">
                                                            <p><strong>Số lượng:</strong> {{ $data->total_quantity }}
                                                            </p>
                                                            <p><strong>Hình thức thanh toán:</strong>
                                                                @if ($data->payment_method == 0)
                                                                    Tiền mặt
                                                                @elseif($data->payment_method == 1)
                                                                    Momo
                                                                @elseif($data->payment_method == 2)
                                                                    VNpay
                                                                @elseif($data->payment_method == 3)
                                                                    Zalopay
                                                                @endif
                                                            </p>
                                                            <span class="d-flex"><strong>Sản phẩm:</strong>
                                                                <ul>
                                                                    @foreach ($product_names as $data)
                                                                        <li
                                                                            style="word-wrap: break-word; overflow-wrap: break-word;
                                                                        white-space: normal; max-width: 100%; word-break: normal;">
                                                                            {{ trim($data) }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            </span>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>

                        <div class="mt-3 d-flex justify-content-center">
                            {{ $ordersShippings->links() }}
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <div class="table-responsive ">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Mã hóa đơn</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Khách hàng</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Ngày xuất bản</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Tổng tiền</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Trạng thái</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Thao tác</h6>
                                    </th>
                                </tr>
                            </thead>
                            @if ($ordersCompleteds->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <h5 class="text-muted">Không tìm thấy kết quả nào</h5>
                                    </td>
                                </tr>
                            @else
                                @foreach ($ordersCompleteds as $data)
                                    <tr class="order-row">
                                        <td class="border-bottom-0">
                                            <p class="fw-semibold mb-0">{{ $data->order_id }}</p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-semibold">{{ $data->order_username }}
                                            </p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-semibold">
                                                {{ Carbon\Carbon::parse($data->created_at)->format('d/m/Y | h:m:s') }}
                                            </p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-semibold">
                                                @if (is_null($data->price_old))
                                                    {{ number_format($data->price_sale, 0, ',', '.') }} VND
                                                @else
                                                    {{ number_format($data->price_old, 0, ',', '.') }} VND
                                                @endif
                                            </p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="badge bg-success mb-0 fw-semibold">Đã giao</p>
                                        </td>
                                        <td class="border-bottom-0 d-flex">
                                            <a href="{{ route('system.orderproduct.updateStatus', $data->order_id) }}"
                                                class="btn btn-success me-1">
                                                <i class="ti ti-check"></i>
                                            </a>
                                            <a class="btn btn-warning" data-bs-toggle="collapse"
                                                href="#collapse{{ $data->order_id }}" role="button"
                                                aria-expanded="false" aria-controls="collapse{{ $data->order_id }}">
                                                <i class="ti ti-arrow-narrow-down"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr id="show">
                                        <td colspan="6">
                                            <div class="collapse" id="collapse{{ $data->order_id }}">
                                                <div class="card card-body m-0">
                                                    <h6 class="fw-semibold mb-2 fs-5">Thông tin chi tiết:</h6>
                                                    <div class="col-md-12 d-flex mt-1">
                                                        <div class="col-md-6">
                                                            <p><strong>Mã đơn hàng:</strong> {{ $data->order_id }}</p>
                                                            <p><strong>Khách hàng:</strong> {{ $data->order_username }}</p>
                                                            <p><strong>Sđt:</strong> {{ $data->order_phone }}</p>
                                                             <p><strong>Email</strong> {{ $data->email }}</p>
                                                            <p><strong>Địa chỉ:</strong> {{ $data->order_address }}</p>
                                                        </div>
                                                        @php
                                                            $product_names = explode(',', $data->product_names);
                                                        @endphp
                                                        <div class="col-md-6">
                                                            <p><strong>Số lượng:</strong> {{ $data->total_quantity }}
                                                            </p>
                                                            <p><strong>Hình thức thanh toán:</strong>
                                                                @if ($data->payment_method == 0)
                                                                    Tiền mặt
                                                                @elseif($data->payment_method == 1)
                                                                    Momo
                                                                @elseif($data->payment_method == 2)
                                                                    VNpay
                                                                @elseif($data->payment_method == 3)
                                                                    Zalopay
                                                                @endif
                                                            </p>
                                                            <span class="d-flex"><strong>Sản phẩm:</strong>
                                                                <ul>
                                                                    @foreach ($product_names as $data)
                                                                        <li
                                                                            style="word-wrap: break-word; overflow-wrap: break-word;
                                                                        white-space: normal; max-width: 100%; word-break: normal;">
                                                                            {{ trim($data) }}.</li>
                                                                    @endforeach
                                                                </ul>
                                                            </span>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        <div class="mt-3 d-flex justify-content-center">
                            {{ $ordersCompleteds->links() }}
                        </div>
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
                            $('#tabInput').val(0);
                        } else if (activeTab === 'nav-profile-tab') {
                            $('#tabInput').val(1);
                        } else if (activeTab === 'nav-contact-tab') {
                            $('#tabInput').val(2);
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
                document.addEventListener('click', function(e) {
                    const deleteButton = e.target.closest('.cancal'); 
                    if (!deleteButton) return; 
                    e.preventDefault();

                    Swal.fire({
                        title: 'Bạn có chắc muốn hủy đơn?',
                        text: "Hành động này không thể hoàn tác!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Hủy',
                        cancelButtonText: 'Thoát'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const orderProductId = deleteButton.getAttribute('data-id');
                            const deleteUrl = '/system/orderproducts/delete/' + orderProductId; 
                            window.location.href = deleteUrl; 
                        }
                    });
                });
            </script>
        @endpush
    @endsection
