@extends('layouts.admin.master')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4 text-center">Bệnh án - Nguyen Van A</h5>
            <div class="card">
                <div class="col-md-12 row">
                    <div class="col-md-3">
                        <div class="header-info">
                            <img src="{{ asset('backend/assets/images/profile/user-1.jpg') }}"
                                 class="img-thumbnail rounded-circle w-75" alt="...">
                            <span class="text-center fs-6 fw-bold">Nguyen Van A</span>
                        </div>
                        <hr class="w-50 m-md-4">
                        <div class="footer-info mt-3">
                            <h6 class="fw-bold">Thông tin</h6>
                            <div class="info">
                                <div class="phone">
                                    <span>
                                        <i class="ti ti-phone"></i>
                                    </span> +84 877894434
                                </div>
                                <div class="birthday">
                                    <span>
                                        <i class="ti ti-calendar"></i>
                                    </span> 04/01/1999
                                </div>
                                <div class="address">
                                    <span>
                                        <i class="ti ti-map-pin"></i>
                                    </span> Việt Nam
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
                                                    <label for="exampleInputEmail1" class="form-label">Tiêu đề</label>
                                                    <input type="text" name="name" class="form-control"
                                                           id="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="exampleInputPassword1" class="form-label">Họ tên</label>
                                                    <input type="text" class="form-control" id="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <div class="mb-3">
                                                        <label for="exampleInputPassword1" class="form-label">Ngày
                                                            sinh</label>
                                                        <input type="date" class="form-control" id="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="exampleInputPassword1" class="form-label">Địa
                                                        chỉ</label>
                                                    <textarea name="" id="" cols="10" rows="2"
                                                              class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="fw-semibold mb-4 mt-3">II. Thông tin vào</h6>

                                    <div class="col-md-12 row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="exampleInputEmail1" class="form-label">Ngày khám</label>
                                                <input type="date" name="name" class="form-control" id="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="exampleInputPassword1" class="form-label">Giời khám</label>
                                                <input type="time" class="form-control" id="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Chuẩn đoán lâm sàng</label>
                                        <textarea class="form-control" name="" id="" cols="10" rows="3"></textarea>
                                    </div>
                                    <h6 class="fw-semibold mb-4 mt-3">III. Thông tin ra</h6>

                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Chuẩn đoán</label>
                                        <textarea class="form-control" name="" id="" cols="10" rows="3"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Lưu</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
