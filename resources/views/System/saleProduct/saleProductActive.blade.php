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
</style>
<div class="card w-100">
    <div class="card-body p-4">
        <h5 class="card-title fw-semibold mb-4">Quản lý thuốc</h5>
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
                            <h6 class="fw-semibold mb-0">Trạng thái</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Hành động</h6>
                        </th>
                    </tr>
                </thead>
                @foreach ($saleProductActive as $active)
                    <tbody id="myTable">
                        <tr>
                            <td class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">{{ $active->sale_code }}</h6>
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
                                <span class="badge bg-success">
                                    @if ($active->status == 1)
                                        Hoạt động
                                    @endif
                                </span>
                            </td>
                            <td class="border-bottom-0">
                                <a href="" class="btn btn-primary">
                                    <i class="ti ti-notes"></i>
                                </a>
                                <a href="javascript:void(0)" class="btn btn-primary "
                                    onclick="openModalEdit('{{ $active->sale_id }}')"><i class="ti ti-pencil"></i></a>
                                <form action="{{ route('system.delete', $active->sale_id) }}"
                                    id="form-delete{{ $active->sale_id }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button type="submit" class="btn btn-danger btn-delete" data-id="{{ $active->sale_id }}">
                                    <i class="ti ti-trash"></i>
                                </button>

                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <div class="collapse" id="collapse">
                                    <div class="card card-body ">
                                        <h6 class="fw-semibold mb-2 fs-5">Thông tin chi tiết:</h6>
                                        <div class="col-md-12 d-flex mt-1">
                                            <div class="col-md-6">
                                                <p><strong>Mã thuốc:</strong></p>
                                                <p><strong>Tên thuốc:</strong></p>
                                                <p><strong>Hoạt tính:</strong> </p>
                                                <p><strong>Đơn vị:</strong> </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Nhóm thuốc:</strong> </p>
                                                <p><strong>Ngày thêm thuốc:</strong>

                                                </p>
                                                <p><strong>Ngày cập nhật:</strong>

                                                </p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </td>
                        </tr>
                        {{-- @endforeach --}}
                    </tbody>
                @endforeach

            </table>
        </div>
    </div>
</div>
