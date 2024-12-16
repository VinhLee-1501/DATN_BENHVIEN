@extends('layouts.admin.master')
@section('Quản lý sản phẩm')
@section('content')
    <style>
        .note-editor .note-toolbar,
        .note-popover .popover-content {
            display: none;
        }

        #addProductForm {
            display: flex;
            flex-direction: column;
            align-items: center;
            /* Căn giữa theo chiều ngang */
        }

        .modal-dialog {
            max-height: calc(100vh - 50px);
            overflow-y: auto;
        }

        .modal-body {
            background-color: white;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            /* Căn các nút sang bên phải */
            width: 100%;
        }

        .img-square {
            width: auto;
            height: 60px;
            object-fit: cover;
        }
    </style>
    <nav class="mb-3">
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link {{ $activeTab == 'nav-home' ? 'active' : '' }}" id="nav-home-tab" data-bs-toggle="tab"
                data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true"
                onclick="window.location='?tab=nav-home'">Còn hàng
            </button>
            <button class="nav-link {{ $activeTab == 'nav-profile' ? 'active' : '' }}" id="nav-profile-tab"
                data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile"
                aria-selected="false" onclick="window.location='?tab=nav-profile'">Hết hàng
            </button>
        </div>
    </nav>

    <form action="{{ route('system.product') }}" method="GET" class="row mb-3 g-2 align-items-center">
        <!-- Hidden input to maintain the active tab -->
        <input type="hidden" name="tab" value="{{ request('tab', 'nav-home') }}">

        <!-- Tìm kiếm -->
        <div class="col-md-9 col-lg-10">
            <div class="row g-2">
                <!-- Tên sản phẩm -->
                <div class="col-md-4">
                    <input type="text" id="inputName" class="form-control" placeholder="Tên sản phẩm" name="name"
                        value="{{ request('name') }}">
                </div>



                <!-- Giá từ -->
                <div class="col-md-4">
                    <input type="number" id="inputPriceFrom" class="form-control" placeholder="Giá từ" name="price_from"
                        value="{{ request('price_from') }}">
                </div>

                <!-- Giá đến -->
                <div class="col-md-4">
                    <input type="number" id="inputPriceTo" class="form-control" placeholder="Giá đến" name="price_to"
                        value="{{ request('price_to') }}">
                </div>
                <!-- Mã sản phẩm -->
                <div class="col-md-4">
                    <input type="text" id="inputCode" class="form-control" placeholder="Mã sản phẩm" name="code_product"
                        value="{{ request('code_product') }}">
                </div>
                <!-- Ngày từ -->
                <div class="col-md-4">
                    <input type="date" id="inputDateFrom" class="form-control" placeholder="Ngày từ" name="date_from"
                        value="{{ request('date_from') }}">
                </div>

                <!-- Ngày đến -->
                <div class="col-md-4">
                    <input type="date" id="inputDateTo" class="form-control" placeholder="Ngày đến" name="date_to"
                        value="{{ request('date_to') }}">
                </div>
            </div>
        </div>

        <!-- Nút tìm kiếm và thêm sản phẩm -->
        <div class="col-md-3 col-lg-2">
            <div class="row g-2">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
                </div>
                <div class="col-12 mt-2">
                    <a href="javascript:void(0)" class="btn btn-success w-100" onclick="openAddModal()">Thêm sản phẩm</a>
                </div>
            </div>
        </div>
    </form>

    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show {{ $activeTab == 'nav-home' ? 'show active' : '' }}" id="nav-home" role="tabpanel"
            aria-labelledby="nav-home-tab">
            @include('System.products.product', ['products' => $product]) <!-- Display available products -->
        </div>
        <div class="tab-pane fade {{ $activeTab == 'nav-profile' ? 'show active' : '' }}" id="nav-profile" role="tabpanel"
            aria-labelledby="nav-profile-tab">
            @include('System.products.productEnd', ['productEnd' => $productEnd]) <!-- Display out-of-stock products -->
        </div>
    </div>




    {{-- ---- Modal thêm thuốc start -----  --}}
    <div class="modal fade" id="addProduct" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMedicineModalLabel">Thêm sản phẩm thuốc</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addProductForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="code_product" class="form-label">Mã sản phẩm</label>
                                <input type="text" class="form-control" name="code_product" id="code_product"
                                    value="{{ mt_rand(10000, 99999) }}">
                                <div class="invalid-feedback" id="code_product_error"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="name" class="form-label">Tên thuốc</label>
                                <input type="text" class="form-control" name="name" id="name">
                                <div class="invalid-feedback" id="name_error"></div>
                            </div>

                            <div class="col-md-6 d-flex flex-column">
                                <label for="product_images" class="form-label">Ảnh sản phẩm</label>
                                <input type="file" class="filepond" name="product_images[]" id="product_images"
                                    multiple accept="image/*">
                                <div class="invalid-feedback" id="product_images_error" style="display:block;"></div>
                                <div id="image_preview" class="row g-1 "></div>
                            </div>

                            <div class="col-md-6">
                                <label for="category_id" class="form-label">Nhóm</label>
                                <select class="form-select" name="category_id" id="category_id">
                                    <option value="">Chọn nhóm thuốc</option>
                                    <!-- Các tùy chọn sẽ được thêm vào bằng AJAX -->
                                </select>
                                <div class="invalid-feedback" id="category_id_error" style="display:block;"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="active_ingredient" class="form-label">Hoạt tính</label>
                                <input name="active_ingredient" class="form-control" id="active_ingredient">
                                <div class="invalid-feedback" id="active_ingredient_error"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="unit_of_measurement" class="form-label">Đơn vị</label>
                                <input type="text" class="form-control" name="unit_of_measurement"
                                    id="unit_of_measurement">
                                <div class="invalid-feedback" id="unit_of_measurement_error"></div>
                            </div>

                            <div class="col-md-6">
                                <label for="used" class="form-label">Công dụng</label>
                                <textarea name="used" class="form-control" id="used"></textarea>
                                <div class="invalid-feedback" id="used_error"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="description" class="form-label">Mô tả</label>
                                <textarea name="description" class="form-control" id="description"></textarea>
                                <div class="invalid-feedback" id="description_error"></div>
                            </div>
                            <div class="col-md-4">
                                <label for="price" class="form-label">Giá</label>
                                <input type="number" class="form-control" name="price" id="price">
                                <div class="invalid-feedback" id="price_error"></div>
                            </div>
                            <div class="col-md-4">
                                <label for="registration_number" class="form-label">Số đăng ký</label>
                                <input type="text" class="form-control" name="registration_number"
                                    id="registration_number">
                                <div class="invalid-feedback" id="registration_number_error"></div>
                            </div>
                            <div class="col-md-4">
                                <label for="registration_number" class="form-label">Số lượng</label>
                                <input type="text" class="form-control" name="quantity" id="registration_number">
                                <div class="invalid-feedback" id="registration_number_error"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="manufacture" class="form-label">Nhà sản xuất</label>
                                <input type="text" class="form-control" name="manufacture" id="manufacture">
                                <div class="invalid-feedback" id="manufacture_error"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="brand" class="form-label">Thương hiệu</label>
                                <input type="text" class="form-control" name="brand" id="brand">
                                <div class="invalid-feedback" id="brand_error"></div>
                            </div>
                        </div>
                        <div class="modal-footer  justify-content-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary" id="addProductBtn">Thêm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- ---- Modal thêm thuốc end -----  --}}


    {{-- ---- Modal câp nhật thuốc start -----  --}}
    <div class="modal fade" id="UpdateProduct" tabindex="-1" aria-labelledby="updateProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Cập nhật sản phẩm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editProductForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="hidden" name="product_id_up" id="product_id_up">
                                <label for="code_product_up" class="form-label">Mã sản phẩm</label>
                                <input type="text" class="form-control" name="code_product_up" id="code_product_up"
                                    value="{{ mt_rand(10000, 99999) }}">
                                <div class="invalid-feedback" id="code_product_error"></div>
                            </div>
                            <div class="col-md-6 d-flex flex-column">
                                <label for="name_up" class="form-label">Tên sản phẩm</label>
                                <input type="text" class="form-control" name="name_up" id="name_up">
                                <div class="invalid-feedback" id="name_error"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="product_images" class="form-label">Ảnh sản phẩm</label>
                                <input type="file" class="filepond" name="product_images_up[]" id="product_images_up"
                                    multiple accept="image/*">

                                <div id="image_preview_up" class="row g-1"></div>
                                <div class="invalid-feedback" id="product_images_error" style="display:block;"></div>

                                <!-- Input file ẩn để thay thế hình ảnh -->
                                <input type="file" class="filepond" name="new_image" id="new_image" accept="image/*"
                                    style="display: none;">

                                <input type="hidden" name="product_images_json" id="product_images_json">
                            </div>

                            <div class="col-md-6">
                                <label for="category_id" class="form-label">Nhóm</label>
                                <select class="form-select" name="category_id_up" id="category_id_up">
                                    <option value="">Chọn nhóm sản phẩm</option>
                                    <!-- Các tùy chọn sẽ được thêm vào bằng AJAX -->
                                </select>
                                <div class="invalid-feedback" id="category_id_error" style="display:block;"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="active_ingredient_up" class="form-label">Hoạt tính</label>
                                <textarea name="active_ingredient_up" class="form-control" id="active_ingredient_up"></textarea>
                                <div class="invalid-feedback" id="active_ingredient_error"></div>
                            </div>

                            <div class="col-md-6">
                                <label for="usage" class="form-label">Công dụng</label>
                                <textarea name="used_up" class="form-control" id="usage_up"></textarea>
                                <div class="invalid-feedback" id="usage_error"></div>
                            </div>
                            <div class="col-md-12">
                                <label for="description" class="form-label">Mô tả</label>
                                <textarea name="description_up" class="form-control" id="description_up"></textarea>
                                <div class="invalid-feedback" id="description_error"></div>
                            </div>
                            <div class="col-md-4">
                                <label for="price" class="form-label">Giá</label>
                                <input type="number" class="form-control" name="price_up" id="price_up">
                                <div class="invalid-feedback" id="price_error"></div>
                            </div>
                            <div class="col-md-4">
                                <label for="registration_number" class="form-label">Số đăng ký</label>
                                <input type="text" class="form-control" name="registration_number_up"
                                    id="registration_number_up">
                                <div class="invalid-feedback" id="registration_number_error"></div>
                            </div>
                            <div class="col-md-4">
                                <label for="registration_number" class="form-label">Số lượng</label>
                                <input type="text" class="form-control" name="quantity_up" id="quantity_up">
                                <div class="invalid-feedback" id="quantity_error"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="manufacture" class="form-label">Nhà sản xuất</label>
                                <input type="text" class="form-control" name="manufacture_up" id="manufacture_up">
                                <div class="invalid-feedback" id="manufacture_error"></div>
                            </div>

                            <div class="col-md-6">
                                <label for="brand" class="form-label">Thương hiệu</label>
                                <input type="text" class="form-control" name="brand_up" id="brand_up">
                                <div class="invalid-feedback" id="brand_error"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="unit_of_measurement_up" class="form-label">Đơn vị</label>
                                <input type="text" class="form-control" name="unit_of_measurement_up"
                                    id="unit_of_measurement_up">
                                <div class="invalid-feedback" id="unit_of_measurement_error"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="status" class="form-label">Trạng thái</label>
                                <select class="form-select" id="status_up" name="status_up">
                                    <option value="1">Hoạt động</option>
                                    <option value="0">Hết</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary" id="updateProductBtn">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ---- Modal cập nhật thuốc end ----- --}}



    {{-- ---- Modal cập nhật thuốc end -----  --}}



    <script>
        let selectedFiles = [];
        // ------ Hiển thị ảnh đã chọn start-----
        document.addEventListener("DOMContentLoaded", function() {
            const productImagesInput = document.getElementById("product_images");
            const imagePreviewContainer = document.getElementById("image_preview");
            const maxImages = 4;
            // Khai báo selectedFiles để lưu trữ các file đã chọn

            $('#product_images').on('change', function(event) {
                const files = Array.from(event.target.files);
                const indexToReplace = productImagesInput.dataset.index;

                if (indexToReplace !== undefined && indexToReplace !== "") {
                    const newFile = files[0];
                    const isFileSelected = selectedFiles.some(selectedFile => selectedFile.name === newFile
                        .name);

                    if (isFileSelected) {
                        alert(`Ảnh "${newFile.name}" đã được chọn. Không thể thay thế.`);
                        return;
                    }

                    selectedFiles[indexToReplace] = newFile;
                    productImagesInput.dataset.index = ""; // Đặt lại index
                } else {

                    for (let file of files) {
                        if (selectedFiles.some(selectedFile => selectedFile.name === file.name)) {
                            alert(`Ảnh "${file.name}" đã được chọn rồi.`);
                            return;
                        }
                    }

                    selectedFiles.push(...files);
                }

                // Cập nhật giao diện xem trước
                renderImagePreviews();
            });

            function renderImagePreviews() {
                imagePreviewContainer.innerHTML = ''; // Làm sạch nội dung trước đó

                selectedFiles.forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const imgContainer = document.createElement('div');
                        imgContainer.style.position = 'relative';
                        imgContainer.style.display = 'inline-block';
                        imgContainer.style.margin = '5px';
                        imgContainer.style.width = '150px';

                        const imgElement = document.createElement('img');
                        imgElement.src = e.target.result;
                        imgElement.classList.add('img-thumbnail');
                        imgElement.style.height = '100px';
                        imgElement.style.width = '100px';
                        imgElement.dataset.index = index;

                        imgElement.addEventListener('click', function() {
                            productImagesInput.dataset.index =
                                index; // Lưu index của ảnh đang được thay thế
                            productImagesInput.click(); // Mở hộp thoại chọn file
                        });

                        const removeButton = document.createElement('button');
                        removeButton.innerText = 'X';
                        removeButton.style.position = 'absolute';
                        removeButton.style.top = '0';
                        removeButton.style.right = '10%';
                        removeButton.style.width = '20px';
                        removeButton.style.height = '20px';
                        removeButton.style.borderRadius = '50%';
                        removeButton.style.fontSize = '12px';
                        removeButton.style.cursor = 'pointer';
                        removeButton.style.backgroundColor = 'red';
                        removeButton.style.color = 'white';

                        removeButton.addEventListener('click', function(event) {
                            event.stopPropagation(); // Ngăn việc mở input khi nhấn nút "X"
                            selectedFiles.splice(index, 1); // Xóa ảnh tại index
                            renderImagePreviews(); // Hiển thị lại ảnh sau khi xóa
                        });

                        imgContainer.appendChild(imgElement); // Thêm ảnh vào container
                        imgContainer.appendChild(removeButton); // Thêm nút "X" vào container
                        imagePreviewContainer.appendChild(
                            imgContainer); // Thêm container vào phần xem trước
                    };
                    reader.readAsDataURL(file); // Đọc file dưới dạng URL
                });
            }
        });

        // ------ Hiển thị ảnh đã chọn end -----


        // ------ Thêm sản phẩm thuốc start------
        function openAddModal() {
            $.ajax({
                url: '/system/products/create',
                type: 'GET',
                success: function(response) {

                    var categorySelect = $('#category_id');
                    categorySelect.empty();
                    categorySelect.append('<option value="">Chọn nhóm</option>');

                    response.category.forEach(function(item) {
                        categorySelect.append('<option value="' + item.category_id + '">' + item
                            .name + '</option>');
                    });


                    $('#addProduct').modal('show');
                },
                error: function(err) {
                    console.log(err.responseJSON);
                    console.error("Lỗi khi lấy dữ liệu nhóm sản phẩm thuốc:", err);
                }
            });
        }

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#addProductForm').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData();
                // Thêm từng trường vào formData
                var name = $('#name').val();
                var codeProduct = $('#code_product').val();
                var unitOfMeasurement = $('#unit_of_measurement').val();
                var activeIngredient = $('#active_ingredient').val();
                var used = $('#used').val();
                var description = $('#description').val();
                var price = $('#price').val();
                var brand = $('#brand').val();
                var manufacture = $('#manufacture').val();
                var registrationNumber = $('input[name="registration_number"]').val();
                var categoryId = $('#category_id').val();

                // Gán các biến vào formData
                formData.append('name', name);
                formData.append('code_product', codeProduct);
                formData.append('unit_of_measurement', unitOfMeasurement);
                formData.append('active_ingredient', activeIngredient);
                formData.append('used', used);
                formData.append('description', description);
                formData.append('price', price);
                formData.append('brand', brand);
                formData.append('manufacture', manufacture);
                formData.append('registration_number', registrationNumber);
                formData.append('category_id', categoryId);

                for (var i = 0; i < selectedFiles.length; i++) {
                    formData.append('product_images[]', selectedFiles[
                        i]);
                }



                $.ajax({
                    url: '/system/products/store',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            $('#addProductModal').modal('hide');
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(err) {
                        console.error("Lỗi khi thêm sản phẩm thuốc:", err);

                        if (err.responseJSON && err.responseJSON.errors) {
                            var errors = err.responseJSON.errors;

                            // Xóa lỗi cũ
                            $('.invalid-feedback').text('');
                            $('.form-control').removeClass('is-invalid');

                            // Hiển thị lỗi mới
                            $.each(errors, function(key, value) {
                                $('#' + key).addClass('is-invalid');
                                $('#' + key + '_error').text(value[0]);
                            });
                        } else {

                            alert('Có lỗi xảy ra, vui lòng kiểm tra console.');
                        }
                    }
                });
            });
        });
        // ------ Thêm sản phẩm thuốc end ------



        // ------ Cập nhật sản phẩm và hiển thị ảnh đã có start ------

        function openUpdateModal(id) {

            $.ajax({
                url: `/system/products/edit/` + id,
                type: 'GET',
                success: function(response) {
                    console.log(response);
                    $('#product_id_up').val(response.product.product_id);
                    $('#name_up').val(response.product.name);
                    $('#code_product_up').val(response.product.code_product);
                    $('#unit_of_measurement_up').val(response.product.unit_of_measurement);
                    $('#active_ingredient_up').summernote('code', response.product.active_ingredient);
                    $('#usage_up').summernote('code', response.product.used); // Hiển thị dữ liệu công dụng
                    $('#description_up').summernote('code', response.product
                        .description); // Hiển thị dữ liệu mô tả
                    $('#price_up').val(response.product.price);
                    $('#brand_up').val(response.product.brand);
                    $('#manufacture_up').val(response.product.manufacture);
                    $('#registration_number_up').val(response.product.registration_number);
                    $('#status_up').val(response.product.status);
                    $('#quantity_up').val(response.product.quantity);

                    $('#category_id_up').val(response.product.category_id);

                    var categorySelect = $('#category_id_up');
                    categorySelect.empty();
                    categorySelect.append(
                        '<option value="">Chọn nhóm sản phẩm</option>');

                    response.category.forEach(function(item) {
                        categorySelect.append('<option value="' + item.category_id + '">' +
                            item.name + '</option>');
                    });

                    categorySelect.val(response.product.category_id);

                    loadExistingImages(response.img_array); // Load các ảnh hiện có
                    $('#UpdateProduct').modal('show');
                },
                error: function(err) {
                    console.error("Lỗi khi lấy dữ liệu sản phẩm:", err);
                }
            });
        }

        let selectedUpdateFiles = []; // Mảng lưu các file hoặc URL ảnh đã chọn

        const productImagesInput = document.getElementById("product_images_up");
        const imagePreviewContainer = document.getElementById("image_preview_up");
        const maxImages = 4;

        // Hiển thị ảnh sản phẩm hiện có
        function loadExistingImages(img_array) {
            imagePreviewContainer.innerHTML = ''; // Làm sạch preview
            selectedUpdateFiles = img_array.map((image, index) => ({
                name: `image_${index}`, // Tên ảnh
                url: image, // URL ảnh
                file: null // Không có file thực tế cho ảnh hiện có
            }));
            selectedUpdateFiles.forEach((file, index) => displayImage(file, index));
        }

        // Xử lý khi người dùng chọn ảnh mới
        $('#product_images_up').on('change', function(event) {
            const files = Array.from(event.target.files);
            const indexToReplace = productImagesInput.dataset.index;

            if (indexToReplace !== undefined && indexToReplace !== "") {
                // Thay thế tệp đã chọn
                const file = files[0];
                selectedUpdateFiles[indexToReplace] = {
                    name: file.name,
                    url: URL.createObjectURL(file),
                    file: file // Thêm file thực tế vào danh sách
                };
                productImagesInput.dataset.index = "";
            } else {
                // Kiểm tra số lượng ảnh
                if (selectedUpdateFiles.length + files.length > maxImages) {
                    alert(`Bạn chỉ có thể chọn tối đa ${maxImages} ảnh.`);
                    return;
                }
                files.forEach(file => {
                    selectedUpdateFiles.push({
                        name: file.name,
                        url: URL.createObjectURL(file),
                        file: file // Thêm file thực tế vào danh sách
                    });
                });
            }

            // Hiển thị lại các ảnh đã chọn
            renderImagePreview();
        });

        // Hiển thị lại tất cả ảnh đã chọn
        function renderImagePreview() {
            imagePreviewContainer.innerHTML = ''; // Làm sạch container ảnh
            selectedUpdateFiles.forEach((file, index) => displayImage(file, index)); // Hiển thị lại ảnh
        }

        // Hàm hiển thị ảnh
        function displayImage(file, index) {
            const imgContainer = document.createElement('div');
            imgContainer.style.position = 'relative';
            imgContainer.style.display = 'inline-block';
            imgContainer.style.margin = '5px';
            imgContainer.style.width = '150px';

            const imgElement = document.createElement('img');
            imgElement.src = file.url; // Dùng URL của ảnh mới hoặc ảnh đã tải lên
            imgElement.classList.add('img-thumbnail');
            imgElement.style.height = '100px';
            imgElement.style.width = '100px';
            imgElement.dataset.index = index;

            imgElement.addEventListener('click', function() {
                productImagesInput.dataset.index = index;
                productImagesInput.click();
            });

            const removeButton = document.createElement('button');
            removeButton.innerText = 'X';
            removeButton.style.position = 'absolute';
            removeButton.style.top = '0';
            removeButton.style.right = '10%';
            removeButton.style.width = '20px';
            removeButton.style.height = '20px';
            removeButton.style.borderRadius = '50%';
            removeButton.style.fontSize = '12px';
            removeButton.style.cursor = 'pointer';
            removeButton.style.backgroundColor = 'red';
            removeButton.style.color = 'white';

            removeButton.addEventListener('click', function() {
                selectedUpdateFiles.splice(index, 1); // Xóa ảnh đã chọn
                renderImagePreview();
            });

            imgContainer.appendChild(imgElement);
            imgContainer.appendChild(removeButton);
            imagePreviewContainer.appendChild(imgContainer);
        }


        // Gửi form cập nhật sản phẩm
        $('#editProductForm').on('submit', function(e) {
            e.preventDefault();

            // Khởi tạo FormData để gửi cả file và dữ liệu form
            var formData = new FormData();
            
            // Thêm các trường dữ liệu vào FormData (dữ liệu không phải là file)
            formData.append('id', $('#product_id_up').val());
            formData.append('name_up', $('#name_up').val());
            formData.append('codeProduct', $('#code_product_up').val());
            formData.append('unitOfMeasurement', $('#unit_of_measurement_up').val());
            formData.append('activeIngredient', $('#active_ingredient_up').val());
            formData.append('used', $('#usage_up').val());
            formData.append('description', $('#description_up').val());
            formData.append('price', $('#price_up').val());
            formData.append('brand', $('#brand_up').val());
            formData.append('manufacture', $('#manufacture_up').val());
            formData.append('registrationNumber', $('#registration_number_up').val());
            formData.append('categoryId', $('#category_id_up').val());
            formData.append('status', $('#status_up').val() || '');
            formData.append('quantity', $('#quantity_up').val());
            formData.append('_token', '{{ csrf_token() }}');

            // Thêm các tệp tin vào FormData
            selectedUpdateFiles.forEach(function(fileObj) {
                if (fileObj.file) {
                    formData.append('product_images_up[]', fileObj.file); // Dùng append để gửi các file
                } else if (fileObj.file === null && fileObj.url) {
                    formData.append('product_images_url[]', fileObj.url); // Thêm URL vào nếu không có file
                }
            });

            // Gửi request AJAX
            $.ajax({
                url: '/system/products/update/' + $('#product_id_up').val(),
                type: 'post',
                data: formData,
                contentType: false, // Đảm bảo rằng không thay đổi kiểu content
                processData: false, // Đảm bảo dữ liệu không bị xử lý bởi jQuery
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        $('#UpdateProduct').modal('hide');
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(err) {
                    console.error("Lỗi khi cập nhật sản phẩm:", err);
                    console.error("Phản hồi lỗi từ server:", err.responseText);
                }
            });
        });



        // ------ Cập nhật sản phẩm và hiển thị ảnh đã có end ------
    </script>

    <script>
        $(document).ready(function() {
            // Áp dụng Summernote cho tất cả các textarea
            $('textarea').summernote({
                minHeight: 100,
                focus: true,
            });
        });
    </script>
@endsection
