@extends('layouts.shop.app')
<style>
    .price_sale {
        color: #b2b2b2;
        font-size: 14px;
        font-weight: 400;
        text-decoration: line-through;
    }
</style>
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
                                        @php
                                            $originalPriceProductCart = $item->price;
                                            $discountProductCart = $item->discount;
                                            if ($discountProductCart >= 1000) {
                                                $discountedPriceProductCart =
                                                    $originalPriceProductCart - $discountProductCart;
                                                $discountPercentProductCart =
                                                    ($discountProductCart / $originalPriceProductCart) * 100;
                                            } elseif ($discountProductCart < 100) {
                                                $discountedPriceProductCart =
                                                    $originalPriceProductCart -
                                                    ($originalPriceProductCart * $discountProductCart) / 100;
                                                $discountPercentProductCart = $discountProductCart;
                                            } else {
                                                $discountedPriceProductCart = $originalPriceProductCart;
                                            }
                                        @endphp
                                        <tr>
                                            <td class="shoping__cart__item">
                                                <img src="{{ asset('storage/uploads/products/' . $item->img_array[0]) }}"
                                                    class="w-25" alt="">
                                                <h6>{{ $item->productName }}</h6>
                                            </td>
                                            <td class="shoping__cart__price w-auto">
                                                @if ($item->dateStartSale <= now() && $item->dateEndSale >= now())
                                                    <span
                                                        id="price_discount">{{ Number::currency($discountedPriceProductCart, 'VND', 'vi') }}</span>
                                                    <span
                                                        class="price_sale">{{ Number::currency($originalPriceProductCart, 'VND', 'vi') }}</span>
                                                @else
                                                    <span
                                                        class="price_origin">{{ Number::currency($originalPriceProductCart, 'VND', 'vi') }}</span>
                                                @endif
                                            </td>
                                            <td class="shoping__cart__quantity">
                                                <div class="quantity">
                                                    <div class="pro-qty">
                                                        <input type="number" id="quantity"
                                                            name="quantity[{{ $item->cart_id }}]"
                                                            value="{{ $item->quantity }}" min="1">
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="shoping__cart__total" id="total_price">
                                                {{-- {{ Number::currency($item->total_price, 'VND', 'vi') }} --}}
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
                <div class="text-md-right mb-4" style="font-size: 20px">Tổng tiền giỏ hàng:
                    <span id="total_cart" class="" style="font-weight: 600"></span>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cartItems = document.querySelectorAll("tbody tr");

            function updateCartTotal() {
                let totalCart = 0;

                cartItems.forEach(item => {
                    const productDiscountElement = item.querySelector('#price_discount');
                    const priceOriginElem = item.querySelector('.price_origin');

                    console.log(productDiscountElement);
                    console.log(priceOriginElem);
                    
                    let price = 0;

                    if (productDiscountElement) {
                        price = parseFloat(productDiscountElement.textContent.replace(/[^\d]/g, ''));
                    } else if (priceOriginElem) {
                        price = parseFloat(priceOriginElem.textContent.replace(/[^\d]/g, ''));
                    }

                    const quantityElem = item.querySelector("#quantity");
                    let quantity = quantityElem ? parseInt(quantityElem.value) : 1;

                    let totalPrice = price * quantity;

                    // Hiển thị tổng tiền cho sản phẩm
                    const totalPriceElem = item.querySelector("#total_price");
                    if (totalPriceElem) {
                        totalPriceElem.textContent = new Intl.NumberFormat('vi-VN', {
                            style: 'currency',
                            currency: 'VND'
                        }).format(totalPrice);
                    }

                    totalCart += totalPrice;
                });

                const totalCartElement = document.querySelector('#total_cart');
                if (totalCartElement) {
                    totalCartElement.textContent = new Intl.NumberFormat('vi-VN', {
                        style: 'currency',
                        currency: 'VND'
                    }).format(totalCart);
                }
            }

            updateCartTotal();

            document.querySelectorAll("#quantity").forEach(input => {
                input.addEventListener("input", updateCartTotal);
            });
        });
    </script>
@endsection
