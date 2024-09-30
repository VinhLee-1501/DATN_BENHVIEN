@extends('layouts.admin.master')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4 text-center">Bệnh án - {{ $medical[0]->last_name  }}
                {{ $medical[0]->first_name }}</h5>
            <div class="card">
                <div class="col-md-12 row">
                    <div class="col-md-3">
                        <div class="header-info">
                            <img src="{{ asset('backend/assets/images/profile/user-1.jpg') }}"
                                 class="img-thumbnail rounded-circle w-75" alt="...">
                            <span class="text-center fs-6 fw-bold">
                                {{ $medical[0]->last_name }}
                                {{ $medical[0]->first_name }}
                            </span>
                        </div>
                        <hr class="w-50 m-md-4">
                        <div class="footer-info mt-3">
                            <h6 class="fw-bold">Thông tin</h6>
                            <div class="info">
                                <div class="phone">
                                    <span>
                                        <i class="ti ti-phone"></i>
                                    </span> {{ $medical[0]->phone }}
                                </div>
                                <div class="birthday">
                                    <span>
                                        <i class="ti ti-calendar"></i>
                                    </span> {{ $medical[0]->birthday }}
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
                        <div class="card w-100">
                            <div class="card-body p-4">
                                <form>
                                    <h6 class="fw-semibold mb-4">I. Hành chính</h6>
                                    <div class="table-responsive ms-3">
                                        <div class="col-md-12 row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="exampleInputEmail1" class="form-label">
                                                        Tiêu đề
                                                    </label>
                                                    <input type="text" name="name" class="form-control"
                                                           value="Thăm khám {{ \Carbon\Carbon::parse($medical[0]->date)->format('d-m-Y') }} ">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="exampleInputPassword1" class="form-label">
                                                        Họ và tên
                                                    </label>
                                                    <input type="text" class="form-control" id=""
                                                    value="{{ $medical[0]->last_name }} {{ $medical[0]->first_name }}
                                                        ">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <div class="mb-3">
                                                        <label for="exampleInputPassword1" class="form-label">
                                                            Ngày sinh
                                                        </label>
                                                        <input type="date" class="form-control" id=""
                                                               value="{{ $medical[0]->birthday }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="exampleInputPassword1" class="form-label">
                                                        Địa chỉ
                                                    </label>
                                                    <textarea name="" id="" cols="10" rows="2"
                                                              class="form-control">
                                                        {{ $medical[0]->address }}
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="fw-semibold mb-4 mt-3">II. Thông tin vào</h6>

                                    <div class="col-md-12">
                                        <div class="">
                                            <div class="mb-3">
                                                <label for="exampleInputEmail1" class="form-label">
                                                    Ngày khám
                                                </label>
                                                <input type="date" name="name" class="form-control"
                                                value="{{ \Carbon\Carbon::parse($medical[0]->date)->format('d-m-Y') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="fw-semibold mb-4 mt-3">III. Thông tin ra</h6>

                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">
                                            Chuẩn đoán
                                        </label>
                                        <textarea class="form-control" name="" rows="3">{{ $medical[0]->diaginsis }}</textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Lưu</button>
                                    <a href="{{ route('admin.prescription_medical_record',
                                    ['medical_id' => $medical[0]->medical_id, 'treatment_id' => $medical[0]->treatment_id]) }}"
                                       type="submit" class="btn btn-primary">Xem toa thuốc</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
