<!-- Humberger Begin -->
<div class="humberger__menu__overlay"></div>
<div class="humberger__menu__wrapper">
    <div class="humberger__menu__logo">
        <a href="#"><img src="{{ asset('frontend/shop/img/vietcare.png')}}" alt=""></a>
    </div>
    <div class="humberger__menu__cart">
        <ul>
            <li><a href="#"><i class="fa fa-shopping-bag"></i> <span>3</span></a></li>
        </ul>
        <div class="header__cart__price">item: <span>$150.00</span></div>
    </div>

    <nav class="humberger__menu__nav mobile-menu">
        <ul>
            <li class="{{ Request::routeIs('shop.shop') ? 'active' : '' }}">
                <a class="" href="{{ route('shop.shop') }}">Cửa hàng</a>
            </li>
            <li class="{{ Request::routeIs('shop.shop-grid') ? 'active' : '' }}">
                <a class="" href="{{ route('shop.shop-grid') }}">Sản phẩm</a>
            </li>

            <li class=" {{ Request::routeIs('shop.blog') ? 'active' : '' }}">
                <a class="" href="{{ route('shop.blog') }}">Tin tức</a>
            </li>

            <li class=" {{ Request::routeIs('client.home') ? 'active' : '' }}">
                <a href="{{ route('client.home') }}">Khám bệnh</a>
            </li>
            @if (auth()->check())
            <li class="nav-item">
                <a class="nav-link" href="{{ route('client.profile.index') }}">
                    <i class="fa fa-user"></i> {{ auth()->user()->firstname }}
                </a>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link" href="{{ route('client.login') }}">
                    <i class="fa fa-sign-in-alt"></i> Đăng nhập
                </a>
            </li>
            @endif

            <!-- Thêm hỗ trợ 24/7 -->
            <li class="nav-item">
                <a class="nav-link" href="tel:+840364911491">
                    <i class="fa fa-phone"></i> +84 0364911491 Hỗ trợ 24/7
                </a>
            </li>
        </ul>
    </nav>


    <div id="mobile-menu-wrap"></div>


</div>
<!-- Humberger End -->
<!-- Header Section Begin -->
<header class="header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-3">
                <div class="header__logo">
                    <a href="{{ route('client.home') }}">
                        <img src="{{ asset('frontend/shop/img/vietcare.png') }}" style="max-height: 50px"
                            alt=""></a>
                </div>
            </div>
            <div class="col-lg-6">
                <nav class="header__menu">
                    <ul style="display:flex; justify-content: space-between">
                        <li class=" {{ Request::routeIs('shop.shop') ? 'active' : '' }}">
                            <a class="" href="{{ route('shop.shop') }}">Cửa hàng</a>
                        </li>
                        <li class=" {{ Request::routeIs('shop.shop-grid') ? 'active' : '' }}">
                            <a class="" href="{{ route('shop.shop-grid') }}">Sản phẩm</a>
                        </li>

                        <li class=" {{ Request::routeIs('shop.blog') ? 'active' : '' }}">
                            <a class="" href="{{ route('shop.blog') }}">Tin tức</a>
                        </li>

                        <li style="border: 1px solid #048647; border-radius: 3px;" class=" {{ Request::routeIs('client.home') ? 'active' : '' }}">
                            <a class="px-2 " href="{{ route('client.home') }}">Khám bệnh</a>
                        </li>
                    </ul>

                </nav>

            </div>
            <div class="col-lg-3 d-flex justify-content-end">
                <div class="col-lg-3 d-none d-lg-block">
                    <div class="header__cart d-flex align-items-center justify-content-end gap-3">
                        @if (auth()->check())
                        <div class="header__login position-relative" onclick="toggleMenu()" style="cursor: pointer;">
                            @if (empty(auth()->user()->avatar))
                            <img class="border-success" class="w-auto" style="width: 28px !important; height: 28px !important; cursor: pointer;"
                                src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png"
                                alt="{{ auth()->user()->firstname }}">
                            @else
                            @if (auth()->user()->google_id || auth()->user()->zalo_id || auth()->user()->facebook_id)
                            <img class="border-success" class="w-auto" style="width: 28px !important; height: 28px !important; cursor: pointer;"
                                src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->firstname }}">
                            @else
                            @if (auth()->user()->avatar ===
                            'https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png')
                            <img class="border-success" class="w-auto" style="width: 28px !important; height: 28px !important; cursor: pointer;"
                                src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png"
                                alt="{{ auth()->user()->firstname }}">
                            @else
                            <img class="border-success" class="w-auto" style="width: 28px !important; height: 28px !important; cursor: pointer;"
                                src="{{ asset('storage/uploads/avatars/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->firstname }}">
                            @endif
                            @endif
                            @endif


                            <div id="dropdownMenuLoggedIn" class="dropdown-menu dropdown-menu-start">
                                <ul class="list-unstyled mx-0">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('client.profile.index') }}">
                                            <i class="fa-regular fa-user"></i> Thông tin tài khoản
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('client.logout') }}">
                                            <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
                                        </a>
                                    </li>
                                </ul>
                            </div>

                        </div>
                        @else
                        <div class="dropdown">
                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownLoggedOutButton">
                                Đăng nhập
                            </button>
                            <div id="dropdownMenuLoggedOut" class="dropdown-menu dropdown-menu-start">
                                <ul>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('client.login') }}">
                                            <i class="fa-regular fa-user"></i> Đăng nhập người dùng
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('system.auth.login') }}">
                                            <i class="fa-solid fa-user-doctor"></i> Đăng nhập bác sĩ
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        @endif


                        <ul class="d-flex gap-3">
                            <li>
                                <a href="{{ route('shop.cart') }}" style="cursor: pointer;">
                                    <i class="fa fa-shopping-bag"></i> <span>{{ $cartCount ?? 0 }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="humberger__open">
                    <i class="fa fa-bars"></i>
                </div>
            </div>
</header>
<!-- Header Section End -->

<!-- Hero Section Begin -->
<section class="hero hero-normal">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-12">
                <div class="hero__categories">
                    <div class="hero__categories__all">
                        <i class="fa fa-bars"></i>
                        <span>Danh mục Thuốc</span>
                    </div>
                    <ul>
                        @foreach ($parent_categories as $parent_categories_item)
                        <li><a href="#">{{ $parent_categories_item->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="dropdown w-100">
                    <form id="searchForm" action="{{route('shop.shop-grid')}}" method="GET">
                        <div class="input-group position-relative">
                            <input type="text" name="search" class="form-control" autocomplete="off"
                                id="searchInput" placeholder="Tìm sản phẩm..." style="padding: 13px">
                            <button class="btn btn-success position-absolute top-50 end-0 translate-middle-y me-2"
                                style="padding: 4px 20px; z-index: 1000;" type="submit" id="searchButton">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </form>
                    <div class="dropdown-menu search-suggestions w-100 p-3" aria-labelledby="searchInput"
                        id="searchSuggestions">
                        <div>
                            <div class="d-flex flex-wrap mb-3" id="productSuggestions">
                                <!-- Sản phẩm đề cử sẽ được hiển thị ở đây -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-12 d-none d-lg-block">
                <div class="hero__search__phone d-flex align-items-center">
                    <div class="hero__search__phone__icon me-3">
                        <i class="fa fa-phone"></i>
                    </div>
                    <div class="hero__search__phone__text">
                        <h5>+84 0364911491</h5>
                        <span>Hỗ trợ 24/7</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const inputElement = document.getElementById('searchInput');
        const searchDropdown = document.querySelector('.search-suggestions');

        // Sự kiện click trên input tìm kiếm
        inputElement.addEventListener('click', function(event) {
            if (!searchDropdown.classList.contains('show')) {
                searchDropdown.classList.add('show'); // Mở dropdown
            }
            event.stopPropagation(); // Ngăn sự kiện lan ra ngoài
        });

        // Sự kiện click ngoài dropdown (đóng dropdown)
        document.addEventListener('click', function() {
            if (searchDropdown.classList.contains('show')) {
                searchDropdown.classList.remove('show'); // Đóng dropdown
            }
        });

        // Ngăn dropdown đóng khi click vào chính nó
        searchDropdown.addEventListener('click', function(event) {
            event.stopPropagation();
        });
    });
</script>

{{-- tìm kiếm và sản phẩm đề cử --}}
<script>
    let debounceTimeout;

    // Hàm gọi AJAX khi có thay đổi trong ô input
    $('#searchInput').on('input', function() {
        let query = $(this).val().trim(); // Lấy giá trị input và loại bỏ khoảng trắng

        // Nếu có từ khóa tìm kiếm, gọi hàm tìm kiếm sản phẩm
        if (query.length > 0) {
            // Nếu có từ khóa, thực hiện debounce
            clearTimeout(debounceTimeout); // Hủy timeout cũ
            debounceTimeout = setTimeout(function() {
                fetchSuggestions(query); // Gọi AJAX để tìm kiếm sản phẩm
            }, 500);
        } else {
            // Nếu không có từ khóa (input trống), ngừng tìm kiếm và hiển thị sản phẩm đề cử
            clearTimeout(debounceTimeout); // Hủy bỏ các yêu cầu tìm kiếm đã lên lịch
            getSuggestedProducts(); // Hiển thị sản phẩm đề cử
        }
    });

    // Hàm AJAX gửi dữ liệu đến server để tìm kiếm sản phẩm
    function fetchSuggestions(query) {
        $.ajax({
            url: '{{ route("shop.search") }}', // Đường dẫn đến server xử lý tìm kiếm
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}', // Thêm CSRF token
                search: query
            },
            success: function(response) {
                const suggestionsContainer = $('#searchSuggestions');
                suggestionsContainer.empty(); // Xóa các phần cũ

                if (response.products.length > 0) {
                    let suggestionsHtml = '<div class="d-flex flex-wrap mb-3">';

                    // Kiểm tra nếu chỉ có 1 sản phẩm, dùng width 100%
                    const isSingleProduct = response.products.length === 1;

                    response.products.forEach(product => {
                        let imgUrl = "{{ asset('storage/uploads/products/') }}/" + product.img;
                        const widthStyle = isSingleProduct ? 'width: 100%' :
                            'width: calc(50% - 16px)'; // Điều chỉnh width

                        // Tạo đường dẫn chi tiết sản phẩm từ Laravel route
                        const productUrl = "{{ route('shop.shop-details', ':id') }}".replace(':id',
                            product.product_id);

                        suggestionsHtml += `
                        <a href="${productUrl}" class="product-link" style="text-decoration: none; color: inherit; display: block; text-align: center; ${widthStyle};">
                            <div class="d-flex m-2">
                                <img src="${imgUrl}" alt="${product.name}"
                                    class="img-fluid rounded" style="width: 60px; height: 60px; margin-right: 8px;">
                                <span class="d-block ps-1 overflow-hidden" style="white-space: nowrap; text-overflow: ellipsis; text-align: center;">
                                     ${product.name}
                                </span>
                            </div>
                         </a>`;
                    });
                    suggestionsHtml += '</div>';

                    suggestionsContainer.html(suggestionsHtml); // Cập nhật lại phần tử #searchSuggestions
                } else {
                    suggestionsContainer.html('<div class="text-muted">Không tìm thấy kết quả.</div>');
                }
            },
            error: function(xhr) {
                console.error('Lỗi khi gửi AJAX:', xhr);
                $('#searchSuggestions').html(
                    '<div class="text-muted">Lỗi khi tìm kiếm, vui lòng thử lại.</div>');
            }
        });
    }

    // Hàm lấy sản phẩm đề cử khi input trống
    function getSuggestedProducts() {
        $.ajax({
            url: '{{ route("shop.getSuggestedProducts") }}', // Đảm bảo đường dẫn đúng
            method: 'GET',
            success: function(response) {
                const suggestionsContainer = $('#searchSuggestions'); // Cập nhật đúng phần tử này
                let suggestionsHtml = '';

                // Tiêu đề sản phẩm đề cử (luôn hiển thị)
                suggestionsHtml += '<div class="mb-3 w-100">' +
                    '<div class="bg-warning text-white p-2 mb-2">' +
                    '<i class="fa-brands fa-product-hunt"></i> Sản phẩm đề cử' +
                    '</div>' +
                    '</div>';

                // Kiểm tra nếu có sản phẩm
                if (response.products.length > 0) {
                    suggestionsHtml += '<div class="d-flex flex-wrap mb-3">';
                    const isSingleProduct = response.products.length === 1;
                    response.products.forEach(product => {
                        let imgUrl = "{{ asset('storage/uploads/products/') }}/" + product.img;

                        const widthStyle = isSingleProduct ? 'width: 100%' :
                            'width: calc(50% - 16px)'; // Điều chỉnh width

                        // Tạo đường dẫn chi tiết sản phẩm từ Laravel route
                        const productUrl = "{{ route('shop.shop-details', ':id') }}".replace(':id',
                            product.product_id);

                        suggestionsHtml += `
                       <a href="${productUrl}" class="product-link" style="text-decoration: none; color: inherit; display: block; text-align: center; ${widthStyle};">
                            <div class="d-flex m-2">
                                <img src="${imgUrl}" alt="${product.name}"
                                    class="img-fluid rounded" style="width: 60px; height: 60px; margin-right: 8px;">
                                <span class="d-block ps-1 overflow-hidden" style="white-space: nowrap; text-overflow: ellipsis; text-align: center;">
                                     ${product.name}
                                </span>
                            </div>
                         </a>`;
                    });
                    suggestionsHtml += '</div>';
                } else {
                    suggestionsHtml += '<div class="text-muted">Không tìm thấy kết quả.</div>';
                }

                // Cập nhật nội dung của phần tử #searchSuggestions
                suggestionsContainer.html(suggestionsHtml); // Thay thế nội dung của #searchSuggestions
            },
            error: function(xhr) {
                console.error('Lỗi khi gửi AJAX:', xhr);
                $('#searchSuggestions').html(
                    '<div class="text-muted">Lỗi khi tải sản phẩm đề cử, vui lòng thử lại.</div>');
            }
        });
    }

    // Gọi getSuggestedProducts khi focus hoặc click vào ô input
    $('#searchInput').on('focus click', function() {
        if ($(this).val().trim() === '') {
            getSuggestedProducts(); // Chỉ gọi getSuggestedProducts khi input trống
        }
    });
</script>

<!-- Hero Section End -->





<!-- <div class="col-lg-6 col-12">
    <div class="hero__search">
        <div class="hero__search__form">
            <form action="#">
                <div class="input-group">
                    <input type="text" placeholder="Bạn đang cần gì" class="form-control">
                    <button type="submit" class="site-btn">TÌM KIẾM</button>
                </div>
            </form>
        </div>
    </div>
</div> -->

<!-- <div class="col-lg-3 col-12 d-none d-lg-block">
    <div class="hero__search__phone d-flex align-items-center">
        <div class="hero__search__phone__icon me-3">
            <i class="fa fa-phone"></i>
        </div>
        <div class="hero__search__phone__text">
            <h5>+84 0364911491</h5>
            <span>Hỗ trợ 24/7</span>
        </div>
    </div>
</div> -->

</div>
</div>
</section>
<!-- Hero Section End -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Dropdown cho đã đăng nhập
        const loggedInContainer = document.querySelector('.header__login');
        const loggedInMenu = document.querySelector('#dropdownMenuLoggedIn');

        if (loggedInContainer && loggedInMenu) {
            loggedInContainer.addEventListener('click', function(event) {
                event.stopPropagation();
                loggedInMenu.classList.toggle('show');
            });

            document.addEventListener('click', function() {
                loggedInMenu.classList.remove('show');
            });

            loggedInMenu.addEventListener('click', function(event) {
                event.stopPropagation();
            });
        }

        // Dropdown cho chưa đăng nhập
        const loggedOutButton = document.querySelector('#dropdownLoggedOutButton');
        const loggedOutMenu = document.querySelector('#dropdownMenuLoggedOut');

        if (loggedOutButton && loggedOutMenu) {
            loggedOutButton.addEventListener('click', function(event) {
                event.stopPropagation();
                loggedOutMenu.classList.toggle('show');
            });

            document.addEventListener('click', function() {
                loggedOutMenu.classList.remove('show');
            });

            loggedOutMenu.addEventListener('click', function(event) {
                event.stopPropagation();
            });
        }
    });
</script>