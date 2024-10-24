@extends('layouts.admin.master')

@section('content')
    <div class="card w-100">
        <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-4">Quản lý bệnh nhân</h5>
            <div class="table-responsive">
                <form action="" class="col-md-12 row" id="searchForm">
                    <div class="col-md-3">
                        <input type="text" id="nameInput" class="form-control" placeholder="Họ tên">
                    </div>
                    <div class="col-md-3">
                        <input type="text" id="phoneInput" class="form-control" placeholder="Số điện thoại">
                    </div>
                    <div class="col-md-3">
                        <input type="text" id="insuranceInput" class="form-control" placeholder="Số bảo hiểm y tế">
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-primary" id="searchButton">Tìm</button>
                    </div>
                </form>

                <table class="table text-nowrap mb-0 align-middle">
                    <thead class="text-dark fs-4">
                    <tr>
                        <th class="border-bottom-0"><h6 class="fw-semibold mb-0">ID</h6></th>
                        <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Họ tên</h6></th>
                        <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Giới tính</h6></th>
                        <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Ngày Sinh</h6></th>
                        <th class="border-bottom-0"><h6 class="fw-semibold mb-0">BHYT</h6></th>
                        <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Số Điện thoại</h6></th>
                        <th class="border-bottom-0"><h6 class="fw-semibold mb-0">SĐT Khẩn cấp</h6></th>
                        <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Thao tác</h6></th>
                    </tr>
                    </thead>
                    <tbody id="myTable">
                    @foreach($patients as $item)
                        <tr>
                            <td class="border-bottom-0"><h6 class="fw-semibold mb-0">{{ $item->patient_id }}</h6></td>
                            <td class="border-bottom-0"><p
                                    class="mb-0 fw-semibold">{{ $item->last_name }} {{ $item->first_name }}</p></td>
                            <td class="border-bottom-0">
                                <p class="badge {{ $item->gender == 1 ? 'bg-info' : 'bg-danger' }} mb-0 fw-semibold">{{ $item->gender == 1 ? 'Nam' : 'Nữ' }}</p>
                            </td>
                            <td class="border-bottom-0"><p class="mb-0 fw-semibold">{{ $item->birthday }}</p></td>
                            <td class="border-bottom-0"><p class="mb-0 fw-semibold">{{ $item->Insurance_number }}</p>
                            </td>
                            <td class="border-bottom-0"><p class="mb-0 fw-semibold">{{ $item->phone }}</p></td>
                            <td class="border-bottom-0"><p class="mb-0 fw-semibold">{{ $item->emergency_contact }}</p>
                            </td>
                            <td class="border-bottom-0 d-flex">
                                <a href="{{ route('system.patients.edit', $item->patient_id) }}"
                                   class="btn btn-primary"><i class="ti ti-notes"></i></a>
                                <a class="btn btn-warning ms-1" data-bs-toggle="collapse"
                                   href="#collapse{{ $item->patient_id }}" role="button" aria-expanded="false"
                                   aria-controls="collapse{{ $item->patient_id }}">Chi tiết</a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="10">
                                <div class="collapse" id="collapse{{ $item->patient_id }}">
                                    <div class="card card-body">
                                        <div class="col-md-12 d-flex mt-1">
                                            <div class="col-md-2 d-flex align-items-center">
                                                <img src="{{ asset('backend/assets/images/profile/user-1.jpg') }}"
                                                     class="rounded-circle" width="80%">
                                            </div>
                                            <div class="col-md-6">
                                                <h6 class="fw-semibold mb-2 fs-5">Thông tin bệnh nhân:</h6>
                                                <div class="d-flex">
                                                    <div class="col-6">
                                                        <p><strong>Mã bệnh nhân:</strong> {{ $item->patient_id }}</p>
                                                        <p><strong>Số điện thoại:</strong> {{ $item->phone }}</p>
                                                        <p><strong>Họ và
                                                                tên:</strong> {{ $item->last_name . ' ' . $item->first_name }}
                                                        </p>
                                                        <p><strong>Giới
                                                                tính:</strong> {{ $item->gender == 1 ? 'Nam' : 'Nữ' }}
                                                        </p>
                                                        <p><strong>Bảo hiểm y tế:</strong> {{ $item->Insurance_number }}
                                                        </p>
                                                        <p><strong>SĐT Khẩn cấp:</strong>
                                                            0{{ $item->emergency_contact }}</p>
                                                    </div>
                                                    <div class="col-4">
                                                        <p><strong>Ngày
                                                                sinh:</strong> {{ Carbon\Carbon::parse($item->birthday)->format('d/m/Y') }}
                                                        </p>
                                                        <p><strong>Địa chỉ:</strong> {{ $item->address }}</p>
                                                        <p><strong>Tạo
                                                                lúc:</strong> {{ Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}
                                                        </p>
                                                        <p><strong>Cập nhật
                                                                lúc:</strong> {{ Carbon\Carbon::parse($item->updated_at)->format('d/m/Y') }}
                                                        </p>
                                                        <p><strong>Nghề nghiệp:</strong> {{ $item->occupation }}</p>
                                                        <p><strong>Quốc tịch:</strong> {{ $item->national }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <h6 class="fw-semibold mb-0 fs-5">Lịch sử bệnh án:</h6>
                                                <table class="table mt-1">
                                                    <thead>
                                                    <tr>
                                                        <th class="py-0" scope="col">Mã</th>
                                                        <th class="py-0" scope="col">Chuẩn đoán</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(isset($item->medical_id))
                                                        <!-- Kiểm tra nếu có medical_id -->
                                                        <tr>
                                                            <td class="py-2"><strong>{{ $item->medical_id }}</strong>
                                                            </td>
                                                            <td class="py-2"><a
                                                                    href="{{ route('system.detail_medical_record', $item->medical_id) }}"
                                                                    class="">{{ $item->diagnosis }}</a></td>
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td colspan="2">Không có hồ sơ y tế.</td>
                                                        </tr>
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    <div id="noResults" class="alert alert-warning" style="display: none;">Không tìm thấy dữ liệu.</div>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function () {
            $("#phoneInput, #nameInput, #insuranceInput").on("keyup", function () {
                var nameValue = $("#nameInput").val().toLowerCase();
                var phoneValue = $("#phoneInput").val().toLowerCase();
                var insuranceValue = $("#insuranceInput").val().toLowerCase();
                var found = false;

                $("#myTable tr").each(function () {
                    var rowText = $(this).text().toLowerCase();
                    if (rowText.indexOf(nameValue) > -1 && rowText.indexOf(phoneValue) > -1 && rowText.indexOf(insuranceValue) > -1) {
                        $(this).show(); // Hiện hàng nếu tìm thấy
                        found = true; // Đã tìm thấy ít nhất một hàng
                    } else {
                        $(this).hide(); // Ẩn hàng nếu không tìm thấy
                    }
                });

                // Hiển thị hoặc ẩn thông báo không tìm thấy dữ liệu
                if (!found) {
                    $("#noResults").show();
                } else {
                    $("#noResults").hide();
                }
            });
        });
    </script>
@endsection
