@extends('layouts.shop.app')
<style>
    .price_sale_detail {
        text-decoration: line-through;
        color: #b2b2b2;
    }

    .sale_product {
        background-color: #d22;
        width: 25%;
        padding: 10px;
        margin: 10px;
        border-radius: 50%;
        color: white;
        text-align: center;
    }

    .price_sale {
        color: #b2b2b2;
        font-size: 14px;
        font-weight: 400;
        text-decoration: line-through;
    }

    .primary-btn {
        border: none;
    }
</style>
@section('content')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="{{ asset('frontend/shop/img/breadcrumb.jpg') }}  ">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Vegetable’s Package</h2>
                        <div class="breadcrumb__option">
                            <a href=" {{ route('shop.shop') }}">Trang chủ</a>
                            <a href=" {{ route('shop.shop') }}">Danh mục</a>
                            <span>Sản phẩm</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__pic">
                        <div class="product__details__pic__item">
                            <img class="product__details__pic__item--large"
                                src="{{ asset('storage/uploads/products/' . $productById->img_array[0]) }}" alt="">
                        </div>
                        <div class="product__details__pic__slider owl-carousel">
                            @for ($i = 0; $i < count($productById->img_array); $i++)
                                <img data-imgbigurl="{{ asset('storage/uploads/products/' . $productById->img_array[$i]) }}"
                                    src="{{ asset('storage/uploads/products/' . $productById->img_array[$i])}}" alt="">
                            @endfor
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__text">
                        <h3>{{ $productById->name }}</h3>
                        <div class="product__details__rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-half-o"></i>
                            <span>(18 đánh giá)</span>
                        </div>
                        @php
                            $originalPrice = $productById->price;
                            $discount = $productById->discount;
                            if ($discount >= 1000) {
                                $discountedPrice = $originalPrice - $discount;
                                $discountPercent = ($discount / $originalPrice) * 100;
                            } elseif ($discount < 100) {
                                $discountedPrice = $originalPrice - ($originalPrice * $discount) / 100;
                                $discountPercent = $discount;
                            } else {
                                $discountedPrice = $originalPrice;
                            }
                        @endphp
                        <div class="product__details__price">Giá:
                            @if ($productById->dateStartSale <= NOW() && $productById->dateEndSale >= NOW())
                                {{ Number::currency($discountedPrice, 'VND', 'vi') }}
                                <span class="price_sale_detail">{{ Number::currency($originalPrice, 'VND', 'vi') }}</span>
                            @else
                                {{ Number::currency($originalPrice, 'VND', 'vi') }}
                            @endif
                        </div>
                        <p>{{ $productById->used }}</p>
                        <form action="{{ route('shop.addProductTocart', $productById->product_id) }}" method="POST"
                            id="add-to-cart-form-{{ $productById->product_id }}">
                            @csrf
                            <div class="product__details__quantity">
                                <div class="quantity">
                                    <div class="pro-qty">
                                        <input type="text" name="quanlity" value="1">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="primary-btn">
                                vào giỏ hàng
                            </button>
                        </form>
                        <ul>
                            <li><b>Thương hiệu:</b> <span>{{ $productById->manufacture }}</span></li>
                            <li><b>Số đăng ký:</b> <span>{{ $productById->registration_number }}</span></li>
                            <li><b>Nước sản xuất:</b> <span>Việt Nam</span></li>
                            <li><b>Hạn dùng:</b> <span>30 tháng kể từ ngày sản xuất</span></li>
                            <li><b>Dạng bào chế:</b> <span>Dung dịch</span></li>
                            <li><b>Hoạt chất:</b> <span>{{ $productById->active_ingredient }}</span></li>
                            <li><b>Loại thuốc:</b> <span>Không cần kê toa</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="product__details__tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab"
                                    aria-selected="true">Chi tiết sản phẩm</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab"
                                    aria-selected="false">Đánh giá <span>(1)</span></a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <h6>Thông tin sản phẩm</h6>
                                    <p>{{ $productById->description }}</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Details Section End -->

    <!-- Related Product Section Begin -->
    <section class="related-product">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title related__product__title">
                        <h2>Sản phẩm đề xuất</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($productByCategory as $productByCategoryItem)
                    @php
                        $originalPrice = $productByCategoryItem->price;
                        $discount = $productByCategoryItem->discount;
                        if ($discount >= 1000) {
                            $discountedPrice = $originalPrice - $discount;
                            $discountPercent = ($discount / $originalPrice) * 100;
                        } elseif ($discount < 100) {
                            $discountedPrice = $originalPrice - ($originalPrice * $discount) / 100;
                            $discountPercent = $discount;
                        } else {
                            $discountedPrice = $originalPrice;
                        }
                    @endphp
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="product__item">
                            <div class="product__item__pic set-bg"
                                data-setbg="{{ asset('storage/uploads/products/' . $productByCategoryItem->img_array[0]) }}">
                                @if ($productByCategoryItem->dateStartSale <= NOW() && $productByCategoryItem->dateEndSale >= NOW())
                                    <div class="sale_product">
                                        {{ Number::percentage($discountPercent) }}
                                    </div>
                                @endif
                                <ul class="product__item__pic__hover">
                                    <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6><a
                                        href="{{ route('shop.shop-details', $productByCategoryItem->product_id) }}">{{ $productByCategoryItem->name }}</a>
                                </h6>
                                <h5>
                                    @if ($productByCategoryItem->dateStartSale <= NOW() && $productByCategoryItem->dateEndSale >= NOW())
                                        {{ Number::currency($discountedPrice, 'VND', 'vi') }}
                                        <span class="price_sale">{{ Number::currency($originalPrice, 'VND', 'vi') }}</span>
                                    @else
                                        {{ Number::currency($originalPrice, 'VND', 'vi') }}
                                    @endif
                                </h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Related Product Section End -->
@endsection
