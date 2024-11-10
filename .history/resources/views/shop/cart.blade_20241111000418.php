@extends('layouts.shop.app')

@section('content')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="{{ asset('frontend/shop/img/breadcrumb.jpg') }}  ">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Giỏ hàng</h2>
                        <div class="breadcrumb__option">
                            <a href="  {{ route('shop.shop') }} ">Trang chủ</a>
                            <span>Giỏ hàng</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shoping Cart Section Begin -->
    <section class="shoping-cart spad">
        <div class="container">
            <form action="{{ route('shop.updateCart') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-lg-12">
                        <div class="shoping__cart__table">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="shoping__product">Sản phẩm</th>
                                        <th>Giá</th>
                                        <th>Số lượng</th>
                                        <th>Tổng tiền</th>
                                        <th>Xóa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cartItems as $item)
                                        <tr>
                                            <td class="shoping__cart__item">
                                                <img src="{{ asset('storage/uploads/products/' . $productById->img_array[0]) }}" alt="">
                                                <h5>{{ $item->productName }}</h5>
                                            </td>
                                            <td class="shoping__cart__price">
                                                {{ Number::currency($item->price, 'VND', 'vi') }}
                                            </td>
                                            <td class="shoping__cart__quantity">
                                                <div class="quantity">
                                                    <div class="pro-qty">
                                                        <input type="text" name="quantity[{{ $item->cart_id }}]"
                                                            value="{{ $item->quantity }}">
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="shoping__cart__total">
                                                {{ Number::currency($item->total_price, 'VND', 'vi') }}
                                            </td>
                                            <td class="shoping__cart__item__close">
                                                <input type="checkbox" name="remove[{{ $item->cart_id }}]" value="1"
                                                    class="remove-item-checkbox">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="shoping__cart__btns">
                            <a href="{{ route('shop.shop-grid') }}" class="primary-btn cart-btn">Tiếp tục mua hàng</a>
                            <button type="submit" class="btn primary-btn cart-btn cart-btn-right"><span
                                    class="icon_loading"></span>
                                Cập nhật giỏ hàng</button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-lg-6">
                    <div class="shoping__continue">
                        <div class="shoping__discount">
                            <h5>Discount Codes</h5>
                            <form action="#">
                                <input type="text" placeholder="Enter your coupon code">
                                <button type="submit" class="site-btn">APPLY COUPON</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="shoping__checkout">
                        <h5>Cart Total</h5>
                        <ul>
                            <li>Subtotal <span>$454.98</span></li>
                            <li>Total <span>$454.98</span></li>
                        </ul>
                        <a href="#" class="primary-btn">PROCEED TO CHECKOUT</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shoping Cart Section End -->
@endsection
