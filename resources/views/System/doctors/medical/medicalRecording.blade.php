=@extends('layouts.admin.master')

@section('content')
    <style>
        .card,
        .table,
        .form-control,
        .form-select {
            padding: 0.4rem;
            /* Giảm padding */
            border-radius: 0;
            /* Bo góc vuông */
        }

        .card,
        .table,
        .form-control {
            font-size: 0.9rem;
        }

        .card-header {}
    </style>
    <div class="container my-4">
        <div class="card mb-3">
            <div class="card-header">Thông tin bệnh nhân</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <label for="patient_id">Mã bệnh nhân</label>
                        <input type="text" class="form-control" id="patient_id" name="patient_id"
                            value="{{ $patient->patient_id }}" readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="patient_name">Họ</label>
                        <input type="text" class="form-control" id="patient_name" name="patient_name"
                            value="{{ $patient->last_name }}" readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="patient_name">Tên</label>
                        <input type="text" class="form-control" id="patient_name" name="patient_name"
                            value="{{ $patient->first_name }}" readonly>
                    </div>
                    <div class="col-md-2">
                        <label for="gender">Giới tính</label>
                        <select class="form-select" id="gender" name="gender" disabled>
                            <option value="1" {{ $patient->gender == 1 ? 'selected' : '' }}>Nam
                            </option>
                            <option value="0" {{ $patient->gender == 0 ? 'selected' : '' }}>Nữ
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="age">Ngày sinh</label>
                        <input type="text" class="form-control" id="age" name="age"
                            value="{{ Carbon\Carbon::parse($patient->birthday)->format('d/m/Y') }}">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="address">Địa chỉ</label>
                        <input type="text" class="form-control" id="address" name="address"
                            value="{{ $patient->address }}" readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="phone">Số điện thoại</label>
                        <input type="text" class="form-control" id="phone" name="phone"
                            value="{{ $patient->phone }}" readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="occupation">Nghề nghiệp</label>
                        <input type="text" class="form-control @error('occupation') is-invalid @enderror" id="occupation"
                            name="occupation" value="{{ $patient->occupation }}">
                        @error('occupation')
                            <div class="text-danger">*{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-3">
                        <label for="emergency_contact">Liên hệ khẩn cấp</label>
                        <input type="text" class="form-control @error('emergency_contact') is-invalid @enderror"
                            id="emergency_contact" name="emergency_contact" value="{{ $patient->emergency_contact }}">
                        @error('emergency_contact')
                            <div class="text-danger">*{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="national">Quốc tịch</label>
                        <input type="text" class="form-control @error('national') is-invalid @enderror" id="national"
                            name="national" value="{{ $patient->national }}">
                        @error('national')
                            <div class="text-danger">*{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="insurance_number">Số bảo hiểm</label>
                        <input type="text" class="form-control @error('insurance_number') is-invalid @enderror"
                            id="insurance_number" name="insurance_number" value="{{ $patient->Insurance_number }}">
                        @error('insurance_number')
                            <div class="text-danger">*{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <form action="{{ route('system.checkupHealth.store', $medical->medical_id) }}" method="post">
            @csrf
            <div class="d-flex col-md-12">
                <!-- Clinical Tests -->
                <div class="card mb-3 col-md-6">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        Dịch vụ cận lâm sàng
                        <div class="row">
                            <select id="serviceSelect" class="form-control" onchange="addSelectedTest()">
                                <option value="">Chọn dịch vụ cận lâm sàng</option>
                                @foreach ($service as $item)
                                    <option value="{{ $item->service_id }}" data-name="{{ $item->name }}"
                                        data-price="{{ $item->price }}">
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id="selectedTestsTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tên cận lâm sàng</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <input type="hidden" id="selectService" name="selectedService" value="">
                                @php  $count =  1;  @endphp
                                @foreach ($services as $data)
                                    @php  $int = $count++ @endphp
                                    <tr>
                                        <td>{{ $int }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td>{{ $data->price }}.000 VNĐ</td>
                                @endforeach
                            </tbody>
                        </table>
                        <span id="totalAmout">Tổng cộng: {{ $totalprice[0]->total_price }}.000 VNĐ</span>
                        <div class="float-xxl-end">
                            <a href="{{ route('system.pdfService', $data->treatment_id) }}"
                                class="btn btn-success btn-sm" type="btn">In Phiếu</a>
                        </div>
                    </div>
                </div>

                <div class="card mb-3 ms-2 col-md-6">
                    <div class="card-header">Chỉ số sinh hiệu</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <label for="blood_pressure">Huyết áp</label>
                                <div class="d-flex">
                                    <input type="text"
                                        class="form-control m-lg-6 p-0 w-25 @error('blood_pressure') is-invalid @enderror"
                                        id="bloodPressure" name="blood_pressure" value="{{ old('blood_pressure') }}">
                                    <p class="mt-3">mmHg</p>
                                </div>
                                @error('blood_pressure')
                                    <div class="text-danger">*{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="respiratory_rate">Nhịp thở</label>
                                <div class="d-flex">
                                    <input type="text"
                                        class="form-control m-lg-6 p-0 w-25 @error('respiratory_rate') is-invalid @enderror"
                                        id="respiration" name="respiratory_rate" value="{{ old('respiratory_rate') }}">
                                    <p class="mt-3">nhịp/phút</p>
                                </div>
                                @error('respiratory_rate')
                                    <div class="text-danger">*{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <label for="height">Chiều cao</label>
                                <div class="d-flex">
                                    <input type="text"
                                        class="form-control m-lg-6 p-0 w-25 @error('height') is-invalid @enderror"
                                        id="height" name="height" value="{{ old('height') }}">
                                    <p class="mt-3">cm</p>
                                </div>
                                @error('height')
                                    <div class="text-danger">*{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="weight">Cân nặng</label>
                                <div class="d-flex">
                                    <input type="text"
                                        class="form-control m-lg-6 p-0 w-25 @error('weight') is-invalid @enderror"
                                        id="weight" name="weight" value="{{ old('weight') }}">
                                    <p class="mt-3">kg</p>
                                </div>
                                @error('weight')
                                    <div class="text-danger">*{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex col-md-12">
                <!-- New Diagnosis Section (Bảng chẩn đoán bệnh) -->
                <div class="card mb-3 me-2 col-md-6">
                    <div class="card-header row">Chẩn đoán bệnh:<p class="col-md-4 row">
                            {{ Carbon\Carbon::now()->format('d/m/Y') }} </p>
                    </div>
                    <div class="card-body">
                        <div class="col mb-2">
                            <label for="symptoms">Triệu chứng</label>
                            <textarea class="form-control @error('symptoms') is-invalid @enderror" id="symptoms" name="symptoms">{{ old('symptoms', $medical->symptom) }}</textarea>
                            @error('symptoms')
                                <div class="text-danger">*{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col">
                            <label for="diaginsis">Chuẩn đoán</label>
                            <textarea class="form-control @error('diaginsis') is-invalid @enderror" id="diaginsis" name="diaginsis">{{ old('diagnosis') }}</textarea>
                            @error('diaginsis')
                                <div class="text-danger">*{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- Patient History -->
                @if (!$patient)
                    <div class="card mb-3 me-2 col-md-6">
                        <div class="card-header">Lịch sử bệnh</div>
                        <div class="card-body">
                            <table class="table text-nowrap mb-0 align-middle">
                                <thead class="text-dark fs-4">

                                    <td>Lịch sử khám trống</td>

                            </table>
                        </div>
                    </div>
                @else
                    <div class="card mb-3 me-2 col-md-6">
                        <div class="card-header">Lịch sử bệnh</div>
                        <div class="card-body">
                            <table class="table text-nowrap mb-0 align-middle">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th>Ngày khám</th>
                                        <th>Chẩn đoán</th>
                                        <th>Bác sĩ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($medical_patient as $data)
                                        <tr>
                                            <td class="border-bottom-0">
                                                {{ Carbon\Carbon::parse($data->date)->format('d/m/Y') }}</td>
                                            <td class="border-bottom-0">{{ $data->diaginsis }}</td>
                                            <td class="border-bottom-0">{{ $data->lastname }}
                                                {{ $data->firstname }}</td>
                                            <td class="border-bottom-0"><a
                                                    href="{{ route('system.recordDoctors.detail', $data->medical_id) }}"
                                                    class="btn btn-success btn-sm">Xem</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

            </div>

            <!-- Prescription Section -->
            <div class="card mb-3">
                <div class="card-header row col-md-12 justify-content-around align-items-center">
                    <div class="col-md-4">Chỉ định dùng thuốc: {{ Carbon\Carbon::now()->format('d/m/Y') }}</div>
                    <div class="mb-3 col-md-8 d-flex mt-3">
                        <label for="days" class="form-label fw-bold mt-2">Ngày uống: </label>
                        <div class="d-flex align-items-center">
                            <span class="me-2" id="selectedDay">3 ngày</span>
                            <!-- Days Selection -->
                            <div class="btn-group" role="group" aria-label="Select days">
                                <input type="radio" class="btn-check" name="days" id="btnradio1"
                                    autocomplete="off" value="3" checked>
                                <label class="btn btn-outline-primary rounded-0" for="btnradio1"
                                    onclick="updateSelectedDay(3)">3</label>

                                <input type="radio" class="btn-check" name="days" id="btnradio2"
                                    autocomplete="off" value="5">
                                <label class="btn btn-outline-primary" for="btnradio2"
                                    onclick="updateSelectedDay(5)">5</label>

                                <input type="radio" class="btn-check" name="days" id="btnradio3"
                                    autocomplete="off" value="7">
                                <label class="btn btn-outline-primary" for="btnradio3"
                                    onclick="updateSelectedDay(7)">7</label>

                                <input type="radio" class="btn-check" name="days" id="btnradio4"
                                    autocomplete="off" value="10">
                                <label class="btn btn-outline-primary" for="btnradio4"
                                    onclick="updateSelectedDay(10)">10</label>

                                <input type="radio" class="btn-check" name="days" id="btnradio5"
                                    autocomplete="off" value="14">
                                <label class="btn btn-outline-primary" for="btnradio5"
                                    onclick="updateSelectedDay(14)">14</label>

                                <input type="radio" class="btn-check" name="days" id="btnradio6"
                                    autocomplete="off" value="15">
                                <label class="btn btn-outline-primary rounded-0" for="btnradio6"
                                    onclick="updateSelectedDay(15)">15</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group p-3 col-md-6">
                        <select id="myAjaxSelect" class="form-control mb-6 myAjaxSelect" name="myAjaxSelect[]"
                            onchange="addSelectedMidicine()">
                            <option disable>Tìm thuốc</option>
                            @foreach ($medicine as $item)
                                <option value='{{ $item->medicine_id }}' data-name='{{ $item->name }}'
                                    data-unit='{{ $item->unit_of_measurement }}'>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <table class="table table-bordered" id="tableMedicine">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tên thuốc</th>
                                <th>DVT</th>
                                <th style="width:15%">Ngày uống</th>
                                <th>Lúc</th>
                                <th>SL</th>
                                <th>Cách dùng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <input type="hidden" id="selectedMedicines" name="selectedMedicines">
                        </tbody>
                    </table>
                </div>
            </div>

    </div>

    <div class="card mt-3">
        <div class="align-items-center card-body d-flex justify-content-between overflow-x-auto" >
            <div class="d-flex">
                <span class="badge bg-danger me-2">CLS</span>
                <span class="me-3" id="total_service">{{ $totalprice[0]->total_price }}.000</span>
                <span class="badge bg-success me-2">PK</span>
                <span class="me-3" id="cost">30.000</span>
                <span class="badge bg-danger me-2">TC</span>
                @php $total = $totalprice[0]->total_price + 30  @endphp
                <span class="me-3" id="total_fullcost"> {{ $total }}.000 VNĐ</span>
            </div>

            <div class="d-flex" style="overflow-x: auto !important;">
                <label for="reexam" class="me-3">Ngày tái khám</label>
                <input type="text" id="reexamDateInput"
                    class="form-control me-2 @error('re_examination_date') is-invalid @enderror"
                    name="re_examination_date" style="width: 150px;">
                @error('re_examination_date')
                    <div class="text-danger">*{{ $message }}</div>
                @enderror
                <div class="d-flex align-items-center">
                    <select id="modeSelect" class="form-select me-3" name="advice" style="width: 250px;"
                        onchange="toggleCustomInput()">
                        <option selected value="">Chọn chế độ</option>
                        <option value="Nghỉ ngơi nhiều">Nghỉ ngơi nhiều</option>
                        <option value="Chế độ ăn uống">Chế độ ăn uống</option>
                        <option value="Vận động nhẹ nhàng">Vận động nhẹ nhàng</option>
                        <option value="custom">Khác (Nhập vào)</option>
                    </select>
                    <input type="text" id="customInput" class="form-control me-2" name="custom_advice"
                        placeholder="Nhập chế độ khác" style="display: none;" oninput="updateSelectValue()">
                    <input type="hidden" class="form-control @error('advice') is-invalid @enderror" id="finalAdvice"
                        name="advice">
                    @error('advice')
                        <div class="text-danger">*{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success me-2">Lưu</button>
                <a type="" class="btn btn-danger">Hủy</a>
            </div>
        </div>
    </div>
    </form>

    @if (session('pdf_data'))
        <script>
            window.onload = function() {
                window.location.href = "{{ route('system.downloadPdf') }}"; // Gọi route để tải PD
            };
        </script>
    @endif


@endsection
