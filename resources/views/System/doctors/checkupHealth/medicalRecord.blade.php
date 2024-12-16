@extends('layouts.admin.master')

@section('content')
    <style>
        .card,
        .table,
        .form-control,
        .form-select {
            padding: 0 rem !important;
            border-radius: 0 !important;

        }

        .card,
        .table,
        .form-control {
            font-size: 0.8rem;
        }

        .card .card-header {
            background-color: #94e4bd37
        }
    </style>

    <div class="container p-0">
        <div class="row">
            <div class="col-md-4 col-lg-3">
                <div class=" w-100">
                    <b class=" py-2 px-3">Thông tin khám bệnh</b>
                    <div class="card-body px-3">
                        <p class="m-1">Bệnh viện VietCare</p>
                        <p class="m-1">Ngày: {{ Carbon\Carbon::parse(now())->format('d/m/Y') }} </p>
                        <p class="m-1">Bác sĩ: <b>{{ $doctor->lastname }} {{ $doctor->firstname }}</b></p>
                        <p class="m-1">Phòng: <b>{{ $content[0]->sclinicName }}</b></p>
                        <p class="m-1">Khoa: <b>{{ $content[0]->specialtyName }}</b></p>
                    </div>
                </div>
                <hr>
                <div class="mt-5 w-100">
                    <b class="py-2 px-3">Thông tin bệnh nhân</b>
                    <div class="card-body px-3">
                        <div class="row">
                            <div class="d-flex m-1">
                                <label for="patient_id">Mã bệnh nhân: </label>
                                <b>{{ $patient->patient_id }}</b>
                            </div>
                            <div class="d-flex m-1">
                                <label for="patient_name">Tên bệnh nhân: </label>
                                <b>{{ $patient->last_name }} {{ $patient->first_name }}</b>
                            </div>
                            <div class="d-flex m-1">
                                <label for="patient_name">Giới tính: </label>
                                <b>{{ $patient->gender == 1 ? 'Nam' : 'Nữ' }}</b>
                            </div>
                            <div class="d-flex m-1">
                                <label for="patient_id">Ngày sinh: </label>
                                <b>{{ Carbon\Carbon::parse($patient->birthday)->format('d/m/Y') }}</b>
                            </div>
                            <div class="d-flex m-1">
                                <label for="patient_name">Địa chỉ: </label>
                                <b>{{ $patient->address }}</b>
                            </div>
                            <div class="d-flex m-1">
                                <label for="patient_id">CCCD/CMND: </label>
                                <b> {{ $patient->cccd }}</b>
                            </div>
                            <div class="d-flex m-1">
                                <label for="patient_name">Số điện thoại: </label>
                                <b> {{ $patient->phone }}</b>
                            </div>
                            <div class="d-flex m-1">
                                <label for="patient_name">Nghề nghiệp: </label>
                                <b> {{ $patient->occupation }}</b>
                            </div>
                            <div class="d-flex m-1">
                                <label for="patient_name">Liên hệ khẩn cấp: </label>
                                <b> {{ $patient->emergency_contact }}</b>
                            </div>
                            <div class="d-flex m-1">
                                <label for="patient_name">Quốc tịch: </label>
                                <b>{{ $patient->national }}</b>
                            </div>
                            <div class="d-flex m-1">
                                <label for="patient_name">Số bảo hiểm: </label>
                                <b> {{ $patient->Insurance_number }}</b>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8 col-lg-9">

                <div class="row">
                    <div class="col-lg-6 col-12">
                        <div class="card w-100">
                            <b class="card-header py-2 px-3">Dịch vụ lâm sàng</b>
                            <div class="card-body px-3">
                                    <table class="table m-0 mb-2" id="selectedTestsTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Tên cận lâm sàng</th>
                                                <th>Thành tiền</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <input type="hidden" id="selectService" name="selectedService" value="">
                                            @if (!isset($services) || empty($services))
                                                <tr>
                                                    <td colspan="3">Không có dịch vụ</td>
                                                </tr>
                                            @else
                                                @php $count = 1; @endphp
                                                @foreach ($services as $data)
                                                    <tr>
                                                        <td>{{ $count++ }}</td>
                                                        <td>{{ $data->name }}</td>
                                                        <td>{{ number_format( $data->price, 0, ',', '.') }} VNĐ</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                    @if ($totalprice == 20)
                                        <span></span>
                                    @else
                                        <span id="totalAmout">Tổng cộng: {{ number_format($totalprice, 0, ',', '.') }} VNĐ</span>
                                        <div class="float-xxl-end">
                                            <a href="{{ route('system.pdfService', $data->treatment_id) }}"
                                                class="btn btn-success btn-sm" type="btn">In Phiếu</a>
                                        </div>
                                    @endif
                              
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-12">
                        <div class="card w-100">
                            <div class="card-header py-2 px-3">
                                <b>Lịch sử bệnh án</b>
                            </div>

                            <div class="card-body px-3" style="overflow-x: auto;">
                                @if (!$patient)
                                    <table class="table m-0 p-0">
                                        <thead>
                                            <tr>
                                                <td>Lịch sử khám trống</td>
                                            </tr>
                                        </thead>
                                    </table>
                                @else
                                    <table class="overflow-scroll m-0 p-0 w-100">
                                        <thead>
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
                                                    <td class="border-bottom-0">
                                                        <a href="{{ route('system.recordDoctors.detail', $data->medical_id) }}"
                                                            class="btn btn-success mb-1 btn-sm">Xem</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <form action="{{ route('system.checkupHealth.store', $medical->medical_id) }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="card w-100">
                                <div class="card-header py-2 px-3 d-flex justify-content-between">
                                    <b>Chuẩn đoán bệnh</b>
                                    {{$medical->medical_id}}
                                    <b>{{ Carbon\Carbon::now()->format('d/m/Y') }}</b>
                                </div>
                                <div class="card-body px-3">
                                    <div class="col mb-2">
                                        <label for="symptoms" class="mb-2">Triệu chứng</label>
                                        <textarea class="form-control @error('symptoms') is-invalid @enderror" id="symptoms" name="symptoms">{{ old('symptoms', $book->symptoms) }}</textarea>
                                        @error('symptoms')
                                            <div class="text-danger">*{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <label for="diaginsis" class="mb-2">Chuẩn đoán</label>
                                        <textarea class="form-control @error('diaginsis') is-invalid @enderror" id="diaginsis" name="diaginsis">{{ old('diaginsis') }}</textarea>
                                        @error('diaginsis')
                                            <div class="text-danger">*{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-12">
                            <div class="card w-100">
                                <b class="card-header py-2 px-3">Chỉ số sinh hiệu</b>
                                <div class="card-body px-3">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                             <label for="blood_pressure" class="ms-2">Huyết áp</label>
                                            <div class="d-flex align-items-center">
                                                <input placeholder="Huyết áp" type="text" class="form-control"
                                                    id="bloodPressure" name="blood_pressure"
                                                    value="{{ $health->blood_pressure ?? '' }}" style="max-width: 120px;">
                                                <p class="mt-3 ms-2">mmHg</p>
                                            </div>
                                            @error('blood_pressure')
                                                <div class="text-danger">*{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                             <label for="respiratory_rate" class="ms-2">Nhịp thở</label>
                                            <div class="d-flex align-items-center">
                                                <input type="text" class="form-control"
                                                    id="respiration" name="respiratory_rate"
                                                    value="{{ $health->respiratory_rate ?? '' }}" style="max-width: 120px;">
                                                <p class="mt-3 ms-2">nhịp/phút</p>
                                            </div>
                                            @error('respiratory_rate')
                                                <div class="text-danger">*{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                             <label for="height" class="ms-2">Chiều cao</label>
                                            <div class="d-flex align-items-center">
                                                <input placeholder="Chiều cao" type="text" class="form-control"
                                                    id="height" name="height" value="{{ $health->height ?? '' }}"
                                                    style="max-width: 120px;">
                                                <p class="mt-3 ms-2">cm</p>
                                            </div>
                                            @error('height')
                                                <div class="text-danger">*{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                             <label for="weight" class="ms-2">Cân nặng</label>
                                            <div class="d-flex align-items-center">
                                                <input placeholder="Cân nặng" type="text" class="form-control"
                                                    id="weight" name="weight" value="{{ $health->weight ?? ''}}"
                                                    style="max-width: 120px;">
                                                <p class="mt-3 ms-2">kg</p>
                                            </div>
                                            @error('weight')
                                                <div class="text-danger">*{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card">
                            <div class="card-header py-2 px-3">
                                <b>Tạo đơn thuốc</b>
                            </div>
                            <div class="card-body px-3">
                                <div class="d-flex flex-wrap align-items-center justify-content-center">
                                    <label for="days" class="form-label fw-bold mt-2 me-2">Ngày uống:</label>
                                    <span id="selectedDay" class="me-3">3 ngày</span>
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

                                <div class="row mt-3">
                                    <div class="col-12 col-md-6 col-lg-4 ms-auto">
                                        <div class="form-group mb-3">
                                            <select id="myAjaxSelect" class="form-select form-select-sm"
                                                name="myAjaxSelect[]" onchange="addSelectedMidicine()">
                                                <option disabled selected>Tìm thuốc</option>
                                                @foreach ($medicine as $item)
                                                    <option value='{{ $item->medicine_id }}'
                                                        data-name='{{ $item->name }}'
                                                        data-unit='{{ $item->unit_of_measurement }}'>
                                                        {{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table" id="tableMedicine">
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


                                <div class="col-md-12 mt-3 p-3">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                        <div class="d-flex flex-wrap align-items-center flex-grow-1">
                                            <label for="reexam" class="mb-2 me-2">Ngày tái khám</label>
                                            <input type="text" id="reexamDateInput"
                                                class="form-control me-2 mb-2 mb-md-0 @error('re_examination_date') is-invalid @enderror"
                                                name="re_examination_date" style="width: 150px;">
                                            @error('re_examination_date')
                                                <div class="text-danger">*{{ $message }}</div>
                                            @enderror
                                            <div class="d-flex align-items-center mt-2 flex-wrap flex-grow-1">
                                                <select id="modeSelect" class="form-select me-3 mb-2" name="advice"
                                                    style="width: 250px;" onchange="toggleCustomInput()">
                                                    <option selected value="">Chọn chế độ</option>
                                                    <option value="Nghỉ ngơi nhiều">Nghỉ ngơi nhiều</option>
                                                    <option value="Chế độ ăn uống">Chế độ ăn uống</option>
                                                    <option value="Vận động nhẹ nhàng">Vận động nhẹ nhàng</option>
                                                    <option value="custom">Khác (Nhập vào)</option>
                                                </select>
                                                <input type="text" id="customInput"
                                                    class="form-control me-2 mb-2 mb-md-0" name="custom_advice"
                                                    placeholder="Nhập chế độ khác" style="display: none;"
                                                    oninput="updateSelectValue()">
                                                <input type="hidden"
                                                    class="form-control @error('advice') is-invalid @enderror"
                                                    id="finalAdvice" name="advice">
                                                @error('advice')
                                                    <div class="text-danger">*{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="d-flex align-items-center mt-2 mt-md-0">
                                                <button type="submit"
                                                    class="btn btn-success me-2 mb-2 mb-md-0">Lưu</button>
                                                <button type="button" class="btn btn-danger mb-2 mb-md-0">Hủy</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if (session('pdf_data'))
        <script>
            window.onload = function() {
                window.location.href = "{{ route('system.downloadPdf') }}"; // Gọi route để tải PD
            };
        </script>
    @endif
@endsection
