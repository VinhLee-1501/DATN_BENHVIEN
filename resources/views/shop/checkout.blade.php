@extends('layouts.shop.app')

@section('content')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Thanh toán</h2>
                        <div class="breadcrumb__option">
                            <a href="./index.html">Trang chủ</a>
                            <span>Thanh toán</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h6><span class="icon_tag_alt"></span> Bạn có mã giảm giá? <a href="#">Nhấn vào đây</a> để nhập mã
                    </h6>
                </div>
            </div>
            <div class="checkout__form">
                <h4>Chi tiết thanh toán</h4>
                <form action="{{ route('shop.calculateShippingFee') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Tên<span>*</span></p>
                                        <input type="text" name="first_name" value="{{ session('formData')['first_name'] ?? '' }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Họ<span>*</span></p>
                                        <input type="text" name="last_name" value="{{ session('formData')['last_name'] ?? '' }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-12">
                                    <div class="checkout__input">
                                        <p>Tỉnh<span>*</span></p>
                                        <select id="provinces" name="province" onchange="getProvinces(event)" class="w-100"
                                            required>
                                            <option value="">-- Chọn Tỉnh/thành phố --</option>
                                            <!-- Các tỉnh sẽ được thêm vào đây bằng JavaScript -->
                                        </select>
                                        <!-- Thêm thẻ span để hiển thị giá trị đã chọn -->
                                        <span id="provinceDisplay" class="selected-value"></span>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-12">
                                    <div class="checkout__input">
                                        <p>Quận/huyện<span>*</span></p>
                                        <select id="districts" name="district" onchange="getDistricts(event)" class="w-100"
                                            required>
                                            <option value="">-- Chọn quận/huyện --</option>
                                            <!-- Các quận sẽ được thêm vào đây bằng JavaScript -->
                                        </select>
                                        <!-- Thêm thẻ span để hiển thị giá trị đã chọn -->
                                        <span id="districtDisplay" class="selected-value"></span>
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
                                        <span id="wardDisplay" class="selected-value"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="checkout__input">
                                <p>Địa chỉ cụ thể<span>*</span></p>
                                <input type="text" name="address" placeholder="Địa chỉ nhận hàng"
                                    class="checkout__input__add" value="{{ session('formData')['address'] ?? '' }}" required>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Số điện thoại<span>*</span></p>
                                        <input type="text" name="phone" value="{{ session('formData')['phone'] ?? '' }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Email<span>*</span></p>
                                        <input type="email" name="email" value="{{ session('formData')['email'] ?? '' }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="checkout__input">
                                <p>Ghi chú<span></span></p>
                                <input type="text" name="note"
                                    placeholder="Ghi chú về đơn đặt hàng của bạn, ví dụ: ghi chú đặc biệt để giao hàng."
                                    value="{{ session('formData')['note'] ?? '' }}">
                            </div>

                            <button type="submit" class="site-btn mb-2">Cập nhật địa chỉ</button>
                            <div class="checkout__input__checkbox">
                                <h6>Bạn chưa có tài khoản? <a href="{{ route('client.login') }}">Nhấn vào đây</a> để tạo tài
                                    khoản</h6>
                            </div>
                            <p>Tạo một tài khoản bằng cách nhập thông tin dưới đây. Nếu bạn là khách hàng cũ vui lòng đăng
                                nhập ở đầu trang</p>

                        </div>

                </form>
                <div class="col-lg-4 col-md-6">
                    <div class="checkout__order">
                        <h4>Hóa đơn của bạn</h4>
                        <div class="checkout__order__products">Sản phẩm <span>Tổng</span></div>
                        <ul>
                            <li>Vegetable’s Package <span>500000</span></li>
                        </ul>
                        <div class="checkout__order__subtotal">Tổng phụ <span>500000</span></div>
                        <!-- Thêm phần hiển thị phí giao hàng -->
                        <div class="checkout__order__shipping-fee">Phí giao hàng
                            <span>{{ $shippingFee ?? 'Chưa tính' }}</span>
                        </div>

                        <div class="checkout__order__total">Tổng <span>500000</span></div>


                        <div class="checkout__input__checkbox">
                            <label for="acc-or">
                                Tạo tài khoản?
                                <input type="checkbox" id="acc-or" name="create_account">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adip elit, sed do eiusmod tempor incididunt ut
                            labore et dolore magna aliqua.</p>
                        <div class="checkout__input__checkbox">
                            <label for="payment">
                                Thanh toán khi nhận hàng
                                <input type="checkbox" id="payment" name="payment_option" value="cash">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="checkout__input__checkbox">
                            <label for="paypal">
                                Paypal
                                <input type="checkbox" id="paypal" name="payment_option" value="paypal">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <button type="submit" class="site-btn">Thanh toán</button>
                    </div>
                </div>
            </div>



        </div>
        </div>
    </section>
    <!-- Checkout Section End -->
@endsection
