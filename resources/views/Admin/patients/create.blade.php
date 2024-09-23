@extends('layouts.admin.master')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Thêm bệnh nhân</h5>
            <div class="card">
                <div class="card-body">
                    <form>
                        <div class="col-md-12 row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Họ tên</label>
                                    <input type="text" name="name" class="form-control" id="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Ngày sinh</label>
                                    <input type="date" class="form-control" id="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Giới tính</label>
                                    <select name="gender" class="form-select">
                                        <option value="">Nam</option>
                                        <option value="">Nữ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" id="">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Mã căn cước</label>
                                    <input type="text" name="email" class="form-control" id="">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">SDT</label>
                                    <input type="text" name="phone" class="form-control" id="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Địa chỉ</label>
                                    <textarea class="form-control" name="" id="" cols="10" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Ảnh hồ sơ</label>
                                    <input type="file" class="form-control" id="">
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="mb-3 form-check form-switch">
                                <label for="exampleInputPassword1" class="form-label">Trạng thái</label>
                                <input type="checkbox" class="form-check-input" id="flexSwitchCheckChecked" checked>
                            </div>
                            <div class="mb-3 form-check form-switch">
                                <label for="exampleInputPassword1" class="form-label">Người dùng</label>
                                <input type="checkbox" class="form-check-input" id="flexSwitchCheckChecked" checked>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
@endsection
