@extends('layouts.admin.master')

@section('content')
    <div class="card w-100">
        <div class="card-body p-4">
            <div class="col-md-12 d-flex justify-content-around align-items-center">
                <div class="col-md-12 d-flex justify-content-center align-items-center">
                    <div class="col-md-4">
                        <h5 class="card-title fw-semibold mb-4">Quản lý lịch khám</h5>
                    </div>
                    <div class="col-md-8 d-flex justify-content-end">
                        <form action="" class="col-md-12 row">
                            <div class="col-md-6">
                                <input type="text" id="inputName" class="form-control" placeholder="Họ tên" name="name">
                            </div>
                            <div class="col-md-6">
                                <input type="text" id="inputPhone" class="form-control" placeholder="SDT" name="phone">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table text-nowrap mb-0 align-middle">
                    <thead class="text-dark fs-4">
                    <tr>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">ID</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Họ tên</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">SDT</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Trạng thái</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Thao tác</h6>
                        </th>
                    </tr>
                    </thead>
                    <tbody id="myTable">
                    @php
                        $count = 1;
                    @endphp
                    @foreach( $book as $item)
                        <tr>
                            <td class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">{{ $count++ }}</h6>
                            </td>
                            <td class="border-bottom-0">
                                <p class="mb-0 fw-semibold">{{ $item->name }}</p>
                            </td>
                            <td class="border-bottom-0">
                                <span class="fw-semibold mb-0">{{ '0'.$item->phone }}</span>
                            </td>
                            <td class="border-bottom-0">
                                <span class="fw-semibold mb-0">
                                    @if( $item->status === 0)
                                        <span class="badge bg-danger">Chưa khám</span>
                                    @elseif($item->status === 1)
                                        <span class="badge bg-success">Đã khám</span>
                                    @else
                                        <span class="badge bg-warning">Hủy</span>
                                    @endif
                                </span>
                            </td>
                            <td class="border-bottom-0 d-flex">

                                <a href="javascript:void(0)"
                                   class="btn btn-primary me-1" onclick="openModal('{{ $item->book_id }}')"><i
                                        class="ti ti-pencil"></i></a>
                                <form action="{{ route('system.deleteAppointmentSchedule', $item->book_id) }}"
                                      id="form-delete{{ $item->book_id }}" method="post">
                                    @method('delete')
                                    @csrf
                                </form>
                                <button type="submit" class="btn btn-danger btn-delete" data-id="{{$item->book_id }}">
                                    <i class="ti ti-trash"></i>
                                </button>
                                <a class="btn btn-warning ms-1" data-bs-toggle="collapse"
                                   href="#collapse{{ $item->book_id }}" role="button" aria-expanded="false"
                                   aria-controls="collapse{{ $item->book_id }}">
                                    Chi tiết
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <div class="collapse" id="collapse{{ $item->book_id }}">
                                    <div class="card card-body ">
                                        <h6 class="fw-semibold mb-2 fs-5">Thông tin chi tiết:</h6>
                                        <div class="col-md-12 row align-items-center">
                                            <!-- Phần ảnh đại diện -->
                                            <div class="col-md-4 text-center">
                                                <img
                                                    src="{{ $item->avatar ? $item->avatar : asset('backend/assets/images/profile/user-1.jpg') }}"
                                                    alt="Ảnh đại diện bác sĩ" class="img-fluid rounded-circle"
                                                    style="width: 150px; height: 150px; object-fit: cover;">
                                            </div>
                                            <div class="col-md-4">
                                                <ul class="list-unstyled mb-0">
                                                    <li><strong>Tên bác sĩ:</strong> {{ $item->lastname }}
                                                        {{ $item->firstname }}</li>
                                                    <li><strong>Chuyên khoa:</strong> {{ $item->specialtyName }}
                                                    </li>
                                                    <li><strong>Số điện thoại:</strong> {{ $item->phone }}</li>
                                                    <li><strong>Phòng khám:</strong> {{ $item->sclinicsName }}</li>
                                                    <li><strong>Thời gian khám:</strong>
                                                        {{ Carbon\Carbon::parse($item->day)->format('d/m/Y') }} {{ Carbon\Carbon::parse($item->day)->format('H:i:s') }}
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-4 text-start">
                                                <ul class="list-unstyled mb-0">
                                                    <li><strong>Trạng thái:</strong>
                                                        @if($item->status === 0)
                                                            <span class="badge bg-danger">Chưa khám</span>
                                                        @elseif( $item->status === 2)
                                                            <span class="badge bg-warning">Hủy</span>
                                                        @else
                                                            <span class="badge bg-success">Xác nhận</span>
                                                        @endif
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {!! $book->links() !!}
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Chi tiết lịch khám</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Thời gian khám:</label>
                                <input type="datetime-local" name="selectedDay" class="form-control" id="selectedDay" value="">
                            </div>
                            <div class="mb-3">
                                <label for="doctor_name" class="col-form-label">Bác sĩ:</label>
                                <select class="form-control" id="doctor_name" name="doctor_name"></select>
                                <input type="text" name="specialty_id" id="specialty_id" hidden>
                            </div>
                            <div class="mb-3">
                                <input class="form-check-input" type="checkbox" value="" id="confirmation-check">
                                <label class="form-check-label" for="confirmation-check">Xác nhận</label>
                            </div>
                            <div class="mb-3">
                                <input class="form-check-input" type="checkbox" value="" id="cancelstatus-check">
                                <label class="form-check-label" for="cancel-check">Hủy</label>
                            </div>
                        </form>
                        <script>
                            document.addEventListener('DOMContentLoaded', (event) => {
                                const now = new Date();
                                const formattedDateTime = now.toISOString().slice(0, 16);
                                document.getElementById('appointment-time').value = formattedDateTime;
                            });
                        </script>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-primary" id="save-btn">Lưu</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            // $('#doctor_name').on('change', function() {
            //     var selectedUserId = $(this).val();
            //     console.log("User ID được chọn:", selectedUserId);
            // });
            function openModal(id) {
                console.log('openModal: id:', id);
                var selectedDay = $('#selectedDay').val();
                var selectedSpecialtyId = $('#specialty_id').val();
                $.ajax({
                    url: '/system/appointmentSchedules/edit/' + id,
                    type: 'GET',
                    success: function (response) {
                        console.log(response)

                        $('#selectedDay').val(response.appointment_time);
                        $('#doctor_name').empty();

                        response.doctors.forEach(function (doctor) {

                            if (doctor.user_id === response.doctor_name.user_id) {
                                $('#doctor_name').append(
                                    $('<option>', {
                                        value: doctor.user_id,
                                        text: response.doctor_name.lastname + ' ' + response.doctor_name.firstname,
                                        selected: true
                                    })
                                );
                            } else if (doctor.specialty_id === response.doctor_name.specialty_id) {
                                $('#doctor_name').append(
                                    $('<option>', {
                                        value: doctor.user_id,
                                        text: doctor.lastname + ' ' +  doctor.firstname,
                                    })
                                );
                            } else {
                                $('#doctor_name').append(
                                    $('<option>', {
                                        value: doctor.user_id,
                                        text: doctor.lastname + ' ' +  doctor.firstname,
                                    })
                                );
                            }
                            console.log(doctor.user_id);
                        });

                        $('#confirmation-check').prop('checked', response.status === 1);
                        $('#cancelstatus-check').prop('checked', response.status === 2);
                        $('#exampleModal').data('id', id);
                        $('#exampleModal').modal('show');
                        // location.reload();
                    },
                    error: function (err) {
                        console.error("Lỗi khi lấy dữ liệu:", err);
                    }
                });
            }

            $('#save-btn').click(function () {
                var id = $('#exampleModal').data('id');
                // console.log(id);
                var appointmentTime = $('#selectedDay').val();
                var doctorName = $('#doctor_name').val();
                var confirmation = $('#confirmation-check').is(':checked');
                var cancel = $('#cancelstatus-check').is(':checked');
                var status = cancel ? 2 : (confirmation ? 1 : 0);

                console.log(doctorName)
                console.log(status)
                console.log(appointmentTime)
                $.ajax({
                    url: '/system/appointmentSchedules/update/' + id,
                    type: 'patch',
                    data: {
                        appointment_time: appointmentTime,
                        doctor_name: doctorName,
                        status: status,
                        _token: '{{ csrf_token() }}'
                    },

                    success: function (response) {
                        $('#exampleModal').modal('hide');

                        if (response.success) {
                            toastr.success(response.message);
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
