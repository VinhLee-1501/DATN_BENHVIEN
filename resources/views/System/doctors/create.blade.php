@extends('layouts.admin.master')

@section('content')

<style>
    .note-editor .note-toolbar,
    .note-popover .popover-content {
        display: none;
    }
</style>
<div class="card w-100">
    <div class="card-body p-4">
        <h5 class="card-title fw-semibold mb-4">Thêm bác sĩ</h5>

        <form action="{{ route('system.doctor.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="lastname" class="form-label">Họ</label>
                    <input type="text" name="lastname" class="form-control" id="lastname" value="{{ old('lastname') }}">
                    @error('lastname')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="firstname" class="form-label">Tên</label>
                    <input type="text" name="firstname" class="form-control" id="firstname" value="{{ old('firstname') }}">
                    @error('firstname')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}">
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="phone" class="form-label">Số điện thoại</label>
                    <input type="text" name="phone" class="form-control" id="phone" value="{{ old('phone') }}">
                    @error('phone')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="birthday" class="form-label">Ngày sinh</label>
                    <input type="date" name="birthday" class="form-control" id="birthday" value="{{ old('birthday') }}">
                </div>

                <div class="col-md-6">
                    <label for="specialty_id" class="form-label">Chuyên khoa</label>
                    <select name="specialty_id" id="specialty_id" class="form-control">
                        <option value="">Chọn chuyên khoa</option>
                        @foreach ($specialties as $specialty)
                            <option value="{{ $specialty->specialty_id }}">{{ $specialty->name }}</option>
                        @endforeach
                    </select>
                    @error('specialty_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="avatar" class="form-label">Ảnh đại diện</label>
                    <input type="file" name="avatar" class="form-control" id="avatar" onchange="previewImage(event)">
                    <div id="imagePreviewContainer" style="margin-top: 10px;">
                        <img id="imagePreview" src="#" alt="Preview Image" style="display: none; width: 100%; max-width: 150px;"/>
                    </div>
                    @error('avatar')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12">
                    <label for="degree" class="form-label">Bằng cấp</label>
                    <textarea name="degree" id="degree" rows="3" class="form-control">{{ old('degree') }}</textarea>
                    @error('degree')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12">
                    <label for="work_experience" class="form-label">Kinh nghiệm làm việc</label>
                    <textarea name="work_experience" id="work_experience" rows="3" class="form-control">{{ old('work_experience') }}</textarea>
                    @error('work_experience')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12">
                    <label for="description" class="form-label">Mô tả</label>
                    <textarea name="description" id="description" rows="3" class="form-control">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Thêm bác sĩ</button>
                <a href="{{ route('system.doctor') }}" class="btn btn-secondary">Quay lại</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script>
        // Hiển thị ảnh xem trước khi chọn ảnh
        function previewImage(event) {
            const imagePreview = document.getElementById('imagePreview');
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');

            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block'; // Hiển thị ảnh
            };

            if (file) {
                reader.readAsDataURL(file);
            }
        }

        $(document).ready(function () {
            // Áp dụng Summernote cho tất cả các textarea
            $('textarea').summernote({
                minHeight: 100,
                focus: true,
            });
        });
    </script>
@endpush

@endsection
