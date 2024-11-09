@extends('layouts.admin.master')
@section('Quản lý sản phẩm')
@section('content')
    <style>
        #addProductForm {
            display: flex;
            flex-direction: column;
            align-items: center;
            /* Căn giữa theo chiều ngang */
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            /* Căn các nút sang bên phải */
            width: 100%;
        }
    </style>
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link  active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
                role="tab" aria-controls="nav-home" aria-selected="true">Hoạt động
            </button>
            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button"
                role="tab" aria-controls="nav-profile" aria-selected="false">Hết
            </button>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="d-flex align-items-center justify-content-between py-3">
            <div class="col-md-6 d-flex">
                <form action="" class="col-md-12 row">
                    <div class="col-md-6">
                        <input type="text" id="inputName" class="form-control" placeholder="Tên sản phẩm" name="name">
                    </div>
                </form>
            </div>
            <div class="">
                <a href="javascript:void(0)" class="btn btn-success me-1" onclick='openAddModal()'>Thêm sản phẩm</a>
            </div>

        </div>
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

            @include('System.products.product')

        </div>


        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">

            @include('System.products.productEnd')

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
                        <div class="col-md-12 row justify-content-center align-items-center">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="code_product" class="form-label">Mã sản phẩm</label>
                                    <input type="text" class="form-control" name="code_product" id="code_product"
                                        value="{{ mt_rand(10000, 99999) }}">
                                    <div class="invalid-feedback" id="code_product_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Tên thuốc</label>
                                    <input type="text" class="form-control" name="name" id="name">
                                    <div class="invalid-feedback" id="name_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="product_images" class="form-label">Ảnh sản phẩm</label>
                                    <input type="file" class="filepond" name="product_images[]" id="product_images"
                                        multiple accept="image/*">
                                    <div class="invalid-feedback" id="product_images_error" style="display:block;"></div>
                                </div>
                                <div id="image_preview" class="row mt-2"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Nhóm</label>
                                    <select class="form-select" name="category_id" id="category_id">
                                        <option value="">Chọn nhóm thuốc</option>
                                        <!-- Các tùy chọn sẽ được thêm vào bằng AJAX -->
                                    </select>
                                    <div class="invalid-feedback" id="category_id_error" style="display:block;"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="actice_ingredient" class="form-label">Hoạt tính</label>
                                    <textarea name="actice_ingredient" class="form-control" id="actice_ingredient"></textarea>
                                    <div class="invalid-feedback" id="actice_ingredient_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="unit_of_measurement" class="form-label">Đơn vị</label>
                                    <input type="text" class="form-control" name="unit_of_measurement"
                                        id="unit_of_measurement">
                                    <div class="invalid-feedback" id="unit_of_measurement_error"></div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="used" class="form-label">Công dụng</label>
                                    <textarea name="used" class="form-control" id="used"></textarea>
                                    <div class="invalid-feedback" id="used_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Mô tả</label>
                                    <textarea name="description" class="form-control" id="description"></textarea>
                                    <div class="invalid-feedback" id="description_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Giá</label>
                                    <input type="number" class="form-control" name="price" id="price">
                                    <div class="invalid-feedback" id="price_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="brand" class="form-label">Thương hiệu</label>
                                    <input type="text" class="form-control" name="brand" id="brand">
                                    <div class="invalid-feedback" id="brand_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="manufacture" class="form-label">Nhà sản xuất</label>
                                    <input type="text" class="form-control" name="manufacture" id="manufacture">
                                    <div class="invalid-feedback" id="manufacture_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="registration_number" class="form-label">Số đăng ký</label>
                                    <input type="text" class="form-control" name="registration_number"
                                        id="registration_number">
                                    <div class="invalid-feedback" id="registration_number_error"></div>
                                </div>
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
                        <div class="col-md-12 row justify-content-center align-items-center">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <input type="hidden"name="product_id_up" id="product_id_up">
                                    <label for="code_product_up" class="form-label">Mã sản phẩm</label>
                                    <input type="text" class="form-control" name="code_product_up"
                                        id="code_product_up" value="{{ mt_rand(10000, 99999) }}">
                                    <div class="invalid-feedback" id="code_product_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name_up" class="form-label">Tên sản phẩm</label>
                                    <input type="text" class="form-control" name="name_up" id="name_up">
                                    <div class="invalid-feedback" id="name_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="product_images" class="form-label">Ảnh sản phẩm</label>
                                    <input type="file" class="filepond" name="product_images_up[]"
                                        id="product_images_up" multiple accept="image/*">
                                    <div class="invalid-feedback" id="product_images_error" style="display:block;"></div>
                                </div>
                                <div id="image_preview_up" class="row mt-2"></div>

                                <!-- Input file ẩn để thay thế hình ảnh -->
                                <input type="file" class="filepond" name="new_image" id="new_image" accept="image/*"
                                    style="display: none;">

                                <input type="hidden" name="product_images_json" id="product_images_json">
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Nhóm</label>
                                    <select class="form-select" name="category_id_up" id="category_id_up">
                                        <option value="">Chọn nhóm sản phẩm</option>
                                        <!-- Các tùy chọn sẽ được thêm vào bằng AJAX -->
                                    </select>
                                    <div class="invalid-feedback" id="category_id_error" style="display:block;"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="active_ingredient_up" class="form-label">Hoạt tính</label>
                                    <textarea name="actice_ingredient_up" class="form-control" id="actice_ingredient_up"></textarea>
                                    <div class="invalid-feedback" id="active_ingredient_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="unit_of_measurement_up" class="form-label">Đơn vị</label>
                                    <input type="text" class="form-control" name="unit_of_measurement_up"
                                        id="unit_of_measurement_up">
                                    <div class="invalid-feedback" id="unit_of_measurement_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="usage" class="form-label">Công dụng</label>
                                    <textarea name="used_up" class="form-control" id="usage_up"></textarea>
                                    <div class="invalid-feedback" id="usage_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Mô tả</label>
                                    <textarea name="description_up" class="form-control" id="description_up"></textarea>
                                    <div class="invalid-feedback" id="description_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Giá</label>
                                    <input type="number" class="form-control" name="price_up" id="price_up">
                                    <div class="invalid-feedback" id="price_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="brand" class="form-label">Thương hiệu</label>
                                    <input type="text" class="form-control" name="brand_up" id="brand_up">
                                    <div class="invalid-feedback" id="brand_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="manufacture" class="form-label">Nhà sản xuất</label>
                                    <input type="text" class="form-control" name="manufacture_up"
                                        id="manufacture_up">
                                    <div class="invalid-feedback" id="manufacture_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="registration_number" class="form-label">Số đăng ký</label>
                                    <input type="text" class="form-control" name="registration_number_up"
                                        id="registration_number_up">
                                    <div class="invalid-feedback" id="registration_number_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Trạng thái</label>
                                    <select class="form-select" id="status_up" name="status_up">
                                        <option value="1">Hoạt động</option>
                                        <option value="0">Hết</option>
                                    </select>
                                </div>
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

                    // Khởi tạo Select2
                    // categorySelect.select2({
                    //     placeholder: "Chọn nhóm thuốc",
                    //     allowClear: true
                    // });



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
                var activeIngredient = $('#actice_ingredient').val();
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
                formData.append('actice_ingredient', activeIngredient);
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
                            location.reload();
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(err) {
                        console.error("Lỗi khi thêm sản phẩm thuốc:", err);
                        console.error("Response Text:", err.responseText);

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
                    $('#actice_ingredient_up').val(response.product.actice_ingredient);
                    $('#usage_up').val(response.product.used);
                    $('#description_up').val(response.product.description);
                    $('#price_up').val(response.product.price);
                    $('#brand_up').val(response.product.brand);
                    $('#manufacture_up').val(response.product.manufacture);
                    $('#registration_number_up').val(response.product.registration_number);
                    $('#status_up').val(response.product.status);

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
            formData.append('activeIngredient', $('#actice_ingredient_up').val());
            formData.append('used', $('#usage_up').val());
            formData.append('description', $('#description_up').val());
            formData.append('price', $('#price_up').val());
            formData.append('brand', $('#brand_up').val());
            formData.append('manufacture', $('#manufacture_up').val());
            formData.append('registrationNumber', $('#registration_number_up').val());
            formData.append('categoryId', $('#category_id_up').val());
            formData.append('status', $('#status_up').val() || '');
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
                        location.reload();
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


@endsection
