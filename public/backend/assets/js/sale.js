// Sale_products

$(document).ready(function () {
    $('#productId').select2();
});

function openAddModal() {
    $('#addSaleProductModalLabel').modal('show');
}

function loadProduct(selectProductId = null) {
    $.ajax({
        url: '/system/sale_products/create',
        type: 'GET',
        success: function (response) {
            const select = $('.productIdEdit, #productId');
            select.empty();
            select.append(`<option value="">-- Chọn sản phẩm --</option>`);

            response.products.forEach(function (product) {
                // Kiểm tra nếu specialty_id hiện tại có bằng với specialty_id của chuyên khoa
                const isSelected = (selectProductId && product.product_id ==
                    selectProductId) ? 'selected' : '';
                select.append(
                    `<option value="${product.product_id}" ${isSelected}>${product.name}</option>`
                );
            });
        },
        error: function (xhr) {
            console.error('Error fetching product:', xhr);
            // Handle error case, e.g., show a notification to the user
        }
    });
}

$(document).ready(function () {
    loadProduct();

    $('#addSaleProductBtn').on('click', function () {
        $('#addSaleProductForm').submit(function (e) {
            e.preventDefault();


            const discount = parseFloat($('#discount').val());
            const isPercentReduction = $('#percentReduction').is(':checked');
            const isReduceMoney = $('#reduceMoney').is(':checked');

            if (isPercentReduction && (isNaN(discount) || discount >= 100)) {
                $('#discount').addClass('is-invalid');
                $('#discount_error').text('Giảm % phải nhỏ hơn 100');
                return;
            } else if (isReduceMoney && (isNaN(discount) || discount < 1000)) {
                $('#discount').addClass('is-invalid');
                $('#discount_error').text('Giảm tiền tối thiểu là 1000');
                return;
            } else {
                $('#discount').removeClass('is-invalid');
                $('#discount_error').text('');
            }

            // Kiểm lỗi chọn ngày
            const today = new Date().toISOString().split("T")[0];
            const timeStart = $('#timeStart').val();
            const timeEnd = $('#timeEnd').val();

            if (timeStart <= today) {
                $('#timeStart').addClass('is-invalid');
                $('#timeStart_error').text('Thời gian bắt đầu phải lớn hơn ngày hiện tại');
                return;
            } else {
                $('#timeStart').removeClass('is-invalid');
                $('#timeStart_error').text('');
            }

            if (timeEnd <= timeStart) {
                $('#timeEnd').addClass('is-invalid');
                $('#timeEnd_error').text('Thời gian kết thúc phải lớn hơn thời gian bắt đầu');
                return;
            } else {
                $('#timeEnd').removeClass('is-invalid');
                $('#timeEnd_error').text('');
            }

            if ($('#statusActive').is(':checked')) {
                $('#statusActive').val(1);
            } else {
                $('#statusActive').val(0);
            }

            var data = $(this).serializeArray();
            console.log(data);

            $.ajax({
                url: '/system/sale_products/store',
                type: 'POST',
                data: data,
                success: function (response) {
                    $('#addSaleProductModalLabel').modal('hide');
                    if (response.success) {
                        toastr.success(response.message);
                        setTimeout(() => {
                            location.reload();
                        }, 2000)
                    } else if (response.error) {
                        toastr.error(response.message);
                    }
                },
                error: function (error) {
                    if (error.responseJSON && error.responseJSON.errors) {
                        let errors = error.responseJSON.errors;
                        $('.invalid-feedback').text('');
                        $('.form-control').removeClass('is-invalid');
                        $.each(errors, function (key, value) {
                            $('#' + key).addClass('is-invalid');
                            $('#' + key + '_error').text(value[0]);
                        });
                    } else {
                        console.error(error);
                    }
                }
            });
        });
    });
});

// Update sale_product

function formatDateForInput(date) {
    // Chuyển đổi ngày giờ sang đối tượng Date
    const vietnamDate = new Date(date);

    // Đảm bảo ngày không bị sai múi giờ
    const day = vietnamDate.getDate().toString().padStart(2, '0');
    const month = (vietnamDate.getMonth() + 1).toString().padStart(2, '0'); // Lấy tháng và thêm 1 vì tháng bắt đầu từ 0
    const year = vietnamDate.getFullYear();

    // Chuyển sang định dạng YYYY-MM-DD cho input type="date"
    const formattedDateForInput = `${year}-${month}-${day}`;

    return formattedDateForInput;
}

function openModalEdit(id) {
    $('#updateSaleProductModalLabel').modal('show');

    $.ajax({
        url: '/system/sale_products/edit/' + id,
        type: 'GET',
        success: function (res) {
            if (res.saleProduct && res.saleProduct.sale_id) {
                $('#saleCodeEdit').val(res.saleProduct.sale_code);
                $('#discountEdit').val(res.saleProduct.discount);
                $('#productIdEdit').val(res.saleProduct.product_id);
                $('#timeStartEdit').val(formatDateForInput(res.saleProduct.time_start));
                $('#timeEndEdit').val(formatDateForInput(res.saleProduct.time_end));
                $('#statusActiveEdit').prop('checked', res.saleProduct.status == 1);
                $('#updateSaleProductModalLabel').data('id', id)
            } else {
                console.error('Error fetching sale product:', res);
            }
            loadProduct(res.saleProduct.product_id)
        }
    });
}

$(document).ready(function () {
    $('#updateSaleProductBtn').on('click', function () {
        $('#updateSaleProductModalLabel').on('submit', function (event) {
            event.preventDefault();
            const id = $('#updateSaleProductModalLabel').data('id');
            const discountEdit = parseFloat($('#discountEdit').val());
            const isPercentReductionEdit = $('#percentReductionEdit').is(':checked');
            const isReduceMoneyEdit = $('#reduceMoneyEdit').is(':checked');

            if (isPercentReductionEdit && (isNaN(discountEdit) || discountEdit >= 100)) {
                $('#discountEdit').addClass('is-invalid');
                $('#discountEdit_error').text('Giảm % phải nhỏ hơn 100');
                return;
            } else if (isReduceMoneyEdit && (isNaN(discountEdit) || discountEdit < 1000)) {
                $('#discountEdit').addClass('is-invalid');
                $('#discountEdit_error').text('Giảm tiền tối thiểu là 1000');
                return;
            } else {
                $('#discountEdit').removeClass('is-invalid');
                $('#discountEdit_error').text('');
            }

            // Kiểm lỗi chọn ngày
            const todayEdit = new Date().toISOString().split("T")[0];
            const timeStartEdit = $('#timeStartEdit').val();
            const timeEndEdit = $('#timeEndEdit').val();

            if (timeStartEdit <= todayEdit) {
                $('#timeStartEdit').addClass('is-invalid');
                $('#timeStartEdit_error').text('Thời gian bắt đầu phải lớn hơn ngày hiện tại');
                return;
            } else {
                $('#timeStartEdit').removeClass('is-invalid');
                $('#timeStartEdit_error').text('');
            }

            if (timeEndEdit <= timeStartEdit) {
                $('#timeEndEdit').addClass('is-invalid');
                $('#timeEndEdit_error').text('Thời gian kết thúc phải lớn hơn thời gian bắt đầu');
                return;
            } else {
                $('#timeEndEdit').removeClass('is-invalid');
                $('#timeEndEdit_error').text('');
            }

            if ($('#statusActiveEdit').is(':checked')) {
                $('#statusActiveEdit').val(1);
            } else {
                $('#statusActiveEdit').val(0);
            }
            const data = $('#updateSaleProductForm').serialize();

            $.ajax({
                url: '/system/sale_products/update/' + id,
                type: 'PATCH',
                data: data,
                success: function (response){
                    $('#updateSaleProductModalLabel').modal('hide');
                    if (response.success) {
                        toastr.success(response.message);
                        setTimeout(() => {
                            location.reload();
                        }, 3000);
                    } else if (response.error) {
                        toastr.error(response.message);
                    }
                },
                error: function (err) {
                    if (err.responseJSON && err.responseJSON.errors) {
                        let errors = err.responseJSON.errors;
                        $('.invalid-feedback').text('');
                        $('.form-control').removeClass('is-invalid');
                        $.each(errors, function (key, value) {
                            $('[name="' + key + '"]').addClass('is-invalid');
                            $('#' + key + '_error').text(value[0]);
                        });
                    } else {
                        console.error(err);
                    }
                }
            });
        })

        
    });
});