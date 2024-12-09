@extends('layouts.admin.master')

@section('content')
    <div class="card-body">
        <h5 class="card-title fw-semibold mb-4 text-center">Chỉnh Sửa Tài Khoản</h5>

        <div class="card w-100">
            <div class="card-body p-4">
                <form action="{{ route('system.accounts.update', $account->user_id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <h6 class="fw-semibold mb-4">I. Tài khoản</h6>
                    <div class="table-responsive ms-3">
                        <div class="col-md-12 row">
                            <div class="col-md-4 " style="display: none">
                                <div class="mb-3">
                                    <label for="codeInput" class="form-label">Mã ngẫu nhiên</label>
                                    <input type="text" id="userid" name="user_id" class="form-control"
                                           value="{{ old('userid', $account->user_id) }}" readonly>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="roleSelect" class="form-label">Vai trò</label>
                                <select id="roleSelect" name="role" class="form-control" onchange="toggleInputs()">
                                <option value="">Chọn vai trò</option>
                                    <option value="0" {{ old('role') == 0 ? 'selected' : '' }}>Bệnh nhân</option>
                                    <option value="1" {{ old('role') == 1 ? 'selected' : '' }}>Quản trị</option>
                                    <option value="3" {{ old('role') == 3 ? 'selected' : '' }}>Nhân viên</option>
                                </select>

                                @error('role')
                                <div class="text-danger">*{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 row" id="inputFields">
                            <div class="col-md-6">
                                <div class="mb-3" id="emailField">
                                    <label for="emailInput" class="form-label">Email</label>
                                    <input type="email" id="emailInput" name="email" class="form-control"
                                           placeholder="Nhập email" value="{{ old('email', $account->email) }}">
                                    @error('email')
                                    <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="passwordInput" class="form-label">Mật khẩu</label>
                                    <input type="password" id="passwordInput" name="password" class="form-control" placeholder="Để trống nếu không muốn đổi mật khẩu">
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
                                    <label for="lastname" class="form-label">Họ</label>
                                    <input type="text" id="lastname" name="lastname" class="form-control"
                                           placeholder="Nhập họ" value="{{ old('lastname', $account->lastname) }}">
                                    @error('lastname')
                                    <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="firstName" class="form-label">Tên</label>
                                    <input type="text" id="firstname" name="firstname" class="form-control"
                                           placeholder="Nhập tên" value="{{ old('firstname', $account->firstname) }}">
                                    @error('firstname')
                                    <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4" id="phoneField">
                                <div class="mb-3">
                                    <label for="phoneInput" class="form-label">Số điện thoại</label>
                                    <input type="text" id="phoneInput" name="phone" class="form-control"
                                           placeholder="Nhập số điện thoại" value="{{ old('phone', $account->phone) }}"
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
                                    <select id="specialtyInput" name="specialty_id" class="form-control">
                                        @foreach($specialties as $item) <!-- Thay đổi từ $account thành $specialties -->
                                        <option value="{{ $item->specialty_id }}" {{ old('specialty_id', $account->specialty_id) == $item->specialty_id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('specialty_id')
                                    <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary">Lưu Thay Đổi</button>
                </form>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                toggleInputs(); // Gọi ngay khi trang load để hiển thị đúng

                // Lắng nghe sự thay đổi của vai trò
                const roleSelect = document.getElementById('roleSelect');
                roleSelect.addEventListener('change', toggleInputs);
            });

            function toggleInputs() {
                const roleSelect = document.getElementById('roleSelect');
                const inputFields = document.getElementById('inputFields');
                const specialtyField = document.getElementById('specialtyField');

                // Hiển thị các trường input dựa trên vai trò
                inputFields.style.display = roleSelect.value ? 'flex' : 'none';

                // Nếu vai trò là Bác sĩ (giá trị là '2') thì hiển thị trường Chuyên khoa
                specialtyField.style.display = roleSelect.value === '2' ? 'flex' : 'none';
            }

            function updateAccountFromPhone() {
                const phoneInput = document.getElementById('phoneInput');
                const emailInput = document.getElementById('emailInput');

                // Logic để tự động cập nhật email từ số điện thoại nếu cần
            }
        </script>
@endsection
