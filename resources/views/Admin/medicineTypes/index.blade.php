@extends('layouts.admin.master')

@section('content')
    <div class="card w-100">
        <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-4">Quản lý nhóm thuốc</h5>
            <div class="table-responsive">
                <form action="" class="col-md-12 row">
                    <div class="col-md-4">
                        <a href="{{ route('admin.medicineTypes.create') }}" class="btn btn-success">Thêm</a>
                    </div>
                    <div class="col-md-4">
                        <input type="text" id="myInput" class="form-control" placeholder="Nhập tên thuốc">
                    </div>

                </form>
                <table class="table text-nowrap mb-0 align-middle">
                    <thead class="text-dark fs-4">
                        <tr>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Mã nhóm</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Tên nhóm thuốc</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Ngày thêm</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Trạng thái</h6>
                            </th>
                            </th>
                        </tr>
                    </thead>

                    <tbody  id="myTable">
                        @foreach ($medicineType as $data)
                            <tr>
                                <td class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">{{ $data->medicine_type_id }}</h6>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-semibold">{{ $data->name }}</p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-semibold">{{ Carbon\Carbon::parse($data->created_at)->format('d/m/Y') }}</p>
                                </td>
                                <td class="border-bottom-0">
                                    @if ($data->status == 1)
                                        <span class="badge bg-success"> Hoạt động </span>
                                    @else
                                        <span class="badge bg-danger">Không Hoạt động </span>
                                    @endif
                                </td>
                                <td class="border-bottom-0 d-flex">
                                    <a href="{{ route('admin.medicineTypes.edit', $data->medicine_type_id )}}"class="btn btn-primary me-1"><i class="ti ti-pencil"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection
