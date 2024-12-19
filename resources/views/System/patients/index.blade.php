@extends('layouts.admin.master')

@section('content')
    <div class="card w-100">
        <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-4">Quản lý bệnh nhân</h5>

            <form action="{{ route('system.patient') }}" method="GET" class="row g-3 mb-4">

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="row g-2">
                        <div class="col-6">
                            <input type="text" name="lastname" class="form-control" placeholder="Họ"
                                value="{{ request('lastname') }}">
                        </div>
                        <div class="col-6">
                            <input type="text" name="firstname" class="form-control" placeholder="Tên"
                                value="{{ request('firstname') }}">
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="row g-2">
                        <div class="col-sm-6 col-md-6">
                            <select name="gender" class="form-select ">
                                <option value="" {{ request('gender') == '' ? 'selected' : '' }}>---Giới tính---
                                </option>

                                <option value="0" {{ request('gender') == '0' ? 'selected' : '' }}>Nữ</option>
                                <option value="1" {{ request('gender') == '1' ? 'selected' : '' }}>Nam</option>
                            </select>
                        </div>


                        <div class="col-sm-6 col-md-6">
                            <input type="text" name="phone" class="form-control" placeholder="Số điện thoại"
                                value="{{ request('phone') }}">
                        </div>

                    </div>
                </div>

                <div class="col-12 col-md-12 col-lg-4 row justify-content-between g-2">
                    <div class="col-12 col-md-6">
                        <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
                    </div>
                    <div class="col-12 col-md-6 ">
                        <a class="btn btn-success w-100" href="{{ route('system.patients.create') }}">
                            Thêm bệnh nhân
                        </a>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered text-nowrap mb-0 align-middle ">
                    <thead class="text-dark fs-4">
                        <tr class="text-center">
                            <th class="border-bottom-0">
                                <p class="fw-semibold mb-0">ID</p>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Họ tên</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Giới tính</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Ngày Sinh</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">CCCD</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Số Điện thoại</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">SĐT Khẩn cấp</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Thao tác</h6>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="myTable">
                        @if ($patients->isEmpty())
                            <div id="noResults" class="alert alert-warning">Không tìm thấy dữ liệu.</div>
                        @else
                            @foreach ($patients as $item)
                                <tr class="text-center">
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">{{ $item->patient_id }}</h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="mb-0 fw-semibold">{{ $item->last_name }} {{ $item->first_name }}</p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p
                                            class="badge {{ $item->gender == 1 ? 'bg-info' : 'bg-danger' }} mb-0 fw-semibold">
                                            {{ $item->gender == 1 ? 'Nam' : 'Nữ' }}
                                        </p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="mb-0 fw-semibold">
                                            {{ \Carbon\Carbon::parse($item->birthday)->format('d/m/Y') }}
                                        </p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="mb-0 fw-semibold">{{ $item->cccd }}</p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="mb-0 fw-semibold">{{ $item->phone }}</p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="mb-0 fw-semibold">{{ $item->emergency_contact }}</p>
                                    </td>
                                    <td class="border-bottom-0 d-flex justify-content-center align-items-center">
                                        <a href="{{ route('system.patients.edit', $item->patient_id) }}"
                                            class="btn btn-primary"> <i class="ti ti-pencil"></i></a>
                                        <a class="btn btn-warning ms-1" data-bs-toggle="collapse"
                                            href="#collapse{{ $item->patient_id }}" role="button" aria-expanded="false"
                                            aria-controls="collapse{{ $item->patient_id }}">Chi tiết</a>
                                        <a href="javascript:void(0)" class="btn btn-success ms-1"
                                            onclick="openAddModal('{{ $item->patient_id }}')"><i
                                                class="ti ti-notes"></i></a>
                                        {{-- {{ route('system.patients.addMedical', $item->patient_id) }} --}}
                                    </td>
                                </tr>
                                <tr id="show">
                                    <td colspan="100">
                                        <div class="collapse" id="collapse{{ $item->patient_id }}">
                                            <div class="card-body">
                                                <div class="col-md-12 row mb-3">
                                                    <div class="col-2 profile-img col-md-2 d-flex align-items-center">
                                                        <!-- Hiển thị ảnh bệnh nhân -->
                                                        @if (empty($item->avatar))
                                                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png"
                                                                alt="Ảnh bác sĩ" class="img-thumbnail"
                                                                style="width: 80%; height: auto;">
                                                        @else
                                                            <img src="{{ asset('storage/uploads/avatars/' . $item->avatar) }}"
                                                                alt="Ảnh bác sĩ" class="img-thumbnail"
                                                                style="width: 80%; height: auto;">
                                                        @endif
                                                    </div>
                                                    <div class="col-5 col-md-5 mb-3">
                                                        <h6 class="fw-semibold mb-0 fs-5 mb-3">Thông tin bệnh nhân</h6>

                                                        <!-- Thông tin bệnh nhân -->
                                                        <p><strong>Ngày sinh:</strong>
                                                            {{ Carbon\Carbon::parse($item->birthday)->format('d/m/Y') }}
                                                        </p>
                                                        <p><strong>Địa chỉ:</strong> {{ $item->address }}</p>
                                                        <p><strong>Tạo lúc:</strong>
                                                            {{ Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}
                                                        </p>
                                                        <p><strong>Cập nhật lúc:</strong>
                                                            {{ Carbon\Carbon::parse($item->updated_at)->format('d/m/Y') }}
                                                        </p>
                                                        <p><strong>Nghề nghiệp:</strong> {{ $item->occupation }}</p>
                                                        <p><strong>Quốc tịch:</strong> {{ $item->national }}</p>
                                                    </div>
                                                    <div class="col-5 col-md-5 mb-3">
                                                        <!-- Chỉ hiển thị nếu có lịch sử bệnh án -->
                                                        <h6 class="fw-semibold mb-0 fs-5 mb-3">Hồ sơ khám bệnh:</h6>
                                                        <table class="table table-bordered mt-1">
                                                            <thead>
                                                                <tr class="text-center">
                                                                    <th class="py-0" scope="col">Mã</th>
                                                                    <th class="py-0" scope="col">Chuẩn đoán</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                @if ($item->medicalRecords->isNotEmpty())
                                                                    @foreach ($item->medicalRecords as $record)
                                                                        <tr class="text-center">
                                                                            <td class="py-1">
                                                                                <strong>{{ $record->medical_id }}</strong>
                                                                            </td>
                                                                            <td class="py-1">
                                                                                <a
                                                                                    href="{{ route('system.detail_medical_record', $record->medical_id) }}">
                                                                                    {{ $record->diaginsis }}
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @else
                                                                    <tr class="text-center">
                                                                        <td class="py-1" colspan="2">Không có hồ sơ y
                                                                            tế.</td>
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
                    </tbody>
                </table>
                <div class="mt-3">
                    {!! $patients->links() !!}
                </div>
                @endif
            </div>

        </div>
    </div>


    <div class="modal fade" id="addMedical" tabindex="-1" aria-labelledby="addMedicalModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMedicalModalLabel">Tạo hồ sơ khám bệnh</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addMedicalForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <input type="hidden" name="patient_id" id="patient_id">
                            <div class="col-md-6">
                                <label for="name_up" class="form-label">Tên bệnh nhân</label>
                                <input type="text" class="form-control" name="name" id="name" value=""
                                    readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="specialty_id" class="form-label">Ngày</label>
                                <input type="date" id="day" class="form-control" name="day"
                                    value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" readonly>
                                <div class="invalid-feedback" id="day_error"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="name_up" class="form-label">Số điện thoại</label>
                                <input type="text" class="form-control" name="phone" id="phone" value=""
                                    readonly>
                            </div>

                            <div class="col-md-6">
                                <label for="blood_pressure" class="form-label">Huyết áp</label>
                                <input name="blood_pressure" class="form-control" id="blood_pressure">
                                <div class="invalid-feedback" id="blood_pressure_error"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="specialty_id" class="form-label">Chuyên Khoa</label>
                                <select class="form-select" name="specialty_id" id="specialty_id">
                                    <option value="">Chọn chuyên khoa</option>
                                    <!-- Các tùy chọn sẽ được thêm vào bằng AJAX -->
                                </select>
                                <div class="invalid-feedback" id="specialty_id_error"></div>
                            </div>

                            <div class="col-md-6">
                                <label for="respiratory_rate" class="form-label">Nhịp tim/phút</label>
                                <input type="text" name="respiratory_rate" class="form-control"
                                    id="respiratory_rate">
                                <div class="invalid-feedback" id="respiratory_rate_error"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="doctor" class="form-label">Bác sĩ</label>
                                <select class="form-select" name="shift_id" id="shift_id">
                                    <option value="">Chọn bác sĩ</option>
                                    <!-- Các tùy chọn sẽ được thêm vào bằng AJAX -->
                                </select>
                                <div class="invalid-feedback" id="shift_id_error"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="price" class="form-label">Chiều cao/cm</label>
                                <input type="text" class="form-control" name="height" id="height">
                                <div class="invalid-feedback" id="height_error"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="symptoms" class="form-label">Triệu chứng</label>
                                <input type="text" class="form-control" name="symptoms" id="symptoms">
                                <div class="invalid-feedback" id="symptoms_error"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="weight" class="form-label">Cân nặng/kg</label>
                                <input type="text" class="form-control" name="weight" id="weight">
                                <div class="invalid-feedback" id="weight_error"></div>
                            </div>
                        </div>
                        
                        <div class="modal-footer justify-content-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary" id="addMedicaltBtn">Tạo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script>
        $(document).ready(function() {
            $("#phoneInput, #nameInput, #insuranceInput").on("keyup", function() {
                var nameValue = $("#nameInput").val().toLowerCase();
                var phoneValue = $("#phoneInput").val().toLowerCase();
                var insuranceValue = $("#insuranceInput").val().toLowerCase();
                var found = false;

                $("#myTable tr").each(function() {
                    var rowText = $(this).text().toLowerCase();
                    if (rowText.indexOf(nameValue) > -1 && rowText.indexOf(phoneValue) > -1 &&
                        rowText.indexOf(insuranceValue) > -1) {
                        $(this).show();
                        found = true;
                    } else {
                        $(this).hide();
                    }
                });

                if (!found) {
                    $("#noResults").show();
                } else {
                    $("#noResults").hide();
                }
            });
        });

        function openAddModal(id) {
            console.log("Modal mở với patient_id:", id); // Thêm console log để kiểm tra
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: `/system/patients/addMedical/` + id,
                type: 'GET',
                success: function(response) {
                    console.log("Dữ liệu trả về:", response); // Kiểm tra dữ liệu trả về
                    $('#name').val(response.patient.last_name + ' ' + response.patient.first_name);
                    $('#phone').val(response.patient.phone);
                    $('#patient_id').val(response.patient.patient_id);

                    var specialtySelect = $('#specialty_id');
                    specialtySelect.empty();
                    specialtySelect.append('<option value="">Chọn chuyên khoa</option>');

                    response.specialty.forEach(function(item) {
                        specialtySelect.append('<option value="' + item.specialty_id + '">' + item
                            .name + '</option>');
                    });

                    specialtySelect.on('change', function() {
                        var specialtyId = $(this).val();

                        if (specialtyId) {
                            $.ajax({
                                url: '/system/patients/getDoctor/' + specialtyId,
                                type: 'GET',
                                success: function(response) {
                                    var shiftSelect = $('#shift_id');
                                    shiftSelect.empty();
                                    shiftSelect.append(
                                        '<option value="">Chọn bác sĩ</option>');

                                    response.schedule.forEach(function(item) {
                                        shiftSelect.append('<option value="' + item
                                            .shift_id + '">' + 'Bs.' + item
                                            .lastname + ' ' + item.firstname +
                                            '</option>');
                                    });

                                    shiftSelect.trigger('change');
                                },
                                error: function(err) {
                                    console.error("Lỗi khi lấy bác sĩ:", err);
                                }
                            });
                        } else {
                            var shiftSelect = $('#shift_id');
                            shiftSelect.empty();
                            shiftSelect.append('<option value="">Chọn bác sĩ</option>');
                            shiftSelect.trigger('change');
                        }
                    });

                    $('#addMedical').modal('show');
                },
                error: function(err) {
                    if (err.responseJSON) {
                        console.log("Chi tiết lỗi từ server:", err.responseJSON);
                    } else {
                        alert("Có lỗi xảy ra, vui lòng kiểm tra console.");
                    }
                }
            });
        }


        $('#addMedicalForm').on('submit', function(e) {
            e.preventDefault();

            console.log('bấm');
            var formData = new FormData();

            // Lấy giá trị và append vào formData
            formData.append('specialty_id', $('#specialty_id').val());
            formData.append('shift_id', $('#shift_id').val());
            formData.append('patient_id', $('#patient_id').val());
            formData.append('name', $('#name').val());
            formData.append('phone', $('#phone').val());
            formData.append('day', $('#day').val());
            formData.append('weight', $('#weight').val());
            formData.append('height', $('#height').val());
            formData.append('symptoms', $('#symptoms').val());
            formData.append('respiratory_rate', $('#respiratory_rate').val());
            formData.append('blood_pressure', $('#blood_pressure').val());

            $.ajax({
                url: '/system/patients/saveMedical', // Đảm bảo đường dẫn này chính xác
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    // console.log(response); // Kiểm tra phản hồi từ server
                    if (response.success) {
                        toastr.success(response.message); // Hiển thị thông báo thành công
                        $('#addMedical').modal('hide'); // Đóng modal
                        location.reload(); // Tải lại trang
                    } else {
                        toastr.error(response.message); // Hiển thị thông báo lỗi
                    }
                },
                error: function(err) {
                    console.error("Lỗi khi thêm:", err);

                    // Kiểm tra nếu có lỗi trả về từ server
                    if (err.responseJSON && err.responseJSON.errors) {
                        var errors = err.responseJSON.errors;

                        $('.invalid-feedback').text(''); // Xóa lỗi cũ
                        $('.form-control').removeClass('is-invalid'); // Xóa class lỗi cũ

                        // Hiển thị lỗi mới
                        $.each(errors, function(key, value) {
                            $('#' + key).addClass('is-invalid'); // Thêm class lỗi
                            $('#' + key + '_error').text(value[
                                0]); // Hiển thị thông báo lỗi cho trường cụ thể
                        });
                    } else {
                        // Nếu không có thông tin lỗi chi tiết, hiển thị cảnh báo chung
                        alert('Có lỗi xảy ra, vui lòng kiểm tra console.');
                    }
                }
            });
        });
    </script>

@endsection
