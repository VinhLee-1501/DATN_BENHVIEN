@extends('layouts.admin.master')

@section('content')
    <div class="card w-100">
        <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-4">Quản lý bác sĩ</h5>
            <div class="table-responsive">
                <table class="table text-nowrap mb-0 align-middle">
                    <thead class="text-dark fs-4">
                    <tr>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">ID</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Họ tên</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Mã căn cước</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Ngày sinh</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Giới tính</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">SDT</h6>
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
                            <p class="mb-0 fw-semibold">BS. Nguyen Van B</p>
                        </td>
                        <td class="border-bottom-0">
                            <p class="mb-0 fw-semibold">093275686778</p>
                        </td>
                        <td class="border-bottom-0">
                            <p class="mb-0 fw-semibold">04/01/1990</p>
                        </td>
                        <td class="border-bottom-0">
                            <span class="fw-semibold mb-0">Nam</span>
                        </td>
                        <td class="border-bottom-0">
                            <span class="fw-semibold mb-0">+84 87654786</span>
                        </td>
                        <td class="border-bottom-0 d-flex">
                            <button class="btn btn-primary me-1"><i class="ti ti-calendar"></i></button>
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
