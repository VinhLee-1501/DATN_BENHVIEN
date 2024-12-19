@extends('layouts.shop.app')

@section('content')

    <!-- Checkout Section Begin -->
    <section class="checkout mt-3">
        <div class="container">

            <div class="checkout__form">
                <h4>Chi tiết thanh toán</h4>
                <form id="formShip" action="{{route('shop.order')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-7 col-md-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Tên<span>*</span></p>
                                        <input type="text" name="first_name"
                                            value="{{ $user->firstname ?? session('formData')['first_name'] }}" required>
                                            <div class="invalid-feedback" id="first_name_error"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Họ<span>*</span></p>
                                        <input type="text" name="last_name"
                                            value="{{ $user->lastname ?? session('formData')['last_name'] }}" required>
                                             <div class="invalid-feedback" id="last_name_error"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-12">
                                    <div class="checkout__input">
                                        <p>Tỉnh<span>*</span></p>
                                        <select id="provinces" name="province" onchange="getProvinces(event)"
                                            class="w-100" required>
                                            <option value="">-- Chọn Tỉnh/thành phố --</option>
                                            <!-- Các tỉnh sẽ được thêm vào đây bằng JavaScript -->
                                        </select>
                                        <!-- Thêm thẻ span để hiển thị giá trị đã chọn -->
                                        <input type="hidden" id="provinceName" name="province_name" />

                                        <span id="provinceDisplay" class="selected-value"></span>
                                         <div class="invalid-feedback" id="province_error"></div>
                                    </div>

                                </div>
                                <div class="col-lg-4 col-12">
                                    <div class="checkout__input">
                                        <p>Quận/huyện<span>*</span></p>
                                        <select id="districts" name="district" onchange="getDistricts(event)"
                                            class="w-100" required>
                                            <option value="">-- Chọn quận/huyện --</option>
                                            <!-- Các quận sẽ được thêm vào đây bằng JavaScript -->
                                        </select>
                                        <!-- Thêm thẻ span để hiển thị giá trị đã chọn -->
                                        <input type="hidden" id="districtName" name="district_name" />
                                        <span id="districtDisplay" class="selected-value"></span>
                                         <div class="invalid-feedback" id="district_error"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-12">
                                    <div class="checkout__input">
                                        <p>Phường/xã<span>*</span></p>
                                        <select id="wards" name="ward" class="w-100" required>
                                            <option value="">-- Chọn phường/xã --</option>
                                            <!-- Các phường sẽ được thêm vào đây bằng JavaScript -->
                                        </select>
                                        <!-- Thêm thẻ span để hiển thị giá trị đã chọn -->
                                        <input type="hidden" id="wardName" name="ward_name" />
                                        <span id="wardDisplay" class="selected-value"></span>
                                         <div class="invalid-feedback" id="ward_error"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="checkout__input">
                                <p>Địa chỉ cụ thể<span>*</span></p>
                                <input type="text" name="address" placeholder="Địa chỉ nhận hàng"
                                    class="checkout__input__add" value="{{ session('formData')['address'] ?? '' }}" required>
                                    <div class="invalid-feedback" id="address_error"></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Số điện thoại<span>*</span></p>
                                        <input type="text" name="phone"
                                            value="{{ $user->phone ?? session('formData')['phone'] }}" required>
                                            <div class="invalid-feedback" id="phone_error"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Email<span>*</span></p>
                                        <input type="email" name="email"
                                            value="{{ $user->email ?? session('formData')['email'] }}" required>
                                            <div class="invalid-feedback" id="email_error"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="checkout__input">
                                <p>Ghi chú<span></span></p>
                                <input type="text" name="note"
                                    placeholder="Ghi chú về đơn đặt hàng của bạn, ví dụ: ghi chú đặc biệt để giao hàng."
                                    value="{{ session('formData')['note'] ?? '' }}">
                            </div>
                            <div class="checkout__input__checkbox">
                                <h6>Bạn chưa có tài khoản? <a href="{{ route('client.login') }}">Nhấn vào đây</a> để tạo tài
                                    khoản</h6>
                            </div>

                        </div>
                        <div class="col-lg-5 col-md-6">
                            <div class="checkout__order">
                                <h4>Hóa đơn của bạn</h4>

                                <div class="checkout__order__products">Sản phẩm <span>Tổng</span></div>
                                @php
                                    use Illuminate\Support\Str;
                                    $total = 0;
                                    $total_sale = 0;
                                    $totalcart = count($cart);
                                @endphp
                                <input type="hidden" id="quantity" name="quantity" value="{{ $totalcart }}">

                                @foreach ($cart as $item)
                                    @php
                                        $price = $item->price - ($item->price * $item->percent) / 100;
                                        $subtotal = $price * $item->quantitycart;
                                        $total += $subtotal;

                                    @endphp
                                    <ul>
                                        <li>
                                            <img src="{{ asset('storage/uploads/products/' . $item->img_first) }}"
                                                style="width: 50px; height: 50px; margin-right: 10px;">
                                            {{ Str::limit($item->name, 20) }}
                                            (x{{ $item->quantitycart }})
                                            <span>{{ number_format($price * $item->quantitycart) }} đ</span>
                                        </li>
                                    </ul>
                                @endforeach

                                <div class="checkout__order__subtotal">Tổng tiền <span
                                        id="total">{{ number_format($total) }} đ</span>
                                    <input type="hidden" name="total" id="total" value="{{ $total }}">
                                </div>

                                <div class="checkout__order__shipping-fee d-flex">
                                    <p>Phí giao hàng</p>
                                    <p id="shipping-fee" class="ms-auto"></p>
                                </div>


                                <div class="checkout__order__shipping-fee d-flex">
                                    <p>Giảm giá: @if (isset($coupon))
                                        {{ $coupon->percent }}%
                                    @endif
                                </p>
                                    <p class="ms-auto" id="sale"> {{ number_format($sale) ?? '0' }} đ</p>
                                </div>
                                <div class="checkout__order__total">Tổng <span id="total_sale"></span>
                                    <input type="hidden" name="total_final" id="total_final">
                                    <input type="hidden" name="cart_id" id="cart_id"
                                        value="{{ $cart[0]->cart_id }}">
                                </div>
                                <input type="hidden" name="coupon_id" id="coupon_id" value="{{ $discount }}">

                                <div class="checkout__input__checkbox">
                                    <label for="payment_cash">
                                        Thanh toán khi nhận hàng
                                        <input type="radio" id="payment_cash" name="payment_option" value="cash"
                                            checked>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>

                                <div class="checkout__input__checkbox">
                                    <label for="payment_vnpay">
                                        Thanh toán VNPAY
                                        <input type="radio" id="payment_vnpay" name="payment_option" value="vnpay">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>

                                <div class="checkout__input__checkbox">
                                    <label for="payment_momo">
                                        Thanh toán MOMO
                                        <input type="radio" id="payment_momo" name="payment_option" value="momo">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="checkout__input__checkbox">
                                    <label for="payment_zalopay">
                                        Thanh toán Zalo Pay
                                        <input type="radio" id="payment_zalopay" name="payment_option"
                                            value="zalopay">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>

                                <button type="submit" name="redirect" class="site-btn">Thanh toán</button>
                                </p>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>

    </section>
@endsection
