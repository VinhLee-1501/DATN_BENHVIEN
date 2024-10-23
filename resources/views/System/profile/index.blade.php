@extends('layouts.admin.master')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4 text-center">Cập nhật thông tin tài khoản</h5>

            <form action="{{ route('system.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="row">
                    <!-- Phần Avatar và thông tin cơ bản -->
                    <div class="col-md-4 text-center">
                        <div class="profile-picture mb-3">
                            <img src="http://127.0.0.1:8000/backend/assets/images/profile/user-1.jpg"
                                class="img-thumbnail rounded-circle w-75" alt="Avatar">
                        </div>
                        <hr class="w-50 m-auto">
                        <h6 class="fw-bold">Thông tin liên hệ</h6>
                        <div class="mt-3">
                            <p><strong>Số điện thoại:</strong> {{ Auth::user()->phone }}</p>
                            <p><strong>Ngày sinh:</strong>
                                {{ auth()->check() && auth()->user()->birthday ? auth()->user()->birthday->format('d/m/Y') : '' }}
                            </p>
                        </div>
                    </div>

                    <!-- Phần thông tin cá nhân -->
                    <div class="col-md-8">
                        <h6 class="fw-semibold mb-4">I. Thông tin cá nhân</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="lastname" class="form-label">Họ:</label>
                                    <input type="text" name="lastname" id="lastname"
                                        value="{{ old('lastname', Auth::user()->lastname) }}"
                                        class="form-control @error('lastname') is-invalid @enderror">
                                    @error('lastname')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="firstname" class="form-label">Tên:</label>
                                    <input type="text" name="firstname" id="firstname"
                                        value="{{ old('firstname', Auth::user()->firstname) }}"
                                        class="form-control @error('firstname') is-invalid @enderror">
                                    @error('firstname')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email:</label>
                                    <input type="email" name="email" id="email"
                                        value="{{ old('email', Auth::user()->email) }}"
                                        class="form-control @error('email') is-invalid @enderror">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                @if (auth::user()->role == 2)
                                    <div class="mb-3">
                                        <label for="specialty" class="form-label">Chuyên khoa:</label>
                                        <select name="specialty_id" id="specialty_id"
                                            class="form-control @error('specialty_id') is-invalid @enderror">
                                            @foreach ($specialties as $specialty)
                                                <option value="{{ $specialty->specialty_id }}"
                                                    {{ old('specialty_id', Auth::user()->specialty_id) == $specialty->specialty_id ? 'selected' : '' }}>
                                                    {{ $specialty->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('specialty_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @else
                                @endif


                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Số điện thoại:</label>
                            <input type="text" name="phone" id="phone"
                                value="{{ old('phone', Auth::user()->phone) }}"
                                class="form-control @error('phone') is-invalid @enderror">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="birthday" class="form-label">Ngày sinh:</label>
                            <input type="date" name="birthday" id="birthday"
                                value="{{ auth()->check() && auth()->user()->birthday ? auth()->user()->birthday->format('Y-m-d') : '' }}"
                                class="form-control @error('birthday') is-invalid @enderror">
                            @error('birthday')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary px-5">Cập nhật thông tin</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
