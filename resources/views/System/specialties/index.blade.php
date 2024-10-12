@extends('layouts.admin.master')
@section('title', 'Quản lý chuyên khoa')
@section('content')
    <div class="card w-100">
        <div class="card-body p-4">
            <div class="col-md-12 d-flex justify-content-around align-items-center">
                <div class="col-md-12 d-flex justify-content-center align-items-center">
                    <div class="col-md-4">
                        <h5 class="card-title fw-semibold mb-4">Quản lý chuyên khoa</h5>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-success mb-4" onclick="openModalCreate()">Thêm</button>
                    </div>
                    <div class="col-md-3 d-flex justify-content-end mb-4">
                        <div class="w-100">
                            <input type="text" id="inputName" class="form-control"
                                   placeholder="Tìm kiếm chuyên khoa" name="nameSpecialty">
                        </div>
                    </div>
                </div>
            </div>

            <table class="table text-nowrap mb-0 align-middle">
                <thead class="text-dark fs-4">
                <tr class="text-center">
                    <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0">ID</h6>
                    </th>
                    <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0">Tên chuyên khoa</h6>
                    </th>
                    {{--                    <th class="border-bottom-0">--}}
                    {{--                        <h6 class="fw-semibold mb-0">Số lượng bác sĩ</h6>--}}
                    {{--                    </th>--}}
                    <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0">Thao tác</h6>
                    </th>
                </tr>
                </thead>
                @php
                    $count = 1;
                @endphp
                <tbody id="myTable">
                @foreach($specialties as $specialty)
                    <tr class="text-center">
                        <td class="border-bottom-0">{{$count++}}</td>
                        <td class="border-bottom-0">{{$specialty->name}}</td>
                        {{--                        <td class="border-bottom-0">--}}
                        {{--                            {{$specialty->doctors_count }}--}}
                        {{--                        </td>--}}
                        <td class="border-bottom-0">
                            <a href="{{ route('system.detail', $specialty->specialty_id) }}" class="btn btn-primary">
                                <i class="ti ti-notes"></i>
                            </a>
                            <a href="javascript:void(0)"
                               class="btn btn-primary " onclick="openModalEdit('{{ $specialty->specialty_id }}')"><i
                                    class="ti ti-pencil"></i></a>
                            <form action="{{route('system.delete', $specialty->specialty_id)}}"
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
                </tbody>
            </table>
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
                    <form id="specialty-form">
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Tên chuyên khoa:</label>
                            <input type="text" name="name"
                                   class="form-control" id="specialtyName" value="">
                            <span class="text-danger" id="name-error"></span>
                        </div>
                        <div class="mb-3">
                            <input class="form-check-input" type="checkbox" value=""
                                   name="status" id="specialtyStatus">
                            <label class="form-check-label" for="confirmation-check">Xác nhận</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary" id="save-btn">Lưu</button>
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
                    <form id="specialty-form">
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Tên chuyên khoa:</label>
                            <input type="text" name="nameEdit"
                                   class="form-control" id="specialtyNameEdit" value="">
                            <input type="text" name="specialty_id" id="specialty_id" hidden>
                            <span class="text-danger" id="name-error"></span>
                        </div>
                        <div class="mb-3">
                            <input class="form-check-input" type="checkbox" value=""
                                   name="statusEdit" id="specialtyStatusEdit">
                            <label class="form-check-label" for="confirmation-check">Xác nhận</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="save-btn-edit">Lưu</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function openModalCreate() {
            $('#exampleModal').modal('show');
        }

        $('#save-btn').click(function () {
            console.log('aaaa')
            const specialtyName = $('#specialtyName').val();
            const specialtyStatus = $('#specialtyStatus').is(':checked') ? 1 : 0;
            // console.log(specialtyName);

            // Kiểm tra lỗi
            if (specialtyName === "") {
                $('#name-error').text("Tên chuyên khoa không được để trống");
                return;
            } else {
                $('#name-error').text("");
            }
            $.ajax({
                url: '/system/specialties/create',
                type: 'POST',
                data: {
                    'name': specialtyName,
                    'status': specialtyStatus,
                    '_token': '{{ csrf_token() }}'
                },
                success: function (response) {
                    console.log(response);
                    $('#exampleModal').modal('hide');
                    location.reload();
                },
                error: function (error) {
                    if (error.status === 422) {
                        let errors = error.responseJSON.errors;
                        if (errors.name) {
                            $('#name-error').text(errors.name[0]);
                        }
                    } else {
                        console.error(error);
                    }
                }
            });
        });
        $(document).ready(function () {

        });

        function openModalEdit(id) {
            $('#exampleModalEdit').modal('show');
            console.log(id);
            $.ajax({
                url: '/system/specialties/edit/' + id,
                type: 'GET',
                success: function (response) {
                    if (response.nameEdit && response.statusEdit) {
                        console.log(response)
                        $('#specialtyNameEdit').val(response.nameEdit);
                        $('#specialtyStatusEdit').prop('checked', response.statusEdit == 1);
                        $('#exampleModalEdit').data('id', id);
                    } else {
                        console.error('Missing data in response:', response);
                    }
                },
                error: function (error) {
                    console.error(error);
                }
            })
        }

        $('#save-btn-edit').click(function () {
            var id = $('#exampleModalEdit').data('id');
            // console.log('Đây là id:',id);
            const specialtyName = $('#specialtyNameEdit').val();
            const specialtyStatus = $('#specialtyStatusEdit').is(':checked') ? 1 : 0;

            console.log(specialtyName, specialtyStatus);

            $.ajax({
                url: '/system/specialties/update/' + id,
                type: 'PATCH',
                data: {
                    nameEdit: specialtyName,
                    statusEdit: specialtyStatus,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    $('#exampleModalEdit').modal('hide');
                    if (response.success) {
                        toastr.success(response.message);
                        location.reload();
                    } else if (response.error) {
                        toastr.error(response.message);
                    }
                },
                error: function (err) {
                    console.error("Error updating data:", err);
                    alert('Có lỗi xảy ra: ' + err.responseJSON.error);
                }
            });
        });


    </script>

@endsection
