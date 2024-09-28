<header class="header">
    <div class="container">
        <div class="header__frame">
            <a href="{{ route('client.home') }}" class="header__logo">
                <img src="{{ asset('frontend/assets/image/logo2.png') }}" alt="PHÒNG KHÁM AN KHANG" />
            </a>
            <div class="header__wrap">
                <ul class="header__menu mt-3">
                    <li class="item">
                        <a class="item__link" href="{{ route('client.introduce') }}">Giới thiệu</a>
                    </li>

                    <li class="item">
                        <a class="item__link" href="{{ route('client.treatment-method') }}">Phương pháp điều trị</a>
                    </li>
                    <li class="item">
                        <a class="item__link" href="{{ route('client.news') }}">Tin tức</a>
                    </li>

                    <li class="item">
                        <a class="item__link" href="{{ route('client.contact') }}">Liên hệ</a>
                    </li>
                </ul>

            </div>
            @if (auth()->check())
                <div style="width: 200px" class="header__login">
                    <a href="{{ route('client.profile.index') }}" class="">{{ auth()->user()->last_name }} {{ auth()->user()->first_name }}</a>
                </div>
            @else
                <div class="header__login">
                    <a href="{{ route('client.login') }}">
                        <div class="button btn-small btn-cta openPopup">
                            Đăng nhập
                        </div>
                    </a>

                </div>
            @endif

            <div class="header__booking">
                <div class="button btn-small btn-cta openPopup" data-popup="#popupBooking">
                    <i class="fa-regular fa-calendar-check"></i> Đặt lịch
                </div>
            </div>
        </div>
    </div>
</header>

<div class="rd-panel">
    <div class="rd-panel__wrap">
        <button class="toggle"><span></span></button>
        <div class="logo">
            <a href="{{ route('client.home') }}"><img src="{{ asset('frontend/assets/image/logo2.png') }}" /></a>
        </div>
    </div>
    <div class="rd-panel__btn">
        <div class="button btn-flex openPopup" data-popup="#popupBooking">
            <i class="fa-regular fa-calendar-check"></i> Đặt lịch
        </div>
    </div>
    @if (auth()->check())
        <div style="width: 200px" class="header__login">
            <a href="{{ route('client.profile.index') }}" class="">{{ auth()->user()->name }}</a>
        </div>
    @else
        <div class="rd-panel__btn">
            <a href="{{ route('client.login') }}">
                <div class="button btn-flex openPopup">
                    Đăng nhập
                </div>
            </a>

        </div>
    @endif


</div>

<div class="rd-menu">
    <ul>
        <li class="active">
            <a href="{{ route('client.home') }}">Trang chủ</a>
        </li>
        <li class="">
            <a href="{{ route('client.introduce') }}">Giới thiệu</a>
        </li>
        <li class="">
            <a href="{{ route('client.treatment-method') }}">Phương pháp điều trị</a>
        </li>
        <li class="">
            <a href="{{ route('client.news') }}">Tin tức</a>
        </li>
        <li class="">
            <a href="{{ route('client.contact') }}">Liên hệ</a>
        </li>
    </ul>
</div>
