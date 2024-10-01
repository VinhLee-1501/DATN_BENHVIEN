@extends('layouts.admin.master')

@section('content')
    <div class="card-body">
        <h5 class="card-title fw-semibold mb-4 text-center">Thêm Tài Khoản</h5>


        <div class="card w-100">
            <div class="card-body p-4">
                <form action="{{ route('admin.accounts.store') }}" method="POST">
                    @csrf
                    <h6 class="fw-semibold mb-4">I. Tài khoản</h6>
                    <div class="table-responsive ms-3">
                        <div class="col-md-12 row">
                            <div class="col-md-4 " style="display: none">
                                <div class="mb-3">
                                    <label for="codeInput" class="form-label">Mã ngẫu nhiên</label>
                                    <input type="text" id="userid" name="userid" class="form-control"
                                           value="{{ strtoupper(Str::random(10)) }}" readonly>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="roleSelect" class="form-label">Vai trò</label>
                                <select id="roleSelect" name="role" class="form-control" onchange="toggleInputs()">
                                    <option value="">Chọn vai trò</option>
                                    <option value="0" {{ old('role') == 0 ? 'selected' : '' }}>Người dùng</option>
                                    <option value="1" {{ old('role') == 1 ? 'selected' : '' }}>Quản trị</option>
                                    <option value="2" {{ old('role') == 2 ? 'selected' : '' }}>Bác sĩ</option>
                                </select>
                                @error('role')
                                <div class="text-danger">*{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 row" id="inputFields" >
                            <div class="col-md-6">
                                <div class="mb-3" id="emailField" >
                                    <label for="emailInput" class="form-label">Email</label>
                                    <input type="email" id="emailInput" name="email" class="form-control"
                                           placeholder="Nhập email" value="{{ old('email') }}">
                                    @error('email')
                                    <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="passwordInput" class="form-label">Mật khẩu</label>
                                    <input type="password" id="passwordInput" name="password" class="form-control"
                                           placeholder="Nhập mật khẩu">
                                    @error('password')
                                    <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <h6 class="fw-semibold mb-4 mt-3">II. Thông tin cá nhân</h6>
                    <div class="table-responsive ms-3">
                        <div class="col-md-12 row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="firstName" class="form-label">Họ</label>
                                    <input type="text" id="lastname" name="lastname" class="form-control"
                                           placeholder="Nhập họ" value="{{ old('lastname') }}">
                                    @error('lastname')
                                    <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="lastName" class="form-label">Tên</label>
                                    <input type="text" id="firstname" name="firstname" class="form-control"
                                           placeholder="Nhập tên" value="{{ old('firstname') }}">
                                    @error('firstname')
                                    <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4" id="phoneField">
                                <div class="mb-3">
                                    <label for="phoneInput" class="form-label">Số điện thoại</label>
                                    <input type="text" id="phoneInput" name="phone" class="form-control"
                                           placeholder="Nhập số điện thoại" value="{{ old('phone') }}"
                                           oninput="updateAccountFromPhone()">
                                    @error('phone')
                                    <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 row" id="specialtyField" style="display: none;">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="specialtyInput" class="form-label">Chuyên khoa</label>
                                    <input type="text" id="specialtyInput" name="specialty" class="form-control"
                                           placeholder="Nhập chuyên khoa" value="{{ old('specialty') }}">
                                    @error('specialty')
                                    <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="departmentInput" class="form-label">Phòng khám</label>
                                    <input type="text" id="departmentInput" name="department" class="form-control"
                                           placeholder="Nhập phòng khám" value="{{ old('department') }}">
                                    @error('department')
                                    <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Lưu</button>
                </form>
            </div>
        </div>

        <script>
            function toggleInputs() {
                const roleSelect = document.getElementById('roleSelect');
                const inputFields = document.getElementById('inputFields');
                const specialtyField = document.getElementById('specialtyField');

                if (roleSelect.value) {
                    inputFields.style.display = 'flex';
                    emailField.style.display = 'block';
                    specialtyField.style.display = roleSelect.value === '2' ? 'flex' : 'none';
                } else {
                    inputFields.style.display = 'none';
                    specialtyField.style.display = 'none';
                }
            }

            function updateAccountFromPhone() {
                const roleSelect = document.getElementById('roleSelect');
                const phoneInput = document.getElementById('phoneInput');
                const emailInput = document.getElementById('emailInput');

            }
        </script>
@endsection