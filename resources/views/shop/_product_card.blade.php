<style>
    .sale_product {
        background-color: #d22;
        width: 18%;
        padding: 10px;
        margin: 10px;
        border-radius: 50%;
        color: white;
        text-align: center;
    }
</style>

@foreach ($products as $product)
    <div class="col-lg-3 col-md-4 col-sm-6 mix oranges fresh-meat">
        <div class="featured__item">
            <div class="featured__item__pic set-bg"
                data-setbg="{{ !empty($product->img_array[0]) ? asset('storage/uploads/products/' . $product->img_array[0]) : asset('frontend/shop/img/featured/feature-1.jpg') }}">
                @if ($product->isInSalePeriod)
                    <div class="sale_product">
                        {{ $product->percent }}%
                    </div>
                @endif
                <ul class="featured__item__pic__hover">
                    <form action="{{ route('shop.addProductTocart', $product->product_id) }}" method="POST"
                        id="add-to-cart-form-{{ $product->product_id }}" class="m-0">
                        @csrf
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn-add-to-cart">
                            <li><i class="fa fa-shopping-cart mt-2"></i></li>
                        </button>
                    </form>
                </ul>
            </div>
            <div class="featured__item__text">
                @php
                    $priceProductFilter = $product->price;
                    $discountPriceProductFilter = $priceProductFilter;
                    if ($product->discount_code) {
                        $percentProductFilter = $product->percent;
                        $discountPriceProductFilter = $priceProductFilter - ($priceProductFilter * $percentProductFilter) / 100;
                    }
                @endphp
                <h6><a href="{{ route('shop.shop-details', $product->product_id) }}">{{ $product->name }}</a></h6>
                @if ($discountPriceProductFilter < $priceProductFilter)
                    <h5>{{ Number::currency($discountPriceProductFilter, 'VND', 'vi') }}</h5>
                    <span
                        style="color: #b2b2b2;
                                font-size: 14px;
                                font-weight: 400;
                                text-decoration: line-through;">{{ Number::currency($priceProductFilter, 'VND', 'vi') }}</span>
                @else
                    <h5>{{ Number::currency($discountPriceProductFilter, 'VND', 'vi') }}</h5>
                @endif
            </div>
        </div>
    </div>
    
@endforeach
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