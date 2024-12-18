@extends('layouts.admin.master')

@section('content')
    <div class="card w-100">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center m-1 mb-4">
                <a href="{{ route('system.order.resetsearch') }}" class="card-title">
                    <h3>Quản lý hóa đơn dịch vụ</h3>
                </a>
            </div>

            <nav class="mb-4">
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                        type="button" role="tab" aria-controls="nav-home" aria-selected="true">Chưa thanh
                        toán</button>
                    <button class="nav-link"id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                        type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Thanh
                        toán
                        trước</button>
                    <button class="nav-link"id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact"
                        type="button" role="tab" aria-controls="nav-contact" aria-selected="false">
                        Đã thanh toán trước</button>
                    <button class="nav-link"id="nav-contacts-tab" data-bs-toggle="tab" data-bs-target="#nav-contacts"
                        type="button" role="tab" aria-controls="nav-contacts" aria-selected="false">
                        Đã thanh toán</button>
                </div>
            </nav>
            <form action="{{ route('system.order') }}" method="GET" class="row mb-3 g-2 align-items-center">
                <!-- Hidden input to maintain the active tab -->
                <input type="hidden" name="tab" class="tab" id="tabInput" value="{{ request('tab', '0') }}">


                <!-- Tìm kiếm -->
                <div class="col-md-9 col-lg-10">
                    <div class="row g-2">
                        <!-- Tên sản phẩm -->
                        <div class="col-md-4">
                            <input type="text" id="inputName" class="form-control" placeholder="Họ tên bệnh nhân"
                                name="name" value="{{ request('name') }}">
                        </div>

                        <!-- Giá từ -->
                        <div class="col-md-4">
                            <input type="number" id="inputPriceFrom" class="form-control" placeholder="Giá từ"
                                name="price_from" value="{{ request('price_from') }}">
                        </div>

                        <!-- Giá đến -->
                        <div class="col-md-4">
                            <input type="number" id="inputPriceTo" class="form-control" placeholder="Giá đến"
                                name="price_to" value="{{ request('price_to') }}">
                        </div>
                        <!-- Mã sản phẩm -->
                        <div class="col-md-4">
                            <input type="text" id="inputCode" class="form-control" placeholder="Mã hóa đơn"
                                name="code_order" value="{{ request('code_order') }}">
                        </div>
                        <!-- Ngày từ -->
                        <div class="col-md-4">
                            <input type="date" id="inputDateFrom" class="form-control" placeholder="Ngày từ"
                                name="date_from" value="{{ request('date_from') }}">
                        </div>

                        <!-- Ngày đến -->
                        <div class="col-md-4">
                            <input type="date" id="inputDateTo" class="form-control" placeholder="Ngày đến"
                                name="date_to" value="{{ request('date_to') }}">
                        </div>
                    </div>
                </div>

                <!-- Nút tìm kiếm và thêm sản phẩm -->
                <div class="col-md-3 col-lg-2">
                    <div class="row g-2">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="tab-content" id="nav-tabContent">
                <!-- Tab Dịch vụ hoạt động -->
                <div class="tab-pane fade active show " id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="table-responsive ">
                        <table class="table table-bordered text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr class="text-center">
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Mã hóa đơn</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Họ tên bệnh nhân</h6>
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
                            <tbody>
                                @if ($ordersUnpaid->isEmpty())
                                    <div id="noResults" class="alert alert-warning">Không tìm thấy dữ liệu.</div>
                                @else
                                    @foreach ($ordersUnpaid->items() as $data)
                                        <tr class="order-row text-center">
                                            <td class="border-bottom-0">
                                                <p class="fw-semibold mb-0">{{ $data->order_id }}</p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-semibold">{{ $data->last_name }}
                                                    {{ $data->first_name }}
                                                </p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-semibold">
                                                    {{ Carbon\Carbon::parse($data->created_at)->format('d/m/Y | h:m:s') }}
                                                </p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-semibold">
                                                    {{ number_format($data->total_price, 0, ',', '.') }} VND
                                                </p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="badge bg-danger mb-0 fw-semibold">Chưa thanh toán</p>
                                            </td>
                                            <td class="border-bottom-0 d-flex justify-content-center align-items-centers">
                                                <a href="#" class="btn btn-success payment-button"
                                                    data-order-id="{{ $data->order_id }}" data-bs-target="#payModal">
                                                    <i class="ti ti-check"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>

                        <div class="mt-3 d-flex justify-content-center">
                            {{ $ordersUnpaid->links() }}
                        </div>
                    </div>
                </div>

                <!-- Tab Dịch vụ không hoạt động -->
                <div class="tab-pane fade " id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <div class="table-responsive ">
                        <table class="table table-bordered text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr class="text-center">
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Mã hóa đơn</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Họ tên bệnh nhân</h6>
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
                            <tbody>
                                @if ($ordersPrepaid->isEmpty())
                                    <div id="noResults" class="alert alert-warning">Không tìm thấy dữ liệu.</div>
                                @else
                                    @foreach ($ordersPrepaid as $data)
                                        <tr class="order-row text-center">
                                            <td class="border-bottom-0">
                                                <p class="fw-semibold mb-0">{{ $data->order_id }}</p>
                                            </td>
                                            <td class="border-bottom-0 ">
                                                <p class="mb-0 fw-semibold">{{ $data->name }}</p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-semibold">
                                                    {{ Carbon\Carbon::parse($data->created_at)->format('d/m/Y | h:m:s') }}
                                                </p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-semibold">
                                                    {{ number_format($data->total_price * 0.3, 0, ',', '.') }} VND
                                                </p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="badge bg-warning mb-0 fw-semibold">Thanh toán trước</p>
                                            </td>
                                            <td class="border-bottom-0 d-flex justify-content-center align-items-centers">
                                                <a href="{{ route('system.order.updateStatus', $data->order_id) }}"
                                                    class="btn btn-success me-1">
                                                    <i class="ti ti-check"></i>
                                                </a>
                                                <a class="btn btn-warning me-1" data-bs-toggle="collapse"
                                                    href="#collapse{{ $data->order_id }}" role="button"
                                                    aria-expanded="false" aria-controls="collapse{{ $data->order_id }}"
                                                    data-order-id="{{ $data->order_id }}" onclick="toggleIcon(this)">
                                                    <i class="ti ti-arrow-narrow-down"
                                                        id="collapse-icon{{ $data->order_id }}"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr id="show">
                                            <td colspan="7">
                                                <div class="collapse" id="collapse{{ $data->order_id }}">
                                                    <div class="card card-body m-0">
                                                        <h6 class="fw-semibold mb-2 fs-5">Thông tin chi tiết:</h6>
                                                        <div class="col-md-12 d-flex mt-1">
                                                            <div class="col-md-6">
                                                                <p><strong>Mã đơn hàng:</strong> {{ $data->order_id }}</p>
                                                                <p><strong>Khách hàng:</strong> {{ $data->name }}</p>
                                                                <p><strong>Sđt:</strong> {{ $data->phone }}</p>
                                                                <p><strong>Email:</strong> {{ $data->email }}</p>
                                                                <p><strong>Triệu chứng:</strong> {{ $data->symptoms }}</p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <p><strong>Thời gian</strong>
                                                                    {{ Carbon\Carbon::parse($data->day)->format('d/m/Y') }}
                                                                    {{ Carbon\Carbon::parse($data->hour)->format('h:s') }}
                                                                </p>
                                                                <p><strong>Bác sĩ:</strong>{{ $data->firstname }}
                                                                    {{ $data->lastname }}</p>
                                                                <p><strong>KHoa:</strong> {{ $data->specialty }}</p>
                                                                <p><strong>Hình thức thanh toán:</strong>
                                                                    @if ($data->payment == 1)
                                                                        Momo
                                                                    @elseif($data->payment == 2)
                                                                        VNpay
                                                                    @elseif($data->payment == 3)
                                                                        Zalopay
                                                                    @endif
                                                                </p>
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
                            {{ $ordersPrepaid->links() }}
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade " id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <div class="table-responsive ">
                        <table class="table table-bordered text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr class="text-center">
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Mã hóa đơn</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Họ tên bệnh nhân</h6>
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
                            <tbody>
                                @if ($ordersisPrepaid->isEmpty())
                                    <div id="noResults" class="alert alert-warning">Không tìm thấy dữ liệu.</div>
                                @else
                                    @foreach ($ordersisPrepaid as $data)
                                        <tr class="order-row text-center">
                                            <td class="border-bottom-0">
                                                <p class="fw-semibold mb-0">{{ $data->order_id }}</p>
                                            </td>
                                            <td class="border-bottom-0 ">
                                                <p class="mb-0 fw-semibold">{{ $data->name }}
                                                </p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-semibold">
                                                    {{ Carbon\Carbon::parse($data->created_at)->format('d/m/Y | h:m:s') }}
                                                </p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-semibold">
                                                    {{ number_format($data->total_price - $data->total_price * 0.3, 0, ',', '.') }}
                                                    VND
                                                </p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="badge bg-info mb-0 fw-semibold">Đã thanh toán trước</p>
                                            </td>
                                            <td class="border-bottom-0 d-flex justify-content-center align-items-centers">
                                                <a href="{{ route('system.order.updateStatus', $data->order_id) }}"
                                                    class="btn btn-success me-1">
                                                    <i class="ti ti-check"></i>
                                                </a>
                                                <a class="btn btn-warning me-1" data-bs-toggle="collapse"
                                                    href="#collapse{{ $data->order_id }}" role="button"
                                                    aria-expanded="false" aria-controls="collapse{{ $data->order_id }}"
                                                    data-order-id="{{ $data->order_id }}" onclick="toggleIcon(this)">
                                                    <i class="ti ti-arrow-narrow-down"
                                                        id="collapse-icon{{ $data->order_id }}"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr id="show">
                                            <td colspan="7">
                                                <div class="collapse" id="collapse{{ $data->order_id }}">
                                                    <div class="card card-body m-0">
                                                        <h6 class="fw-semibold mb-2 fs-5">Thông tin chi tiết:</h6>
                                                        <div class="col-md-12 d-flex mt-1">
                                                            <div class="col-md-6">
                                                                <p><strong>Mã đơn hàng:</strong> {{ $data->order_id }}</p>
                                                                <p><strong>Khách hàng:</strong> {{ $data->name }}</p>
                                                                <p><strong>Sđt:</strong> {{ $data->phone }}</p>
                                                                <p><strong>Email:</strong> {{ $data->email }}</p>
                                                                <p><strong>Triệu chứng:</strong> {{ $data->symptoms }}</p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <p><strong>Thời gian</strong>
                                                                    {{ Carbon\Carbon::parse($data->day)->format('d/m/Y') }}
                                                                    {{ Carbon\Carbon::parse($data->hour)->format('h:s') }}
                                                                </p>
                                                                <p><strong>Bác sĩ:</strong>{{ $data->firstname }}
                                                                    {{ $data->lastname }}</p>
                                                                <p><strong>Khoa:</strong> {{ $data->specialty }}</p>
                                                                <p><strong>Hình thức thanh toán:</strong>
                                                                    @if ($data->payment == 1)
                                                                        Momo
                                                                    @elseif($data->payment == 2)
                                                                        VNpay
                                                                    @elseif($data->payment == 3)
                                                                        Zalopay
                                                                    @endif
                                                                </p>
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
                            {{ $ordersisPrepaid->links() }}
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade " id="nav-contacts" role="tabpanel" aria-labelledby="nav-contacts-tab">
                    <div class="table-responsive ">
                        <table class="table table-bordered text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr class="text-center">
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Mã hóa đơn</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Họ tên bệnh nhân</h6>
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
                            <tbody>
                                @if ($ordersPaid->isEmpty())
                                    <div id="noResults" class="alert alert-warning">Không tìm thấy dữ liệu.</div>
                                @else
                                    @foreach ($ordersPaid as $data)
                                        <tr class="order-row text-center">
                                            <td class="border-bottom-0">
                                                <p class="fw-semibold mb-0">{{ $data->order_id }}</p>
                                            </td>
                                            <td class="border-bottom-0 ">
                                                <p class="mb-0 fw-semibold">
                                                    @if ($data->name)
                                                        <!-- Nếu có tên, hiển thị tên bệnh nhân -->
                                                        {{ $data->name }}
                                                    @elseif($data->first_name && $data->last_name)
                                                        <!-- Nếu không có tên, hiển thị họ tên -->
                                                        {{ $data->first_name }} {{ $data->last_name }}
                                                    @else
                                                        Chưa có thông tin bệnh nhân
                                                    @endif
                                                </p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-semibold">
                                                    {{ Carbon\Carbon::parse($data->created_at)->format('d/m/Y | h:m:s') }}
                                                </p>
                                            </td>
                                            <td class="border-bottom-0">
                                                @if (!empty($data->treatment_id))
                                                    <p class="mb-0 fw-semibold">
                                                        {{ number_format($data->total_amount, 0, ',', '.') }} VND
                                                    </p>
                                                @else
                                                    <p class="mb-0 fw-semibold">
                                                        {{ number_format($data->total_price, 0, ',', '.') }} VND
                                                    </p>
                                                @endif
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="badge bg-success mb-0 fw-semibold">Đã thanh toán</p>
                                            </td>
                                            <td class="border-bottom-0 d-flex justify-content-center align-items-centers">
                                                @if (!empty($data->treatment_id))
                                                    <a href="{{ route('system.order.print', $data->order_id) }}"
                                                        class="btn btn-primary me-1" target="_blank">
                                                        <i class="ti ti-printer"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('system.order.print_orderOnline', $data->order_id) }}"
                                                        class="btn btn-primary me-1" target="_blank">
                                                        <i class="ti ti-printer"></i>
                                                    </a>
                                                @endif
                                                <a data-id="{{ $data->order_id }}" class="btn btn-danger me-1">
                                                    <i class="ti ti-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <div class="mt-3 d-flex justify-content-center">
                            {{ $ordersPaid->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="payForm">
        <div class="modal fade" id="payModal" tabindex="-1" aria-labelledby="payModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <!-- Header -->
                    <div class="modal-header">
                        <div class="d-flex flex-row align-items-center">
                            <img src="{{ asset('backend/assets/images/logos/logo.png') }}" alt="Hospital Logo"
                                style="width: 60px;">
                            <div class="ms-3">
                                <h5 class="mb-1">Bệnh Viện VietCare</h5>
                                <p class="mb-0"><strong>Địa chỉ: </strong>315, Nguyễn Văn Linh, An Khánh, Ninh Kiều</p>
                                <p class="mb-0"><strong>SĐT: </strong> 0292.382.0071 - 0292.382.3167</p>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Body -->
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            <h4>Chi tiết hóa đơn</h4>
                            <p id="currentDate">{{ now()->format('H:i:s d/m/Y') }}</p>
                        </div>

                        <!-- Thông tin khách hàng -->
                        <div class="row mb-3 d-flex flex-wrap align-items-start">
                            <div class="col-auto me-3 mb-2">
                                <strong>Mã hóa đơn:</strong> <span id="invoiceCode"></span>
                            </div>
                            <div class="col-auto me-3 mb-2">
                                <strong>Họ tên:</strong> <span id="customerName"></span>
                            </div>
                            <div class="col-auto me-3 mb-2">
                                <strong>Năm sinh:</strong> <span id="customerDob"></span>
                            </div>
                            <div class="col-auto me-3 mb-2">
                                <strong>Giới tính:</strong> <span id="customerGender"></span>
                            </div>
                        </div>

                        <!-- Bảng dịch vụ -->
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Dịch vụ</th>
                                        <th>Đơn giá</th>
                                    </tr>
                                </thead>
                                <tbody id="serviceTableBody"></tbody>
                            </table>
                        </div>

                        <!-- Tổng cộng -->
                        <div class="row mt-3">
                            <!-- Cột bên trái -->
                            <div class="col-6">
                                <div class="mb-2">
                                    <label for="payment_method" class="form-label">Hình thức thanh toán:</label>
                                    <select id="paymentMethod" class="form-select w-50 payment-method mt-1"
                                        name="payment_method" required>
                                        <option value="0">Tiền mặt</option>
                                        <option value="1">Momo</option>
                                        <option value="2">VNpay</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Cột bên phải -->
                            <div class="col-6 text-end">
                                <div class="mb-2">
                                    <strong>Phí dịch vụ:</strong> <span id="serviceFee"></span>
                                </div>
                                <div class="mb-2">
                                    <strong>Tổng tiền:</strong> <span id="totalAmount"></span>
                                </div>
                                <div class="mb-2" id="cashInputWrapper">
                                    <label for="cashReceived" class="form-label me-2"><strong>Tiền nhận:</strong></label>
                                    <input type="number" min="0" id="cashReceived"
                                        class="form-control d-inline w-50" placeholder="Nhập số tiền">
                                </div>
                                <div class="mb-2">
                                    <strong>Tiền thừa:</strong> <span id="changeAmount"></span>
                                </div>
                                <div>
                                    <strong>Người thu ngân:</strong> <span id="cashierName"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" form="payForm" class="btn btn-primary">Thanh toán</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @push('scripts')
        {{-- <script>
            $(document).ready(function() {
                // Gắn sự kiện onchange cho select
                $('#itemsPerPage').on('change', function() {
                    // Lấy giá trị của select
                    var itemsPerPage = $(this).val();

                    // Lấy \ hiện tại
                    var url = new URL(window.location.href);

                    // Thêm hoặc cập nhật tham số itemsPerPage trong URL
                    url.searchParams.set('itemsPerPage', itemsPerPage);

                    // Thực hiện điều hướng (reload trang với tham số itemsPerPage mới)
                    window.location.href = url.toString();
                });
            });
        </script> --}}
        {{-- <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Lắng nghe sự kiện khi người dùng click vào tab
                document.querySelectorAll('button[data-bs-toggle="tab"]').forEach(function(tabButton) {
                    tabButton.addEventListener('shown.bs.tab', function(e) {
                        // Kiểm tra nếu tab đang được chọn là tab "profile"
                        if (e.target.id === 'nav-contacts-tab') {
                            document.getElementById('deleteButton').style.display =
                                'inline-block'; // Hiển thị nút xóa
                        } else {
                            document.getElementById('deleteButton').style.display =
                                'none'; // Ẩn nút xóa
                        }
                    });
                });

                // Kiểm tra trạng thái tab khi trang được tải để đảm bảo trạng thái của nút "Xóa" đúng lúc load trang
                const activeTab = document.querySelector('button[data-bs-toggle="tab"].active');
                if (activeTab && activeTab.id === 'nav-contacts-tab') {
                    document.getElementById('deleteButton').style.display = 'inline-block'; // Hiển thị nút xóa
                } else {
                    document.getElementById('deleteButton').style.display = 'none'; // Ẩn nút xóa
                }
            });
        </script> --}}
        <script>
            $(document).ready(function() {
                var currentOrderData = null;

                // Xử lý sự kiện click vào nút thanh toán
                $('.payment-button').on('click', function() {
                    var orderId = $(this).data('order-id');

                    // Gọi AJAX để lấy thông tin đơn hàng
                    $.ajax({
                        url: '/system/order-services/edit/' + orderId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if (response.success && response.data && response.user) {
                                var data = response.data;
                                var user = response.user;
                                currentOrderData = data;

                                // Hiển thị thông tin trong modal
                                $('#invoiceCode').text(data.order_id);
                                $('#customerName').text(data.first_name + ' ' + data.last_name);
                                $('#customerDob').text(new Date(data.birthday).toLocaleDateString(
                                    'vi-VN'));
                                $('#customerGender').text(data.gender === 1 ? 'Nam' : 'Nữ');

                                $('#cashierName').text(user.first_name + ' ' + user.last_name);

                                var serviceTableBody = $('#serviceTableBody');
                                serviceTableBody.empty();
                                var serviceNames = data.service_names.split('|');
                                var servicePrices = data.service_prices.split('|');

                                if (serviceNames.length === servicePrices.length) {

                                    $.each(serviceNames, function(index, serviceName) {
                                        const price = servicePrices[index];
                                        serviceTableBody.append(
                                            `<tr>
                                                <td>${index + 1}</td>
                                                <td>${serviceName}</td>
                                                <td>${new Intl.NumberFormat('vi-VN').format(price)} VND</td>
                                            </tr>`
                                        );
                                    });
                                }


                                $('#serviceFee').text(new Intl.NumberFormat('vi-VN').format(20000) +
                                    ' VND');
                                $('#totalAmount').text(
                                    new Intl.NumberFormat('vi-VN').format(
                                        parseFloat(data.total_price) + 20000
                                    ) + ' VND'
                                );



                                // Kích hoạt modal
                                $('#payModal').modal('show');

                                // Kích hoạt sự kiện change để kiểm tra hiển thị các trường
                                $('#paymentMethod').trigger('change');
                            } else {
                                alert('Không thể lấy dữ liệu hóa đơn.');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX Error:', status, error);
                            alert('Có lỗi xảy ra khi gọi dữ liệu.');
                        }
                    });
                });

                // Xử lý hiển thị trường "Khách đưa" và "Tiền thừa" khi thay đổi hình thức thanh toán
                $('#paymentMethod').on('change', function() {
                    const cashInputWrapper = $('#cashInputWrapper');
                    const changeAmountWrapper = $('#changeAmount').closest('div');

                    if ($(this).val() === '0') { // Nếu chọn Momo
                        cashInputWrapper.show();
                        changeAmountWrapper.show();
                    } else { // Nếu chọn Tiền mặt                     
                        cashInputWrapper.hide();
                        changeAmountWrapper.hide();
                    }
                });

                // Tính toán tiền thừa khi khách nhập
                $('#cashReceived').on('input', function() {
                    calculateChangeAmount();
                });

                function calculateChangeAmount() {
                    var cashReceived = $('#cashReceived').val();
                    var totalAmount = parseInt($('#totalAmount').text().replace(/\D/g, ''));
                    console.log(totalAmount);
                    var changeAmount = (cashReceived) - totalAmount;
                    $('#changeAmount').text(new Intl.NumberFormat('vi-VN').format(changeAmount > 0 ? changeAmount : 0) +
                        ' VND');
                }

                // Gửi dữ liệu qua AJAX khi submit form
                $('#payForm').on('submit', function(event) {
                    event.preventDefault();

                    if (!currentOrderData) {
                        alert('Dữ liệu đơn hàng không tồn tại.');
                        return;
                    }

                    var orderId = currentOrderData.order_id;
                    var paymentMethod = $('#paymentMethod').val();
                    var cashReceived = $('#cashReceived').val();
                    var totalAmount = $('#totalAmount').text().replace(/\D/g, '');
                    var changeAmount = parseInt($('#changeAmount').text().replace(/\D/g, '')) || 0;
                    var cashierName = $('#cashierName').text().trim();

                    $.ajax({
                        url: "{{ route('system.order.handlepay') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            order_id: orderId,
                            payment_method: paymentMethod,
                            cash_received: cashReceived,
                            change_amount: changeAmount,
                            cashier_name: cashierName,
                            total_amount: totalAmount
                        },
                        success: function(response) {
                            if (response.success) {
                                if (paymentMethod === "0") {
                                    if (response.pdf_url) {
                                        window.open(response.pdf_url, '_blank', 'noopener');
                                    }
                                    $('#payModal').modal('hide');
                                    location.reload();
                                } else if (paymentMethod === "1") {
                                    if (response.payUrl) {
                                        window.location.href = response.payUrl;

                                    } else {
                                        toastr.error('Không tìm thấy liên kết thanh toán.');
                                    }
                                } else if (paymentMethod === "2") {
                                    if (response.payUrl) {
                                        window.location.href = response.payUrl;
                                    } else {
                                        toastr.error('Không tìm thấy liên kết thanh toán.');
                                    }
                                } else {
                                    toastr.error('Phương thức thanh toán không hợp lệ.');
                                }
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX Error:', status, error);

                            // Xóa các lỗi cũ trước khi hiển thị lỗi mới
                            $('#cashReceived').removeClass('is-invalid');
                            $('#cashInputWrapper .invalid-feedback').remove();

                            if (xhr.status === 422) {
                                var errors = xhr.responseJSON.errors;
                                if (errors.cash_received) {
                                    $('#cashReceived').addClass(
                                        'is-invalid'); // Thêm class is-invalid
                                    $('#cashInputWrapper').append(
                                        `<div class="invalid-feedback">${errors.cash_received[0]}</div>`
                                    );
                                }
                                if (errors.payment_method) {
                                    toastr.error(errors.payment_method[0]);
                                }
                            } else {
                                toastr.error('Có lỗi xảy ra, vui lòng thử lại.');
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
                            const couponId = deleteButton.getAttribute('data-id');
                            const deleteUrl = '/system/order-services/delete/' + couponId;
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
                var selectedCheckboxes = document.querySelectorAll('input[name="order_id[]"]:checked');
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
                                url: './order-services/multipledelete', // Đường dẫn tới route xóa
                                type: 'POST', // Sử dụng POST
                                data: {
                                    _token: '{{ csrf_token() }}', // Token CSRF
                                    order_id: selectedIds
                                },
                                success: function(response) {
                                    toastr.success('Các hóa đơn đã được xóa thành công.');

                                    location.reload();

                                },
                                error: function(xhr, status, error) {
                                    toastr.error('Đã xảy ra lỗi khi xóa hóa đơn.');
                                }
                            });
                        }
                    });
                } else {
                    toastr.error('Vui lòng chọn ít nhất một hóa đơn để xóa');
                }
            });
        </script> --}}
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
                    } else if (activeTab === 'nav-contacts-tab') {
                        $('#tabInput').val(3);
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
            function toggleIcon(element) {
                var orderId = $(element).data('order-id');
                var icon = $(element).find('i');

                if (icon.hasClass('ti-arrow-narrow-down')) {
                    icon.replaceWith('<i class="ti ti-arrow-narrow-up" id="collapse-icon' + orderId + '"></i>');
                } else {
                    icon.replaceWith('<i class="ti ti-arrow-narrow-down" id="collapse-icon' + orderId + '"></i>');
                }

                $('#collapse' + orderId).on('shown.bs.collapse', function() {
                    $('#collapse-icon' + orderId).replaceWith('<i class="ti ti-arrow-narrow-up" id="collapse-icon' +
                        orderId + '"></i>');
                }).on('hidden.bs.collapse', function() {
                    $('#collapse-icon' + orderId).replaceWith('<i class="ti ti-arrow-narrow-down" id="collapse-icon' +
                        orderId + '"></i>');
                });
            }
        </script>
    @endpush
@endsection
