<div id="popupLogin" class="popup login">
    <div class="popup__container">
        <div class="popup__frame">
            <div class="popup__form">
                <div class="popup__close closePopup">
                    <i class="fa-solid fa-xmark"></i>
                </div>
                <div class="popup__form--frame">
                    <div class="box-header">
                        <div class="box-title text-center highlight">Đăng nhập</div>
                    </div>
                    <form action="{{ route('client.login') }}" method="POST" class="form login">
                        @csrf
                        <div id="loading" style="display:none;">
                            <img src="https://phongkhamtuean.com.vn/frontend/home/images/loading.gif"
                                alt="Loading..." />
                        </div>
                        <x-message.message></x-message.message>
                        <div class="form__frame">
                            <div class="form__group">
                                <input id="phone" type="text" name="phone" placeholder="Số điện thoại" />
                                @error('phone')
                                    <div class="form__error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form__group">
                                <input id="password" type="password" name="password" placeholder="Mật khẩu" />
                                @error('password')
                                    <div class="form__error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form__group form__group--checkbox">
                                <input id="rememberMe" type="checkbox" name="rememberMe" />
                                <label for="rememberMe">Ghi nhớ đăng nhập</label>
                            </div>
                            <div class="form__action">
                                <button style="border:none" type="submit" class="button btn-login btn-flex">
                                    Đăng nhập
                                </button>
                                <button type="button" class="button btn-secondary btn-cancel btn-flex closePopup">
                                    Huỷ
                                </button>
                            </div>
                            <div class="form__link text-center p-3">
                                <a href="#" class="openPopup" data-popup="#popupForgotPassword">Quên mật khẩu?</a>
                                |
                                <a href="{{ route('client.register') }}" class=" openPopup" data-popup="">Đăng ký</a>

                            </div>
                            <div class="form__social-login text-center">
                                <div style="background-color: #ea4335; color: #fff"
                                    class="button btn-google-login btn-flex">
                                    <span>Đăng nhập với</span><Span style="font-size: 25px;">Google</Span>

                                </div>
                                <div style="background-color:#0068FF; color:#fff"
                                    class="button btn-zalo-login btn-flex">
                                    <span>Đăng nhập với</span><span style="font-size: 25px;">Zalo</span>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="popupRegister" class="popup register">
    <div class="popup__container">
        <div class="popup__frame">
            <div class="popup__form">
                <div class="popup__close closePopup">
                    <i class="fa-solid fa-xmark"></i>
                </div>
                <div class="popup__form--frame">
                    <div class="box-header">
                        <div class="box-title text-center highlight">Đăng kí</div>
                    </div>
                    <form action="{{ route('client.register') }}" method="POST" class="form register">
                        @csrf
                        <div id="loading" style="display:none;">
                            <img src="https://phongkhamtuean.com.vn/frontend/home/images/loading.gif"
                                alt="Loading..." />
                        </div>
                        <x-message.message></x-message.message>
                        <div class="form__frame">
                            <!-- Trường Họ -->
                            <div class="form__action">
                                <div class="form__group">
                                    <input id="lastname" type="text" name="lastname" placeholder="Họ"
                                        value="{{ old('lastname') }}" />
                                    @error('lastname')
                                        <div class="form__error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Trường Tên -->
                                <div class="form__group">
                                    <input id="firstname" type="text" name="firstname" placeholder="Tên"
                                        value="{{ old('firstname') }}" />
                                    @error('firstname')
                                        <div class="form__error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <!-- Trường Số điện thoại -->
                            <div class="form__group">
                                <input id="phone" type="text" name="phone" placeholder="Số điện thoại"
                                    value="{{ old('phone') }}" />
                                @error('phone')
                                    <div class="form__error">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Trường Email -->
                            <div class="form__group">
                                <input id="email" type="email" name="email" placeholder="Email"
                                    value="{{ old('email') }}" />
                                @error('email')
                                    <div class="form__error">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Trường Mật khẩu -->
                            <div class="form__group">
                                <input id="password" type="password" name="password" placeholder="Mật khẩu" />
                                @error('password')
                                    <div class="form__error">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Trường Nhập lại mật khẩu -->
                            <div class="form__group">
                                <input id="password_confirmation" type="password" name="password_confirmation"
                                    placeholder="Nhập lại mật khẩu" />
                                @error('password_confirmation')
                                    <div class="form__error">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Nút hành động -->
                            <div class="form__action">
                                <button style="border: none" type="submit" class="button btn-register btn-flex">Đăng
                                    kí</button>
                                <button type="button"
                                    class="button btn-secondary btn-cancel btn-flex closePopup">Huỷ</button>
                            </div>

                            <!-- Link đến đăng nhập -->
                            <div class="form__link text-center">
                                Đã có tài khoản? <a href="#" class="openPopup" data-popup="#popupLogin">Đăng
                                    nhập</a>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
</div>


<div id="popupForgotPassword" class="popup forgot-password">
    <div class="popup__container">
        <div class="popup__frame">
            <div class="popup__form">
                <div class="popup__close closePopup">
                    <i class="fa-solid fa-xmark"></i>
                </div>
                <div class="popup__form--frame">
                    <div class="box-header">
                        <div class="box-title text-center highlight">Quên mật khẩu
                        </div>
                    </div>
                    <div class="form forgot-password">
                        <div id="loading" style="display:none;">
                            <img src="https://phongkhamtuean.com.vn/frontend/home/images/loading.gif"
                                alt="Loading..." />
                        </div>
                        <div class="form__notice">
                            <div class="notice success" style="display:none;">Gửi link
                                thành công!</div>
                            <div class="notice error" style="display:none;">Lỗi! Vui
                                lòng kiểm tra thông tin!</div>
                        </div>
                        <div class="form__frame">
                            <div class="form__group">
                                <input id="emailForgot" type="email" name="emailForgot" placeholder="Email" />
                            </div>
                            <div class="form__action">
                                <div class="button btn-submit btn-flex">
                                    Gửi link khôi phục
                                </div>
                                <div class="button btn-secondary btn-cancel btn-flex closePopup">
                                    Huỷ
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
