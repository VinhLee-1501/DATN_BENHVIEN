<div id="popupBooking" class="popup booking">
    <div class="popup__container">
        <div class="popup__frame">
            <div class="popup__image">
                <img src="{{asset('frontend/assets/image/benh-tai-mui-hong-o-tre(1).jpg')}}" alt="Hình ảnh"/>
            </div>
            <div class="popup__form">
                <div class="popup__close closePopup">
                    <i class="fa-solid fa-xmark"></i>
                </div>
                <div class="popup__form--frame">
                    <div class="box-header">
                        <div class="box-title text-center highlight">Đặt lịch hẹn</div>
                    </div>
                    <div class="form booking">
                        <div id="loading">
                            <img src="https://phongkhamtuean.com.vn/frontend/home/images/loading.gif"
                                 alt="Background"/>
                        </div>
                        <div class="form__notice">
                            <div class="notice success">Thông tin đã gửi thành công!</div>
                            <div class="notice error">Lỗi! Không gửi được thông tin!</div>
                            <div class="notice warning">
                                Vui lòng nhập đúng định dạng!
                            </div>
                        </div>
                        <div class="form__frame">

                            <div class="form__flex">
                                <div class="form__group">
                                    <input id="date" type="text" name="date" placeholder="Chọn ngày"
                                           onfocus="this.type='date'" onclick="hidePast()"/>
                                </div>
                                <div class="form__group">
                                    <input id="time" type="text" name="time" min="08:30" max="17:00"
                                           placeholder="Chọn thời gian" onfocus="this.type='time'"/>
                                </div>
                            </div>
                            <div class="form__group">
                                <input id="fullname" type="text" name="fullname" placeholder="Họ tên"/>
                            </div>
                            <div class="form__group">
                                <input id="phone" type="text" name="phone" placeholder="Số điện thoại"/>
                            </div>
                            <div class="form__group">
                                <input id="email" type="text" name="email" placeholder="Email (nếu có)"/>
                            </div>
                            <div class="form__group">
                                <input id="content" type="text" name="content" placeholder="Nội dung (nếu có)"/>
                                <input id="webiste" type="text" name="website" style="display: none"/>
                            </div>
                            <div class="form__action">
                                <div class="button btn-booking btn-flex">
                                    <i class="fa-regular fa-calendar-check"></i> Đặt lịch
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
