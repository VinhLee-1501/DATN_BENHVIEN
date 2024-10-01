@extends('layouts.admin.master')

@section('content')
    <div class="card w-100">
        <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-4">Quản lý thuốc</h5>
            <div class="table-responsive">
                <form action="" class="col-md-12 row">
                    <div class="col-md-8 d-flex p-4">
                        <a href="{{ route('system.medicines.create') }}" class="btn btn-success me-2">Thêm thuốc</a>
                        <a href="{{ route('system.medicines.end') }}" class="btn btn-danger me-2">Thuốc hết</a>
                        <a href="{{ route('system.medicine') }}" class="btn btn-primary">Thuốc hoạt động</a>
                    </div>
                    <div class="col-md-4">
                        <input type="text" id="myInput" class="form-control" placeholder="Nhập tên thuốc">
                    </div>

                </form>
                <table class="table text-nowrap mb-0 align-middle">
                    <thead class="text-dark fs-4">
                        <tr>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Mã thuốc</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Tên thuốc</h6>
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
                    <tbody  id="myTable">
                        @foreach ($medicine as $data)
                            <tr>
                                <td class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">{{ $data->medicine_id }}</h6>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-semibold">{{ $data->name }}</p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-semibold">
                                        {{ Carbon\Carbon::parse($data->created_at)->format('d/m/Y') }}</p>
                                </td>
                                <td class="border-bottom-0">
                                    @if ($data->status == 1)
                                    <span class="badge bg-success">Hoạt động </span>
                                @else
                                    <span class="badge bg-danger">Hết</span>
                                @endif
                                </td>
                                <td class="border-bottom-0 d-flex">
                                    <a href="{{ route('system.medicines.edit', $data->medicine_id) }}"
                                        class="btn btn-primary me-1">
                                        <i class="ti ti-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.medicines.delete', $data->medicine_id) }}"
                                        id="form-delete{{ $data->medicine_id }}" method="post">
                                      @method('delete')
                                      @csrf
                                  </form>
                                  <button type="submit" class="btn btn-danger btn-delete" data-id="{{$data->medicine_id }}">
                                      <i class="ti ti-trash"></i>
                                  </button>
                                    <a class="btn btn-warning ms-1" data-bs-toggle="collapse"
                                        href="#collapse{{ $data->medicine_id }}" role="button" aria-expanded="false"
                                        aria-controls="collapse{{ $data->medicine_id }}">
                                        Chi tiết
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <div class="collapse" id="collapse{{ $data->medicine_id }}">
                                        <div class="card card-body ">
                                            <h6 class="fw-semibold mb-2 fs-5">Thông tin chi tiết:</h6>
                                            <div class="col-md-12 d-flex mt-1">
                                                <div class="col-md-6">
                                                    <p><strong>Mã thuốc:</strong> {{ $data->medicine_id }}</p>
                                                    <p><strong>Tên thuốc:</strong> {{ $data->name }}</p>
                                                    <p><strong>Hoạt tính:</strong> {{ $data->active_ingredient }}</p>
                                                    <p><strong>Đơn vị:</strong> {{ $data->unit_of_measurement }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                <p><strong>Nhóm thuốc:</strong> {{$data->medicine_types_name }}</p>
                                                <p><strong>Ngày thêm thuốc:</strong> {{ Carbon\Carbon::parse($data->created_at)->format('H:i d/m/Y ') }}</p>
                                                <p><strong>Ngày cập nhật:</strong> {{ Carbon\Carbon::parse($data->updated_at)->format(' H:i d/m/Y ') }}</p>
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
@endsection
