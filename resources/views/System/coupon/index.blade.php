@extends('layouts.admin.master')
@section('Quản lí mã giảm giá')
@section('content')
    <div class="card w-100">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center m-1 mb-4">
                <a href="{{ route('system.coupon.resetsearch') }}" class="card-title">
                    <h3>Quản lý mã giảm giá</h3>
                </a>
                <div>
                    <a href="{{ route('system.coupons.create') }}" class="btn btn-success">Thêm mới</a>
                </div>
            </div>
            <div class="table text-nowrap mb-0 align-middle">
                <form id="searchForm" action="{{ route('system.coupon') }}" class="d-flex position-relative" method="get">
                    <input type="text" name="search" id="searchInput" class="form-control ms-3"
                        value="{{ request('search', $search) }}" placeholder="Nhập tiêu đề"
                        style="border-top-right-radius: 0; border-bottom-right-radius: 0; width:214px;">
                    <!-- Nút tìm kiếm -->
                    <button type="submit" class="btn btn-success position-absolute px-0"
                        style="top: 50%; right: 75%; transform: translateY(-50%); z-index: 1; border-top-left-radius: 0; border-bottom-left-radius: 0;">
                        <i class="ti ti-search"></i>
                    </button>
                    <button type="button" id="deleteButton" class="btn btn-danger position-absolute px-0"
                        style="left: 27%; top: 50%; transform: translateY(-50%);"><i class="ti ti-trash"></i></button>
                    <div class="position-absolute" style="right: 0%; top: 50%; transform: translateY(-50%);">
                        <div class="d-flex ">
                            <span class="me-2 mt-2">Hiển thị:</span>
                            <select class="form-select" id="itemsPerPage" aria-label="Items per page" style="width: auto;">
                                <option value="5" {{ request()->input('itemsPerPage', 5) == 5 ? 'selected' : '' }}>5
                                </option>
                                <option value="10" {{ request()->input('itemsPerPage', 5) == 10 ? 'selected' : '' }}>10
                                </option>
                                <option value="15" {{ request()->input('itemsPerPage', 5) == 15 ? 'selected' : '' }}>15
                                </option>
                                <option value="20" {{ request()->input('itemsPerPage', 5) == 20 ? 'selected' : '' }}>20
                                </option>
                            </select>

                        </div>
                    </div>

                </form>

                <!-- Form Xóa Bài Viết -->
                <form id="deleteForm" action="{{ route('system.coupon.multipledelete') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th></th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Mã giảm giá</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Mô tả</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Ngày bắt đầu</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Ngày kết thúc</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Hành động</h6>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            @if ($coupons->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <h5 class="text-muted">Không tìm thấy kết quả nào
                                        </h5>
                                    </td>
                                </tr>
                            @else
                            
                                @foreach ($coupons as $data)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="coupon_id[]" value="{{ $data->coupon_id }}"
                                                class="blogCheckbox">
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="fw-semibold mb-0">{{ $data->discount_code }}</p>
                                        </td>
                                        <td class="border-bottom-0 " style="overflow: hidden;">
                                            <p class="mb-0 fw-semibold">{{ $data->note }}</p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-semibold">{{ $data->time_start }}</p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-semibold">{{ $data->time_end }}</p>
                                        </td>
                                        <td class="border-bottom-0 d-flex">
                                            <a href="{{ route('system.coupons.edit', $data->discount_code) }}"
                                                class="btn btn-primary me-1">
                                                <i class="ti ti-pencil"></i>
                                            </a>
                                            <a href="{{ route('system.coupons.delete', $data->coupon_id) }}"
                                                class="btn btn-danger me-1">
                                                <i class="ti ti-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </form>
                <div class="mt-3 d-flex justify-content-center">
                    {{ $coupons->links() }}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('deleteButton').addEventListener('click', function() {
                var selectedCheckboxes = document.querySelectorAll('input[name="coupon_id[]"]:checked');
                var selectedIds = [];

                // Lấy tất cả coupon_id đã chọn
                selectedCheckboxes.forEach(function(checkbox) {
                    selectedIds.push(checkbox.value);
                });

                // Kiểm tra nếu có ít nhất một checkbox được chọn
                if (selectedIds.length > 0) {
                    // Thêm các coupon_id đã chọn vào form
                    var form = document.getElementById('deleteForm');
                    form.innerHTML += selectedIds.map(id => `<input type="hidden" name="coupon_id[]" value="${id}">`)
                        .join('');

                    // Gửi form
                    form.submit();
                } else {
                    toastr.error('Vui lòng chọn ít nhất một bài viết để xóa.');
                }
            });
        </script>
        <script>
            $(document).ready(function() {
                // Gắn sự kiện onchange cho select
                $('#itemsPerPage').on('change', function() {
                    // Lấy giá trị của select
                    var itemsPerPage = $(this).val();

                    // Lấy URL hiện tại
                    var url = new URL(window.location.href);

                    // Thêm hoặc cập nhật tham số itemsPerPage trong URL
                    url.searchParams.set('itemsPerPage', itemsPerPage);

                    // Thực hiện điều hướng (reload trang với tham số itemsPerPage mới)
                    window.location.href = url.toString();
                });
            });
        </script>
    @endpush
@endsection
