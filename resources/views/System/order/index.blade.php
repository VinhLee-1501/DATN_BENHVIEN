@extends('layouts.admin.master')

@section('content')
    <div class="card w-100">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center m-1 mb-4">
                <a href="{{ route('system.order.resetsearch') }}" class="card-title">
                    <h3>Quản lý hóa đơn</h3>
                </a>
            </div>

            <div class="nav nav-tabs mb-2" id="nav-tab" role="tablist">
                <a class="nav-link {{ request()->routeIs('system.order') ? 'active' : '' }}" id="nav-home-tab"
                    href="{{ route('system.order') }}">
                    Chưa thanh toán
                </a>
                <a class="nav-link {{ request()->routeIs('system.orders.complete') ? 'active' : '' }}" id="nav-profile-tab"
                    href="{{ route('system.orders.complete') }}">
                    Đã thanh toán
                </a>
            </div>

            <div class="table">
                @if (isset($orders))
                    <form id="searchForm" action="{{ route('system.order') }}" class="d-flex position-relative"method="get">
                    @else
                        <form id="searchForm" action="{{ route('system.orders.complete') }}"
                            class="d-flex position-relative"method="get">
                @endif
                <input type="text" name="search" id="searchInput" class="form-control  ms-3"
                    value="{{ request('search', $search) }}" placeholder="Nhập mã hóa đơn"
                    style="border-top-right-radius: 0; border-bottom-right-radius: 0; width:214px;">
                <button type="submit" class="btn btn-success position-absolute px-0"
                    style="top: 50%; right: 75%; transform: translateY(-50%); z-index: 1; border-top-left-radius: 0; border-bottom-left-radius: 0;">
                    <i class="ti ti-search"></i>
                </button>
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
                <table class="table text-nowrap mb-0 align-middle">
                    <thead class="text-dark fs-4">
                        <tr>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Mã hóa đơn</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Họ tên bệnh nhân</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Ngày xuất bản</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Hình thức</h6>
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
                        @if (isset($orders))
                            @if ($orders->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <h5 class="text-muted">Không tìm thấy kết quả nào</h5>
                                    </td>
                                </tr>
                            @else
                                @foreach ($orders as $data)
                                    <tr>
                                        <form action="{{ route('system.order.updatestatus', $data->row_id) }}"
                                            method="post">
                                            @csrf
                                            @method('PATCH')
                                            <td class="border-bottom-0">
                                                <p class="fw-semibold mb-0">{{ $data->order_id }}</p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-semibold">{{ $data->last_name }} {{ $data->first_name }}
                                                </p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-semibold">
                                                    {{ Carbon\Carbon::parse($data->created_at)->format('d/m/Y') }}</p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <select class="form-select" name="payment" style="width: auto;">
                                                    <option value="0">Thanh toán tiền mặt</option>
                                                    <option value="1">Thanh toán online</option>
                                                </select>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="badge bg-danger mb-0 fw-semibold">Chưa thanh toán</p>
                                            </td>
                                            <td class="border-bottom-0 d-flex">
                                                <a href="{{ route('system.order.print', $data->row_id) }}"
                                                    class="btn btn-primary me-1"target="_blank">
                                                    <i class="ti ti-printer"></i>
                                                </a>
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="ti ti-check"></i>
                                                </button>
                                                
                                            </td>
                                        </form>
                                    </tr>
                                @endforeach
                            @endif
                        @else
                            @if ($ordersun->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <h5 class="text-muted">Không tìm thấy kết quả nào</h5>
                                    </td>
                                </tr>
                            @else
                                @foreach ($ordersun as $data)
                                    <tr>
                                        <form action="{{ route('system.order.updatestatus', $data->row_id) }}"
                                            method="post">
                                            @csrf
                                            @method('PATCH')
                                            <td class="border-bottom-0">
                                                <p class="fw-semibold mb-0">{{ $data->order_id }}</p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-semibold">{{ $data->last_name }} {{ $data->first_name }}
                                                </p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-semibold">
                                                    {{ Carbon\Carbon::parse($data->created_at)->format('d/m/Y') }}</p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <select class="form-select" name="payment" style="width: auto;">
                                                    <option value="0">Thanh toán tiền mặt</option>
                                                    <option value="1">Thanh toán online</option>
                                                </select>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="badge bg-danger mb-0 fw-semibold">Chưa thanh toán</p>
                                            </td>
                                            <td class="border-bottom-0 d-flex">
                                                {{-- <a href="{{ route('system.order.print', $data->row_id) }}"
                                                    class="btn btn-primary me-1"target="_blank">
                                                    <i class="ti ti-printer"></i>
                                                </a>
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="ti ti-check"></i>
                                                </button> --}}
                                                <a href="{{ route('system.order.edit', $data->order_id) }}" class="btn btn-primary me-1">
                                                    <i class="ti ti-article"></i>
                                                </a>
                                            </td>
                                        </form>
                                    </tr>
                                @endforeach
                            @endif
                        @endif
                    </tbody>
                </table>
                <form action="{{ route('system.order.checkout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-primary me-1">
                        Thanh toán
                    </button>
                </form>
                <div class="mt-3 d-flex justify-content-center">
                    @if (isset($orders))
                        {{ $orders->links() }}
                    @else
                        {{ $ordersun->links() }}
                    @endif
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
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
