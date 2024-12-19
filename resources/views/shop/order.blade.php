@extends('layouts.shop.app')

<style>
    .order-info {
        background-color: #f9f9f9;
        margin-bottom: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .order-info h5 {
        margin-top: 0;
        margin-bottom: 10px;
        font-size: 16px;
        font-weight: bold;
    }

    .order-status {
        margin-bottom: 10px;
        font-weight: bold;
    }

    .status-success {
        color: #28a745;
    }

    .status-failure {
        color: #dc3545;
    }

    .status-pending {
        color: #ffc107;
    }

    .status-cod {
        color: #17a2b8;
    }

    .table th,
    .table td {
        vertical-align: middle;
    }

    td img {
        height: 100px;
        width: auto;
    }
</style>

@section('content')
    @if (!$order_user)
        <h5 class="text-center p-4">Chưa có đơn hàng mua nhé !!!</h5>
    @else
        <section class="shoping-cart spad">
            <div class="container">
                @php
                    $statusText = '';
                    $statusClass = '';
                    if ($order->payment_status == 1) {
                        $statusText = 'Thanh toán thành công';
                        $statusClass = 'status-success';
                    } elseif ($order->payment_status == 2) {
                        $statusText = 'Thanh toán không thành công';
                        $statusClass = 'status-failure';
                    } else {
                        $statusText = 'Đặt hàng thành công';
                        $statusClass = 'status-cod';
                    }

                    if ($order->payment_method == 0) {
                        $methodText = 'Thanh toán khi nhận hàng';
                    } elseif ($order->payment_method == 1) {
                        $methodText = 'Thanh toán bằng VNPAY';
                    } elseif ($order->payment_method == 2) {
                        $methodText = 'Thanh toán bằng MOMOPAY';
                    } elseif ($order->payment_method == 4) {
                        $methodText = 'Thanh toán bằng ZaloPay';
                    }
                @endphp

                <h5 class="mb-3">Thông tin đơn hàng vừa đặt</h5>

                <!-- Thông tin đơn hàng vừa đặt -->
                <div class="order-info p-3">
                    @if (request('vnp_TransactionStatus'))
                        <div>
                            <p>Trạng thái giao dịch: {{ request('vnp_TransactionStatus') }}</p>
                        </div>
                    @endif
                    <h5>Mã đơn hàng: {{ $order->order_id }}</h5>

                    <div class="row">
                        <div class="col-6">
                            <p>Ngày đặt hàng: {{ \Carbon\Carbon::parse($order->created_at)->format('H:i d/m/Y') }}</p>
                            <p class="status-failure">Tổng giá trị đơn hàng:
                                {{ number_format($order->price_sale ?? $order->price_old) }} VND</p>
                        </div>
                        <div class="col-6 text-end">
                            <p class="order-status">{{ $methodText }}</p>
                            <p class="order-status {{ $statusClass }}">{{ $statusText }}</p>
                        </div>
                    </div>

                    <!-- Accordion for Products -->
                    <div class="accordion" id="orderAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingAllProducts">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseAllProducts" aria-expanded="true"
                                    aria-controls="collapseAllProducts">
                                    Tất cả sản phẩm trong đơn hàng
                                </button>
                            </h2>
                            <div id="collapseAllProducts" class="accordion-collapse collapse show"
                                aria-labelledby="headingAllProducts" data-bs-parent="#orderAccordion">
                                <div class="accordion-body">
                                    <!-- Product Table -->
                                    <table class="table table-bordered align-middle">
                                        <thead>
                                            <tr class="text-center">
                                                <th scope="col">Ảnh</th>
                                                <th scope="col">Tên sản phẩm</th>
                                                <th scope="col">Giá</th>
                                                <th scope="col">Số lượng</th>
                                                <th scope="col">Tổng giá</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($product as $item)
                                                <tr class="text-center">
                                                    <td><img src="{{ asset('storage/uploads/products/' . $item->img_first) }}"
                                                            class="product-image" alt="{{ $item->name }}"></td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ number_format($item->price) }} VND</td>
                                                    <td>{{ $item->quantitycart }}</td>
                                                     <td>{{ number_format($item->price * $item->quantitycart) }} VND</td>
                                                    {{-- <td> <a href="{{ route('shop.shop-details', $item->product_id)}}" class="btn btn-primary">Đánh giá</a></td> --}}
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Các đơn hàng trước đây -->
                <h5 class="mb-3">Các đơn hàng trước đây</h5>
                <div class="row ">
                    @foreach ($order_user as $item)
                        <div class="col-md-6 ">
                            <div class=" order-info row p-3 g-0">
                                <h5>Mã đơn hàng: {{ $item->order_id }}</h5>
                                <div class="col-md-6 col-12">
                                    <p>Ngày đặt hàng: {{ \Carbon\Carbon::parse($item->created_at)->format('H:i d/m/Y') }}
                                    </p>
                                    <p class="d-flex status-failure">Giá trị đơn hàng:
                                        {{ number_format($item->price_sale ?? $item->price_old) }}đ</p>
                                </div>

                                <div class="col-md-6 col-12 text-end">
                                     <p class="order-status status-success">
                                        Phương thức thanh toán:
                                        @if ($item->payment_method == 1)
                                            VNPay
                                        @elseif($item->payment_method == 0)
                                            Khi nhận hàng
                                        @elseif($item->payment_method == 2)
                                           MoMoPay
                                        @elseif($item->payment_method == 4)
                                            ZaloPay
                                        @else
                                            Không xác định
                                        @endif
                                    </p>
                                        @if ($item->payment_status == 1)
                                        <p
                                            class="order-status 
                                                  @if ($item->order_status == 1) status-success
                                                  @elseif ($item->order_status == 0) status-pending
                                                @else status-cancelled @endif">
                                            {{ $item->order_status == 1 ? 'Đã xác nhận' : ($item->order_status == 0 ? 'Đang chờ xử lý' : 'Đã hủy') }}
                                        </p>
                                    @else
                                        <p class="order-status status-failed">Thanh toán thất bại</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
