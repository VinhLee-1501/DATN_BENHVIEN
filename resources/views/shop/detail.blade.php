@extends('layouts.shop.app')

@section('content')
    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__pic">
                        <div class="product__details__pic__item">
                            <img class="product__details__pic__item--large"
                                src="{{ asset('storage/uploads/products/' . $productById->img_array[0]) }}" alt="">
                            @php
                                // dd($productById->img_array);
                            @endphp
                        </div>
                        <div class="product__details__pic__slider owl-carousel">
                            @for ($i = 0; $i < count($productById->img_array); $i++)
                                <img data-imgbigurl="{{ asset('storage/uploads/products/' . $productById->img_array[$i]) }}"
                                    src="{{ asset('storage/uploads/products/' . $productById->img_array[$i]) }}"
                                    alt="">
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
                            $price = $productById->price;
                            $discountedPriceProductId = $price;
                            if ($productById->discount_code) {
                                $percent = $productById->percent;
                                $discountedPriceProductId = $price - ($price * $percent) / 100;
                            }
                        @endphp
                        <div class="product__details__price">Giá:
                            @if ($productById->dateStartSale <= NOW() && $productById->dateEndSale >= NOW())
                                {{ Number::currency($discountedPriceProductId, 'VND', 'vi') }}
                                <span class="price_sale_detail"
                                    style="color: #b2b2b2;
                                                        font-size: 24px;
                                                        font-weight: 400;
                                                        text-decoration: line-through;">{{ Number::currency($price, 'VND', 'vi') }}</span>
                            @else
                                {{ Number::currency($discountedPriceProductId, 'VND', 'vi') }}
                            @endif
                        </div>
                        <p>{{ $productById->used }}</p>
                        <form action="{{ route('shop.addProductTocart', $productById->product_id) }}" method="POST"
                            id="add-to-cart-form-{{ $productById->product_id }}">
                            @csrf
                            <div class="product__details__quantity">
                                <div class="quantity">
                                    <div class="pro-qty">
                                        <input type="number" name="quantity" value="1" min="1">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="primary-btn btn-add-to-cart">
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
                                <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab"
                                    aria-selected="false">Đánh
                                    giá <span>(1)</span></a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <h6>Thông tin sản phẩm</h6>
                                    <p id="description" class="description">{{ $productById->description }}</p>
                                </div>
                                <button id="toggle-description" class="btn btn-link col-sm-12">Xem thêm</button>
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
                                                        <textarea class="form-control" id="comment" rows="4" placeholder="Viết đánh giá của bạn"></textarea>
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
                        $price = $productByCategoryItem->price;
                        $discountedPriceCategory = $price;
                        if ($productByCategoryItem->discount_code) {
                            $percent = $productByCategoryItem->percent;
                            $discountedPriceCategory = $price - ($price * $percent) / 100;
                        }
                    @endphp
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="product__item">
                            <div class="product__item__pic set-bg"
                                data-setbg="{{ asset('storage/uploads/products/' . $productByCategoryItem->img_array[0]) }}">
                                @if ($productByCategoryItem->dateStartSale <= NOW() && $productByCategoryItem->dateEndSale >= NOW())
                                    <div class="sale_product">
                                        {{ Number::percentage($discountedPriceProductId) }}
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
                                        {{ Number::currency($discountedPriceCategory, 'VND', 'vi') }}
                                        <span
                                            class="price_sale">{{ Number::currency($discountedPriceCategory, 'VND', 'vi') }}</span>
                                    @else
                                        {{ Number::currency($discountedPriceCategory, 'VND', 'vi') }}
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
        document.addEventListener('DOMContentLoaded', function() {
            const description = document.getElementById('description');
            const toggleButton = document.getElementById('toggle-description');

            if (!description || !toggleButton) {
                console.error('Phần tử không tồn tại!');
                return;
            }

            const fullHeight = description.scrollHeight;

            toggleButton.addEventListener('click', function() {
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
                        // Kiểm tra trạng thái của phản hồi
                        if (data.status === 'success') {
                            console.log(data.message); // Kiểm tra thông báo trong console
                            toastr.success(data.message); // Hiển thị thông báo thành công
                        } else if (data.status === 'error') {
                            console.warn(data.message); // Kiểm tra lỗi trong console
                            toastr.error(data.message); // Hiển thị thông báo lỗi
                        } else if (data.status === 'warning') {
                            toastr.warning(data
                                .message); // Hiển thị thông báo cảnh báo nếu người dùng chưa đăng nhập
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
