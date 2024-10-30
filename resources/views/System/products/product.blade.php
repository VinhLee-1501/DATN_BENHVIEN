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
                    {{-- @foreach ($medicine as $data) --}}
                    <tr>
                        <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">{{ $count++ }}</h6>
                        </td>
                        <td class="border-bottom-0" style="width:15%;">
                            <div class="img-container">
                                <img src="{{ asset('backend/assets/images/profile/user-1.jpg') }}"
                                    class="img-fluid img-square" />
                            </div>
                        </td>
                        <td class="border-bottom-0">
                            <p class="mb-0 fw-semibold">tên</p>
                        </td>
                        <td class="border-bottom-0">
                            <p class="mb-0 fw-semibold">
                                {{ Carbon\Carbon::now()->format('d/m/Y') }}</p>
                        </td>
                        <td class="border-bottom-0">
                            {{-- @if ($data->status == 1) --}}
                            <span class="badge bg-success">Hoạt động </span>
                            {{-- @else
                                    <span class="badge bg-danger">Hết</span>
                                @endif --}}
                        </td>
                        <td class="border-bottom-0 d-flex">
                            {{-- <a href="javascript:void(0)" class="btn btn-primary me-1" --}}
                            {{-- onclick="openEditModalMedicine('{{ $data->medicine_id }}')"> --}}
                            <i class="ti ti-pencil"></i>
                            {{-- </a> --}}
                            {{-- <form action="{{ route('system.medicines.delete', $data->medicine_id) }}"
                                    id="form-delete" method="post">
                                    @method('delete')
                                    @csrf
                                </form> --}}
                            <button type="submit" class="btn btn-danger btn-delete"
                                    data-id=""> 
                            <i class="ti ti-trash"></i>
                            </button>
                            <a class="btn btn-warning ms-1" data-bs-toggle="collapse"
                                    href="#collapse" role="button" aria-expanded="false"
                                    aria-controls="collapse">
                                    Chi tiết
                                </a>
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
            </table>
        </div>
    </div>
</div>
