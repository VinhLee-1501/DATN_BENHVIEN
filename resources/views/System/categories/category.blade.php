<style>
    .img-container {
        width: 100%;
        max-width: 150px;
        aspect-ratio: 1 / 1;
    }

    .img-square {
        width: 100%;
        height: 100%;
        object-fit: cover;
        min-width: 50px;
        max-width: 150px;
    }

    .img-container-detail {
        width: 100%;
        max-width: 150px;
        aspect-ratio: 1 / 1;
    }

    .img-square-detail {
        width: 100%;
        height: 100%;
        object-fit: cover;
        min-width: 50px;
        max-width: 150px;
    }
</style>
<div class="d-flex align-items-center justify-content-between py-3">
    <div class="col-md-6 d-flex">
        <form action="" class="col-md-12 row">
            <div class="col-md-6">
                <input type="text" id="inputName" class="form-control" placeholder="Tên sản phẩm" name="name">
            </div>
        </form>
    </div>
    <div class="">
        <a href="javascript:void(0)" class="btn btn-success me-1" onclick='openAddModal()'>Thêm danh mục</a>
    </div>
</div>
<div class="card w-100">
    <div class="card-body p-4">
        <h5 class="card-title fw-semibold mb-4">Quản lý danh mục</h5>

        <div class="table-responsive">
            {!! $category->links() !!}
            <table class="table table-bordered text-nowrap mb-0 align-middle">
                <thead class="text-dark fs-4">
                    <tr class="text-center">
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">#</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Tên danh mục</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Ảnh</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Ngày thêm</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Trạng thái</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Hành động</h6>
                        </th>
                    </tr>
                </thead>
                <tbody id="myTable">
                    @php
                        $count = 1;
                    @endphp
                    @foreach ($category as $data)
                        <tr class="align-baseline text-center">
                            <td class="border-bottom-0">
                                <h6 class="fw-semibold mb-0"> {{ $count++ }}</h6>
                            </td>
                            <td class="border-bottom-0">
                                <p class="mb-0 fw-semibold">{{ $data->name }}</p>
                            </td>
                            <td class="border-bottom-0">
                                @if ($data->img)
                                    <img src="{{ asset('storage/uploads/categories/' . $data->img) }}"
                                        alt="Category Image" style="width: 100px; height: auto;">
                                @else
                                    <img src="{{ asset('backend/assets/images/products/img-notfound.jpg') }}"
                                        alt="Category Image" style="width: 100px; height: auto;">
                                @endif

                            </td>
                            <td class="border-bottom-0">
                                <p class="mb-0 fw-semibold">
                                    {{ Carbon\Carbon::parse($data->create_at)->format('d/m/Y') }}</p>
                            </td>
                            <td class="border-bottom-0">
                                @if ($data->status == 1)
                                    <span class="badge bg-success">Hoạt động </span>
                                @else
                                    <span class="badge bg-danger">Ẩn</span>
                                @endif
                            </td>
                            </td>
                            <td class="border-bottom-0 d-flex justify-content-center align-items-center" colspan="5">
                                <a href="javascript:void(0)" class="btn btn-primary me-1"
                                    onclick="openUpdateModal('{{ $data->category_id }}')">
                                    <i class="ti ti-pencil"></i>
                                </a>
                                <form action="{{ route('system.category.delete', $data->category_id) }}"
                                    id="form-delete{{ $data->category_id }}" method="post">
                                    @method('delete')
                                    @csrf
                                </form>
                                <button type="submit" class="btn btn-danger btn-delete"
                                    data-id="{{ $data->category_id }}">
                                    <i class="ti ti-trash"></i>
                                </button>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $category->links() !!}
        </div>
    </div>
</div>

{{-- ---- Modal thêm danh mục start -----  --}}
<div class="modal fade" id="addProduct" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMedicineModalLabel">Thêm danh mục</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addProductForm" medthod="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-12 row">
                        <div class="mb-3">
                            <label for="medicine" class="form-label">Tên danh mục</label>
                            <input type="text" name="name" class="form-control " id="name">
                            <div class="invalid-feedback" id="name_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="img" class="form-label">Ảnh</label>
                            <input type="file" name="img" class="form-control" id="img" accept="image/*">
                            <div class="invalid-feedback" id="img_error"></div>
                        </div>
                        <div id="image-preview" style="margin-bottom: 10px;"></div>
                        <div class="mb-3">
                            <label for="parent_id" class="form-label">Danh mục cha</label>
                            <select class="form-select" name="parent_id" id="parent_id">
                                <option value="">Chọn nhóm thuốc</option>
                                <!-- Các tùy chọn sẽ được thêm vào bằng AJAX -->
                            </select>
                            <div class="invalid-feedback" id="parent_id_error" style="display:block;"></div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button class="btn btn-primary" id="addMedicineBtn" type="submit">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- ---- Modal thêm danh mục end -----  --}}

{{-- ---- Modal cập nhật danh mục start -----  --}}
<div class="modal fade" id="updateProduct" tabindex="-1" aria-labelledby="updateModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateCategoryModal">Cập nhật danh mục</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateForm" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-12 row">
                        <div class="mb-3">
                            <label for="name_up" class="form-label">Tên danh mục</label>
                            <input type="text" name="name_up" class="form-control " id="name_up">
                            <input type="hidden" name="category_id" class="form-control " id="category_id">
                            <div class="invalid-feedback" id="name_up_error"></div>
                        </div>
                        <div class="d-grid justify-content-center mb-3">
                            <label for="img" class="form-label text-center">Ảnh</label>

                            <img id="current_img" src="{{ asset('backend/assets/images/products/img-notfound.jpg') }}"
                                alt="Category Image"
                                style="width: 150px; height: 150px; cursor: pointer;object-fit: cover;">

                            <input type="file" name="img" class="form-control" id="img_up"
                                accept="image/*" style="display: none;">

                            <div class="invalid-feedback" id="img_error"></div>

                        </div>

                        <div class="mb-3">
                            <label for="parent_id_up" class="form-label">Danh mục cha</label>
                            <select class="form-select" name="parent_id_up" id="parent_id_up">
                                <option value="">Chọn nhóm thuốc</option>
                                <!-- Các tùy chọn sẽ được thêm vào bằng AJAX -->
                            </select>
                            <div class="invalid-feedback" id="parent_id_up_error" style="display:block;"></div>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Trạng thái</label>
                            <select class="form-select" id="status" name="status">
                                <option value="1">Hoạt động</option>
                                <option value="0">Hết</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button class="btn btn-primary" id="updateMedicineBtn" type="submit">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- ---- Modal cập nhật danh mục end -----  --}}



<script>
    // ------ Thêm sản phẩm thuốc start------

    document.getElementById('img').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const previewDiv = document.getElementById('image-preview');
        const errorDiv = document.getElementById('img_error');

        previewDiv.innerHTML = '';
        errorDiv.textContent = '';

        if (file) {
            if (file.type.startsWith('image/')) {
                const imgElement = document.createElement('img');
                imgElement.src = URL.createObjectURL(file);
                imgElement.style.maxWidth = '150px';
                imgElement.style.maxHeight = '150px';
                imgElement.style.objectFit = 'cover';
                imgElement.style.display = 'block';
                imgElement.style.margin = '0 auto';

                previewDiv.appendChild(imgElement);

                imgElement.onload = function() {
                    URL.revokeObjectURL(imgElement.src);
                };
            } else {

                errorDiv.textContent = 'Vui lòng chọn một tệp ảnh hợp lệ.';
            }
        } else {
            errorDiv.textContent = 'Không có ảnh nào được chọn.';
        }
    });

    function openAddModal() {
        $.ajax({
            url: '/system/categories/create',
            type: 'GET',
            success: function(response) {


                var categorySelect = $('#parent_id ');
                categorySelect.empty();
                categorySelect.append('<option value="">Chọn nhóm</option>');

                response.parent.forEach(function(item) {
                    categorySelect.append('<option value="' + item.parent_id + '">' + item
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

            var name = $('#name').val();
            var parent_id = $('#parent_id').val();
            var file = $('#img')[0].files[0];

            formData.append('name', name);
            formData.append('img', file);
            formData.append('parent_id', parent_id);
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

            $.ajax({
                url: '/system/categories/store',
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
                        }, 2000);
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



    // cập nhật
    let selectedFile = null;
    $('#current_img').on('click', function() {
        $('#img_up').click();
    });

    $('#img_up').on('change', function(event) {
        selectedFile = event.target.files[0]; // Lưu tệp ảnh đã chọn vào biến
        if (selectedFile) {
            var reader = new FileReader();

            // Đọc file ảnh và hiển thị trong thẻ img
            reader.onload = function(e) {
                $('#current_img').attr('src', e.target.result); // Cập nhật src của ảnh hiện tại
            };

            reader.readAsDataURL(selectedFile);
        }
    });

    function openUpdateModal(id) {

        $.ajax({
            url: `/system/categories/edit/` + id,
            type: 'GET',
            success: function(response) {

                $('#name_up').val(response.category.name);
                $('#category_id').val(response.category.category_id);
                $('#status').val(response.category.status);
                if (response.category && response.category.img) {

                    $('#current_img').attr('src', '/storage/uploads/categories/' + response.category.img);
                } else {
                    $('#current_img').attr('src',
                        '{{ asset('backend/assets/images/products/img-notfound.jpg') }}');
                }
                $('#current_img').show();

                $('#parent_id_up').val(response.category.parent_id);
                var categorySelect = $('#parent_id_up');
                categorySelect.empty();
                categorySelect.append(
                    '<option value="">Chọn nhóm danh mục</option>');

                response.parent.forEach(function(item) {
                    categorySelect.append('<option value="' + item.parent_id + '">' +
                        item.name + '</option>');
                });

                categorySelect.val(response.category.parent_id);


                $('#updateProduct').modal('show');
            },
            error: function(err) {
                console.error("Lỗi khi lấy dữ liệu sản phẩm:", err);
            }
        });
    }
    $(document).ready(function() {
        $('#updateForm').on('submit', function(e) {
            e.preventDefault();

            var id = $('#category_id').val();
            var status = $('#status').val();
            var formData = new FormData();

            formData.append('name', $('#name_up').val());
            formData.append('status', $('#status').val());
            formData.append('parent_id', $('#parent_id_up').val());
            if (selectedFile) {
                formData.append('img', selectedFile);
            }

            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));


            $.ajax({
                url: '/system/categories/update/' + id,
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        $('#updateProduct').modal('hide');
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(err) {
                    console.error("Lỗi khi cập nhật danh mục:", err);

                }
            });
        });
    });
</script>
