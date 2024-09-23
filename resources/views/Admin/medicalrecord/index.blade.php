@extends('layouts.admin.master')

@section('content')
    <div class="card w-100">
        <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-4">Quản lý bệnh án</h5>
            <div class="table-responsive">
                <form action="" class="col-md-12 row">
                    <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="Họ tên">
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="Mã căn cước">
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary">Tìm</button>
                    </div>
                </form>
                <table class="table text-nowrap mb-0 align-middle">
                    <thead class="text-dark fs-4">
                    <tr>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">ID</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Tiêu đề</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Bệnh nhân</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Ngày khám</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Giới tính</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Thao tác</h6>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">1</h6>
                        </td>
                        <td class="border-bottom-0">
                            <p class="mb-0 fw-semibold">Thăm khám 22/08/2024</p>
                        </td>
                        <td class="border-bottom-0">
                            <p class="mb-0 fw-semibold">Nguyen Van A</p>
                        </td>
                        <td class="border-bottom-0">
                            <p class="mb-0 fw-semibold">22/08/2024</p>
                        </td>
                        <td class="border-bottom-0">
                            <span class="fw-semibold mb-0">Nam</span>
                        </td>
                        <td class="border-bottom-0 d-flex">
                            <button class="btn btn-primary me-1"><i class="ti ti-pencil"></i></button>
                            <button class="btn btn-danger"><i class="ti ti-trash"></i></button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
