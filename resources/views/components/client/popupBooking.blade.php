<style>

</style>

<div id="popupBooking" class="popup booking">
    <div class="popup__container">
        <div class="popup__frame">
            <div class="popup__image">
                <img src="{{ asset('frontend/assets/image/benh-tai-mui-hong-o-tre(1).jpg') }}" alt="Hình ảnh" />
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
                                alt="Background" />
                        </div>
                        <div class="form__notice">
                            <div class="notice success">Thông tin đã gửi thành công!</div>
                            <div class="notice error">Lỗi! Không gửi được thông tin!</div>
                            <div class="notice warning">
                                Vui lòng nhập đúng định dạng!
                            </div>
                        </div>
                        <form action="{{ route('client.booking') }}" method="POST">
                            @csrf
                            <div class="form__frame">
                                <div class="form__flex">
                                    <div class="form__group">
                                        <input id="day" type="text" name="day" placeholder="Chọn ngày"
                                            onfocus="this.type='date'" onclick="hidePast()"
                                            value="{{ old('day') }}" />
                                        @if ($errors->has('day'))
                                            <span class="text-danger">{{ $errors->first('day') }}</span>
                                        @endif
                                    </div>
                                    <div class="form__group">
                                        <input id="hour" type="time" name="hour" placeholder="Chọn giờ"
                                            value="{{ old('day') }}" />
                                        @if ($errors->has('hour'))
                                            <span class="text-danger">{{ $errors->first('hour') }}</span>
                                        @endif
                                    </div>
                                </div>

                                @if (Auth::check())
                                    @php
                                        $user = Auth::user();
                                        $userInfo = \App\Models\Patient::where('phone', $user->phone)->first();
                                    @endphp
                                    @if ($userInfo)
                                        <div class="form__group">
                                            <input id="name" type="text" name="name"
                                                value="{{ $userInfo->first_name }} {{ $userInfo->last_name }}"
                                                placeholder="Họ tên" />
                                            @if ($errors->has('name'))
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                        <div class="form__group">
                                            <input id="phone" type="text" name="phone"
                                                value="{{ $userInfo->phone }}" placeholder="Số điện thoại" />
                                            @if ($errors->has('phone'))
                                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                                            @endif
                                        </div>
                                        <div class="form__group">
                                            <input id="email" type="text" name="email"
                                                value="{{ Auth::user()->email ?? '' }}" placeholder="Email (nếu có)" />
                                            @if ($errors->has('email'))
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>
                                    @else
                                        <div class="form__group">
                                            <input id="name" type="text" name="name"
                                                value="{{ old('name') }}" placeholder="Họ tên" />
                                            @if ($errors->has('name'))
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                        <div class="form__group">
                                            <input id="phone" type="text" name="phone"
                                                value="{{ old('phone') }}" placeholder="Số điện thoại" />
                                            @if ($errors->has('phone'))
                                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                                            @endif
                                        </div>
                                        <div class="form__group">
                                            <input id="email" type="text" name="email"
                                                value="{{ old('email') }}" placeholder="Email (nếu có)" />
                                            @if ($errors->has('email'))
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>
                                    @endif
                                @else
                                    <div class="form__group">
                                        <input id="name" type="text" name="name" value="{{ old('name') }}"
                                            placeholder="Họ tên" />
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                    <div class="form__group">
                                        <input id="phone" type="text" name="phone" value="{{ old('phone') }}"
                                            placeholder="Số điện thoại" />
                                        @if ($errors->has('phone'))
                                            <span class="text-danger">{{ $errors->first('phone') }}</span>
                                        @endif
                                    </div>

                                    <div class="form__group">
                                        <input id="email" type="text" name="email"
                                            value="{{ old('email') }}" placeholder="Email (nếu có)" />
                                        @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>


                                @endif
                                <div class="form__flex">
                                    <div class="form__group">
                                        <select style="width: 100%" id="specialty" name="specialty_id">
                                            <option value="" disabled
                                                {{ old('specialty_id') == '' ? 'selected' : '' }}>--Chọn chuyên khoa--
                                            </option>
                                            @foreach ($specialties as $specialty)
                                                <option value="{{ $specialty->specialty_id }}"
                                                    {{ old('specialty_id') == $specialty->specialty_id ? 'selected' : '' }}>
                                                    {{ $specialty->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('specialty_id'))
                                            <span class="text-danger">{{ $errors->first('specialty_id') }}</span>
                                        @endif

                                    </div>
                                    <div class="form__group">
                                        <select style="width: 100%" id="role" name="role">
                                            <option value="" disabled
                                                {{ old('specialty_id') == '' ? 'selected' : '' }}>--Chọn hình thức
                                                khám--</option>
                                            <option value="0">Trực tiếp</option>
                                            <option value="1">Trực tuyến</option>
                                        </select>
                                        @if ($errors->has('role'))
                                            <span class="text-danger">{{ $errors->first('role') }}</span>
                                        @endif

                                    </div>
                                </div>

                                <div class="form__group">
                                    <textarea id="symptoms" name="symptoms" value="" placeholder="Triệu chứng (nếu có)">{{ old('symptoms') }}</textarea>
                                    @if ($errors->has('symptoms'))
                                        <span class="text-danger">{{ $errors->first('symptoms') }}</span>
                                    @endif
                                </div>

                                <!-- Hiển thị reCAPTCHA -->
                                <div class="recaptcha-container">
                                    <div class="g-recaptcha" data-sitekey="{{ config('recaptcha.site_key') }}"></div>
                                    <!-- Hiển thị lỗi -->
                                </div>

                                @if ($errors->has('g-recaptcha-response'))
                                    <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                                @endif


                                <div class="form__action">
                                    <button type="submit" class="button btn-booking btn-flex">
                                        <i class="fa-regular fa-calendar-check"></i> Đặt lịch
                                    </button>
                                    <div class="button btn-secondary btn-cancel btn-flex closePopup">Huỷ</div>
                                </div>
                            </div>
                        </form>



                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
