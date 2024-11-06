@extends('layouts.admin.master')
@section('Quản lý mã giảm giá')
@section('content')

    {{-- <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link  active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
                role="tab" aria-controls="nav-home" aria-selected="true">Hoạt động
            </button>
            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button"
                role="tab" aria-controls="nav-profile" aria-selected="false">Không hoạt động
            </button>
        </div>
    </nav> --}}
    <div class="tab-content" id="nav-tabContent">


        <div class="card w-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between py-3">
                    <h5 class="col-md-4 card-title fw-semibold ">Quản mã giảm giá</h5>
                    <div class="col-md-6 d-flex">
                        <form action="" class="col-md-12 row">
                            <div class="col-md-6">
                                <input type="text" id="inputName" class="form-control" placeholder="Mã giảm giá"
                                    name="name">
                            </div>
                        </form>
                    </div>
                    <div class="col-md-2">
                        <a href="javascript:void(0)" class="btn btn-success me-1" onclick='openAddModal()'>Thêm mã</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Mã</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Giảm giá</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">TG bắt đầu</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">TG kết thúc</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Hành động</h6>
                                </th>
                            </tr>
                        </thead>
                        @foreach ($couponActive as $active)
                            <tbody id="myTable">
                                <tr>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">{{ $active->coupon_code }}</h6>
                                    </td>
                                    <td class="border-bottom-0" style="width:15%;">
                                        <p class="mb-0 fw-semibold">
                                            @if ($active->discount > 100)
                                                {{ Number::currency($active->discount, 'VND', 'vi') }}
                                            @else
                                                {{ $active->discount }}%
                                            @endif
                                        </p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="mb-0 fw-semibold">
                                            {{ Carbon\Carbon::parse($active->time_start)->format('d-m-Y') }}
                                        </p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="mb-0 fw-semibold">
                                            {{ Carbon\Carbon::parse($active->time_end)->format('d-m-Y') }}
                                        </p>
                                    </td>

                                    <td class="border-bottom-0">
                                        <a href="" class="btn btn-primary">
                                            <i class="ti ti-notes"></i>
                                        </a>
                                        <a href="javascript:void(0)" class="btn btn-primary "
                                            onclick="openModalEditCoupon('{{ $active->coupon_id }}')"><i
                                                class="ti ti-pencil"></i></a>
                                        <form action="{{ route('system.delete', $active->coupon_id) }}"
                                            id="form-delete{{ $active->coupon_id }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <button type="submit" class="btn btn-danger btn-delete"
                                            data-id="{{ $active->coupon_id }}">
                                            <i class="ti ti-trash"></i>
                                        </button>

                                    </td>
                                </tr>
                            </tbody>
                        @endforeach

                    </table>
                </div>
            </div>
        </div>

    </div>


    {{-- Thêm  --}}
    <div class="modal fade" id="addCouponModalLabel" tabindex="-1" aria-labelledby="addCouponModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCouponModalLabel">Thêm Mã giảm giá sản phẩm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCouponForm">
                        @csrf
                        <div class="col-md-12 row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="couponCode" class="form-label">Mã Giảm giá</label>
                                    <input type="text" name="couponCode" id="couponCode" class="form-control"
                                        value="">
                                    <div class="invalid-feedback" id="couponCode_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="discount" class="form-label">Giá giảm</label>
                                    <input type="text" class="form-control" name="discount" id="discount">
                                    <div class="invalid-feedback" id="discount_error"></div>
                                    <div class="d-flex mt-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="percentReduction"
                                                id="percentReduction">
                                            <label class="form-check-label" for="percentReduction">
                                                Giảm %
                                            </label>
                                        </div>
                                        <div class="form-check ms-5">
                                            <input class="form-check-input" type="checkbox" name="reduceMoney"
                                                id="reduceMoney" checked>
                                            <label class="form-check-label" for="reduceMoney">
                                                Giảm tiền
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Thời gian bắt đầu</label>
                                    <input type="date" class="form-control" name="timeStart" id="timeStart">
                                    <div class="invalid-feedback" id="timeStart_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Thời gian kết thúc</label>
                                    <input type="date" class="form-control" name="timeEnd" id="timeEnd">
                                    <div class="invalid-feedback" id="timeEnd_error"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button class="btn btn-primary" id="addCoupontBtn" type="submit">Thêm</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- Sửa --}}
    <div class="modal fade" id="updateCouponModalLabel" tabindex="-1" aria-labelledby="updateCouponModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateCouponModalLabel">Thêm Mã giảm giá sản phẩm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateCouponForm">
                        @csrf
                        <div class="col-md-12 row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="couponCodeEdit" class="form-label">Mã Giảm giá</label>
                                    <input type="text" name="couponCode" id="couponCodeEdit" class="form-control"
                                        value="">
                                    {{-- <input type="text" id="couponId" name="couponId" hidden> --}}
                                    <div class="invalid-feedback" id="couponCodeEdit_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="discount" class="form-label">Giá giảm</label>
                                    <input type="text" class="form-control" name="discount" id="discountEdit">
                                    <div class="invalid-feedback" id="discountEdit_error"></div>
                                    <div class="d-flex mt-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="percentReduction"
                                                id="percentReductionEdit">
                                            <label class="form-check-label" for="percentReduction">
                                                Giảm %
                                            </label>
                                        </div>
                                        <div class="form-check ms-5">
                                            <input class="form-check-input" type="checkbox" name="reduceMoney"
                                                id="reduceMoneyEdit" checked>
                                            <label class="form-check-label" for="reduceMoney">
                                                Giảm tiền
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Thời gian bắt đầu</label>
                                    <input type="date" class="form-control" name="timeStart" id="timeStartEdit">
                                    <div class="invalid-feedback" id="timeStartEdit_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Thời gian kết thúc</label>
                                    <input type="date" class="form-control" name="timeEnd" id="timeEndEdit">
                                    <div class="invalid-feedback" id="timeEndEdit_error"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button class="btn btn-primary" id="updateCoupontBtn" type="submit">Thêm</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        function openAddModal() {
            $('#addCouponModalLabel').modal('show');
        }

        $('#addCoupontBtn').on('click', function() {
            $('#addCouponForm').on('submit', function(e) {
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

                const data = $(this).serializeArray();

                $.ajax({
                    url: '/system/coupons/store',
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        $('#addCouponModalLabel').modal('hide');
                        if (response.success) {
                            toastr.success(response.message);
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(err) {
                        if (err.responseJSON && err.responseJSON.errors) {
                            let error = err.responseJSON.errors;
                            $('.invalid-feedback').text('');
                            $('.form-control').removeClass('is-invalid');
                            $.each(error, function(key, value) {
                                $('#' + key).addClass('is-invalid');
                                $('#' + key + '_error').text(value[0]);
                            });
                        } else {
                            console.error(err);
                        }
                    }
                });
            });
        });
    </script>

    <script>
        function formatDateForInput(date) {
            // Chuyển đổi ngày giờ sang đối tượng Date
            const vietnamDate = new Date(date);

            // Đảm bảo ngày không bị sai múi giờ
            const day = vietnamDate.getDate().toString().padStart(2, '0');
            const month = (vietnamDate.getMonth() + 1).toString().padStart(2,
                '0'); // Lấy tháng và thêm 1 vì tháng bắt đầu từ 0
            const year = vietnamDate.getFullYear();

            // Chuyển sang định dạng YYYY-MM-DD cho input type="date"
            const formattedDateForInput = `${year}-${month}-${day}`;

            return formattedDateForInput;
        }

        function openModalEditCoupon(id) {
            $('#updateCouponModalLabel').modal('show');
            $.ajax({
                url: '/system/coupons/edit/' + id,
                type: 'GET',
                success: function(res) {
                    if (res.coupon && res.coupon.coupon_id) {
                        $('#couponCodeEdit').val(res.coupon.coupon_code);
                        $('#discountEdit').val(res.coupon.discount);
                        $('#timeStartEdit').val(formatDateForInput(res.coupon.time_start));
                        $('#timeEndEdit').val(formatDateForInput(res.coupon.time_end));
                        $('#updateCouponModalLabel').data('id', id);
                    } else {
                        alert('Không tìm thấy mã coupon');
                    }
                }
            })

            $(document).ready(function() {
                $('#updateCoupontBtn').on('click', function() {
                    $('#updateCouponForm').on('submit', function(e) {
                        e.preventDefault();
                        const id = $('#updateCouponModalLabel').data('id');
                        const discountEdit = parseFloat($('#discountEdit').val());
                        const isPercentReductionEdit = $('#percentReductionEdit').is(':checked');
                        const isReduceMoneyEdit = $('#reduceMoneyEdit').is(':checked');

                        if (isPercentReductionEdit && (isNaN(discountEdit) || discountEdit >=
                                100)) {
                            $('#discountEdit').addClass('is-invalid');
                            $('#discountEdit_error').text('Giảm % phải nhỏ hơn 100');
                            return;
                        } else if (isReduceMoneyEdit && (isNaN(discountEdit) || discountEdit <
                                1000)) {
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
                            $('#timeStartEdit_error').text(
                                'Thời gian bắt đầu phải lớn hơn ngày hiện tại');
                            return;
                        } else {
                            $('#timeStartEdit').removeClass('is-invalid');
                            $('#timeStartEdit_error').text('');
                        }

                        if (timeEndEdit <= timeStartEdit) {
                            $('#timeEndEdit').addClass('is-invalid');
                            $('#timeEndEdit_error').text(
                                'Thời gian kết thúc phải lớn hơn thời gian bắt đầu');
                            return;
                        } else {
                            $('#timeEndEdit').removeClass('is-invalid');
                            $('#timeEndEdit_error').text('');
                        }

                        const data = $(this).serializeArray();
                        

                        $.ajax({
                            url: '/system/coupons/update/' + id,
                            type: 'PATCH',
                            data: data,
                            success: function(response) {
                                $('#updateCouponModalLabel').modal('hide');
                                if (response.success) {
                                    toastr.success(response.message);
                                    setTimeout(() => {
                                        location.reload();
                                    }, 2000);
                                } else {
                                    alert(response.message);
                                }
                            },
                            error: function(err) {
                                if (err.responseJSON && err.responseJSON.errors) {
                                    let error = err.responseJSON.errors;
                                    $('.invalid-feedback').text('');
                                    $('.form-control').removeClass('is-invalid');
                                    $.each(error, function(key, value) {
                                        $('[name="' + key + '"]' ).addClass('is-invalid');
                                        $('#' + key + '_error').text(value[0]);
                                    });
                                }else{
                                    console.error(err);
                                }
                            }
                        });

                    })
                })
            });
        }
    </script>
@endsection
