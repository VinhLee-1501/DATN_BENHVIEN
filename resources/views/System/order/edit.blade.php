@extends('layouts.admin.master')

@section('content')
    <div class="card w-100">
        <div class="card-body p-4">
            <!-- Hospital Header -->
            <div class="header me-4 d-flex align-items-center">
                <img src="{{ asset('backend/assets/images/logos/logo.png') }}" alt="Hospital Logo" style="width: 60px;">
                <div class="hospital-info ms-3">
                    <h4 class="mb-1">Bệnh Viện VietCare</h4>
                    <p class="mb-0"><strong>Địa chỉ: </strong>315, Nguyễn Văn Linh, An Khánh, Ninh Kiều</p>
                    <p class="mb-0"><strong>SĐT: </strong> 0292.382.0071 - 0292.382.3167</p>
                </div>
            </div>
            
            <!-- Invoice Details -->
            <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
                <div class="text-center flex-grow-1">
                    <div class="card-title">
                        <h3 class="mb-0">Chi tiết hóa đơn</h3>
                        <p class="mb-0 fs-3">{{ \Carbon\Carbon::parse($orders->created_at)->format('d/m/Y | h:m:s ') }}</p>
                    </div>
                </div>
                <div class="text-start">
                    <p class="mb-0">Mã hóa đơn: {{ $orders->order_id }}</p>
                    <p class="mb-0">Mã bệnh án: {{ $orders->medical_id }}</p>
                    <p class="mb-0">Mã bệnh nhân: {{ $orders->patient_id }}</p>
                </div>
            </div>
            
            <!-- Patient Information -->
            <div class="row mt-3 ms-1">
                <div class="col">
                    <strong>Họ tên:</strong> 
                    <span class="fw-light fs-3">{{ $orders->last_name }} {{ $orders->first_name }}</span>
                </div>
                <div class="col">
                    <strong>Năm sinh:</strong> 
                    <span class="fw-light fs-3">{{ \Carbon\Carbon::parse($orders->birthday)->format(':d/m/Y') }}</span>
                </div>
                <div class="col">
                    <strong>Tuổi:</strong> 
                    <span class="fw-light fs-3">{{ \Carbon\Carbon::parse($orders->birthday)->age }}</span>
                </div>
                <div class="col">
                    <strong>Giới tính:</strong> 
                    <span class="fw-light fs-3">{{ $orders->gender == 1 ? 'Nam' : 'Nữ' }}</span>
                </div>
            </div>            

            <!-- Services Table -->
            <div class="table-responsive mt-3">
                <table class="table text-nowrap mb-0 align-middle table-bordered">
                    <thead class="text-dark fs-4">
                        <tr>
                            <th class="border-bottom-0"><h6 class="fw-semibold mb-0">#</h6></th>
                            <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Dịch vụ</h6></th>
                            <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Đơn giá</h6></th>
                        </tr>
                    </thead>
                    <tbody class="fw-light fs-2">
                        @php
                            $service_names = explode('|', $orders->service_names);
                            $service_prices = array_map(
                                fn($price) => $price * 1000,
                                explode('|', $orders->service_prices),
                            );
                            $count = 1;
                            $total_price = array_sum($service_prices); // Tính tổng tiền
                        @endphp

                        @foreach ($service_names as $index => $service_name)
                            <tr>
                                <td class="border-bottom-0"><h6 class="fw-light mb-0">{{ $count++ }}</h6></td>
                                <td class="border-bottom-0"><h6 class="fw-light mb-0">{{ $service_name }}</h6></td>
                                <td class="border-bottom-0"><h6 class="fw-light mb-0">{{ number_format($service_prices[$index] , 0, ',', '.') }} VND</h6></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Payment Method and Total Price -->
            <div class="row mt-4 d-flex justify-content-between">
                <div class="col d-flex align-items-center">
                    <h5 class="fw-semibold mb-0">Hình thức thanh toán:</h5>
                    @if($orders->payment == 0)
                        <p class="fs-3 fw-light mb-0 ms-2">Tiền mặt</p>
                    @else
                        <p class="fs-3 fw-light mb-0 ms-2">Chuyển khoản</p>
                    @endif
                </div>
                <div class="col text-end d-flex flex-column align-items-end" style=" padding-top: 10px; margin-top: 10px;"> 
                    <div class="d-flex align-items-center justify-content-end"> <!-- Thêm div để nhóm lại -->
                        <h5 class="fw-semibold mb-0">Tổng tiền:</h5>
                        <p class="fs-3 fw-light mb-0 ms-2">{{ number_format($total_price + 20000, 0, ',', '.') }} VND</p>
                    </div>
                    <p class="fs-3 fw-light mb-0 ms-2">Phí dịch vụ: 20.000 VND</p>
                </div>
            </div>
                       
            <!-- Cashier Information -->
            <div class="row mt-3">
                <div class="col text-start text-end">
                    <h5 class="fw-semibold mb-0">Người thu ngân</h5>
                    <p class="fs-3 fw-light mb-0 ms-2">{{ $orders->cashier ?? 'Chưa có thông tin' }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection  
