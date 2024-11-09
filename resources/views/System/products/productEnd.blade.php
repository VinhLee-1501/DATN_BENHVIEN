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
<div class="card w-100">
    <div class="card-body p-4">
        <h5 class="card-title fw-semibold mb-4">Quản lý sản phẩm</h5>
        <div class="table-responsive">
            <table class="table text-nowrap mb-0 align-middle">
                <thead class="text-dark fs-4">
                    <tr>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">#</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Ảnh</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Tên sản phẩm</h6>
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
                    @foreach ($productEnd as $data)
                        <tr class="align-baseline">
                            <td class="border-bottom-0">
                                <h6 class="fw-semibold mb-0"> {{ $count++ }}</h6>
                            </td>
                            <td class="border-bottom-0" style="width:15%;">
                                <div class="img-container">
                                    @if (!$data->img)
                                        <img src="{{ asset('storage/uploads/products/' . $data->img_array[0]) }}"
                                            class="img-fluid img-square" />
                                    @else
                                        <img src="{{ asset('backend/assets/images/products/img-notfound.jpg') }}"
                                            class="img-fluid img-square-detail" alt="Product Image" />
                                    @endif
                                </div>
                            </td>
                            <td class="border-bottom-0">
                                <p class="mb-0 fw-semibold">{{ $data->name }}</p>
                            </td>
                            <td class="border-bottom-0">
                                <p class="mb-0 fw-semibold">
                                    {{ Carbon\Carbon::parse($data->create_at)->format('d/m/Y') }}</p>
                            </td>
                            <td class="border-bottom-0">
                                @if ($data->status == 1)
                                    <span class="badge bg-success">Hoạt động </span>
                                @else
                                    <span class="badge bg-danger">Hết</span>
                                @endif
                            </td>
                            </td>
                            <td class="border-bottom-0 d-flex " colspan="5">
                                <a href="javascript:void(0)" class="btn btn-primary me-1"
                                    onclick="openUpdateModal('{{ $data->product_id }}')">
                                    <i class="ti ti-pencil"></i>
                                </a>
                                <form action="{{ route('system.product.delete', $data->product_id) }}" id="form-delete"
                                    method="post">
                                    @method('delete')
                                    @csrf
                                </form>
                                <button type="submit" class="btn btn-danger btn-delete" data-id="">
                                    <i class="ti ti-trash"></i>
                                </button>
                                <a class="btn btn-warning ms-1" data-bs-toggle="collapse"
                                    href="#collapse{{ $data->product_id }}" role="button" aria-expanded="false"
                                    aria-controls="collapse{{ $data->product_id }}">
                                    Chi tiết
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <div class="collapse p-4" id="collapse{{ $data->product_id }}">
                                    <h6 class="fw-semibold mb-2 fs-5">Thông tin chi tiết:</h6>
                                    <div class="row mt-1">
                                        <div class="col-md-5">
                                            <div id="productImageCarousel{{ $data->product_id }}"
                                                class="carousel slide img-container-detail mt-3"
                                                data-bs-ride="carousel">
                                                <div class="carousel-inner">
                                                    @foreach ($data->img_array as $index => $img)
                                                        <!-- Đổi $data thành $img -->
                                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                            <img src="{{ asset('storage/uploads/products/' . $img) }}"
                                                                class="d-block w-100 img-fluid"
                                                                style="height: 150px; object-fit: cover;" />
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <button class="carousel-control-prev" type="button"
                                                    data-bs-target="#productImageCarousel{{ $data->product_id }}"
                                                    data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Previous</span>
                                                </button>
                                                <button class="carousel-control-next" type="button"
                                                    data-bs-target="#productImageCarousel{{ $data->product_id }}"
                                                    data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Next</span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-7 d-flex">
                                            <div class="col-md-7 p-2">
                                                <p><strong>Mã sản phẩm:</strong> {{ $data->code_product }}
                                                    {!! $barcodeEnd[$data->product_id] !!}</p>
                                                <p><strong>Tên sản phẩm:</strong> {{ $data->name }}</p>
                                                <p><strong>Đơn vị:</strong> {{ $data->unit_of_measurement }}</p>
                                                <p><strong>Hoạt tính:</strong> {{ $data->actice_ingredient }}</p>
                                                <p><strong>Công dụng:</strong> {{ $data->used }}</p>
                                            </div>
                                            <div class="col-md-5 p-2">
                                                <div class="d-flex">
                                                    <p><strong>Giá gốc:</strong> {{ $data->price }}</p>
                                                    <p class="ms-2"><strong>Giá giảm:</strong> {{ $data->price }}
                                                    </p>
                                                </div>
                                                <p><strong>Thương hiệu:</strong> {{ $data->brand }}</p>
                                                <p><strong>Hạn sự dụng:</strong> {{ $data->manufacture }}</p>
                                                <p><strong>Số:</strong> {{ $data->registration_number }}</p>
                                                <p><strong>Nhóm sản phẩm:</strong> {{ $data->nameCategory }}</p>
                                                <p><strong>Ngày thêm sản phẩm:</strong>
                                                    {{ Carbon\Carbon::parse($data->created_at)->format('H:i d/m/Y ') }}
                                                </p>
                                                <p><strong>Ngày cập nhật:</strong>
                                                    {{ Carbon\Carbon::parse($data->updated_at)->format(' H:i d/m/Y ') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
