@extends('layouts.admin.master')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Thêm bệnh nhân</h5>
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="row">
                    <!-- Cột bên trái -->
                    <div class="col-md-6">
                        <div class="left-patient">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Mã bệnh nhân</label>
                                        <input type="text" name="patient_id" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Số điện thoại</label>
                                        <input type="text" name="phone" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Họ</label>
                                        <input type="text" name="last_name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tên</label>
                                        <input type="text" name="first_name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Giới tính</label>
                                        <select name="gender" class="form-select">
                                            <option value="0">Nữ</option>
                                            <option value="1">Nam</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Ngày sinh</label>
                                        <input type="date" name="birthday" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cột bên phải -->
                    <div class="col-md-6">
                        <div class="right-patient">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">CCCD</label>
                                        <input type="text" name="cccd" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">SDT khẩn cấp</label>
                                        <input type="number" name="emergency_contact" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nghề nghiệp</label>
                                        <input type="text" name="occupation" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Quốc tịch</label>
                                        <input type="text" name="national" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Địa chỉ</label>
                                        <textarea class="form-control" name="address" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Ảnh đại diện</label>
                                        <input type="file" name="avatar" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Nút lưu -->
                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
         <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Thêm bệnh nhân</h5>

            <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="row">
                    <!-- Cột bên trái -->
                    <div class="col-md-6">
                        <div class="left-patient">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Mã bệnh nhân</label>
                                        <input type="text" name="patient_id" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Số điện thoại</label>
                                        <input type="text" name="phone" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Họ</label>
                                        <input type="text" name="last_name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tên</label>
                                        <input type="text" name="first_name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Giới tính</label>
                                        <select name="gender" class="form-select">
                                            <option value="0">Nữ</option>
                                            <option value="1">Nam</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Ngày sinh</label>
                                        <input type="date" name="birthday" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cột bên phải -->
                    <div class="col-md-6">
                        <div class="right-patient">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">CCCD</label>
                                        <input type="text" name="cccd" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">SDT khẩn cấp</label>
                                        <input type="number" name="emergency_contact" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nghề nghiệp</label>
                                        <input type="text" name="occupation" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Quốc tịch</label>
                                        <input type="text" name="national" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Địa chỉ</label>
                                        <textarea class="form-control" name="address" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Ảnh đại diện</label>
                                        <input type="file" name="avatar" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Nút lưu -->
                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
@endsection
