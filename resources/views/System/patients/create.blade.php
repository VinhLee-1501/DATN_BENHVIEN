@extends('layouts.admin.master')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Thêm bệnh nhân</h5>
            <form id="savePatient" action="{{ route('system.patients.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Mã bệnh nhân</label>
                                <input type="text" name="patient_id"
                                    class="form-control @error('patient_id') is-invalid @enderror"
                                    value="{{ strtoupper(Str::random(10)) }}">
                                @error('patient_id')
                                    <div class="text-danger">*{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Họ</label>
                                <input type="text" name="last_name" id="last_name"
                                    class="form-control @error('last_name') is-invalid @enderror"
                                    value="{{ old('last_name') }}">
                                @error('last_name')
                                    <div class="text-danger">*{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Tên</label>
                                <input type="text" name="first_name" id="first_name"
                                    class="form-control @error('first_name') is-invalid @enderror"
                                    value="{{ old('first_name') }}">
                                @error('first_name')
                                    <div class="text-danger">*{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">CCCD</label>
                                <input type="text" name="cccd" id="cccd" value="{{ old('cccd') }}"
                                    class="form-control @error('cccd') is-invalid @enderror">
                                @error('cccd')
                                    <div class="text-danger">*{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Ngày sinh</label>
                                <input type="date" name="age" id="age" value="{{ old('age') }}"
                                    class="form-control @error('age') is-invalid @enderror">
                                @error('age')
                                    <div class="text-danger">*{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Giới tính</label>
                                <select name="gender" class="form-select">
                                    <option value="0">Nữ</option>
                                    <option value="1">Nam</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Số điện thoại</label>
                                <input type="text" id="phone" name="phone"
                                    class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="text-danger">*{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="text" id="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                                @error('email')
                                    <div class="text-danger">*{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Nghề nghiệp</label>
                                <input type="text" class="form-control @error('occupation') is-invalid @enderror"
                                    id="occupation" name="occupation" value="{{ old('occupation') }}">
                                @error('occupation')
                                    <div class="text-danger">*{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">SDT khẩn cấp</label>
                                <input type="text" name="emergency_contact" id="emergency_contact"
                                    class="form-control @error('emergency_contact') is-invalid @enderror">
                                @error('emergency_contact')
                                    <div class="text-danger">*{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Quốc tịch</label>
                                <input type="text" class="form-control @error('national') is-invalid @enderror"
                                    id="national" name="national" value="{{ old('national') }}">
                                @error('national')
                                    <div class="text-danger">*{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Địa chỉ</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="2">{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="text-danger">*{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>

    </div>
@endsection
