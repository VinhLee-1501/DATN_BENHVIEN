@extends('layouts.admin.master')

@section('content')
    <div class="card-body">

        <h5 class="card-title fw-semibold mb-4 ">Thêm bài viết</h5>

        <div class="card w-100">
            <div class="card-body p-4">
                <form action="{{ route('system.blogs.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="table-responsive ms-3">
                        <div class="col-md-12 row">
                            <div class="mb-3">
                                <label for="roleSelect" class="form-label">Tiêu đề</label>
                                <input type="text" id="titleInput" name="title" class="form-control"
                                    placeholder="Tiêu đề" value="{{ old('title') }}">
                                @error('title')
                                    <div class="text-danger">*{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 row" id="inputFields">
                            <div class="col-md-9">
                                <div class="mb-3">
                                    <label for="" class="form-label">Nội dung</label>
                                    <textarea id="summernote" name="content">{{ old('content') }}</textarea>
                                    @error('content')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="" class="form-label">Ảnh đại diện</label>
                                    <input type="file" class="filepond" name="thumbnail">
                                    @error('thumbnail')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="describeTextarea" class="form-label">Mô tả</label>
                                    <textarea id="describeTextarea" name="describe" class="form-control" 
                                              placeholder="Mô tả" rows="4" style="overflow-y: scroll;">{{ old('describe') }}</textarea>
                                    @error('describe')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="" class="form-label">Trạng thái</label>
                                    <select class="form-select" id="statusSelect" name="status"
                                        onchange="toggleDateInput()">
                                        <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Chờ xuất bản
                                        </option>
                                        <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Xuất bản</option>
                                    </select>
                                </div>

                                <div class="mb-3" id="dateContainer" style="display:none;">
                                    <label for="" class="form-label">Ngày xuất bản</label>
                                    <input type="date" id="dateInput" name="date" class="form-control"
                                        value="{{ old('date') }}">
                                    @error('date')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Tác giả</label>
                                    <input type="text" id="authorInput" name="author" class="form-control"
                                        value="{{ $user->lastname }} {{ $user->firstname }}" placeholder="Tác giả">
                                    @error('author')
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
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#summernote').summernote({
                    styleTags: [
                        'h2', 'h3', 'h4', 'h5', 'h6'
                    ],
                    codemirror: {
                        theme: 'monokai'
                    },
                    lang: 'vi-VN',
                    placeholder: 'Nhập nội dung....',
                    minHeight: 300,
                    focus: true,
                    fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'times new roman'],
                    toolbar: [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough', 'superscript', 'subscript']],
                        ['fontsize', ['fontsize']],
                        ['fontname', ['fontname']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['height', ['height']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']],
                        ['style', ['style']],
                    ],
                    popover: {
                        image: [
                            ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                            ['float', ['floatLeft', 'floatRight', 'floatNone']],
                            ['remove', ['removeMedia']]
                        ],
                        link: [
                            ['link', ['linkDialogShow', 'unlink']]
                        ],
                        table: [
                            ['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']],
                            ['delete', ['deleteRow', 'deleteCol', 'deleteTable']],
                        ],
                        air: [
                            ['color', ['color']],
                            ['font', ['bold', 'underline', 'clear']],
                            ['para', ['ul', 'paragraph']],
                            ['table', ['table']],
                            ['insert', ['link', 'picture']]
                        ]
                    }
                });
            });
        </script>
        <script>
            FilePond.registerPlugin(
                FilePondPluginImagePreview,
                FilePondPluginFileValidateType,
                FilePondPluginFileValidateSize
            );

            const inputElement = document.querySelector('input[type="file"]');
            const pond = FilePond.create(inputElement);

            @if (session('uploaded_file_base64') && $errors->any())
                const uploadedFile = '{{ session('uploaded_file_base64') }}';
                const byteCharacters = atob(uploadedFile);
                const byteNumbers = new Array(byteCharacters.length);
                for (let i = 0; i < byteCharacters.length; i++) {
                    byteNumbers[i] = byteCharacters.charCodeAt(i);
                }
                const byteArray = new Uint8Array(byteNumbers);
                const blob = new Blob([byteArray], {
                    type: 'image/jpeg'
                }); // Đảm bảo đúng loại file
                const file = new File([blob], 'thumbnail.jpg', {
                    type: 'image/jpeg'
                });

                pond.addFile(file);
            @endif
            pond.setOptions({
                server: {
                    process: {
                        url: './uploadfile',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }

                    },
                    revert: {
                        url: './revertfile',
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }
                },
                labelIdle: `Tối đa 500KB <span class="filepond--label-action">Chọn tệp</span>`,
                // acceptedFileTypes: ['image/jpeg', 'image/png'],
                maxFileSize: '500KB',
                imagePreviewHeight: 200,
            });
        </script>
        <script>
            function toggleDateInput() {
                var statusSelect = document.getElementById('statusSelect');
                var dateContainer = document.getElementById('dateContainer');

                if (statusSelect.value == "1") {
                    dateContainer.style.display = "block";
                } else {
                    dateContainer.style.display = "none";
                }
            }

            function setMinDate() {
                var dateInput = document.getElementById('dateInput');
                var tomorrow = new Date();
                tomorrow.setDate(tomorrow.getDate() + 1);

                var dd = String(tomorrow.getDate()).padStart(2, '0');
                var mm = String(tomorrow.getMonth() + 1).padStart(2, '0');
                var yyyy = tomorrow.getFullYear();

                var minDate = yyyy + '-' + mm + '-' + dd;
                dateInput.setAttribute('min', minDate);
            }

            window.onload = function() {
                setMinDate();
                toggleDateInput();
            };
        </script>
    @endpush
@endsection
