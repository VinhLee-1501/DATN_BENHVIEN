@extends('layouts.admin.master')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Chỉnh sửa thông tin bệnh nhân</h5>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('system.patients.update', $patient->patient_id) }}" method="POST">
                        @csrf
                        @method('PATCH')

{{--                        @if ($errors->any())--}}
{{--                            <div class="alert alert-danger">--}}
{{--                                <ul>--}}
{{--                                    @foreach ($errors->all() as $error)--}}
{{--                                        <li>{{ $error }}</li>--}}
{{--                                    @endforeach--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                        @endif--}}

                        <div class="col-md-12 row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Mã bệnh nhân</label>
                                    <input type="text" name="patient_id" class="form-control"
                                           value="{{ old('patient_id', $patient->patient_id) }}">
                                    @error('patient_id')
                                    <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Số điện thoại</label>
                                    <input type="text" name="phone" class="form-control"
                                           value="{{ old('phone', $patient->phone) }}" inputmode="numeric">
                                    @error('phone')
                                    <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Họ</label>
                                    <input type="text" name="last_name" class="form-control"
                                           value="{{ old('last_name', $patient->last_name) }}">
                                    @error('last_name')
                                    <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Tên</label>
                                    <input type="text" name="first_name" class="form-control"
                                           value="{{ old('first_name', $patient->first_name) }}">
                                    @error('first_name')
                                    <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Giới tính</label>
                                    <select name="gender" class="form-select">
                                        <option value="0" {{ old('gender', $patient->gender) == 0 ? 'selected' : '' }}>
                                            Nữ
                                        </option>
                                        <option value="1" {{ old('gender', $patient->gender) == 1 ? 'selected' : '' }}>
                                            Nam
                                        </option>
                                    </select>
                                    @error('gender')
                                    <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Ngày sinh</label>
                                    <input type="date" name="birthday" class="form-control"
                                           value="{{ old('birthday', $patient->birthday) }}">
                                    @error('birthday')
                                    <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Số BHYT</label>
                                    <input type="number" name="insurance_number" class="form-control"
                                           value="{{ old('insurance_number', $patient->Insurance_number) }}">
                                    @error('insurance_number')
                                    <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">SDT khẩn cấp</label>
                                    <input type="number" name="emergency_contact" class="form-control"
                                           value="{{ old('emergency_contact', $patient->emergency_contact) }}">
                                    @error('emergency_contact')
                                    <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Địa chỉ</label>
                                    <textarea class="form-control" name="address" cols="10"
                                              rows="5">{{ old('address', $patient->address) }}</textarea>
                                    @error('address')
                                    <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nghề nghiệp</label>
                                    <input type="text" name="occupation" class="form-control"
                                           value="{{ old('occupation', $patient->occupation) }}">
                                    @error('occupation')
                                    <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Quốc tịch</label>
                                    <input type="text" name="national" class="form-control"
                                           value="{{ old('national', $patient->national) }}">
                                    @error('national')
                                    <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Ảnh đại diện</label>
                                    <input type="file" name="avatar" class="form-control">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
