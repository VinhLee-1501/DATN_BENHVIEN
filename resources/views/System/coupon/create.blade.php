@extends('layouts.admin.master')
@section('Thêm mã giảm giá')
@section('content')
    <div class="card w-100">
        <div class="card-body p-3">
            <h3 class="card-title fw-semibold m-0">Thêm mã giảm giá</h3>
        </div>
    </div>
    <form id="couponForm">
        @csrf
        <div class="card w-100">
            <div class="card-body p-4">
                <div class="mb-3">
                    <label class="form-label" for="code">Mã giảm giá</label>
                    <div class="d-flex">
                        <input type="text" id="codeInput" name="discount_code" class="form-control"
                            placeholder="Mã giảm giá" value="{{ old('discount_code') }}">
                        <a class="btn btn-primary" onclick="generateRandomCode()">
                            <i class="ti ti-dice-6"></i>
                        </a>
                    </div>
                    <div id="codeError" class="text-danger"></div>
                </div>
                <div class="">
                    <label class="form-label" for="note">Mô tả</label>
                    <input type="text" id="noteInput" name="note" class="form-control" placeholder="Mô tả"
                        value="{{ old('note') }}">
                    <div id="noteError" class="text-danger"></div>
                </div>
            </div>
        </div>

        <div class="card w-100">
            <div class="card-body p-4">
                <h5 class="card-title mb-4">Dữ liệu mã giảm giá</h5>
                <div class="table-responsive">
                    <div class="d-flex align-items-start flex-wrap">
                        <div class="nav flex-column nav-pills col-md-2  text-start" id="v-pills-tab" role="tablist"
                            aria-orientation="vertical">
                            <button class="nav-link active d-flex align-items-center" id="v-pills-home-tab"
                                data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab"
                                aria-controls="v-pills-home" aria-selected="true">
                                <i class="ti ti-database me-2"></i> Chung
                            </button>
                            <button class="nav-link d-flex align-items-center" id="v-pills-profile-tab"
                                data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab"
                                aria-controls="v-pills-profile" aria-selected="false">
                                <i class="ti ti-ban me-2"></i> Hạn chế sử dụng
                            </button>
                        </div>
                        <div class="tab-content col-md-10" id="v-pills-tabContent">
                            <div class="tab-pane fade show active px-4" id="v-pills-home" role="tabpanel"
                                aria-labelledby="v-pills-home-tab">
                                <div class="d-flex mb-4 align-items-center">
                                    <div class="col-2 p-2">
                                        <label for="Type">Loại ưu đãi</label>
                                    </div>
                                    <div class="col-10">
                                        <select class="form-control" id="TypeSelect" name="type">
                                            <option value="1" {{ old('Type') == 1 ? 'selected' : '' }}>Giảm giá sản
                                                phẩm cố định</option>
                                            <option value="0" {{ old('Type') == 0 ? 'selected' : '' }}>Giảm giá theo
                                                hóa đơn</option>
                                            <option value="2" {{ old('Type') == 2 ? 'selected' : '' }}>Giảm giá theo
                                                danh mục</option>
                                        </select>
                                        <div id="TypeError" class="text-danger"></div>
                                    </div>
                                </div>
                                <div class="d-flex mb-4 align-items-center">
                                    <div class="col-2 p-2">
                                        <label for="discountRate">Mức ưu đãi</label>
                                    </div>
                                    <div class="col-10">
                                        <input type="text" placeholder="0" id="discountRate" name="percent"
                                            class="form-control" value="{{ old('discountRate') }}">
                                        <div id="discountRateError" class="text-danger"></div>
                                    </div>
                                </div>
                                <div class="d-flex mb-4 align-items-center">
                                    <div class="col-2 p-2">
                                        <label for="startDate">Ngày bắt đầu</label>
                                    </div>
                                    <div class="col-10">
                                        <input type="date" id="startDate" name="time_start" class="form-control"
                                            value="{{ old('startDate') }}">
                                        <div id="startDateError" class="text-danger"></div>
                                    </div>
                                </div>
                                <div class="d-flex mb-4 align-items-center">
                                    <div class="col-2 p-2">
                                        <label for="endDate">Ngày kết thúc</label>
                                    </div>
                                    <div class="col-10">
                                        <input type="date" id="endDate" name="time_end" class="form-control"
                                            value="{{ old('endDate') }}">
                                        <div id="endDateError" class="text-danger"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade  px-4" id="v-pills-profile" role="tabpanel"
                                aria-labelledby="v-pills-profile-tab">
                                <div class="d-flex mb-4 align-items-center">
                                    <div class="col-2 p-2">
                                        <label for="maxuse">Số lần sử dụng</label>
                                    </div>
                                    <div class="col-10">
                                        <input type="text" placeholder="0" id="maxuse" name="use_limit"
                                            class="form-control" value="{{ old('maxuse') }}">
                                        <div id="maxuseError" class="text-danger"></div>
                                    </div>
                                </div>
                                <div class="d-flex mb-4 align-items-center">
                                    <div class="col-2 p-2">
                                        <label for="minpurchase">Mức chi tiêu tối thiểu</label>
                                    </div>
                                    <div class="col-10">
                                        <input type="text" placeholder="0" id="minpurchase" name="min_purchase"
                                            class="form-control" value="{{ old('minpurchase') }}">
                                        <div id="minpurchaseError" class="text-danger"></div>
                                    </div>
                                </div>
                                <div class="d-flex mb-4 align-items-center">
                                    <div class="col-2 p-2">
                                        <label for="product">Sản phẩm</label>
                                    </div>
                                    <div class="col-10">
                                        <select name="product_id[]" id="product-select" class="form-control"
                                            multiple="multiple">
                                        </select>
                                        <div id="productError" class="text-danger"></div>
                                    </div>
                                </div>
                                <div class="d-flex mb-4 align-items-center">
                                    <div class="col-2 p-2">
                                        <label for="category">Danh mục</label>
                                    </div>
                                    <div class="col-10">
                                        <select name="category_id[]" id="category-select" class="form-control"
                                            multiple="multiple">
                                        </select>
                                        <div id="categoryError" class="text-danger"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Lưu</button>
            </div>
        </div>
    </form>

    @push('scripts')
        <script>
            //hàm random mã giảm giá
            function generateRandomCode() {

                const characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
                let randomCode = '';

                for (let i = 0; i < 10; i++) {
                    randomCode += characters.charAt(Math.floor(Math.random() * characters.length));
                }

                document.getElementById('codeInput').value = randomCode.toUpperCase();
            }
        </script>
        <script>
            $(document).ready(function() {
                $('#product-select').select2({
                    ajax: {
                        url: '/system/coupons/listproduct',
                        type: 'get',
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                searchItem: params.term,
                                page: params.page || 1
                            };
                        },
                        processResults: function(data, params) {
                            params.page = params.page || 1;
                            return {
                                results: data.data.map(function(item) {
                                    return {
                                        id: item.product_id, // id từ dữ liệu
                                        text: item.name // Hiển thị tên danh mục
                                    };
                                }),
                                pagination: {
                                    more: data.last_page != params.page
                                }
                            };
                        },
                        cache: true
                    },
                    placeholder: 'Chọn sản phẩm',
                    minimumInputLength: 0,
                    width: '100%',
                    allowClear: true
                });

                $('#product-select').on('change', function() {
                    var optionCount = $(this).find('option:selected').length;
                    var newHeight = 25 * optionCount + 20;

                    $(this).next('.select2').find('.select2-selection').css('height', newHeight + 'px');
                });

                const oldProductValue = "{{ old('product') }}";
                if (oldProductValue) {
                    $('#product-select').val(oldProductValue).trigger('change');
                    $('#product-select').select2();
                }
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#category-select').select2({
                    ajax: {
                        url: '/system/coupons/listcategory',
                        type: 'get',
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                searchItem: params.term,
                                page: params.page || 1
                            };
                        },
                        processResults: function(data, params) {
                            params.page = params.page || 1;
                            return {
                                results: data.data.map(function(item) {
                                    return {
                                        id: item.category_id, // id từ dữ liệu
                                        text: item.name // Hiển thị tên danh mục
                                    };
                                }),
                                pagination: {
                                    more: data.last_page != params.page
                                }
                            };
                        },
                        cache: true
                    },
                    placeholder: 'Chọn danh mục',
                    minimumInputLength: 0,
                    width: '100%',
                    allowClear: true
                });

                $('#category-select').on('change', function() {
                    var optionCount = $(this).find('option:selected').length;
                    var newHeight = 25 * optionCount + 20;

                    $(this).next('.select2').find('.select2-selection').css('height', newHeight + 'px');
                });

                const oldCategoryValue = "{{ old('category') }}";
                if (oldCategoryValue) {
                    $('#category-select').val(oldCategoryValue).trigger('change');
                    $('#category-select').select2();
                }
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Lấy ngày hôm nay và ngày mai
                const today = new Date();
                const tomorrow = new Date();
                tomorrow.setDate(today.getDate() + 1); // Ngày mai

                // Chuyển đổi ngày sang định dạng 'YYYY-MM-DD'
                const todayString = today.toISOString().split('T')[0];
                const tomorrowString = tomorrow.toISOString().split('T')[0];

                // Cập nhật thuộc tính min cho ngày bắt đầu và ngày kết thúc
                document.getElementById('startDate').setAttribute('min',
                    todayString); // Ngày bắt đầu chỉ có thể là hôm nay
                document.getElementById('endDate').setAttribute('min',
                    tomorrowString); // Ngày kết thúc chỉ có thể là ngày mai của ngày bắt đầu

                // Lắng nghe sự thay đổi của ngày bắt đầu để thiết lập ngày kết thúc
                document.getElementById('startDate').addEventListener('change', function() {
                    const startDate = new Date(this.value);

                    // Đảm bảo ngày kết thúc phải lớn hơn ngày bắt đầu
                    if (document.getElementById('endDate').value) {
                        const endDate = new Date(document.getElementById('endDate').value);
                        if (startDate >= endDate) {
                            document.getElementById('endDate').value =
                                ''; // Xóa giá trị ngày kết thúc nếu không hợp lệ
                        }
                    }

                    // Cộng thêm 1 ngày vào ngày bắt đầu để làm ngày kết thúc hợp lệ nhất
                    startDate.setDate(startDate.getDate() + 1);

                    // Chuyển ngày kết thúc sang định dạng 'YYYY-MM-DD'
                    const newEndDate = startDate.toISOString().split('T')[0];
                    document.getElementById('endDate').setAttribute('min',
                        newEndDate); // Cập nhật giá trị min cho endDate
                });

                // Lắng nghe sự thay đổi của ngày kết thúc để đảm bảo nó phải lớn hơn ngày bắt đầu
                document.getElementById('endDate').addEventListener('change', function() {
                    const endDate = new Date(this.value);
                    const startDate = new Date(document.getElementById('startDate').value);

                    // Nếu ngày kết thúc nhỏ hơn hoặc bằng ngày bắt đầu, thì không cho phép
                    if (endDate <= startDate) {
                        alert("Ngày kết thúc phải lớn hơn ngày bắt đầu!");
                        this.value = ''; // Xóa giá trị ngày kết thúc nếu không hợp lệ
                    }
                });
            });
        </script>
        <script>
            $('#couponForm').on('submit', function(event) {
                event.preventDefault(); // Ngừng hành động mặc định của form (tránh reload trang)


                // Biến để kiểm tra xem có lỗi ở tab profile hay không
                let showProfileTab = false;

                // Gửi AJAX request để cập nhật dữ liệu
                $.ajax({
                    url: '/system/coupons/store',
                    method: 'POST',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);

                            window.location.href = '{{ route('system.coupon') }}';

                        } else {
                            toastr.error('Cập nhật thất bại');
                        }
                    },
                    error: function(xhr) {
                        // Làm sạch thông báo lỗi trước khi gửi yêu cầu mới
                        $('#codeError').text('');
                        $('#TypeError').text('');
                        $('#discountRateError').text('');
                        $('#startDateError').text('');
                        $('#endDateError').text('');
                        $('#maxuseError').text('');
                        $('#minpurchaseError').text('');
                        $('#productError').text('');
                        $('#categoryError').text('');
                        $('#noteError').text('');


                        // Kiểm tra và hiển thị lỗi cho từng trường
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            const errors = xhr.responseJSON.errors;

                            if (errors.note) {
                                $('#noteError').text(errors.note[0]);
                            }
                            if (errors.discount_code) {
                                $('#codeError').text(errors.discount_code[0]);
                            }
                            if (errors.type) {
                                $('#TypeError').text(errors.type[0]);
                            }
                            if (errors.percent) {
                                $('#discountRateError').text(errors.percent[0]);
                            }
                            if (errors.time_start) {
                                $('#startDateError').text(errors.time_start[0]);
                            }
                            if (errors.time_end) {
                                $('#endDateError').text(errors.time_end[0]);
                            }

                            // Kiểm tra lỗi cho các trường ở tab profile và đánh dấu nếu có lỗi
                            if (errors.use_limit) {
                                $('#maxuseError').text(errors.use_limit[0]);
                                showProfileTab = true; // Có lỗi ở tab profile
                            }
                            if (errors.min_purchase) {
                                $('#minpurchaseError').text(errors.min_purchase[0]);
                                showProfileTab = true; // Có lỗi ở tab profile
                            }
                            if (errors.product_id) {
                                $('#productError').text(errors.product_id[0]);
                                showProfileTab = true; // Có lỗi ở tab profile
                            }
                            if (errors.category_id) {
                                $('#categoryError').text(errors.category_id[0]);
                                showProfileTab = true; // Có lỗi ở tab profile
                            }

                            // Chuyển sang tab home nếu có lỗi ở tab home
                            if ($('#codeError').text() || $('#TypeError').text() || $('#discountRateError')
                                .text() || $('#startDateError').text() || $('#endDateError').text()) {
                                $('#v-pills-home-tab').tab('show'); // Chuyển sang tab home nếu có lỗi
                            }
                            // Nếu không có lỗi ở tab home nhưng có lỗi ở tab profile
                            else if (showProfileTab) {
                                $('#v-pills-profile-tab').tab('show'); // Chuyển sang tab profile nếu có lỗi
                            }
                        }
                    }
                });
            });
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Lấy các phần tử cần thao tác
                const typeSelect = document.getElementById("TypeSelect");
                const productSelect = document.getElementById("product-select");
                const categorySelect = document.getElementById("category-select");
                const minpurchaseInput = document.getElementById("minpurchase");

                // Hàm kiểm tra và vô hiệu hóa các input dựa vào giá trị của TypeSelect
                function toggleInputs() {
                    const selectedValue = typeSelect.value;

                    // Mặc định mở khóa tất cả các input
                    productSelect.disabled = false;
                    categorySelect.disabled = false;
                    minpurchaseInput.disabled = false;

                    // Kiểm tra giá trị của TypeSelect
                    if (selectedValue === "0") {
                        // Nếu là 0 (Giảm giá theo hóa đơn) thì vô hiệu hóa product và category
                        productSelect.disabled = true;
                        categorySelect.disabled = true;
                    } else if (selectedValue === "1") {
                        // Nếu là 1 (Giảm giá sản phẩm cố định) thì vô hiệu hóa minpurchase và category
                        minpurchaseInput.disabled = true;
                        categorySelect.disabled = true;
                    } else if (selectedValue === "2") {
                        // Nếu là 2 (Giảm giá theo danh mục) thì vô hiệu hóa minpurchase và product
                        minpurchaseInput.disabled = true;
                        productSelect.disabled = true;
                    }
                }

                // Gọi hàm kiểm tra khi giá trị của TypeSelect thay đổi
                typeSelect.addEventListener("change", toggleInputs);

                // Gọi hàm kiểm tra ngay khi trang được tải để cập nhật trạng thái
                toggleInputs();
            });
        </script>
    @endpush
@endsection
