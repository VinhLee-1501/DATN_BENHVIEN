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
                    <b class=" py-2 px-3">Thông tin khám bệnh (Trực tuyến)</b>
                    <div class="card-body px-3">
                        <p class="m-1">Bệnh viện VietCare</p>
                        <p class="m-1">Ngày: {{ Carbon\Carbon::parse(now())->format('d/m/Y') }} </p>
                        <p class="m-1">Bác sĩ: <b>{{ $doctor->lastname }} {{ $doctor->firstname }}</b></p>
                        <p class="m-1">Phòng: <b>{{ $content[0]->sclinicName }}</b></p>
                        <p class="m-1">Khoa: <b>{{ $content[0]->specialtyName }}</b></p>
                    </div>
                </div>

                <div class="mt-5 w-100">
                    <b class="py-2 px-3">Thông tin bệnh nhân</b>
                    <div class="card-body px-3">
                        @if (!$patient)
                            <form action="{{ route('system.Online.savePatient', $book->book_id) }}" method="post">
                                @csrf
                                <div class=" mb-2">
                                    <div class="col-12 mb-2 mt-2">
                                        <label for="patient_id">Mã bệnh nhân</label>
                                        <input type="text" class="form-control" id="patient_id" name="patient_id"
                                            value="{{ strtoupper(Str::random(10)) }}">
                                    </div>
                                    <div class="col-12  mb-2">
                                        <label for="patient_name">Họ</label>
                                        <input type="text" class="form-control" id="patient_name" name="last_name"
                                            value="{{ old('last_name') }}">
                                    </div>
                                    <div class="col-12 mb-2">
                                        <label for="patient_name">Tên</label>
                                        <input type="text" class="form-control" id="patient_name" name="first_name"
                                            value="{{ $book->name }}">
                                    </div>
                                    <div class="col-12 mb-2">
                                        <label for="gender">Giới tính</label>
                                        <select class="form-select" id="gender" name="gender">
                                            <option value="1">Nam</option>
                                            <option value="0">Nữ</option>
                                        </select>
                                    </div>
                                    <div class="col-12 mb-2 ">
                                        <label for="age">Ngày sinh</label>
                                        <input type="date" class="form-control" id="age" name="age"
                                            value="{{ old('age') }}">
                                        @error('age')
                                            <div class="text-danger">*{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12 mb-2 ">
                                        <label for="age">CCCD/CMND</label>
                                        <input type="text" class="form-control" id="cccd" name="cccd"
                                            value="{{ old('cccd') }}">
                                        @error('cccd')
                                            <div class="text-danger">*{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12 mb-2">
                                        <label for="address">Địa chỉ</label>
                                        <input type="text" class="form-control @error('address') is-invalid @enderror"
                                            id="address" name="address" value="{{ old('address') }}">
                                        @error('address')
                                            <div class="text-danger">*{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12 mb-2">
                                        <label for="phone">Số điện thoại</label>
                                        <input type="text" class="form-control" id="phone" name="phone"
                                            value="{{ $book->phone }}" readonly>
                                        @error('phone')
                                            <div class="text-danger">*{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12 mb-2">
                                        <label for="occupation">Nghề nghiệp</label>
                                        <input type="text" class="form-control @error('occupation') is-invalid @enderror"
                                            id="occupation" name="occupation" value="{{ old('occupation') }}">
                                        @error('occupation')
                                            <div class="text-danger">*{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12 mb-2">
                                        <label for="emergency_contact">Liên hệ khẩn cấp</label>
                                        <input type="text"
                                            class="form-control @error('emergency_contact') is-invalid @enderror"
                                            id="emergency_contact" name="emergency_contact"
                                            value="{{ old('emergency_contact') }}">
                                        @error('emergency_contact')
                                            <div class="text-danger">*{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12 mb-2">
                                        <label for="national">Quốc tịch</label>
                                        <input type="text" class="form-control @error('national') is-invalid @enderror"
                                            id="national" name="national" value="{{ old('national') }}">
                                        @error('national')
                                            <div class="text-danger">*{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 text-end mt-2">
                                        <button type="submit" class="btn btn-success btn-sm">Lưu bệnh nhân</button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <div class="row">
                                <div class="d-flex m-1">
                                    <label for="patient_id">Mã bệnh nhân: </label>
                                    <b>{{ $user['patient']->patient_id }}</b>
                                </div>
                                <div class="d-flex m-1">
                                    <label for="patient_name">Tên bệnh nhân: </label>
                                    <b>{{ $user['patient']->last_name }} {{ $user['patient']->first_name }}</b>
                                </div>
                                <div class="d-flex m-1">
                                    <label for="patient_name">Giới tính: </label>
                                    <b>{{ $user['patient']->gender == 1 ? 'Nam' : 'Nữ' }}</b>
                                </div>
                                <div class="d-flex m-1">
                                    <label for="patient_id">Ngày sinh: </label>
                                    <b>{{ Carbon\Carbon::parse($user['patient']->birthday)->format('d/m/Y') }}</b>
                                </div>
                                <div class="d-flex m-1">
                                    <label for="patient_id">CCCD/CMND: </label>
                                    <b> {{ $user['patient']->cccd }}</b>
                                </div>
                                <div class="d-flex m-1">
                                    <label for="patient_name">Địa chỉ: </label>
                                    <b>{{ $user['patient']->address }}</b>
                                </div>

                                <div class="d-flex m-1">
                                    <label for="patient_name">Số điện thoại: </label>
                                    <b> {{ $user['patient']->phone }}</b>
                                </div>
                                <div class="d-flex m-1">
                                    <label for="patient_name">Nghề nghiệp: </label>
                                    <b> {{ $user['patient']->occupation }}</b>
                                </div>
                                <div class="d-flex m-1">
                                    <label for="patient_name">Liên hệ khẩn cấp: </label>
                                    <b> {{ $user['patient']->emergency_contact }}</b>
                                </div>
                                <div class="d-flex m-1">
                                    <label for="patient_name">Quốc tịch: </label>
                                    <b>{{ $user['patient']->national }}</b>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-8 col-lg-9">
                <form action="{{ route('system.Online.store', $book->book_id) }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class=" card w-100">
                                <div class="card-header py-2 px-3 d-flex justify-content-between">

                                    <b>Chuẩn đoán bệnh</b>
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
                        <div class="col-md-6">
                            <div class=" card w-100">
                                <div class="card-header py-2 px-3">

                                    <b>Lịch sử bệnh án</b>

                                </div>

                                <div class="card-body px-3">
                                    @if (!$patient)
                                        <table class="table m-0 p-0">
                                            <thead>
                                                <tr>
                                                    <td>Lịch sử khám trống</td>
                                                </tr>
                                            </thead>
                                        </table>
                                    @else
                                        <table class="table  m-0 p-0">
                                            <thead>
                                                <tr>
                                                    <th>Ngày khám</th>
                                                    <th>Chẩn đoán</th>
                                                    <th>Bác sĩ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($user['medicalRecord'] as $data)
                                                    <tr>
                                                        <td class="border-bottom-0">
                                                            {{ Carbon\Carbon::parse($data->date)->format('d/m/Y') }}</td>
                                                        <td class="border-bottom-0">{{ $data->diaginsis }}</td>
                                                        <td class="border-bottom-0">{{ $data->lastname }}
                                                            {{ $data->firstname }}
                                                        </td>
                                                        <td class="border-bottom-0"><a
                                                                href="{{ route('system.recordDoctors.detail', $data->medical_id) }}"
                                                                class="btn btn-success btn-sm">Xem</a></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
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


                                    <div class="col-12 mt-3 p-3">
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
                                                    <button type="submit" class="btn btn-success me-2 mb-2 mb-md-0">Lưu</button>
                                                    <button type="submit"
                                                        class="btn btn-danger mb-2 mb-md-0">Hủy</button>
                                                </div>
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

@endsection
