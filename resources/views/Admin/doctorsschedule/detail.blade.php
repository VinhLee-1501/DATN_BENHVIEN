@extends('layouts.admin.master')

@section('content')
    <div class="card w-100">
        <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-4">Lịch làm bác sĩ Nguyen Van B</h5>
            <div class="table-responsive">
                <table class="table text-nowrap mb-0 align-middle">
                    <thead class="text-dark fs-4">
                    <tr>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Ngày làm</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Thao tác</h6>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">24/08/2024</h6>
                        </td>
                        <td class="border-bottom-0 d-flex">
                            <button class="btn btn-primary"><i class="ti ti-pencil"></i></button>
                            {{-- <button class="btn btn-danger"><i class="ti ti-trash"></i></button> --}}
                        </td>
                    </tr>
                    <tr>
                        <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">25/08/2024</h6>
                        </td>
                        <td class="border-bottom-0 d-flex">
                            <button class="btn btn-primary"><i class="ti ti-pencil"></i></button>
                            {{-- <button class="btn btn-danger"><i class="ti ti-trash"></i></button> --}}
                        </td>
                    </tr>
                    <tr>
                        <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">27/08/2024</h6>
                        </td>
                        <td class="border-bottom-0 d-flex">
                            <button class="btn btn-primary"><i class="ti ti-pencil"></i></button>
                            {{-- <button class="btn btn-danger"><i class="ti ti-trash"></i></button> --}}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
