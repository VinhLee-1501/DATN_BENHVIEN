@extends('layouts.shop.app')

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
                                    <input type="text" name="quantity" value="1">
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
                            <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab" aria-selected="false">Đánh
                                giá <span>(1)</span></a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabs-1" role="tabpanel">
                            <div class="product__details__tab__desc">
                                <h6>Thông tin sản phẩm</h6>
                                <p>{{ $productById->description }}</p>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabs-2" role="tabpanel">
                            <div class="product__details__tab__desc">
                                <h6 class="text-center mb-4">Đánh giá sản phẩm</h6>

                                <div class="row g-4">
                                    <!-- Left side: Existing Reviews -->
                                    <div class="col-lg-6">
                                        <h6 class="mb-3">Đánh giá từ khách hàng</h6>

                                        <!-- Review 1 -->
                                        <div class="review-item mb-3 p-3 border rounded shadow-sm">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <strong class="text-primary">Nguyễn Văn A</strong>
                                                <span class="text-muted">12/11/2024</span>
                                            </div>
                                            <div class="rating mb-2">
                                                <i class="fa fa-star text-warning"></i>
                                                <i class="fa fa-star text-warning"></i>
                                                <i class="fa fa-star text-warning"></i>
                                                <i class="fa fa-star text-warning"></i>
                                                <i class="fa fa-star-half-o text-warning"></i>
                                            </div>
                                            <p class="text-muted">Sản phẩm rất tốt, tôi hài lòng với chất lượng.</p>
                                        </div>

                                        <!-- Review 2 -->
                                        <div class="review-item mb-3 p-3 border rounded shadow-sm">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <strong class="text-primary">Trần Thị B</strong>
                                                <span class="text-muted">10/11/2024</span>
                                            </div>
                                            <div class="rating mb-2">
                                                <i class="fa fa-star text-warning"></i>
                                                <i class="fa fa-star text-warning"></i>
                                                <i class="fa fa-star text-warning"></i>
                                                <i class="fa fa-star-half-o text-warning"></i>
                                                <i class="fa fa-star-o text-warning"></i>
                                            </div>
                                            <p class="text-muted">Sản phẩm khá tốt, tuy nhiên giá hơi cao một chút.</p>
                                        </div>

                                        <!-- Review 3 -->
                                        <div class="review-item mb-3 p-3 border rounded shadow-sm">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <strong class="text-primary">Lê Minh C</strong>
                                                <span class="text-muted">08/11/2024</span>
                                            </div>
                                            <div class="rating mb-2">
                                                <i class="fa fa-star text-warning"></i>
                                                <i class="fa fa-star text-warning"></i>
                                                <i class="fa fa-star text-warning"></i>
                                                <i class="fa fa-star-o text-warning"></i>
                                                <i class="fa fa-star-o text-warning"></i>
                                            </div>
                                            <p class="text-muted">Sản phẩm sử dụng ổn, nhưng giao hàng chậm.</p>
                                        </div>
                                    </div>

                                    <!-- Divider Line -->
                                    <div class="col-12 d-block d-lg-none">
                                        <hr class="my-4">
                                    </div>

                                    <!-- Right side: Form to Add a Review -->
                                    <div class="col-lg-6">
                                        <h6 class="mb-3">Để lại đánh giá của bạn</h6>

                                        <!-- Comment Form with Border -->
                                        <div class="border p-4 rounded shadow-sm">
                                            <form>
                                                <div class="mb-3">
                                                    <label for="rating" class="form-label">Đánh giá</label>
                                                    <div class="rating">
                                                        <i class="fa fa-star text-warning"></i>
                                                        <i class="fa fa-star text-warning"></i>
                                                        <i class="fa fa-star text-warning"></i>
                                                        <i class="fa fa-star text-warning"></i>
                                                        <i class="fa fa-star-o text-warning"></i>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="comment" class="form-label">Bình luận</label>
                                                    <textarea class="form-control" id="comment" rows="4"
                                                        placeholder="Viết đánh giá của bạn"></textarea>
                                                </div>

                                                <button type="submit" class="btn btn-primary w-100">Gửi đánh
                                                    giá</button>
                                            </form>
                                        </div>
                                    </div>
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

<script>
        document.addEventListener('DOMContentLoaded', function () {
            const description = document.getElementById('description');
            const toggleButton = document.getElementById('toggle-description');

            if (!description || !toggleButton) {
                console.error('Phần tử không tồn tại!');
                return;
            }

            const fullHeight = description.scrollHeight;

            toggleButton.addEventListener('click', function () {
                if (description.classList.contains('expanded')) {
                    // Thu gọn
                    description.style.maxHeight = '100px';
                    description.classList.remove('expanded');
                    toggleButton.textContent = 'Xem thêm';
                } else {
                    // Mở rộng
                    description.style.maxHeight = fullHeight + 'px';
                    description.classList.add('expanded');
                    toggleButton.textContent = 'Thu gọn';
                }
            });
        });
    </script>
@endsection