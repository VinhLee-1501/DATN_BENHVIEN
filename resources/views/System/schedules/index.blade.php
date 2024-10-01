@extends('layouts.admin.master')

@section('content')
    <div class="card w-100">
        <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-4">Quản lý lịch làm việc bác sĩ</h5>
            <div class="table-responsive">
                <form action="" class="col-md-12 row">
                    <div class="col-md-8 d-flex p-4">
                        <a href="{{ route('system.schedules.create') }}" class="btn btn-success me-2">Thêm lịch mới</a>
                    </div>
                    <div class="col-md-4">
                        <input type="text" id="myInput" class="form-control" placeholder="Tìm lịch làm">
                    </div>
                </form>
                <table class="table text-nowrap mb-0 align-middle">
                    <thead class="text-dark fs-4">
                        <tr>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Mã lịch làm</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Tên bác sĩ</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Chuyên khoa</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Ngày khám</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Phòng khám</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Hành động</h6>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="myTable">
                        @foreach ($schedule as $data)
                            <tr>
                                <td class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">{{ $data->shift_id }}</h6>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-semibold">{{ $data->lastname }} {{ $data->firstname }}</p>
                                </td>
                                <td class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">{{ $data->specialty_name }}</h6>
                                </td>

                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-semibold">
                                        {{ Carbon\Carbon::parse($data->day)->format('d/m/Y') }}</p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-semibold">{{ $data->sclinic_name }}</p>
                                </td>
                                </td>
                                <td class="border-bottom-0 d-flex">
                                    <a href="{{ route('system.schedules.edit', $data->shift_id) }}"
                                        class="btn btn-primary me-1">
                                        <i class="ti ti-pencil"></i>
                                    </a>
                                    <form action="{{ route('system.schedules.delete', $data->shift_id) }}"
                                        id="form-delete{{ $data->shift_id }}" method="post">
                                        @method('delete')
                                        @csrf
                                    </form>
                                    <button type="submit" class="btn btn-danger btn-delete"
                                        data-id="{{ $data->shift_id }}">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                    <a class="btn btn-warning ms-1" data-bs-toggle="collapse"
                                        href="#collapse{{ $data->shift_id }}" role="button" aria-expanded="false"
                                        aria-controls="collapse{{ $data->shift_id }}">
                                        Chi tiết
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <div class="collapse" id="collapse{{ $data->shift_id }}">
                                        <div class="card">
                                            <div class="card-body">
                                                <h6 class="fw-bold mb-3 fs-5">Thông tin bác sĩ và phòng khám:</h6>
                                                <div class="row align-items-center">
                                                    <!-- Phần ảnh đại diện -->
                                                    <div class="col-md-4 text-center">
                                                        <img src="{{ $data->avatar ? $data->avatar : asset('backend/assets/images/profile/user-1.jpg') }}"
                                                            alt="Ảnh đại diện bác sĩ" class="img-fluid rounded-circle"
                                                            style="width: 150px; height: 150px; object-fit: cover;">
                                                    </div>
                                                    <div class="col-md-8">
                                                        <ul class="list-unstyled mb-0">
                                                            <li><strong>Tên bác sĩ:</strong> {{ $data->lastname }}
                                                                {{ $data->firstname }}</li>
                                                            <li><strong>Chuyên khoa:</strong> {{ $data->specialty_name }}
                                                            </li>
                                                            <li><strong>Số điện thoại:</strong> {{ $data->phone }}</li>
                                                            <li><strong>Phòng khám:</strong> {{ $data->sclinic_name }}</li>
                                                            <li><strong>Ngày khám:</strong>
                                                                {{ Carbon\Carbon::parse($data->day)->format('d/m/Y') }}
                                                            </li>
                                                        </ul>
                                                    </div>
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
