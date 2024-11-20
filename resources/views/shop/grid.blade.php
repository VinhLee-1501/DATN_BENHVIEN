@extends('layouts.shop.app')

@section('content')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="{{ asset('frontend/shop/img/Group.png') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Organi Shop</h2>
                        <div class="breadcrumb__option">
                            <a href="./index.html">Trang chủ</a>
                            <span>Sản phẩm</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-5">
                    <div class="sidebar">
                        <div class="sidebar__item">
                            <h4>Danh Mục</h4>
                            <!-- foreach danh muc -->
                            <ul>
                                @foreach ($categories as $category_item)
                                    <li><a href="#">{{ $category_item->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                       
                        <div class="sidebar__item">
                            <div class="latest-product__text">
                                <h4>Sản Phẩm Mới</h4>
                                <div class="latest-product__slider owl-carousel">
                                    @foreach ($chunkedProductsNew as $chunkNew)
                                        <div class="latest-prdouct__slider__item">
                                            @foreach ($chunkNew as $productNewItem)
                                                @php
                                                    $price = $productNewItem->price;
                                                    $discountedPrice = $price;
                                                    if ($productNewItem->discount_code) {
                                                        $percent = $productNewItem->percent;
                                                        $discountedPrice = $price - ($price * $percent) / 100;
                                                    }
                                                @endphp <a
                                                    href="{{ route('shop.shop-details', $productNewItem->product_id) }}"
                                                    class="latest-product__item">
                                                    <div class="latest-product__item__pic w-25"> <img
                                                            src="{{ isset($productNewItem->imgName) ? asset('storage/uploads/products/' . $productNewItem->imgName) : asset('frontend/shop/img/image.jpg') }}"
                                                            alt="{{ $productNewItem->name }}"> </div>
                                                    <div class="latest-product__item__text">
                                                        <span
                                                            style="font-weight: normal; font-size: 15px">{{ $productNewItem->name }}</span>
                                                        <span
                                                            style="font-size: 14px">{{ Number::currency($discountedPrice, 'VND', 'vi') }}
                                                            VND</span>
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
                <div class="col-lg-9 col-md-7">
                    <div class="product__discount">
                        <div class="section-title product__discount__title">
                            <h2>Giảm Giá</h2>
                        </div>
                        <div class="row">
                            <div class="product__discount__slider owl-carousel">

                                @foreach ($SelectProductWithsaleProduct as $saleProductItem)
                                    @php
                                        $price = $saleProductItem->price;
                                        $discountedPrice = $price;
                                        if ($saleProductItem->discount_code) {
                                            $percent = $saleProductItem->percent;
                                            $discountedPrice = $price - ($price * $percent) / 100;
                                        }
                                    @endphp
                                    <div class="col-lg-4">
                                        <div class="product__discount__item">
                                            <div class="product__discount__item__pic set-bg"
                                                data-setbg="{{ asset('storage/uploads/products/' . $saleProductItem->imgNameSale) }} ">
                                                <div class="product__discount__percent">
                                                    {{ $percent }}%
                                                </div>
                                                <ul class="product__item__pic__hover">
                                                    <form
                                                        action="{{ route('shop.addProductTocart', $saleProductItem->product_id) }}"
                                                        method="POST"
                                                        id="add-to-cart-form-{{ $saleProductItem->product_id }}">
                                                        @csrf
                                                        <input type="text" name="quantity" value="1" hidden>
                                                        <button type="submit" class="btn-add-to-cart">
                                                            <li><a href=""><i class="fa fa-shopping-cart"></i></a>
                                                            </li>
                                                        </button>
                                                    </form>
                                                </ul>
                                            </div>
                                            <div class="product__discount__item__text">
                                                <span>{{ $saleProductItem->categoryName }}</span>
                                                <h5><a
                                                        href="{{ route('shop.shop-details', $saleProductItem->product_id) }}">{{ $saleProductItem->name }}</a>
                                                </h5>
                                                <div class="product__item__price">
                                                    {{ Number::currency($discountedPrice, 'VND', 'vi') }}
                                                    <span>{{ Number::currency($price, 'VND', 'vi') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="filter__item">
                        <div class="row">
                            <div class="col-lg-4 col-md-5">
                                <div class="filter__sort">
                                    {{-- <span>Sort By</span>
                                    <select>
                                        <option value="0">Default</option>
                                        <option value="0">Default</option>
                                    </select> --}}
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="filter__found">
                                    <h6><span>{{ $countProducts }}</span>Sản phẩm hiển thị</h6>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-3">
                                {{-- <div class="filter__option">
                                    <span class="icon_grid-2x2"></span>
                                    <span class="icon_ul"></span>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @foreach ($prodcutsActive as $prodcutsActiveItem)
                            @php
                                $price = $prodcutsActiveItem->price;
                                $discountedPriceProductActive = $price;
                                if ($prodcutsActiveItem->discount_code) {
                                    $percent = $prodcutsActiveItem->percent;
                                    $discountedPriceProductActive = $price - ($price * $percent) / 100;
                                }
                            @endphp
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg"
                                        data-setbg="{{ isset($prodcutsActiveItem->imgName) ? asset('storage/uploads/products/' . $prodcutsActiveItem->imgName) : asset('frontend/shop/img/image.jpg') }}">
                                        @if ($prodcutsActiveItem->dateStartSale <= NOW() && $prodcutsActiveItem->dateEndSale >= NOW())
                                            <div class="sale_product">
                                                {{ $percent }}%
                                            </div>
                                        @endif
                                        <ul class="product__item__pic__hover">
                                            <form
                                                action="{{ route('shop.addProductTocart', $prodcutsActiveItem->product_id) }}"
                                                method="POST"
                                                id="add-to-cart-form-{{ $prodcutsActiveItem->product_id }}">
                                                @csrf
                                                <input type="text" name="quantity" value="1" hidden>
                                                <button type="submit" class="btn-add-to-cart">
                                                    <li><a href=""><i class="fa fa-shopping-cart"></i></a>
                                                    </li>
                                                </button>
                                            </form>
                                        </ul>
                                    </div>
                                    <div class="product__item__text">
                                        <h6><a
                                                href="{{ route('shop.shop-details', $prodcutsActiveItem->product_id) }}">{{ $prodcutsActiveItem->name }}</a>
                                        </h6>
                                        <h5>
                                            @if ($prodcutsActiveItem->dateStartSale <= now() && $prodcutsActiveItem->dateEndSale >= now())
                                                {{ Number::currency($discountedPriceProductActive, 'VND', 'vi') }}
                                                <span
                                                    class="price_sale">{{ Number::currency($price, 'VND', 'vi') }}</span>
                                            @else
                                                {{ Number::currency($price, 'VND', 'vi') }}
                                            @endif
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- <div class="product__pagination"> -->
                            {{ $prodcutsActive->links() }}
                        <!-- </div> -->
                    </div>
                </div>
            </div>
    </section>
    <!-- Product Section End -->
@endsection
