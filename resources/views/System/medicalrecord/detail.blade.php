@extends('layouts.admin.master')

@section('content')
    <div class="card w-100">
        <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-4 text-center text-primary">Bệnh án - {{ $medical[0]->last_name }}
                {{ $medical[0]->first_name }}</h5>

            <div class="row">
                <div class="col-md-3 text-center">
                    <img src="{{ asset('backend/assets/images/profile/user-1.jpg') }}" class="img-thumbnail rounded-circle"
                        alt="...">
                    <h6 class="fw-bold mt-2 text-primary">{{ $medical[0]->last_name }} {{ $medical[0]->first_name }}</h6>
                    <hr>
                    <h6 class="fw-bold">Thông tin</h6>
                    <div><i class="ti ti-phone"></i> <strong>Điện thoại:</strong> {{ $medical[0]->phone }}</div>
                    <div><i class="ti ti-calendar"></i> <strong>Ngày sinh:</strong>
                        {{ \Carbon\Carbon::parse($medical[0]->birthday)->format('d-m-Y') }}</div>
                    <div><i class="ti ti-map-pin"></i> <strong>Địa chỉ:</strong> {{ $medical[0]->address }}</div>
                </div>
                <div class="col-md-9">
                    <form>
                        <h6 class="fw-semibold mb-4">I. Hành chính</h6>
                        <div class="row mb-3">
                            <div class="col-md-6"><label class="form-label">Tiêu đề:</label>
                                <p class="border p-2 rounded bg-light">Thăm khám
                                    {{ \Carbon\Carbon::parse($medical[0]->date)->format('d-m-Y') }}</p>
                            </div>
                            <div class="col-md-6"><label class="form-label">Họ và tên:</label>
                                <p class="border p-2 rounded bg-light">{{ $medical[0]->last_name }}
                                    {{ $medical[0]->first_name }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6"><label class="form-label">Ngày sinh:</label>
                                <p class="border p-2 rounded bg-light">
                                    {{ \Carbon\Carbon::parse($medical[0]->birthday)->format('d-m-Y') }}</p>
                            </div>
                            <div class="col-md-6"><label class="form-label">Địa chỉ:</label>
                                <p class="border p-2 rounded bg-light">{{ $medical[0]->address }}</p>
                            </div>
                            <div class="col-md-12"><label class="form-label">Bác sĩ phụ trách:</label>
                                <p class="border p-2 rounded bg-light">{{ $medical[0]->lastname }}
                                    {{ $medical[0]->firstname }}</p>
                            </div>
                        </div>

                        <h6 class="fw-semibold mb-4 mt-3">II. Thông tin vào</h6>
                        <div class="row mb-3">
                            <div class="col-md-6"><label class="form-label">Ngày khám:</label>
                                <p class="border p-2 rounded bg-light">
                                    {{ \Carbon\Carbon::parse($medical[0]->date)->format('d-m-Y') }}</p>
                            </div>
                            <div class="col-md-6"><label class="form-label">Triệu chứng:</label>
                                <p class="border p-2 rounded bg-light">{{ $medical[0]->symptom }}</p>
                            </div>
                        </div>

                        <h6 class="fw-semibold mb-4 mt-3">III. Thông tin ra</h6>
                        <div class="row mb-3">
                            <div class="col-md-6"><label class="form-label">Chuẩn đoán:</label>
                                <p class="border p-2 rounded bg-light">{{ $medical[0]->diaginsis }}</p>
                            </div>
                            <div class="col-md-6"><label class="form-label">Ngày tái khám:</label>
                                <p class="border p-2 rounded bg-light">
                                    {{ \Carbon\Carbon::parse($medical[0]->re_examination_date)->format('d-m-Y') }}</p>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Dịch vụ:</label>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tên cận lâm sàng</th>
                                            <th>Thành tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <input type="hidden" id="selectService" name="selectedService" value="">
                                        @foreach ($services as $index => $data)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $data->name }}</td>
                                                <td>{{ Number::format($data->price) }}VND</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end">
                                <strong id="totalAmout">
                                    Tổng cộng:
                                    @isset($totalprice->total_price)
                                        {{ Number::format($totalprice->total_price) }}VND
                                    @endisset
                                </strong>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Đơn thuốc:</label>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Tên thuốc</th>
                                            <th>Liều dùng</th>
                                            <th>Số lượng</th>
                                            <th>Cách dùng</th>
                                            <th>Lúc uống</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($medicines as $index => $data)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $data->name }}</td>
                                                <td>{{ $data->dosage }}</td>
                                                <td>{{ $data->quantity }}</td>
                                                <td>{{ $data->usage }}</td>
                                                <td>{{ $data->note }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
