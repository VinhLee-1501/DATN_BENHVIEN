@extends('layouts.admin.master')
@section('Chi tiết cận lâm sàng')
@section('content')
    <style>
        .note-editor .note-toolbar,
        .note-popover .popover-content {
            display: none;
        }
    </style>
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center m-1 mb-4">
            <h5 class="card-title fw-semibold mb-4 ">Chi tiết cận lâm sàng</h5>
        </div>
        <div class="card w-100">
            <div class="card-body p-4">

                <div class="row m-4">
                    <!-- Thông tin khách hàng -->
                    <div class="row mb-3 ">
                        <div class="col-auto me-3 mb-2">
                            <strong>Mã Bệnh án:</strong> {{ $MedicalRecord->medical_id }}
                        </div>
                        <div class="col-auto me-3 mb-2">
                            <strong>Họ tên bệnh nhân:</strong> {{ $MedicalRecord->last_name }}
                            {{ $MedicalRecord->first_name }}
                        </div>
                        <div class="col-auto me-3 mb-2">
                            <strong>Năm sinh: {{ Carbon\Carbon::parse($MedicalRecord->birthday)->format('Y') }}</strong>
                        </div>
                        <div class="col-auto me-3 mb-2">
                            <strong>Giới tính:</strong> <span id="customerGender">
                                @if ($MedicalRecord->gender == 1)
                                    Nam
                                @else
                                    Nữ
                                @endif
                            </span>
                        </div>
                        <div class="col-12 me-3 mb-2">
                            <strong>Địa chỉ:</strong> {{ $MedicalRecord->address }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-auto me-3 mb-2">
                            <strong>Bác sĩ:</strong> {{ $MedicalRecord->firstname }} {{ $MedicalRecord->lastname }}
                        </div>
                        <div class="col-auto me-3 mb-2">
                            <strong>Khoa:</strong> {{ $MedicalRecord->specialty_name }}
                        </div>
                        <div class="col-auto me-3 mb-2">
                            <strong>Phòng:</strong> {{ $MedicalRecord->clinic_name }}
                        </div>
                    </div>

                    <!-- Bảng dịch vụ -->
                    <div class="row">
                        <div class="container">
                            <form method="POST"
                                action="{{ route('system.borderline-result.update', ['treatment_id' => $MedicalRecord->treatment_id, 'service_id' => $MedicalRecord->service_id]) }}"
                                enctype="multipart/form-data" id="treatmentForm">
                                @csrf

                                <!-- Tiêu đề dịch vụ -->
                                <div class="row mb-2">
                                    <div class="col-1 text-right">
                                        <strong>Dịch vụ:</strong>
                                    </div>
                                    <div class="col-auto">
                                        {{ $MedicalRecord->service_name }}
                                    </div>
                                </div>

                                <!-- Ảnh -->
                                <div class="row mb-2">
                                    <div class="col-1 text-right">
                                        <strong>Ảnh:</strong>
                                    </div>
                                    <div class="col-7">
                                        <input type="file" class="form-control" name="image[]" id="image" multiple>
                                        <div id="image-error" class="text-danger"></div>
                                    </div>

                                </div>

                                <!-- Mô tả -->
                                <div class="row mb-2">
                                    <div class="col-1 text-right">
                                        <strong>Mô tả:</strong>
                                    </div>
                                    <div class="col-7">
                                        <textarea class="form-control" rows="3" name="note" id="note">{{ $MedicalRecord->note }}</textarea>
                                        <div id="note-error" class="text-danger"></div>
                                    </div>

                                </div>

                                <!-- Kết quả -->
                                <div class="row mb-2">
                                    <div class="col-1 text-right">
                                        <strong>Kết quả:</strong>
                                    </div>
                                    <div class="col-7">
                                        <textarea class="form-control" rows="3" name="result" id="result">{{ $MedicalRecord->result }}</textarea>
                                        <div id="result-error" class="text-danger"></div>
                                    </div>

                                </div>

                                <button type="submit" id="submit-button" class="btn btn-primary mt-4">Lưu thông
                                    tin</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const inputElement = document.querySelector('input[name="image[]"]');
                const pond = FilePond.create(inputElement);
                const imagePaths = @json($images);

                pond.setOptions({
                    server: {
                        process: {
                            url: '/system/borderline-result/uploadfile?treatment_id={{ $MedicalRecord->treatment_id }}&service_id={{ $MedicalRecord->service_id }}',
                            method: 'post',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        },
                    },

                    labelIdle: `Tối đa 1MB <span class="filepond--label-action">Chọn tệp</span>`,
                    acceptedFileTypes: ['image/jpeg', 'image/png'],
                    maxFileSize: 1 * 1024 * 1024, // 1MB in bytes
                    labelMaxFileSize: '1 MB',
                    imagePreviewHeight: 200,
                    allowMultiple: true,
                    instantUpload: false,
                });

                pond.on('removefile', function(error, file) {
                    if (error) {
                        console.error('Error removing file:', error);
                        return;
                    }

                    // Gọi API revert để xóa file trên server
                    fetch(`/system/borderline-result/revertfile?treatment_id={{ $MedicalRecord->treatment_id }}&file_name=${file.filename}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                console.log(`File ${file.id} reverted successfully.`);
                            } else {
                                console.error(`Failed to revert file ${file.id}.`);
                            }
                        })
                        .catch(error => {
                            console.error('Error during revert file:', error);
                        });
                });

                const submitButton = document.querySelector("#submit-button");
                submitButton.addEventListener("click", function() {
                    pond.processFiles();
                });

                $.ajax({
                    url: '/system/borderline-result/fetch-images',
                    method: 'POST',
                    data: {
                        image_paths: imagePaths,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        response.images.forEach(image => {
                            fetch(image.url)
                                .then(response => response.blob())
                                .then(blob => {
                                    const mimeType = blob.type;
                                    const file = new File([blob], image.name, {
                                        type: mimeType
                                    });

                                    pond.addFile(file).then(() => {
                                        console.log('File added successfully:', image
                                            .name);
                                    }).catch(error => {
                                        console.error('Error adding file:', error);
                                    });
                                })
                                .catch(error => {
                                    console.error('Error fetching image:', error);
                                });
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching images:', error);
                    }
                });
            });
        </script>

        <script>
            $('#treatmentForm').on('submit', function(event) {
                event.preventDefault(); // Ngừng hành động submit mặc định của form

                var formData = new FormData(this); // Lấy dữ liệu của form, bao gồm file

                $('#image-error').text('');
                $('#note-error').text('');
                $('#result-error').text('');

                $.ajax({
                    url: $(this).attr('action'), // Lấy URL từ thuộc tính action của form
                    method: 'POST', // Phương thức POST
                    data: formData, // Dữ liệu form gửi đi
                    processData: false, // Không xử lý dữ liệu
                    contentType: false, // Không thiết lập contentType
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content') // Thêm CSRF token vào header
                    },
                    success: function(response) {
                        toastr.success('Thêm thông tin thành công.'); // Hiển thị thông báo thành công
                        setTimeout(function() {
                            location.reload(); // Tải lại trang sau khi lưu thành công
                        }, 2000);
                    },
                    error: function(xhr) {
                        // Xử lý lỗi khi gửi request
                        let errors = xhr.responseJSON.errors;
                        if (errors.image) {
                            $('#image-error').text(errors.image[0]); // Hiển thị lỗi cho file
                        }
                        if (errors.note) {
                            $('#note-error').text(errors.note[0]); // Hiển thị lỗi cho mô tả
                        }
                        if (errors.result) {
                            $('#result-error').text(errors.result[0]); // Hiển thị lỗi cho kết quả
                        }
                    }
                });
            });
        </script>
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
