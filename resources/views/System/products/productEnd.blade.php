<div class="card w-100">
    <div class="card-body p-4">
        <h5 class="card-title fw-semibold mb-4">Sản phẩm không hoạt động</h5>
        <div class="table-responsive">
            <div class="mt-3">
                {!! $productEnd->links() !!}

            </div>
            <table class="table table-bordered text-nowrap mb-0 align-middle">
                <thead class="text-dark fs-4">
                    <tr class="text-center">
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">#</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Ảnh</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Tên sản phẩm</h6>
                        </th>
                        <th class="border-bottom-0 text-end">
                            <h6 class="fw-semibold mb-0">Giá tiền</h6>
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
                    @if($productEnd->isEmpty())
                    <div id="noResults" class="alert alert-warning">Không tìm thấy dữ liệu.</div>
                    @else
                    @php
                    $count = 1;
                    @endphp
                    @foreach ($productEnd->items() as $data)

                    <tr class="align-baseline text-center">
                        <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-0"> {{ $count++ }}</h6>
                        </td>
                        <td class="border-bottom-0">
                            @php
                            $imgArray = explode(',', $data->img_array); // Split the comma-separated string into an array
                            @endphp

                            @if (!empty($imgArray) && is_array($imgArray) && count($imgArray) > 0)
                            <img src="{{ asset('storage/uploads/products/' . $imgArray[0]) }}"
                                class="img-fluid img-square" />
                            @else
                            <img src="{{ asset('backend/assets/images/products/img-notfound.jpg') }}"
                                class="img-fluid img-square-detail" alt="Product Image" />
                            @endif
                        </td>
                        <td class="border-bottom-0">
                            <p class="mb-0 fw-semibold">{{ \Illuminate\Support\Str::limit($data->name, 40) }}</p>
                        </td>

                        <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">{{ number_format($data->price, 0, ',', '.') }}đ</h6>
                        </td>
                        <td class="border-bottom-0">
                            <p class="mb-0 fw-semibold">
                                {{ Carbon\Carbon::parse($data->create_at)->format('d/m/Y') }}
                            </p>
                        </td>
                        <td class="border-bottom-0">
                            @if ($data->status == 1)
                            <span class="badge bg-success">Hoạt động </span>
                            @else
                            <span class="badge bg-danger">Hết</span>
                            @endif
                        </td>
                        <td class="border-bottom-0 d-flex justify-content-center align-items-center" colspan="5">
                            <a href="javascript:void(0)" class="btn btn-primary me-1"
                                onclick="openUpdateModal('{{ $data->product_id }}')">
                                <i class="ti ti-pencil"></i>
                            </a>
                            <form action="{{ route('system.product.delete', $data->product_id) }}"
                                id="form-delete{{ $data->product_id }}" method="post">
                                @method('delete')
                                @csrf
                            </form>
                            <button type="submit" class="btn btn-danger btn-delete" data-id="{{ $data->product_id }}">
                                <i class="ti ti-trash"></i>
                            </button>
                            <a class="btn btn-warning ms-1" data-bs-toggle="collapse"
                                href="#collapse{{ $data->product_id }}" role="button" aria-expanded="false"
                                aria-controls="collapse{{ $data->product_id }}">
                                Chi tiết
                            </a>
                        </td>
                    </tr>
                    <tr id="show">
                        <td colspan="10">
                            <div class="collapse" id="collapse{{ $data->product_id }}">
                                <div class="card shadow-sm mt-2">
                                    <h4 class="fw-semibold">Thông tin chi tiết:</h4>

                                    <div class="card-body">


                                        <div class="row g-2">
                                            <div class="col-6 col-md-7">
                                                <p class="text-wrap"><strong>Mã sản phẩm:</strong>
                                                    {{ $data->code_product }}

                                                    @if(isset($barcodeEnd[$data->product_id]))
                                                    {!! $barcodeEnd[$data->product_id] !!}

                                                    @else
                                                    <span>Không có mã vạch</span>
                                                    @endif

                                                </p>
                                                <p class="text-wrap"><strong>Tên sản phẩm:</strong> {{ $data->name }}
                                                </p>
                                                <p class="text-wrap"><strong>Đơn vị:</strong>
                                                    {{ $data->unit_of_measurement }}
                                                </p>
                                                <p class="text-wrap"><strong>Hoạt tính:</strong>
                                                    {{ $data->active_ingredient }}
                                                </p>
                                                <p class="text-wrap"><strong>Công dụng:</strong> {{ $data->used }}</p>
                                            </div>
                                            <div class="col-6 col-md-5 ">
                                                <div class="d-flex text-wrap">
                                                    <p><strong>Giá gốc:</strong> {{ $data->price }}</p>
                                                    <p class="ms-2"><strong>Giá giảm:</strong> {{ $data->price }}</p>
                                                </div>
                                                <p class="text-wrap"><strong>Thương hiệu:</strong> {{ $data->brand }}
                                                </p>
                                                <p class="text-wrap"><strong>Hạn sử dụng:</strong>
                                                    {{ $data->manufacture }}
                                                </p>
                                                <p class="text-wrap"><strong>Số:</strong>
                                                    {{ $data->registration_number }}
                                                </p>
                                                <p class="text-wrap"><strong>Nhóm sản phẩm:</strong>
                                                    {{ $data->nameCategory }}
                                                </p>
                                                <p class="text-wrap"><strong>Ngày thêm sản phẩm:</strong>
                                                    {{ Carbon\Carbon::parse($data->created_at)->format('H:i d/m/Y ') }}
                                                </p>
                                                <p class="text-wrap"><strong>Ngày cập nhật:</strong>
                                                    {{ Carbon\Carbon::parse($data->updated_at)->format('H:i d/m/Y ') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>

            </table>
            <div class="mt-3">
                {!! $productEnd->links() !!}

            </div>
        </div>
    </div>
</div>