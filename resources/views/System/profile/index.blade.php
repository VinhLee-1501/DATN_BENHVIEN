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
                        <div class="profile-picture position-relative mb-3">
                            @if (empty(auth()->user()->avatar))
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png"
                                    class="img-thumbnail w-75 h-75" alt="Avatar" id="profileImage">
                            @else
                                <img src="{{ asset('storage/uploads/avatars/' . auth()->user()->avatar) }}"
                                    class="img-thumbnail w-75 h-75" alt="Avatar" id="profileImage">
                            @endif

                            <!-- Icon máy ảnh hiển thị khi rê chuột -->
                            <div class="camera-icon position-absolute top-50 start-50 translate-middle"
                                onclick="showModal()" style="display: none; cursor: pointer;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24"
                                    fill="none" stroke="white" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-camera-up">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M12 20h-7a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2h1a2 2 0 0 0 2 -2a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v3.5" />
                                    <path d="M12 16a3 3 0 1 0 0 -6a3 3 0 0 0 0 6z" />
                                    <path d="M19 22v-6" />
                                    <path d="M22 19l-3 -3l-3 3" />
                                </svg>
                            </div>
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
    <div class="modal fade" id="updateAvatarModal" tabindex="-1" aria-labelledby="updateAvatarLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateAvatarLabel">Cập nhật hình đại diện</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('system.change-avatar') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3 h-100 d-flex justify-content-center align-items-center">
                            <!-- Ảnh xem trước sau khi tải lên -->
                            @if (empty(auth()->user()->avatar))
                                <img id="previewImage"
                                     src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png"
                                     class="img-thumbnail" style="width: 150px; height: 150px;" alt="Preview">
                            @else
                                <img id="previewImage"
                                     src="{{ asset('storage/uploads/avatars/' . auth()->user()->avatar) }}"
                                     class="img-thumbnail" style="width: 150px; height: 150px;" alt="Preview">
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="avatarInput" class="form-label">Chọn hình đại diện mới</label>
                            <input type="file" name="avatar" class="form-control" id="avatarInput"
                                accept="image/*">

                            <!-- Hiển thị thông báo lỗi nếu có -->
                            @error('avatar')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- JavaScript -->
    <script>
        // Hiển thị icon máy ảnh khi rê chuột
        document.querySelector('.profile-picture').addEventListener('mouseenter', function() {
            document.querySelector('.camera-icon').style.display = 'block';
        });

        document.querySelector('.profile-picture').addEventListener('mouseleave', function() {
            document.querySelector('.camera-icon').style.display = 'none';
        });

        // Hiển thị modal khi nhấn vào icon máy ảnh
        function showModal() {
            var myModal = new bootstrap.Modal(document.getElementById('updateAvatarModal'), {});
            myModal.show();
        }

        // Cập nhật ảnh xem trước khi chọn file mới
        document.getElementById('avatarInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Hiển thị ảnh mới trong modal và ảnh đại diện chính
                    document.getElementById('previewImage').src = e.target.result;
                    document.getElementById('profileImage').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
