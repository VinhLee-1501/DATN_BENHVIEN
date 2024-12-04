@extends('layouts.admin.master')

@section('content')
<div class="card w-100">
    <div class="card-body p-4">
        <h5 class="card-title fw-semibold mb-4">Quản lý bệnh án</h5>

        <form action="{{ route('system.medicalRecord') }}" method="GET" class="row g-2 justify-content-center align-items-center">
            <div class="row g-2 justify-content-center align-items-center col-md-5">
                <div class="col-md-6 col-sm-6">

                    <input type="text" id="medicalIdInput" class="form-control" placeholder="Mã bệnh án"
                        name="medical_id" value="{{ request('medical_id') }}">

                </div>

                <div class="col-md-6 col-sm-6">

                    <input type="text" id="diaginsisInput" class="form-control" placeholder="Tiêu đề bệnh án"
                        name="diaginsis" value="{{ request('diaginsis') }}">

                </div>
            </div>
            <div class="row g-2 justify-content-center align-items-center col-md-5">
                <div class="col-md-6 col-sm-6">

                    <input type="text" id="firstnameInput" class="form-control" placeholder="Họ bệnh nhân"
                        name="lastname" value="{{ request('lastname') }}">

                </div>

                <div class="col-md-6 col-sm-6">

                    <input type="text" id="lastnameInput" class="form-control" placeholder="Tên bệnh nhân"
                        name="firstname" value="{{ request('firstname') }}">

                </div>
            </div>

            <div class="col-md-2 col-sm-12">
                <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
            </div>
        </form>



        <div class="table-responsive">
            <div class="mt-3">
                {!! $medicalRecord->links() !!}

            </div>
            <table class="table table-bordered text-nowrap mb-0 align-middle">
                <thead class="text-dark fs-4  ">
                    <tr class="text-center">
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
                <tbody id="myTable">
                    @if($medicalRecord->isEmpty())
                    <tr>
                        <div id="noResults" class="alert alert-warning">Không tìm thấy dữ liệu.</div>
                    </tr>
                    @else


                    @foreach ($medicalRecord as $item)
                    <tr class="text-center">
                        <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">{{ $item->medical_id }}</h6>
                        </td>
                        <td class="border-bottom-0">
                            <p class="mb-0 fw-semibold">{{ $item->diaginsis }}</p>
                        </td>
                        <td class="border-bottom-0">
                            <p class="mb-0 fw-semibold">
                                {{ $item->patientForeignKey->last_name . ' ' . $item->patientForeignKey->first_name }}
                            </p>
                            <p class="mb-0 fw-semibold" hidden>{{ $item->patientForeignKey->phone }}</p>
                        </td>
                        <td class="border-bottom-0">
                            <p class="mb-0 fw-semibold">{{ $item->date }}</p>
                        </td>
                        <td class="border-bottom-0">
                            <span class="fw-semibold mb-0">
                                @if ($item->gender == 1)
                                <span class="badge bg-success">Nam</span>
                                @else
                                <span class="badge bg-danger">Nữ</span>
                                @endif
                            </span>
                        </td>
                        <td class="border-bottom-0 d-flex justify-content-center align-items-center">
                            <a href="{{ route('system.detail_medical_record', $item->medical_id) }}"
                                class="btn btn-primary"><i class="ti ti-notes"></i></a>
                            <form action="{{ route('system.delete_medical_record', $item->medical_id) }}"
                                id="form-delete{{ $item->medical_id }}" method="post">
                                @method('delete')
                                @csrf
                            </form>
                            <button type="submit" class="btn btn-danger btn-delete ms-1"
                                data-id="{{ $item->medical_id }}">
                                <i class="ti ti-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            <div class="mt-3">
                {!! $medicalRecord->links() !!}
            </div>
        </div>
    </div>
</div>

@endsection