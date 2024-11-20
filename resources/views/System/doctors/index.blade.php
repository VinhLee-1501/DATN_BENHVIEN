@extends('layouts.admin.master')

@section('content')



<style>
    .note-editor .note-toolbar,
    .note-popover .popover-content {
        display: none;
    }

    .modal-dialog {
        max-height: calc(100vh - 50px);
        /* Chiều cao tối đa của modal, trừ khoảng cách 50px */
        overflow-y: auto;
        /* Thêm thanh cuộn dọc nếu nội dung vượt quá chiều cao */
    }

    .modal-content {
        max-height: calc(100vh - 50px);
        /* Áp dụng tương tự cho nội dung modal */
    }

    .text-limited {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

<div class="card w-100">
    <div class="card-body p-4">
        <h5 class="card-title fw-semibold mb-4">Quản lý bác sĩ</h5>


        <form action="{{ route('system.doctor') }}" method="GET" class="row g-3 mb-4">

    <div class="col-12 col-md-6 col-lg-4">
        <div class="row g-2">
            <div class="col-6">
                <input type="text" name="lastname" class="form-control" placeholder="Họ"
                    value="{{ request('lastname') }}">
            </div>
            <div class="col-6">
                <input type="text" name="firstname" class="form-control" placeholder="Tên"
                    value="{{ request('firstname') }}">
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-5">
        <div class="row g-2">
            <div class="col-6">
                <input type="text" name="phone" class="form-control" placeholder="Số điện thoại"
                    value="{{ request('phone') }}">
            </div>
            <div class="col-6">
                <select name="specialty_id" class="form-control">
                    <option value="">Chọn chuyên khoa</option>
                    @foreach($specialties as $specialty)
                        <option value="{{ $specialty->specialty_id }}" 
                            {{ request('specialty_id') == $specialty->specialty_id ? 'selected' : '' }}>
                            {{ $specialty->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
        <div class="d-flex gap-2 justify-content-between justify-content-md-start">
            <button type="submit" class="btn btn-primary w-100 w-md-auto">Tìm kiếm</button>
            <a class="btn btn-success w-100 w-md-auto" href="{{ route('system.doctor.create') }}">Thêm bác sĩ</a>
        </div>
    </div>

</form>


        <div class="table-responsive">
            <table class="table text-nowrap mb-0 align-middle">
                <thead class="text-dark fs-4">
                    <tr>
                        <th>ID</th>
                        <th>Ảnh</th>
                        <th>Họ tên</th>
                        <th>Chuyên khoa</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($doctors as $doctor)
                        <tr>
                            <td>{{ $doctor->user_id }}</td>
                            <td>
                                @if (empty($doctor->avatar))
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png"
                                        alt="Ảnh bác sĩ" class="img-thumbnail" style="width: 50px; height: auto;">
                                @else
                                    @if ($doctor->google_id || $doctor->zalo_id || $doctor->facebook_id)
                                        <img src="{{ $doctor->avatar }}" alt="Ảnh bác sĩ" class="img-thumbnail"
                                            style="width: 50px; height: auto;">
                                    @else
                                        @if ($doctor->avatar === 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png')
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png"
                                                alt="Ảnh bác sĩ" class="img-thumbnail" style="width: 50px; height: auto;">
                                        @else
                                            <img src="{{ asset('storage/uploads/avatars/' . $doctor->avatar) }}" alt="Ảnh bác sĩ"
                                                class="img-thumbnail" style="width: 50px; height: auto;">
                                        @endif
                                    @endif
                                @endif
                            </td>

                            <td>{{ $doctor->lastname }} {{ $doctor->firstname }}</td>
                            <td>{{ $doctor->specialty_name }}</td>
                            <td>{{ $doctor->email }}</td>
                            <td>{{ $doctor->phone }}</td>
                            <td>
                                <a href="#" class="btn btn-primary me-2" data-bs-toggle="modal"
                                    data-bs-target="#editDoctorModal" onclick="loadDoctorData('{{ $doctor->user_id }}')">
                                    <i class="ti ti-pencil"></i>
                                </a>

                                <a class="btn btn-warning" data-bs-toggle="collapse" href="#details{{ $doctor->user_id }}"
                                    role="button" aria-expanded="false" aria-controls="details{{ $doctor->user_id }}">
                                    Chi tiết
                                </a>
                            </td>
                        </tr>
                        <tr id="show">
                            <td colspan="100">
                                <div class="collapse" id="details{{ $doctor->user_id }}">
                                    <div class="card shadow-sm mt-2">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4 text-center">
                                                    @if (empty($doctor->avatar))
                                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png"
                                                            alt="Ảnh bác sĩ" class="img-thumbnail"
                                                            style="width: 150px; height: auto;">
                                                    @else
                                                        @if ($doctor->google_id || $doctor->zalo_id || $doctor->facebook_id)
                                                            <img src="{{ $doctor->avatar }}" alt="Ảnh bác sĩ" class="img-thumbnail"
                                                                style="width: 150px; height: auto;">
                                                        @else
                                                            @if ($doctor->avatar === 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png')
                                                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png"
                                                                    alt="Ảnh bác sĩ" class="img-thumbnail"
                                                                    style="width: 150px; height: auto;">
                                                            @else
                                                                <img src="{{ asset('storage/uploads/avatars/' . $doctor->avatar) }}"
                                                                    alt="Ảnh bác sĩ" class="img-thumbnail"
                                                                    style="width: 150px; height: auto;">
                                                            @endif
                                                        @endif
                                                    @endif

                                                    <div class="mt-3">
                                                        <p><strong>Mã bác sĩ:</strong> {{ $doctor->user_id }}</p>
                                                        <p><strong>Họ và tên:</strong> {{ $doctor->lastname }}
                                                            {{ $doctor->firstname }}
                                                        </p>
                                                        <p><strong>Số điện thoại:</strong> {{ $doctor->phone }}</p>
                                                        <p><strong>Email:</strong> {{ $doctor->email }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <ul class="list-group">
                                                        <li class="list-group-item"><strong>Bằng cấp</strong>
                                                            <span
                                                                class="text-limited">{!! $doctor->profile_degree ? Str::limit($doctor->profile_degree, 150, '...') : 'Chưa có thông tin' !!}</span>
                                                        </li>
                                                        <li class="list-group-item"><strong>Kinh nghiệm làm việc:</strong>
                                                            <span
                                                                class="text-limited">{!! $doctor->profile_work_experience ? Str::limit($doctor->profile_work_experience, 150, '...') : 'Chưa có thông tin' !!}</span>
                                                        </li>
                                                        <li class="list-group-item"><strong>Mô tả:</strong>
                                                            <span
                                                                class="text-limited">{!! $doctor->profile_description ? Str::limit($doctor->profile_description, 50, '...') : 'Chưa có thông tin' !!}</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">
                                <div id="noResults" class="alert alert-warning">Không tìm thấy dữ liệu.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
            <div class="mt-3">
                {{ $doctors->links() }}
            </div>
        </div>

        <div class="modal fade" id="editDoctorModal" tabindex="-1" aria-labelledby="editDoctorModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" style="max-width: 80vw;">
                <form id="editDoctorForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title" id="editDoctorModalLabel">Chỉnh sửa thông tin bác sĩ</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="lastname" class="form-label">Họ</label>
                                    <input type="text" class="form-control" id="lastname" name="lastname">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="firstname" class="form-label">Tên</label>
                                    <input type="text" class="form-control" id="firstname" name="firstname">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Số điện thoại</label>
                                    <input type="text" class="form-control" id="phone" name="phone">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="work_experience" class="form-label">Kinh nghiệm làm việc</label>
                                    <textarea rows="4" class="form-control" id="work_experience"
                                        name="work_experience"></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="degree" class="form-label">Bằng cấp</label>
                                    <textarea rows="4" class="form-control" id="degree" name="degree"></textarea>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="description" class="form-label">Mô tả</label>
                                    <textarea rows="5" class="form-control" id="description"
                                        name="description"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if($errors->any())
    <script type="text/javascript">
        $(document).ready(function () {
            // Kiểm tra nếu có lỗi
            @if($errors->any())
                // Mở modal khi có lỗi
                $('#editDoctorModal').modal('show');
                // Thêm class is-invalid vào các trường có lỗi
                @foreach ($errors->keys() as $key)
                    $('#{{ $key }}').addClass('is-invalid');
                @endforeach
            @endif
        });


    </script>

@endif

<script>

    //Lấy dữ liệu dựa vào ID
    function loadDoctorData(id) {
        var formAction = "/system/doctors/update/" + id;
        document.getElementById('editDoctorForm').action = formAction;

        // Fetch data bác sĩ và điền vào form
        fetch(`/system/doctors/edit/${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('firstname').value = data.firstname;
                document.getElementById('lastname').value = data.lastname;
                document.getElementById('phone').value = data.phone;
                document.getElementById('email').value = data.email;

                // Áp dụng Summernote sau khi điền dữ liệu
                $('#degree').summernote('code', data.profile_doctor.degree || '');
                $('#work_experience').summernote('code', data.profile_doctor.work_experience || '');
                $('#description').summernote('code', data.profile_doctor.description || '');
            })
            .catch(error => console.error('Error:', error));
    }


</script>
@push('scripts')
    <script>
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