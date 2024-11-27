@extends('layouts.shop.app') <style>
    .order-info {
        background-color: #f9f9f9;
        padding: 15px;
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

    .product-list {
        margin-top: 10px;
    }

    .product-item {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .product-image {
        width: 150px;
        height: auto;
        margin-right: 10px;
    }

    .product-details p {
        margin: 0;
    }

    .order-status {
        margin-bottom: 10px;
        font-weight: bold;
    }

    .status-success {
        color: #28a745;
        /* Màu xanh lá cây để biểu thị trạng thái hoàn thành */
    }

    .status-failure {
        color: #dc3545;
        /* Màu đỏ để biểu thị trạng thái thất bại */
    }

    .status-pending {
        color: #ffc107;
        /* Màu vàng để biểu thị trạng thái đang chờ */
    }

    .status-cod {
        color: #17a2b8;
        /* Màu xanh để biểu thị trạng thái thanh toán khi nhận hàng */
    }

    @media (max-width: 768px) {
        .order-info {
            padding: 10px;
        }

        .product-image {
            width: 40px;
            margin-right: 5px;
        }

        .product-details p {
            font-size: 14px;
        }
    }
</style>
@section('content')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="{{ asset('frontend/shop/img/breadcrumb.jpg') }}  ">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Đơn hàng</h2>
                        <div class="breadcrumb__option">
                            <a href="{{ route('shop.shop') }}">Trang chủ</a>
                            <span>Đơn hàng</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shopping Cart Section Begin -->
    @if (!$order_user)
        <h5 class="text-center p-4">Chưa có đơn hàng mua nhé !!!</h5>
    @else
        <section class="shoping-cart spad">
            <div class="container">
                @php
                    $statusText = '';
                    $statusClass = '';
                    if ($order->payment_status === 1) {
                        $statusText = 'Thanh toán thành công';
                        $statusClass = 'status-success';
                    } elseif ($order->payment_status === 2) {
                        $statusText = 'Thanh toán không thành công';
                        $statusClass = 'status-failure';
                    } else {
                        $statusText = 'Đặt hàng thành công';
                        $statusClass = 'status-cod';
                    }

                    if ($order->payment_method === 0) {
                        $methodText = 'Thanh toán khi nhận hàng';
                    } elseif ($order->payment_method === 1) {
                        $methodText = 'Thanh toán bằng VNPAY';
                    } elseif ($order->payment_method === 2) {
                        $methodText = 'Thanh toán bằng MOMOPAY';
                    } elseif ($order->payment_method === 4) {
                        $methodText = 'Thanh toán bằng ZaloPay';
                    }
                @endphp

                <!-- Thông tin đơn hàng vừa đặt -->
                <div class="order-info">
                    <h5>Thông tin đơn hàng vừa đặt</h5>
                    @if (request('vnp_TransactionStatus'))
                            <div>
                                <p>Trạng thái giao dịch: {{ request('vnp_TransactionStatus') }}</p>
                            </div>
                        @endif
                    <h5>Mã đơn hàng: {{ $order->order_id }}</h5>
                    <p>Ngày đặt hàng: {{ \Carbon\Carbon::parse($order->created_at)->format('H:i d/m/Y') }}
                        {{ $order->created_at }}</p>
                    <p class="status-failure">Tổng giá trị đơn hàng:
                        {{ number_format($order->price_sale ?? $order->price_old) }} VND</p>
                    <p class="order-status ">{{ $methodText }}</p>
                    <p class="order-status {{ $statusClass }}">{{ $statusText }}</p>
                    <div class="product-list">
                        @foreach ($product as $item)
                            <div class="product-item">
                                <img src="{{ asset('storage/uploads/products/' . $item->img_first) }}"
                                    class="product-image">
                                <div class="pt-3">
                                    <p class="m-0">{{ $item->name }}</p>
                                    <p class="m-0">{{ number_format($item->price) }} VND</p>
                                    <p class="m-0">Số lượng: {{ $item->quantity }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Các đơn hàng trước đây -->
                <h5>Các đơn hàng trước đây</h5>
                @foreach ($order_user as $item)
                    <div class="order-info">
                        <h5>Mã đơn hàng: {{ $item->order_id }}</h5>
                        <p>Ngày đặt hàng: {{ \Carbon\Carbon::parse($item->created_at)->format('H:i d/m/Y') }}</p>
                        <!-- Định dạng ngày giờ -->
                        <p class="d-flex status-failure">Giá trị đơn hàng:
                            {{ number_format($item->price_sale ?? $item->price_old) }}đ </p>
                        @php
                            $statusText = '';
                            $statusClass = '';
                            if ($item->payment_method == 0) {
                                $statusText = 'Thanh toán khi nhận hàng';
                            } elseif ($item->payment_method == 1) {
                                $statusText = 'Thanh toán bằng VNPAY';
                            } elseif ($item->payment_method == 2) {
                                $statusText = 'Thanh toán bằng MOMOPAY';
                            } else {
                                $statusText = 'Thanh toán bằng ZaloPay';
                            }
                        @endphp
                        <p class="order-status status-success">Phương thức thanh toán: {{ $statusText }}</p>

                        <!-- Thông tin địa chỉ giao hàng -->
                        <p>Địa chỉ giao hàng: {{ $item->order_address }}</p>

                        <!-- Trạng thái đơn hàng -->
                        <p
                            class="order-status 
            @if ($item->order_status === 1) status-success
            @elseif ($item->order_status === 0)
                status-pending
            @else
                status-cancelled @endif">
                            {{ $item->order_status === 1 ? 'Đã xác nhận' : ($item->order_status === 0 ? 'Đang chờ xử lý' : 'Đã hủy') }}
                        </p>
                    </div>
                @endforeach

            </div>
        </section>
    @endif

    <!-- Shopping Cart Section End -->
@endsection
