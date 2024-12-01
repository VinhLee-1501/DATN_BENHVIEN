<header class="header">
    <div class="container">
        <div class="header__frame">
            <a href="{{ route('client.home') }}" class="header__logo">
                <img src="{{ asset('frontend/shop/img/Vietcare.png')}}" alt="VIETCARE HOSPITAL" />
            </a>
            <div class="header__wrap">
                <ul class="header__menu mt-3">
                    <li class="item">
                        <a class="item__link" href="{{ route('client.introduce') }}">Giới thiệu</a>
                    </li>

                    <li class="item">
                        <a class="item__link" href="{{ route('shop.shop') }}">Cửa Hàng</a>
                    </li>
                    <li class="item">
                        <a class="item__link" href="{{ route('client.news') }}">Tin tức</a>
                    </li>

                    <li class="item">
                        <a class="item__link" href="{{ route('client.contact') }}">Liên hệ</a>
                    </li>

                    <li class="item">
                        <a class="item__link" href="{{ route('client.meeting') }}">Cuộc họp</a>
                    </li>
                </ul>

            </div>
            @if (auth()->check())
                <div style="width: 4%;" class="header__login" onclick="toggleMenu()">
                    @if (empty(auth()->user()->avatar))
                        <img style="max-width: 100%; border: 1px solid #048647;"
                            src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png"
                            alt="{{ auth()->user()->firstname }}">
                    @else
                        @if (auth()->user()->google_id || auth()->user()->zalo_id || auth()->user()->facebook_id)
                            <img style="max-width: 100%; border: 1px solid #048647;"
                                src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->firstname }}">
                        @else
                            @if (auth()->user()->avatar ===
                                    'https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png')
                                <img style="max-width: 100%; border: 1px solid #048647;"
                                    src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png"
                                    alt="{{ auth()->user()->firstname }}">
                            @else
                                <img style="max-width: 100%; border: 1px solid #048647;"
                                    src="{{ asset('storage/uploads/avatars/' . auth()->user()->avatar) }}"
                                    alt="{{ auth()->user()->firstname }}">
                            @endif
                        @endif
                    @endif


                    <div id="dropdownMenu" class="dropdown-menu" style="display: none;">
                        <ul>
                            <a href="{{ route('client.profile.index') }}">
                                <li><i class="fa-regular fa-user"></i> Thông tin tài khoản</li>
                            </a>
                            <a href="{{ route('client.logout') }}">
                                <li><i class="fa-solid fa-right-from-bracket"></i> Đăng xuất</li>
                            </a>
                        </ul>
                    </div>
                </div>
            @else
                <div class="header__login">
                    <div class="login-container">
                        <div class="button btn-small btn-cta openPopup">
                            Đăng nhập
                        </div>
                        <div id="dropdownMenu" class="dropdown-menu" style="display: none;">
                            <ul>
                                <a href="{{ route('client.login') }}">
                                    <li><i class="fa-regular fa-user"></i> Đăng nhập người dùng</li>
                                </a>
                                <a href="{{ route('system.auth.login') }}">
                                    <li><i class="fa-solid fa-user-doctor"></i> Đăng nhập bác sĩ</li>
                                </a>
                            </ul>
                        </div>
                    </div>
                </div>

                <script>
                    // Lấy các phần tử cần thiết
                    const loginContainer = document.querySelector('.login-container');
                    const loginOptions = document.querySelector('.dropdown-menu');
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
                    <div style="background-color: #ffbc11" class="button btn-small btn-cta openPopup">
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
            <a href="#">Sản phẩm</a>
        </li>
        <li class="">
            <a href="{{ route('client.news') }}">Tin tức</a>
        </li>
        <li class="">
            <a href="{{ route('client.contact') }}">Liên hệ</a>
        </li>
    </ul>
</div>
