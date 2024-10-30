<div id="popupResetPassword" class="popup reset-password">
    <div class="popup__container">
        <div class="popup__frame">
            <div class="popup__form">
                <div class="popup__close closePopup">
                    <i class="fa-solid fa-xmark"></i>
                </div>
                <div class="popup__form--frame">
                    <div class="box-header">
                        <div class="box-title text-center highlight">Đổi mật khẩu</div>
                    </div>
                    <form action="{{ route('client.change-password') }}" method="POST" class="form change-password">
                        @csrf

                        <div id="loading" style="display:none;">
                            <img src="https://phongkhamtuean.com.vn/frontend/home/images/loading.gif" alt="Loading..." />
                        </div>

                        <x-message.message></x-message.message>

                        <div class="form__frame">
                            <div class="form__group">
                                <input 
                                    id="new_password" 
                                    type="password" 
                                    name="new_password" 
                                    placeholder="Mật khẩu mới" 
                                    required
                                />
                                @error('new_password')
                                    <div class="form__error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form__group">
                                <input 
                                    id="new_password_confirmation" 
                                    type="password" 
                                    name="new_password_confirmation" 
                                    placeholder="Xác nhận mật khẩu mới" 
                                    required
                                />
                                @error('new_password_confirmation')
                                    <div class="form__error">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Thêm các trường ẩn cho email và token -->
                            <input type="hidden" name="email" value="{{ request()->query('email') }}">
                            <input type="hidden" name="token" value="{{ request()->query('token') }}">

                            <div class="form__action">
                                <button style="border:none" type="submit" class="button btn-change-password btn-flex">
                                    Đổi mật khẩu
                                </button>
                                <button type="button" class="button btn-secondary btn-cancel btn-flex closePopup">
                                    Huỷ
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
