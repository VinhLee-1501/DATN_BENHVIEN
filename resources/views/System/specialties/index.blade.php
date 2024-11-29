@extends('layouts.admin.master')
@section('title', 'Quản lý chuyên khoa')
@section('content')

<div class="card w-100">
    <div class="card-body p-4">

        <h5 class="card-title fw-semibold mb-4">Quản lý chuyên khoa</h5>

        <form action="{{ route('system.specialty') }}" method="GET" class="row g-1 align-items-center">

            <div class="col-md-4">
                <input type="text" id="inputName" class="form-control" placeholder="Tìm kiếm chuyên khoa" name="nameSpecialty" value="{{ request('nameSpecialty') }}">
            </div>
            <div class="col-md-4">
                <select class="form-select" name="status" id="status">
                    <option value="">Chọn trạng thái</option>
                    <option value="1" {{ request('status') == 1 ? 'selected' : '' }}>Hoạt động</option>
                    <option value="0" {{ request('status') == 0 ? 'selected' : '' }}>Không hoạt động</option>
                </select>
            </div>


            <div class="col-md-2">
                <button class="btn btn-primary w-100">Tìm kiếm</button>
            </div>
            <div class="col-md-2">
                <a class="btn btn-success w-100" onclick="openModalCreate()">Thêm</a>
            </div>
        </form>

        <!-- </div> -->
        <div class="table-responsive">
            <div class="mt-3">
                {!! $specialties->links() !!}

            </div>
            <table class="table table-bordered text-nowrap mb-0 align-middle">
                <thead class="text-dark fs-4  ">
                    <tr class="text-center">
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">ID</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Tên chuyên khoa</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Trạng thái</h6>
                        </th>

                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Thao tác</h6>
                        </th>
                    </tr>
                </thead>
                @php
                $count = 1;
                @endphp
                <tbody id="myTable">
                    @if($specialties->isEmpty())
                    <div id="noResults" class="alert alert-warning">Không tìm thấy dữ liệu.</div>
                    @else
                    @foreach ($specialties as $specialty)
                    <tr class="text-center">
                        <td class="border-bottom-0">{{ $count++ }}</td>
                        <td class="border-bottom-0">{{ $specialty->name }}</td>
                        <td class="border-bottom-0">
                            @if($specialty->status == 0)
                            <span class="badge bg-danger">Không Hoạt động</span>
                            @elseif($specialty->status == 1)
                            <span class="badge bg-success">Hoạt động</span>
                            @endif
                        </td>

                        <td class="border-bottom-0">
                            <a href="{{ route('system.detail_specialty', $specialty->specialty_id) }}"
                                class="btn btn-primary">
                                <i class="ti ti-notes"></i>
                            </a>
                            <a href="javascript:void(0)" class="btn btn-primary "
                                onclick="openModalEdit('{{ $specialty->specialty_id }}')"><i
                                    class="ti ti-pencil"></i></a>
                            <form action="{{ route('system.delete_specialty', $specialty->specialty_id) }}"
                                id="form-delete{{ $specialty->specialty_id }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('DELETE')
                            </form>
                            <button type="submit" class="btn btn-danger btn-delete"
                                data-id="{{ $specialty->specialty_id }}">
                                <i class="ti ti-trash"></i>
                            </button>

                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            <div class="mt-3">
                {!! $specialties->links() !!}

            </div>

        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm chuyên khoa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addSpecialtyForm">
                        @csrf
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Tên chuyên khoa:</label>
                            <input type="text" name="specialtyName" class="form-control" id="specialtyName">
                            <span class="invalid-feedback" id="specialtyName_error"></span>
                        </div>
                        <div class="mb-3">
                            <input class="form-check-input" type="checkbox" name="specialtyStatus" id="specialtyStatus"
                                value="1">
                            {{-- <input type="hidden" name="specialtyStatus" value="0"> --}}
                            <label class="form-check-label" for="confirmation-check">Xác nhận</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary" id="addSpecialty">Lưu</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm chuyên khoa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateSpecialtyForm">
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Tên chuyên khoa:</label>
                            <input type="text" name="specialtyName" class="form-control" id="specialtyNameEdit"
                                value="">
                            <input type="text" name="specialty_id" id="specialty_id" hidden>

                            <span class="invalid-feedback" id="specialtyName_error"></span>
                        </div>
                        <div class="mb-3">
                            <input class="form-check-input" type="checkbox" value="" name="specialtyStatus"
                                id="specialtyStatusEdit">
                            <label class="form-check-label" for="confirmation-check">Xác nhận</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="updateSpecialty">Lưu</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function openModalCreate() {
            $('#exampleModal').modal('show');
        }

        $(document).ready(function() {

            $('#addSpecialty').click(function(e) {
                e.preventDefault();
                if ($('#specialtyStatus').is(':checked')) {
                    $('#specialtyStatus').val(1);
                } else {
                    $('#specialtyStatus').val(0);
                }
                var formData = $('#addSpecialtyForm').serialize();

                $.ajax({
                    url: '/system/specialties/store',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#exampleModal').modal('hide');
                        if (response.success) {
                            toastr.success(response.message);
                            setTimeout(() => {
                                location.reload();
                            }, 2000)
                        } else if (response.error) {
                            toastr.error(response.message);
                        }
                    },
                    error: function(error) {
                        if (error.responseJSON && error.responseJSON.errors) {
                            let errors = error.responseJSON.errors;

                            $('.invalid-feedback').text('');
                            $('.form-control').removeClass('is-invalid');
                            $.each(errors, function(key, value) {
                                $('#' + key).addClass('is-invalid');
                                $('#' + key + '_error').text(value[0]);
                            });
                        } else {
                            console.error(error);
                        }
                    }
                });
            })
        })
    </script>

    <script>
        function openModalEdit(id) {
            $('#exampleModalEdit').modal('show');
            console.log(id);
            $.ajax({
                url: '/system/specialties/edit/' + id,
                type: 'GET',
                success: function(response) {
                    if (response.specialtyName && response.specialtyStatus !== undefined) {
                        console.log(response)
                        $('#specialtyNameEdit').val(response.specialtyName);
                        $('#specialtyStatusEdit').prop('checked', response.specialtyStatus == 1);
                        $('#exampleModalEdit').data('id', id);
                    } else {
                        console.error('Missing data in response:', response);
                    }
                },
                error: function(error) {
                    console.error(error);
                }
            })
        }

        $('#updateSpecialty').click(function() {
            var id = $('#exampleModalEdit').data('id');

            const specialtyName = $('#specialtyNameEdit').val();
            const specialtyStatus = $('#specialtyStatusEdit').is(':checked') ? 1 : 0;

            $.ajax({
                url: '/system/specialties/update/' + id,
                type: 'PATCH',
                data: {
                    specialtyName: specialtyName,
                    specialtyStatus: specialtyStatus,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#exampleModalEdit').modal('hide');
                    if (response.success) {
                        toastr.success(response.message);
                        setTimeout(() => {
                            location.reload();
                        }, 3000);
                    } else if (response.error) {
                        toastr.error(response.message);
                    }
                },
                error: function(err) {
                    if (err.responseJSON && err.responseJSON.errors) {
                        let errors = err.responseJSON.errors;

                        $('.invalid-feedback').text('');
                        $('.form-control').removeClass('is-invalid');
                        $.each(errors, function(key, value) {
                            $('[name="' + key + '"]').addClass('is-invalid');
                            $('#' + key + '_error').text(value[0]);
                        });
                    } else {
                        console.error(error);
                    }
                }
            });
        });
    </script>

    @endsection