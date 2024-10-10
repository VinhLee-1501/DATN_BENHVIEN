<header class="header">
    <div class="container">
        <div class="header__frame">
            <a href="{{ route('client.home') }}" class="header__logo">
                <img src="{{ asset('frontend/assets/image/logo-header.png') }}" alt="VIETCARE HOSPITAL" />
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
                    <a href="{{ route('client.profile.index') }}" class="">{{ auth()->user()->lastname }}
                        {{ auth()->user()->firstname }}</a>
                </div>
            @else
                <div class="header__login">
                    <div class="login-container">
                        <div class="button btn-small btn-cta openPopup">
                            Đăng nhập
                        </div>

                        <div class="login-options" style="display: none;">
                            <a href="{{ route('client.login') }}">
                                <div style="border-radius: 0px; width: 240px" class="button btn-small">
                                    Đăng nhập người dùng
                                </div>
                            </a>
                            <a href="{{ route('system.auth.login') }}">
                                <div style="border-radius: 0px; width: 240px" class="button btn-small">
                                    Đăng nhập với bác sĩ
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <script>
                    // Lấy các phần tử cần thiết
                    const loginContainer = document.querySelector('.login-container');
                    const loginOptions = document.querySelector('.login-options');
                    const loginButton = loginContainer.querySelector('.openPopup');

                    // Hiện/ẩn login-options khi nhấn vào nút Đăng nhập
                    loginButton.addEventListener('click', function(event) {
                        event.stopPropagation(); // Ngăn sự kiện click tiếp tục lan truyền
                        loginOptions.style.display = loginOptions.style.display === 'block' ? 'none' : 'block';
                    });

                    // Ẩn login-options khi nhấn ra ngoài
                    document.addEventListener('click', function() {
                        loginOptions.style.display = 'none';
                    });
                </script>
            @endif

            <div class="header__booking">

                <a href="{{ route('client.booking') }}">
                    <div class="button btn-small btn-cta openPopup">
                        <i class="fa-regular fa-calendar-check"></i> Đặt lịch
                    </div>
                </a>

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
        <a href="{{ route('client.booking') }}">
            <div class="button btn-flex openPopup" data-popup="#popupBooking">
                <i class="fa-regular fa-calendar-check"></i> Đặt lịch
            </div>
        </a>
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
