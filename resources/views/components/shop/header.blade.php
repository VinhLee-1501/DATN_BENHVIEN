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

            <li  {{ Request::routeIs('client.home') ? 'active' : '' }}">
                <a  href="{{ route('client.home') }}">Khám bệnh</a>
            </li>
        </ul>
    </nav>
    <div id="mobile-menu-wrap"></div>
    
    
</div>
<!-- Humberger End -->
<!-- Header Section Begin -->
<header class="header">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="header__logo">
                    <a href="{{ route('client.home') }}">
                        <img src="{{ asset('frontend/shop/img/vietcare.png')}}" style="max-height: 50px" alt=""></a>
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

                        <li style="border: 1px solid #048647; border-radius: 3px;

                        " class=" {{ Request::routeIs('client.home') ? 'active' : '' }}">
                            <a class="px-2 " href="{{ route('client.home') }}">Khám bệnh</a>
                        </li>


                        <!-- 3 danh mục -->
                        <!-- <li class="{{ Request::routeIs('shop.medicine-category1') ? 'active' : '' }}">
                            <a href="#">Thuốc</a>
                            <ul class="header__menu__dropdown">
                                <li><a href="./shop-details.html">Shop Details</a></li>
                                <li><a href="./shoping-cart.html">Shoping Cart</a></li>
                                <li><a href="./checkout.html">Check Out</a></li>
                                <li><a href="./blog-details.html">Blog Details</a></li>
                            </ul>
                        </li>
                        <li class="{{ Request::routeIs('shop.medicine-category2') ? 'active' : '' }}">
                            <a href="#">Thuốc</a>
                            <ul class="header__menu__dropdown">
                                <li><a href="./shop-details.html">Shop Details</a></li>
                                <li><a href="./shoping-cart.html">Shoping Cart</a></li>
                                <li><a href="./checkout.html">Check Out</a></li>
                                <li><a href="./blog-details.html">Blog Details</a></li>
                            </ul>
                        </li>
                        <li class="{{ Request::routeIs('shop.medicine-category3') ? 'active' : '' }}">
                            <a href="#">Thuốc</a>
                            <ul class="header__menu__dropdown">
                                <li><a href="./shop-details.html">Shop Details</a></li>
                                <li><a href="./shoping-cart.html">Shoping Cart</a></li>
                                <li><a href="./checkout.html">Check Out</a></li>
                                <li><a href="./blog-details.html">Blog Details</a></li>
                            </ul>
                        </li> -->
                        <!-- /3 danh mục -->
                    </ul>

                </nav>
            </div>
            <div class="col-lg-3">
                <div class="header__cart">
                    <ul>
                        <!-- <li><a href="#"><i class="fa fa-heart"></i> <span>1</span></a></li> -->
                        <li><a href="{{ route('shop.cart') }}"><i class="fa fa-shopping-bag"></i> <span>{{ $cartCount ?? 0  }}</span></a>
                        </li>
                    </ul>
                    <div class="header__cart__price">Tổng giá: <span>{{ Number::currency($cartCountPrice, 'VND', 'vi') ?? 0 }}</span></div>
                </div>
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
            <div class="col-lg-3">
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
            <div class="col-lg-9">
                <div class="hero__search">
                    <div class="hero__search__form">
                        <form action="#">
                            <!-- <div class="hero__search__categories">
                                    Danh mục thuốc
                                    <span class="arrow_carrot-down"></span>
                                </div> -->
                            <input type="text" placeholder="Bạn đang cần gì">
                            <button type="submit" class="site-btn">TÌM KIẾM</button>
                        </form>
                    </div>
                    <div class="hero__search__phone">
                        <div class="hero__search__phone__icon">
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
    </div>
</section>
<!-- Hero Section End -->