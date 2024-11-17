@extends('layouts.shop.app')

<style>
    .btn-add-to-cart {
        background: none;
        border: none;
        padding: 0;
        outline: none;
        cursor: pointer;
    }
</style>
@section('content')
    <!-- Categories Section Begin -->
    <section class="categories">
        <div class="container">
            <div class="row">
                <div class="categories__slider owl-carousel">
                    <div class="col-lg-3">
                        <div class="categories__item set-bg"
                            data-setbg=" {{ asset('frontend/shop/img/categories/cat-1.jpg ') }}">
                            <h5><a href="#">Fresh Fruit</a></h5>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="categories__item set-bg"
                            data-setbg="{{ asset('frontend/s    hop/img/categories/cat-2.jpg ') }}">
                            <h5><a href="#">Dried Fruit</a></h5>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="categories__item set-bg"
                            data-setbg="{{ asset('frontend/shop/img/categories/cat-3.jpg ') }}">
                            <h5><a href="#">Vegetables</a></h5>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="categories__item set-bg"
                            data-setbg="{{ asset('frontend/shop/img/categories/cat-4.jpg ') }}">
                            <h5><a href="#">drink fruits</a></h5>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="categories__item set-bg"
                            data-setbg="{{ asset('frontend/shop/img/categories/cat-5.jpg ') }}">
                            <h5><a href="#">drink fruits</a></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Categories Section End -->

    <!-- Featured Section Begin -->
    <section class="featured spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Sản Phẩm Nổi Bật</h2>
                    </div>
                    <div class="featured__controls">
                        <ul>
                            <li class="active" data-filter="*">All</li>
                            @foreach ($parentCategoryProductFillter as $itemNameParent)
                                <li data-filter="{{ $itemNameParent->parent_id }}">{{ $itemNameParent->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row featured__filter">
                {{-- Filter product by parent_id to table parent_categories --}}
            </div>
        </div>
    </section>
    <!-- Featured Section End -->

    <!-- Banner Begin -->
    <div class="banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="{{ asset('frontend/shop/img/banner/banner-1.jpg ') }}" alt="">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="{{ asset('frontend/shop/img/banner/banner-2.jpg ') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner End -->

    <!-- Latest Product Section Begin -->
    <section class="latest-product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4>Sản Phẩm mới</h4>
                        <div class="latest-product__slider owl-carousel">
                            @foreach ($chunkedProductsNew as $chunkNew)
                                <div class="latest-prdouct__slider__item">
                                    @foreach ($chunkNew as $productNewItem)
                                        <a href="{{ route('shop.shop-details', $productNewItem->product_id) }}"
                                            class="latest-product__item">
                                            <div class="latest-product__item__pic w-50"> <img
                                                    src="{{ isset($productNewItem->imgName) ? asset('storage/uploads/products/' . $productNewItem->imgName) : asset('frontend/shop/img/image.jpg') }}"
                                                    alt="">
                                                
                                            </div>
                                            <div class="latest-product__item__text">
                                                <h6>{{ $productNewItem->name }}</h6>
                                                <span>
                                                    @php
                                                        $priceNewProduct = $productNewItem->price;
                                                        $discountedPriceNewProduct = $priceNewProduct; // Default to the original price if no discount
                                                        if ($productNewItem->discount_code) {
                                                            $percentNewProduct = $productNewItem->percent; // Giả sử bạn lưu tỷ lệ % giảm trong discount_code
                                                            $discountedPriceNewProduct = $priceNewProduct -
                                                                ($priceNewProduct * $percentNewProduct) / 100;
                                                        }
                                                    @endphp

                                                    @if ($discountedPriceNewProduct < $priceNewProduct)
                                                        {{ Number::currency($discountedPriceNewProduct, 'VND', 'vi') }}
                                                        <span
                                                            style="color: #b2b2b2;
                                                        font-size: 14px;
                                                        font-weight: 400;
                                                        text-decoration: line-through;">{{ Number::currency($priceNewProduct, 'VND', 'vi') }}
                                                        </span>
                                                    @else
                                                        {{ Number::currency($discountedPriceNewProduct, 'VND', 'vi') }}
                                                    @endif
                                                </span>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4>Được mua nhiều nhất</h4>
                        <div class="latest-product__slider owl-carousel">
                            <div class="latest-prdouct__slider__item">
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="{{ asset('frontend/shop/img/latest-product/lp-1.jpg ') }}"
                                            alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="{{ asset('frontend/shop/img/latest-product/lp-2.jpg ') }}"
                                            alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="{{ asset('frontend/shop/img/latest-product/lp-3.jpg ') }}"
                                            alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                            </div>
                            <div class="latest-prdouct__slider__item">
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="{{ asset('frontend/shop/img/latest-product/lp-1.jpg ') }}"
                                            alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="{{ asset('frontend/shop/img/latest-product/lp-2.jpg ') }}"
                                            alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="{{ asset('frontend/shop/img/latest-product/lp-3.jpg ') }}"
                                            alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4>Sản Phẩm Giảm Giá</h4>
                        <div class="latest-product__slider owl-carousel">
                            @foreach ($chunkedProductsSale as $chunk)
                                <div class="latest-prdouct__slider__item">
                                    @foreach ($chunk as $productSales)
                                        <a href="{{ route('shop.shop-details', $productSales->product_id) }}"
                                            class="latest-product__item">
                                            <div class="latest-product__item__pic w-50"> <img
                                                    src="{{ isset($productSales->imgName) ? asset('storage/uploads/products/' . $productSales->imgName) : asset('frontend/shop/img/latest-product/lp-1.jpg') }}"
                                                    alt="{{ $productSales->name }}"> </div>
                                            <div class="latest-product__item__text">
                                                <h6>{{ $productSales->name }}</h6>
                                                <span>
                                                    @php
                                                        $price = $productSales->price;
                                                        if ($productSales->discount_code) {
                                                            $percent = $productSales->percent;
                                                            $discountedPrice = $price - ($price * $percent) / 100;
                                                        }
                                                    @endphp
                                                    {{ Number::currency($discountedPrice, 'VND', 'vi') }}
                                                </span>
                                                <span
                                                    style="color: #b2b2b2;
                                                        font-size: 14px;
                                                        font-weight: 400;
                                                        text-decoration: line-through;">{{ Number::currency($productSales->price, 'VND', 'vi') }}
                                                </span>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Latest Product Section End -->
@endsection
