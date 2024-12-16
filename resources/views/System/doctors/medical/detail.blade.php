@extends('layouts.admin.master')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4 text-center">Bệnh án - {{ $medical[0]->last_name }}
                {{ $medical[0]->first_name }}</h5>
            <div class="col-md-12 row">
                <div class="col-md-3">
                    <div class="header-info justify-content-around input-group">
                        <img src="{{ asset('backend/assets/images/profile/user-1.jpg') }}"
                            class="img-thumbnail rounded-circle w-75" alt="...">
                        <span class="text-center fs-6 fw-bold">
                            {{ $medical[0]->last_name }}
                            {{ $medical[0]->first_name }}
                        </span>
                    </div>
                    <hr class="w-50 m-auto">
                    <div class="footer-info mt-3 text-center">
                        <h6 class="fw-bold">Thông tin</h6>
                        <div class="info">
                            <div class="phone">
                                <span>
                                    <i class="ti ti-phone"></i>
                                </span>{{ $medical[0]->phone }}
                            </div>
                            <div class="birthday">
                                <span>
                                    <i class="ti ti-calendar"></i>
                                </span> {{ \Carbon\Carbon::parse($medical[0]->birthday)->format('d-m-Y') }}
                            </div>
                            <div class="address">
                                <span>
                                    <i class="ti ti-map-pin"></i>
                                </span> {{ $medical[0]->address }}
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-9">
                    <form>
                        <h6 class="fw-semibold mb-4">I. Hành chính</h6>
                        <div class="table-responsive ms-3">
                            <div class="col-md-12 row">
                                <div class="col-md-6">
                                    <div class="mb-3 d-flex">
                                        <label class="form-label">Tiêu đề: </label>
                                        <p>Thăm khám {{ \Carbon\Carbon::parse($medical[0]->date)->format('d-m-Y') }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3 d-flex">
                                        <label class="form-label">Họ và tên: </label>
                                        <p>{{ $medical[0]->last_name }} {{ $medical[0]->first_name }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 row">
                                <div class="col-md-6">
                                    <div class="mb-3 d-flex">
                                        <label class="form-label">Ngày sinh: </label>
                                        <p>{{ \Carbon\Carbon::parse($medical[0]->birthday)->format('d-m-Y') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3 d-flex">
                                        <label class="form-label">Địa chỉ: </label>
                                        <p>{{ $medical[0]->address }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 row">
                                <div class="mb-3 d-flex">
                                    <label class="form-label">Bác sĩ phụ trách: </label>
                                    <p>{{ $medical[0]->lastname }} {{ $medical[0]->firstname }}</p>
                                </div>
                            </div>
                        </div>

                        <h6 class="fw-semibold mb-4 mt-3">II. Thông tin vào</h6>
                        <div class="col-md-12 row">
                            <div class="mb-3 col-md-6 d-flex">
                                <label class="form-label">Ngày khám: </label>
                                <p>{{ \Carbon\Carbon::parse($medical[0]->date)->format('d-m-Y') }}</p>
                            </div>
                            <div class="mb-3 col-md-6 d-flex">
                                <label class="form-label">Triệu chứng: </label>
                                <p>{{ $medical[0]->symptom }}</p>
                            </div>
                        </div>

                        <h6 class="fw-semibold mb-4 mt-3">III. Thông tin ra</h6>
                        <div class="col-md-12 row">
                            <div class="mb-3 col-md-6 d-flex">
                                <label class="form-label">Chuẩn đoán:</label>
                                <p>{{ $medical[0]->diaginsis }}</p>
                            </div>
                            <div class="mb-3 col-md-6 d-flex">
                                <label class="form-label">Ngày tái khám:</label>
                                <p>{{ \Carbon\Carbon::parse($medical[0]->re_examination_date)->format('d-m-Y') }}</p>
                            </div>
                            <div class="mb-3">
                                @if (isset($services) && !$services->isEmpty())
                                    <label class="form-label">Dịch vụ</label>
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
                                            @php $count = 1; @endphp
                                            @foreach ($services as $data)
                                                <tr>
                                                    <td>{{ $count++ }}</td>
                                                    <td>{{ $data->name }}</td>
                                                    <td>{{ number_format($data->price) }}đ</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div></div>
                                @endif

                                @if (isset($totalprice) && !$totalprice->isEmpty())
                                    <div class="d-flex justify-content-end">
                                        <span id="totalAmout">Tổng cộng:
                                            @php
                                                $total = $services->sum('price'); 
                                            @endphp
                                            {{ number_format($total) }}đ
                                        </span>
                                    </div>
                                @else
                                    <div class="d-flex justify-content-end">
                                    </div>
                                @endif
                            </div>



                            <div class="mb-3">
                                <label class="form-label">Đơn thuốc</label>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Tên thuốc</th>
                                            <th>Lần uống/Ngày</th>
                                            <th>Số lượng</th>
                                            <th>Cách dùng</th>
                                            <th>Lúc uống</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php  $count =  1;  @endphp
                                        @foreach ($medicines as $data)
                                            @php  $int = $count++ @endphp
                                            <tr>
                                                <td>{{ $int }}</td>
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
