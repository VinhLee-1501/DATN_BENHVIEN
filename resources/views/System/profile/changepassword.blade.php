@extends('layouts.admin.master')

@section('content')
    <div class="card mx-auto" style="max-width: 600px;">
        <div class="card-body">
            <div id="change_password"
                class="tab {{ $errors->has('current_password') || $errors->has('new_password') || session('change_password_success') || session('change_password_error') ? 'active' : '' }}">
                <h5 class="text-center">Đổi mật khẩu</h5>
                <form method="POST" action="{{ route('client.profile.change-password') }}" class="profile__form">
                    @csrf
                    @method('PATCH')

                    <!-- Mật khẩu hiện tại -->
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                        <input type="password" id="current_password" name="current_password"
                            class="form-control @error('current_password') is-invalid @enderror" />
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Mật khẩu mới -->
                    <div class="mb-3">
                        <label for="new_password" class="form-label">Mật khẩu mới</label>
                        <input type="password" id="new_password" name="new_password"
                            class="form-control @error('new_password') is-invalid @enderror" />
                        @error('new_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Xác nhận mật khẩu mới -->
                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                            class="form-control @error('new_password_confirmation') is-invalid @enderror" />
                        @error('new_password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nút submit -->
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
