@extends('layouts.admin.master')

@section('content')



<style>
    .note-editor .note-toolbar,
    .note-popover .popover-content {
        display: none;
    }

    .card {
        margin-bottom: 0px;
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
                        <select name="specialty_id" class="form-select">
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
            <div class="mt-3">
                {{ $doctors->links() }}
            </div>
            <table class="table table-bordered text-nowrap mb-0 align-middle">
                <thead class="text-dark">
                    <tr class="text-center">
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
                    <tr class="text-center">
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
                        <td class="d-flex justify-content-center align-items-center">
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
                                                            class="text-limited">{!! $doctor->profile_description ? Str::limit($doctor->profile_description, 150, '...') : 'Chưa có thông tin' !!}</span>
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

        @if(isset($doctor))
        <div class="modal fade" id="editDoctorModal" tabindex="-1" aria-labelledby="editDoctorModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">

                <form id="editDoctorForm" method="POST" action="{{ route('system.doctor.update',$doctor->user_id) }}">
                    @csrf
                    @method('PATCH')
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title" id="editDoctorModalLabel">Chỉnh sửa thông tin bác sĩ {{ $doctor->firstname }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-2">
                                <input type="hidden" id="doctor_id" name="doctor_id" value="{{ old('doctor_id') }}">

                                <div class="col-md-6">

                                    <label for="lastname" class="form-label">Họ</label>
                                    <input type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastname" name="lastname" value="{{ old('lastname', $doctor->lastname) }}">
                                    @error('lastname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="firstname" class="form-label">Tên</label>
                                    <input type="text" class="form-control @error('firstname') is-invalid @enderror" id="firstname" name="firstname" value="{{ old('firstname', $doctor->firstname) }}">
                                    @error('firstname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Số điện thoại</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $doctor->phone) }}">
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $doctor->email) }}">
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="degree" class="form-label">Bằng cấp</label>
                                    <textarea rows="4" class="form-control @error('degree') is-invalid @enderror" id="degree" name="degree">{{ old('degree', $doctor->profileDoctor->degree ?? '') }}</textarea>
                                    @error('degree')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="work_experience" class="form-label">Kinh nghiệm làm việc</label>
                                    <textarea rows="4" class="form-control @error('work_experience') is-invalid @enderror" id="work_experience" name="work_experience">{{ old('work_experience', $doctor->profileDoctor->work_experience ?? '') }}</textarea>
                                    @error('work_experience')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="description" class="form-label">Mô tả</label>
                                    <textarea rows="5" class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description', $doctor->profileDoctor->description ?? '') }}</textarea>
                                    @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
        @endif
        <!-- modal -->



    </div>
</div>
@if($errors->any())
<script type="text/javascript">
    $(document).ready(function() {
        $('#editDoctorModal').modal('show');

        let doctorId = $('#doctor_id').val();
        if (doctorId) {
            let formAction = "/system/doctors/update/" + doctorId;
            $('#editDoctorForm').attr('action', formAction);
        }
    });
</script>
@endif

<script>
    $(document).ready(function() {
        // Xóa lỗi khi modal bị đóng
        $('#editDoctorModal').on('hidden.bs.modal', function() {
            // Xóa class `is-invalid` khỏi tất cả các input
            $(this).find('.is-invalid').removeClass('is-invalid');
            // Xóa tất cả các thông báo lỗi
            $(this).find('.invalid-feedback').remove();
            // Reset giá trị các input
            $(this).find('input, textarea').val('');
            // Reset Summernote (nếu có sử dụng)
            $(this).find('.summernote').summernote('reset');
        });

        // Khi mở modal khác, reset modal hiện tại (nếu cần)
        $('#editDoctorModal').on('show.bs.modal', function(event) {
            // Lấy dữ liệu từ nút nhấn
            let button = $(event.relatedTarget);
            let doctorId = button.data('id'); // Giả định bạn đã đặt data-id cho nút nhấn
            let modal = $(this);

            // Gọi AJAX để lấy dữ liệu bác sĩ theo ID (nếu cần)
            $.ajax({
                url: `/system/doctors/${doctorId}`,
                type: 'GET',
                success: function(data) {
                    // Gán giá trị cho các input trong modal
                    modal.find('#doctor_id').val(data.user_id);
                    modal.find('#lastname').val(data.lastname);
                    modal.find('#firstname').val(data.firstname);
                    modal.find('#phone').val(data.phone);
                    modal.find('#email').val(data.email);
                    modal.find('#degree').val(data.profileDoctor.degree || '');
                    modal.find('#work_experience').val(data.profileDoctor.work_experience || '');
                    modal.find('#description').val(data.profileDoctor.description || '');
                    // Nếu bạn sử dụng Summernote hoặc các trình soạn thảo khác, cập nhật nội dung tại đây
                },
                error: function(xhr) {
                    console.error('Không thể tải dữ liệu bác sĩ:', xhr);
                }
            });
        });
    });
</script>



<script>
    function loadDoctorData(id) {
        document.getElementById('doctor_id').value = id;
        let formAction = "/system/doctors/update/" + id;
        document.getElementById('editDoctorForm').action = formAction;

        // Fetch dữ liệu và điền vào form
        fetch(`/system/doctors/edit/${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('firstname').value = data.firstname;
                document.getElementById('lastname').value = data.lastname;
                document.getElementById('phone').value = data.phone;
                document.getElementById('email').value = data.email;

                $('#degree').summernote('code', data.profile_doctor.degree || '');
                $('#work_experience').summernote('code', data.profile_doctor.work_experience || '');
                $('#description').summernote('code', data.profile_doctor.description || '');
            })
            .catch(error => console.error('Error:', error));
    }
</script>
@push('scripts')
<script>
    $(document).ready(function() {
        // Áp dụng Summernote cho tất cả các textarea
        $('textarea').summernote({
            minHeight: 100,
            focus: true,
        });
    });
</script>


@endpush
@endsection