@extends('layouts.admin.master')

@section('content')
    <div class="card w-100">
        <div class="card-body p-4">
            <div class="col-md-12 d-flex justify-content-around align-items-center">
                <div class="col-md-5">
                    <h5 class="card-title fw-semibold mb-4">Quản lý bệnh án</h5>
                </div>
                <div class="col-md-6 d-flex justify-content-end">
                    <form action="" class="col-md-12 row">
                        <div class="col-md-4">
                            <input type="text" id="nameInput" class="form-control" placeholder="Họ tên" name="name">
                        </div>
                        <div class="col-md-4">
                            <input type="text" id="phoneInput" class="form-control" placeholder="SDT" name="phone">
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary">Tìm</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="table-responsive">

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
                    <tbody id="myTable">
                    @foreach($medicalRecord as $item)
                        <tr>
                            <td class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">{{ $item->medical_id }}</h6>
                            </td>
                            <td class="border-bottom-0">
                                <p class="mb-0 fw-semibold">{{ $item->diaginsis }}</p>
                            </td>
                            <td class="border-bottom-0">
                                <p class="mb-0 fw-semibold">{{ $item->patientForeignKey->last_name
                                                                .$item->patientForeignKey->first_name }}</p>
                                <p class="mb-0 fw-semibold" hidden>{{ $item->patientForeignKey->phone }}</p>
                            </td>
                            <td class="border-bottom-0">
                                <p class="mb-0 fw-semibold">{{ $item->date }}</p>
                            </td>
                            <td class="border-bottom-0">
                                <span class="fw-semibold mb-0">
                                    @if($item->gender == 1)
                                        <span class="badge bg-success">Nam</span>
                                    @else
                                        <span class="badge bg-danger">Nữ</span>
                                    @endif
                                </span>
                            </td>
                            <td class="border-bottom-0 d-flex">
                                <a href="{{ route('system.detail_medical_record', $item->medical_id) }}" class="btn btn-primary"><i class="ti ti-notes"></i></a>
                                <form action="{{ route('system.delete_medical_record', $item->medical_id) }}"
                                      id="form-delete{{ $item->medical_id }}" method="post">
                                    @method('delete')
                                    @csrf
                                </form>
                                <button type="submit" class="btn btn-danger btn-delete ms-1" data-id="{{ $item->medical_id }}">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $("#phoneInput, #nameInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
@endsection
