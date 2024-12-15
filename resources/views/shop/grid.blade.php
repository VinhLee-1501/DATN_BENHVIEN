@extends('layouts.shop.app')

@section('content')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg pt-3" data-setbg="">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <img src="{{ asset('frontend/shop/img/banner/banner.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Product Section Begin -->
    <section class="product mt-md-5 mt-sm-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-5">
                    <div class="sidebar">


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
                                                @endphp
                                                <a href="{{ route('shop.shop-details', $productNewItem->product_id) }}"
                                                    class="latest-product__item">
                                                    <div class="row align-items-center">
                                                        <div class="latest-product__item__pic col-md-4"> <img
                                                                style="width: 100%; height:auto;"
                                                                src="{{ isset($productNewItem->imgName) ? asset('storage/uploads/products/' . $productNewItem->imgName) : asset('frontend/shop/img/image.jpg') }}"
                                                                alt="{{ $productNewItem->name }}">
                                                        </div>
                                                        <div class="latest-product__item__text col-md-8">
                                                            <span style="font-size: 14px">{{ $productNewItem->name }}</span>
                                                            <span
                                                                style="font-size: 14px">{{ Number::currency($discountedPrice, 'VND', 'vi') }}
                                                            </span>
                                                        </div>
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
                                    <div class="col-lg-12">
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
                            <div class="col-lg-12 col-md-5">
                                <div class="filter__sort">
                                    {{-- <span>Sort By</span>
                                    <select>
                                        <option value="0">Default</option>
                                        <option value="0">Default</option>
                                    </select> --}}
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-4">
                                <div class="filter__found">
                                    <h6><span>{{ $countProducts }}</span>Sản phẩm hiển thị</h6>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-3">
                                {{-- <div class="filter__option">
                                    <span class="icon_grid-2x2"></span>
                                    <span class="icon_ul"></span>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @foreach ($productsActive as $productsActiveItem)
                            @php
                                $price = $productsActiveItem->price;
                                $discountedPriceProductActive = $price;
                                if ($productsActiveItem->discount_code) {
                                    $percent = $productsActiveItem->percent;
                                    $discountedPriceProductActive = $price - ($price * $percent) / 100;
                                }
                            @endphp
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg"
                                        data-setbg="{{ isset($productsActiveItem->imgName) ? asset('storage/uploads/products/' . $productsActiveItem->imgName) : asset('frontend/shop/img/image.jpg') }}">
                                        @if ($productsActiveItem->dateStartSale <= NOW() && $productsActiveItem->dateEndSale >= NOW())
                                            <div class="sale_product">
                                                {{ $percent }}%
                                            </div>
                                        @endif
                                        <ul class="product__item__pic__hover">
                                            <form
                                                action="{{ route('shop.addProductTocart', $productsActiveItem->product_id) }}"
                                                method="POST" id="add-to-cart-form-{{ $productsActiveItem->product_id }}">
                                                @csrf
                                                <input type="text" name="quantity" value="1" hidden>
                                                <button type="submit" class="btn-add-to-cart">
                                                    <li><a href=""><i class="fa fa-shopping-cart"></i></a></li>
                                                </button>
                                            </form>
                                        </ul>


                                    </div>
                                    <div class="product__item__text">
                                        <h6><a
                                                href="{{ route('shop.shop-details', $productsActiveItem->product_id) }}">{{ $productsActiveItem->name }}</a>
                                        </h6>
                                        <h5>
                                            @if ($productsActiveItem->dateStartSale <= now() && $productsActiveItem->dateEndSale >= now())
                                                {{ Number::currency($discountedPriceProductActive, 'VND', 'vi') }}
                                                <span class="price_sale">{{ Number::currency($price, 'VND', 'vi') }}</span>
                                            @else
                                                {{ Number::currency($price, 'VND', 'vi') }}
                                            @endif
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- <div class="product__pagination"> -->
                        {{ $productsActive->links() }}
                        <!-- </div> -->
                    </div>
                </div>
            </div>
    </section>
    <!-- Product Section End -->



    <script>
        document.querySelectorAll('.btn-add-to-cart').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault(); // Ngăn không cho trang tải lại

                const form = this.closest('form'); // Lấy form liên quan đến button
                const formData = new FormData(form); // Lấy dữ liệu trong form

                fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Phản hồi HTTP không hợp lệ!');
                        }
                        return response.json(); // Chuyển đổi phản hồi sang JSON
                    })
                    .then(data => {
                        if (data.status === 'success') {
                            console.log(data.message); // Kiểm tra thông báo trong console
                            toastr.success(data.message); // Hiển thị thông báo thành công
                        } else if (data.status === 'error') {
                            console.warn(data.message); // Kiểm tra lỗi trong console
                            toastr.error(data.message); // Hiển thị thông báo lỗi
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error.message); // Hiển thị lỗi trong console
                        toastr.error('Đã xảy ra lỗi khi thêm sản phẩm vào giỏ hàng.');
                    });
            });
        });
    </script>
@endsection
