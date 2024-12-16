@extends('layouts.admin.master')

@section('content')
    <div class="card w-100">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center m-1 mb-4">
                <a href="{{ route('system.order.resetsearch') }}" class="card-title">
                    <h3>Quản lý hóa đơn thuốc</h3>
                </a>
            </div>

            <nav class="mb-4">
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                        type="button" role="tab" aria-controls="nav-home" aria-selected="true">Chưa thanh
                        toán</button>
                    <button class="nav-link"id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact"
                        type="button" role="tab" aria-controls="nav-contact" aria-selected="false">
                        Đã thanh toán</button>
                    <button class="nav-link"id="nav-contacts-tab" data-bs-toggle="tab" data-bs-target="#nav-contacts"
                        type="button" role="tab" aria-controls="nav-contacts" aria-selected="false">
                        Đã phát thuốc</button>
                </div>
            </nav>
            <form action="{{ route('system.ordermedicine') }}" method="GET" class="row mb-3 g-2 align-items-center">
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
                <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr class="text-center">
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Mã hóa đơn</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Tên bệnh nhân</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Ngày tạo</h6>
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
                                @forelse ($ordersUnpaid as $medicine)
                                    @if ($medicine->status == 0)
                                        @php
                                            $totalPrice = $medicine->total_medicine_price + $medicine->price_service;
                                        @endphp
                                        <tr class="order-row text-center">
                                            <td class="border-bottom-0">
                                                <p class="fw-semibold mb-0">{{ $medicine->order_medicine_id }}</p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-semibold">{{ $medicine->patient_firstname }}
                                                    {{ $medicine->patient_lastname }}</p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-semibold">
                                                    {{ \Carbon\Carbon::parse($medicine->created_at)->format('H:i:s, d/m/Y') }}
                                                </p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-semibold">
                                                    {{ number_format($totalPrice, 0, ',', '.') }}
                                                    VND
                                                </p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="badge bg-danger mb-0 fw-semibold">Chưa thanh toán</p>
                                            </td>
                                            <td class="border-bottom-0 d-flex justify-content-center align-items-center">
                                                <a href="#" class="btn btn-success payment-button"
                                                    data-order_medicine_id="{{ $medicine->order_medicine_id }}"
                                                    data-bs-target="#payModal">
                                                    <i class="ti ti-check"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <div id="noResults" class="alert alert-warning">Không tìm thấy dữ liệu.
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="mt-3 d-flex justify-content-center">
                            {{ $ordersUnpaid->links() }}
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
                                        <h6 class="fw-semibold mb-0">Tên bệnh nhân</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Ngày tạo</h6>
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
                                @forelse ($ordersUnpaid as $medicine)
                                    @if ($medicine->status == 1)
                                        @php
                                            $totalPrice = $medicine->total_medicine_price + $medicine->price_service;
                                        @endphp
                                        <tr class="order-row text-center">
                                            <td class="border-bottom-0">
                                                <p class="fw-semibold mb-0">{{ $medicine->order_medicine_id }}</p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-semibold">{{ $medicine->patient_firstname }}
                                                    {{ $medicine->patient_lastname }}</p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-semibold">
                                                    {{ \Carbon\Carbon::parse($medicine->created_at)->format('H:i:s, d/m/Y') }}
                                                </p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-semibold">
                                                    {{ number_format($totalPrice, 0, ',', '.') }}
                                                    VND
                                                </p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="badge bg-success mb-0 fw-semibold">Đã thanh toán</p>
                                            </td>
                                            <td class="border-bottom-0 d-flex justify-content-center align-items-center">
                                                <a href="{{ route('system.ordermedicine.print', $medicine->order_medicine_id) }}"
                                                    class="btn btn-primary me-1" target="_blank">
                                                    <i class="ti ti-printer"></i>
                                                </a>
                                                <a data-id="{{ $medicine->order_medicine_id }}"
                                                    class="btn btn-danger me-1">
                                                    <i class="ti ti-trash"></i>
                                                </a>
                                                <a href="{{ route('system.ordermedicine.dispense', $medicine->order_medicine_id) }}"
                                                    class="btn btn-warning me-1">
                                                    Phát thuốc
                                                </a>
                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            <div id="noResults" class="alert alert-warning">Không tìm thấy dữ liệu.
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>

                        <div class="mt-3 d-flex justify-content-center">
                            {{ $ordersUnpaid->links() }}
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade " id="nav-contacts" role="tabpanel" aria-labelledby="nav-contacts-tab">
                    <div class="table-responsive ">
                        <div class="table-responsive">
                            <table class="table table-bordered text-nowrap mb-0 align-middle">
                                <thead class="text-dark fs-4">
                                    <tr class="text-center">
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Mã hóa đơn</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Tên bệnh nhân</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Ngày tạo</h6>
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
                                    @forelse ($ordersUnpaid as $medicine)
                                        @if ($medicine->status == 2)
                                            @php
                                                $totalPrice =
                                                    $medicine->total_medicine_price + $medicine->price_service;
                                            @endphp
                                            <tr class="order-row text-center">
                                                <td class="border-bottom-0">
                                                    <p class="fw-semibold mb-0">{{ $medicine->order_medicine_id }}</p>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <p class="mb-0 fw-semibold">{{ $medicine->patient_firstname }}
                                                        {{ $medicine->patient_lastname }}</p>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <p class="mb-0 fw-semibold">
                                                        {{ \Carbon\Carbon::parse($medicine->created_at)->format('H:i:s, d/m/Y') }}
                                                    </p>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <p class="mb-0 fw-semibold">
                                                        {{ number_format($totalPrice, 0, ',', '.') }}
                                                        VND
                                                    </p>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <p class="badge bg-success mb-0 fw-semibold">Đã thanh toán</p>
                                                </td>
                                                <td
                                                    class="border-bottom-0 d-flex justify-content-center align-items-center">
                                                    <a href="{{ route('system.ordermedicine.print', $medicine->order_medicine_id) }}"
                                                        class="btn btn-primary me-1" target="_blank">
                                                        <i class="ti ti-printer"></i>
                                                    </a>


                                                </td>
                                            </tr>
                                        @endif
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                <div id="noResults" class="alert alert-warning">Không tìm thấy dữ liệu.
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>

                            </table>

                            <div class="mt-3 d-flex justify-content-center">
                                {{ $ordersUnpaid->links() }}
                            </div>

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
                                        <th>Đơn thuốc</th>
                                        <th>Đơn giá</th>
                                        <th>Số lượng</th>
                                        <th>Tổng cộng</th>
                                    </tr>
                                </thead>
                                <tbody id="serviceTableBody">
                                    <!-- Rows will be populated dynamically via JS -->
                                </tbody>
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
                                        <option value="1">Chuyển khoản</option>
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
                                    <strong>Tiền thừa:</strong> <span id="changeAmount">0</span>
                                </div>
                                <div>
                                    <strong>Người thu ngân:</strong> <span id="cashierName">Nguyễn Văn A</span>
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
        <script>
            $(document).ready(function() {
                var currentOrderData = null;

                // Handle the click event on the payment button
                $('.payment-button').on('click', function() {
                    var ordermedicineId = $(this).data('order_medicine_id');

                    $.ajax({
                        url: '/system/order-medicines/edit/' + ordermedicineId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if (response.success && response.data) {
                                var data = response.data;
                                var user = response.user;
                                currentOrderData = data;

                                // Display order details in the modal
                                $('#invoiceCode').text(data.order_medicine_id); // Order ID
                                $('#customerName').text(data.patient_firstname + ' ' + data
                                    .patient_lastname);
                                $('#customerDob').text(new Date(data.patient_birthday)
                                    .toLocaleDateString('vi-VN')); // Birthdate
                                $('#customerGender').text(data.patient_gender === 1 ? 'Nam' :
                                    'Nữ'); // Gender
                                $('#cashierName').text(user.first_name + ' ' + user.last_name);

                                // Populate the medicine and treatment table
                                var medicineTableBody = $('#serviceTableBody');
                                medicineTableBody.empty(); // Clear previous rows

                                // Log dữ liệu để kiểm tra
                                console.log(data); // Kiểm tra dữ liệu trả về từ máy chủ

                                // Kiểm tra dữ liệu có tồn tại và hợp lệ không
                                if (data.medicine_names && data.medicine_prices && data
                                    .medicine_quantities) {
                                    var medicineNames = data.medicine_names.split("|");
                                    var medicinePrices = data.medicine_prices.split("|");
                                    var medicineQuantities = data.medicine_quantities.split("|");

                                    // Tính tổng tiền thuốc
                                    var totalMedicineAmount = 0;

                                    if (medicineNames.length === medicinePrices.length &&
                                        medicinePrices.length === medicineQuantities.length) {
                                        $.each(medicineNames, function(index, medicineName) {
                                            const price = parseFloat(medicinePrices[index]);
                                            const quantity = parseInt(medicineQuantities[
                                                index]);

                                            // Tính tổng tiền cho mỗi loại thuốc
                                            var totalMedicinePrice = price * quantity;

                                            // Cộng dồn vào tổng tiền thuốc
                                            totalMedicineAmount += totalMedicinePrice;

                                            // Thêm thông tin thuốc vào bảng
                                            medicineTableBody.append(`
                <tr>
                    <td>${index + 1}</td> <!-- Chỉ số thứ tự -->
                    <td>${medicineName}</td>
                    <td>${new Intl.NumberFormat('vi-VN').format(price)} VND</td>
                    <td>${quantity}</td>
                    <td>${new Intl.NumberFormat('vi-VN').format(totalMedicinePrice)} VND</td>
                </tr>
            `);
                                        });
                                    } else {
                                        console.error(
                                            'Dữ liệu không đồng nhất về số lượng thuốc, giá, và số lượng.'
                                        );
                                    }
                                } else {
                                    console.error('Dữ liệu thuốc bị thiếu hoặc không hợp lệ');
                                }
                                
                                totalMedicineAmount = parseFloat(totalMedicineAmount.toString()
                                    .replace(/[^0-9.-]/g, '')) || 0;
                                serviceFee = parseFloat(serviceFee.toString().replace(/[^0-9.-]/g,
                                    '')) || 0;

                                var totalAmount = totalMedicineAmount + serviceFee;

                                // Debug giá trị để kiểm tra
                                console.log("Chi tiết giá trị:", {
                                    totalMedicineAmount,
                                    serviceFee,
                                    totalAmount
                                });

                                // Hiển thị giá trị lên giao diện
                                $('#serviceFee').text(new Intl.NumberFormat('vi-VN').format(
                                    serviceFee) + ' VND');
                                $('#totalAmount').text(new Intl.NumberFormat('vi-VN').format(
                                    totalAmount) + ' VND');

                                // Hiển thị modal
                                $('#payModal').modal('show');

                                // Trigger thay đổi phương thức thanh toán
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

                // Handle the display of "Cash Received" and "Change" fields based on payment method
                $('#paymentMethod').on('change', function() {
                    const cashInputWrapper = $('#cashInputWrapper');
                    const changeAmountWrapper = $('#changeAmount').closest('div');

                    if ($(this).val() === '0') { // Momo payment
                        cashInputWrapper.show();
                        changeAmountWrapper.show();
                    } else { // Cash payment
                        cashInputWrapper.hide();
                        changeAmountWrapper.hide();
                    }
                });

                // Calculate the change when cash is received
                $('#cashReceived').on('input', function() {
                    calculateChangeAmount();
                });

                function calculateChangeAmount() {
                    var cashReceived = $('#cashReceived').val();
                    var totalAmount = parseInt($('#totalAmount').text().replace(/\D/g, ''));
                    var changeAmount = cashReceived - totalAmount;
                    $('#changeAmount').text(new Intl.NumberFormat('vi-VN').format(changeAmount > 0 ? changeAmount : 0) +
                        ' VND');
                }

                // Handle form submission and send payment data via AJAX
                $('#payForm').on('submit', function(event) {
                    event.preventDefault();

                    if (!currentOrderData) {
                        toastr.error('Dữ liệu đơn hàng không tồn tại.');
                        return;
                    }

                    // Lấy dữ liệu từ form và chuẩn hóa
                    var ordermedicineId = currentOrderData.order_medicine_id;
                    var paymentMethod = $('#paymentMethod').val();
                    var cashReceived = parseInt($('#cashReceived').val().replace(/\D/g, '') ||
                        0); // Chuyển sang số nguyên
                    var totalAmount = parseInt($('#totalAmount').text().replace(/\D/g,
                        '')); // Chuyển sang số nguyên
                    var changeAmount = cashReceived > totalAmount ? cashReceived - totalAmount :
                        0; // Tính tiền thừa
                    var cashierName = $('#cashierName').text().trim();

                    // Kiểm tra dữ liệu trước khi gửi
                    if (!paymentMethod || isNaN(totalAmount) || totalAmount <= 0) {
                        toastr.error('Vui lòng kiểm tra lại thông tin thanh toán.');
                        return;
                    }

                    // Gửi dữ liệu qua AJAX POST
                    $.ajax({
                        url: "{{ route('system.ordermedicine.handlepay') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            order_medicine_id: ordermedicineId,
                            payment_method: paymentMethod,
                            cash_received: cashReceived,
                            change_amount: changeAmount,
                            cashier_name: cashierName,
                            total_amount: totalAmount
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success('Thanh toán thành công!');

                                // Xử lý tùy theo phương thức thanh toán
                                if (paymentMethod === "0") { // Momo
                                    if (response.pdf_url) {
                                        window.open(response.pdf_url, '_blank'); // Mở file PDF
                                    }
                                } else if (paymentMethod === "1" || paymentMethod ===
                                    "2") { // Tiền mặt hoặc khác
                                    if (response.payUrl) {
                                        window.location.href = response.payUrl;
                                    } else {
                                        toastr.error('Không tìm thấy liên kết thanh toán.');
                                    }
                                }

                                $('#payModal').modal('hide');
                                location.reload(); // Làm mới trang
                            } else {
                                toastr.error(response.message || 'Thanh toán thất bại.');
                            }
                        },
                        error: function(xhr) {
                            console.error('AJAX Error:', xhr);

                            // Xử lý lỗi cụ thể từ server
                            if (xhr.status === 422) {
                                var errors = xhr.responseJSON.errors;
                                if (errors) {
                                    if (errors.cash_received) {
                                        $('#cashReceived').addClass('is-invalid');
                                        $('#cashInputWrapper .invalid-feedback').remove();
                                        $('#cashInputWrapper').append(
                                            `<div class="invalid-feedback">${errors.cash_received[0]}</div>`
                                        );
                                    }
                                    if (errors.payment_method) {
                                        toastr.error(errors.payment_method[0]);
                                    }
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
                            const deleteUrl = '/system/order-medicines/delete/' + couponId;
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
