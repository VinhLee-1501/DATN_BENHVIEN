@extends('layouts.admin.master')
@section('content')
    <style>
        /* Đặt lại kích thước và định dạng cho calendar */
        #calendar {
            font-family: Arial, sans-serif;
        }

        /* Định dạng toolbar (thanh công cụ) */
        .fc-toolbar {
            background-color: #ffffff;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .fc-left,
        .fc-center,
        .fc-right {
            font-size: 14px;
            color: #333;
        }

        /* Nút trên thanh công cụ */
        .fc-button {
            padding: 8px 16px;
            margin: 0 5px;
            background-color: #1a252f;
            /* Màu nền nút chính */
            color: white;
            /* Màu chữ trắng */
            border: none;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .fc-button:hover {
            background-color: #94e5be;
            /* Màu nền khi hover (xanh nhạt) */
        }

        .fc-button.fc-state-active {
            background-color: #048647;
            /* Màu active */
            color: white;
        }

        /* Định dạng tiêu đề tháng */
        .fc-center h2 {
            font-size: 20px;
            color: #333;
            font-weight: bold;
        }

        /* Các ngày trong tháng */
        .fc-day-header {
            background-color: #f1f1f1;
            text-align: center;
            padding: 10px;
            color: #333;
        }

        /* Các ngày trong tuần */
        .fc-day-header span {
            font-size: 14px;
            color: #333;
        }

        /* Các ngày trong lịch */
        .fc-day {
            text-align: center;
            padding: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .fc-day:hover {
            background-color: #e8f9f1;
            /* Màu nền khi hover */
        }

        .fc-day.fc-other-month {
            background-color: #EEEEEE !important;
            color: #aaa !important;
        }

        .fc-day.fc-future {
            background-color: #ffffff;
        }

        .fc-day.fc-today {
            background-color: #048647;
            /* Màu nền cho ngày hôm nay */
            font-weight: bold;
            color: white;
            /* Màu chữ trắng cho ngày hôm nay */
        }

        /* Chỉnh sửa chiều cao của các hàng */
        .fc-row.fc-week {
            height: 132px;
        }

        .fc-content-skeleton table td {
            padding: 5px;
        }

        .fc-button-active {
            background-color: #048647 !important;
        }

        .fc-button-primary:disabled {
            background-color: #048647 !important;
        }

        .fc-view-container {
            overflow-x: auto;
            /* Cho phép cuộn ngang */
            -webkit-overflow-scrolling: touch;
            /* Cải thiện cuộn trên thiết bị di động */
        }

        /* Điều chỉnh khi màn hình nhỏ hơn */
        @media (max-width: 768px) {


            .fc-toolbar {
                flex-direction: column;
                text-align: center;
            }

            .fc-view-container {
                overflow-x: auto !important;
            }

            .fc-left,
            .fc-center,
            .fc-right {
                float: none;
                width: 100%;
            }

            .fc-button-group {
                display: flex;
                justify-content: center;
            }

            .fc-button {
                margin: 5px;
            }

            .fc-day-number {
                font-size: 12px;
            }
        }
    </style>

    <div class="card w-100">
        <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-4">Quản lý lịch làm việc bác sĩ</h5>
            <div class="mb-4">
                <select id="specialty-filter" name="specialty_id" class="form-control">
                    <option value="">Chọn chuyên khoa</option>
                    @foreach ($specialties as $specialty)
                        <option value="{{ $specialty->specialty_id }}">{{ $specialty->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="table-responsive">
                <div id="calendar">

                </div>
            </div>

            {{-- Modal form create value to database at table schedules --}}
            <div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Thêm lịch bác sĩ</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Thời gian khám:</label>
                                    <input type="date" name="day" class="form-control" id="daySelect" value="">
                                </div>
                                <div class="col-md-12 row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="" class="col-form-label">Bác sĩ:</label>
                                            <select class="form-control" id="username" name="user_id">
                                            </select>
                                            <input type="text" name="specialty_id" id="specialty_id" hidden>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="" class="col-form-label">Phòng khám:</label>
                                            <select class="form-control" id="clinicsId" name="sclicnic"></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Ghi chú:</label>
                                    <textarea name="note" id="note" class="form-control"></textarea>
                                    <span class="invalid-feedback" id="note_error"></span>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="status" id="cancelstatusCheck">
                                    <label class="form-check-label" for="cancelstatus-check">
                                        Khám trực tuyến
                                    </label>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="button" class="btn btn-primary" id="btn-save">Lưu</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- End modal create value to database at table schedules --}}

            {{-- Modal form update value to row at schedules table --}}
            <div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Sửa lịch bác sĩ</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Thời gian khám:</label>
                                    <input type="date" name="day" class="form-control" id="daySelect" value="">
                                    <input type="hidden" name="shift_id" class="form-control" id="shift_id"
                                        value="">
                                </div>
                                <div class="col-md-12 row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="" class="col-form-label">Bác sĩ:</label>
                                            <select class="form-control" id="usernameEdit" name="user_id"
                                                readonly></select>
                                            <input type="hidden" name="userId" id="userId" value="">
                                            <input type="text" name="specialty_id" id="specialty_id" hidden>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="" class="col-form-label">Phòng khám:</label>
                                            <select class="form-control" id="clinicsId" name="sclinic_id"></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Ghi chú:</label>
                                    <textarea name="note" id="noteEdit" class="form-control"></textarea>
                                    {{-- <span class="invalid-feedback" id="note_error"></span> --}}
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="check"
                                        id="cancelstatusCheckEdit">
                                    <label class="form-check-label" for="cancelstatus-check">
                                        Xác nhận
                                    </label>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="button" class="btn btn-primary" id="btn-edit">Lưu</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- End modal form update value to row at schedules table --}}
        </div>
    </div>

    <script>
        // hiển thị danh sách bác sĩ theo chuyên khoa
        function loadDoctor(specialty_id) {

            $.ajax({
                url: '/system/schedules/doctor',
                type: 'GET',
                data: {
                    specialty_id: specialty_id
                },
                success: function(response) {
                    // console.log(response);
                    $('#username').empty();
                    response.users.forEach(function(user) {
                        $('#username').append(
                            $('<option>', {
                                value: user.user_id,
                                text: user.lastname + ' ' + user.firstname
                            })
                        );
                    })
                },
                error: function(err) {
                    console.error("Error fetching doctors:", err);
                }
            });
        }

        // Hiển thị dnah sách phòng
        function loadClinic(selectedClinicId, specialty_id) {
            return $.ajax({
                url: '/system/schedules/clinic',
                type: 'GET',
                data: {
                    specialty_id: specialty_id
                },
                success: function(response) {
                    // console.log(response);
                    $('#clinicsId').empty();
                    response.clinics.forEach(function(clinic) {
                        var option = $('<option>', {
                            value: clinic.sclinic_id,
                            text: clinic.name
                        });
                        if (clinic.sclinic_id === selectedClinicId) {
                            option.prop('selected', true);
                        }
                        $('#clinicsId').append(option);
                    });
                },
                error: function(err) {
                    console.error("Error fetching clinics:", err);
                }
            });
        }

        // Format thời gian
        function formatDate(date) {
            var d = new Date(date);
            d.setMinutes(d.getMinutes() - d.getTimezoneOffset());
            return d.toISOString().split('T')[0];
        }

        // thực hiện các method và sự kiện bên trong klhi DOM được tải.
        $(document).ready(function() {
            loadDoctor('');
            loadClinic();

            $('#specialty-filter').on('change', function() {
                var specialtyId = $(this).val();
                document.getElementById('specialty_id').value = specialtyId;
                loadDoctor(specialtyId);
                loadClinic(specialtyId, specialtyId);

            });
        });

        // Cập nhật ngày khám bác sĩ
        function showEditPopup(eventId, newDay, userId, sclinicId, note, status) {
            $.ajax({
                url: '/system/schedules/edit/' + eventId,
                type: 'GET',
                success: function(response) {
                    $('#editEventModal #daySelect').val(newDay);
                    $('#editEventModal #userId').val(userId);
                    $('#editEventModal #shift_id').val(eventId);
                    $('#editEventModal #cancelstatusCheckEdit').prop(':checked', status);

                    // console.log(userId);

                    // Populate the clinics dropdown
                    $('#editEventModal #clinicsId').empty();
                    response.sclinic.forEach(function(clinic) {
                        var option = $('<option>', {
                            value: clinic.sclinic_id,
                            text: clinic.name
                        });
                        if (clinic.sclinic_id === sclinicId) {
                            option.prop('selected', true);
                        }
                        $('#editEventModal #clinicsId').append(option);
                    });

                    $('#userId').empty();
                    // console.log(response.user);

                    if (response.user) {
                        var user = response.user;
                        // console.log(user.firstname);
                        $('#usernameEdit').empty();
                        $('#usernameEdit').append(
                            $('<option>', {
                                value: user.user_id,
                                text: user.lastname + ' ' + user.firstname,
                                selected: true
                            })
                        );

                    } else {
                        console.error("response.user is null or undefined");
                    }

                    if (Array.isArray(response.user)) {
                        response.user.forEach(function(item) {
                            var option = $('<option>', {
                                value: item.user_id,
                                text: item.lastname + ' ' + item.firstname,
                                selected: item.user_id === userId
                            });
                            $('#userId').append(option);
                        });
                    }

                    // $('#editEventModal #noteEdit').val(response.schedules.note || note);
                    $('#editEventModal').modal('show');
                },
                error: function(err) {
                    console.error("Error fetching data:", err);
                }
            });

            // Thực hiện event cập nhật
            $('#btn-edit').off('click').on('click', function() {
                var eventId = $('#editEventModal #shift_id').val();
                var daySelect = $('#editEventModal #daySelect').val();
                var userId = $('#editEventModal #userId').val();
                var clinicId = $('#editEventModal #clinicsId').val();
                var note = $('#editEventModal #noteEdit').val();
                var confirmationCheck = $('#editEventModal #cancelstatusCheckEdit').is(':checked');
                var specialty = $('#specialty-filter').val();

                $.ajax({
                    url: '/system/schedules/update/' + eventId,
                    type: 'PATCH',
                    data: {
                        specialty_id: specialty,
                        day: daySelect,
                        user_id: userId,
                        sclinic_id: clinicId,
                        note: note,
                        status: confirmationCheck ? 1 : 0,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#editEventModal').modal('hide');
                        if (response.success) {
                            toastr.success(response.message);
                            calendar.refetchEvents();
                        } else if (response.error) {
                            toastr.error(response.message);
                        }
                    },
                    error: function(err) {
                        console.error("Error updating data:", err);
                        alert('Có lỗi xảy ra: ' + (err.responseJSON.message || 'Unknown error'));
                    }
                });
            });
        }

        // Thư viện fullCalendar
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'vi',
                buttonText: {
                    today: 'Hôm nay',
                    month: 'Tháng',
                    week: 'Tuần',
                    day: 'Ngày'
                },
                allDayText: 'Cả ngày',
                plugins: ['dayGrid', 'interaction'],
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,dayGridWeek'
                },
                // Event truy xuất dữ liệu
                events: function(fetchInfo, successCallback, failureCallback) {
                    var specialtyId = document.getElementById('specialty-filter').value;
                    //  (specialtyId);
                    if (specialtyId) {
                        $.ajax({
                            url: '/system/schedules/data',
                            dataType: 'json',
                            data: {
                                specialty_id: specialtyId
                            },
                            success: function(data) {
                                // Lưu thông tin bác sĩ và phòng khám cho mỗi ngày

                                successCallback(data);
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                            }
                        });
                    } else {
                        successCallback([]);
                    }
                },
                editable: true,
                eventClick: function(info) {
                    // Kiểm tra xem người dùng có bấm vào phần tử có class "delete-event"
                    const target = $(info.jsEvent.target);
                    
                    if (target.hasClass('delete-event')) {
                        // Nếu là tiêu đề xóa, hiển thị popup xóa
                        var eventId = info.event.id;
                        // Gọi hàm để hiển thị popup xóa
                        showDeletePopup(eventId);
                    } else {
                        // Nếu không phải tiêu đề xóa, hiển thị popup edit
                        var eventId = info.event.id;
                        var newDay = formatDate(info.event.start);
                        var userId = info.event.extendedProps.user_id;
                        var sclinicId = info.event.extendedProps.sclinic_id;
                        var note = info.event.extendedProps.note;
                        var status = info.event.extendedProps.status;
                        // Hiển thị popup edit cho sự kiện này
                        showEditPopup(eventId, newDay, userId, sclinicId, note, status);
                    }
                },


                // Event cập nhật dữ liệu
                eventDrop: function(info) {

                    const today = new Date();
                    const selectedDate = new Date(info.event.start);

                    // Check if the new date is in the past
                    if (selectedDate < today) {
                        info.revert();
                        alert('Không thể di chuyển sự kiện vào ngày trong quá khứ.');
                        return;
                    }

                    var userId = info.event.extendedProps.user_id;
                    var newDay = formatDate(info.event.start);
                    var sclinicId = info.event.extendedProps.sclinic_id;
                    // console.log(userId, newDay, sclinicId);

                    const eventsOnSameDay = calendar.getEvents().filter(event =>
                        formatDate(event.start) === newDay && event.id !== info.event.id
                    );

                    // Ensure max 3 doctors per day
                    if (eventsOnSameDay.length >= 3) {
                        info.revert();
                        alert('Chỉ có thể lên lịch tối đa 3 bác sĩ cho mỗi ngày.');
                        return;
                    }

                    // Ensure doctor is only assigned to one clinic on the same day
                    const doctorInAnotherClinic = eventsOnSameDay.some(event =>
                        event.extendedProps.user_id === userId
                    );
                    if (doctorInAnotherClinic) {
                        info.revert();
                        alert('Bác sĩ này đã được lên lịch cho phòng khác vào ngày này.');
                        return;
                    }

                    if (userId && sclinicId) {
                        showEditPopup(info.event.id, newDay, userId, sclinicId);
                    } else {
                        console.error("Missing event data:", {
                            userId,
                            sclinicId
                        });
                    }
                },
                // Event truy xuất dữ liệu, hiển thị thông tin item
                eventRender: function(info) {
                    // console.log(doctorData);
                    if (new Date(info.dateStr) < new Date()) {
                        alert('Bạn không thể thêm sự kiện vào ngày trước ngày hiện tại.');
                        return;
                    }

                    var doctorData = info.event.extendedProps.doctorData;
                    // Lấy thông tin bác sĩ và phòng khám từ doctorData
                    var doctorName = '';
                    var clinicName = '';
                    if (doctorData) {
                        var doctorInfo = doctorData.find(function(item) {
                            return item.user_id === info.event.extendedProps.user_id;
                        });
                        if (doctorInfo) {
                            // Hiển thị thông tin bác sĩ và phòng khám
                            doctorName = info.event.title;
                            clinicName = 'Phòng khám: ' + doctorInfo.sclinic_id;
                        }
                    }
                    info.el.querySelector('.fc-title').innerHTML =
                        '<b class="delete-event" data-event-id="' + info.event.id + '">' + info.event
                        .title + '</b><br>' +
                        'SDT: ' + info.event.extendedProps.phone + '<br>' +
                        'CK: ' + info.event.extendedProps.specialty_name + '<br>' +
                        'TT: ' + (info.event.extendedProps.status == 1 ? 'Trực tuyến' : 'Trực tiếp');
                },
                // Event thêm dữ liệu
                dateClick: function(info) {
                    if (new Date(info.dateStr) < new Date()) {
                        alert('Bạn không thể thêm sự kiện vào ngày trước ngày hiện tại.');
                        return;
                    }

                    var eventsOnSameDay = calendar.getEvents().filter(function(event) {
                        return formatDate(event.start) === info.dateStr;
                    });

                    if (eventsOnSameDay.length >= 3) {
                        alert('Chỉ có thể lên lịch tối đa 3 bác sĩ cho mỗi ngày.');
                        return;
                    }

                    $('#addEventModal').modal('show');
                    $('#daySelect').val(info.dateStr);
                    $('#btn-save').off('click').click(function() {
                        var daySelect = $('#daySelect').val();
                        var userId = $('#username').val();
                        var clinicId = $('#clinicsId').val();
                        var note = $('#note').val();
                        var status = $('#cancelstatusCheck').is(
                            ':checked');

                        var specialty = $('#specialty-filter').val();

                        if (!specialty) {
                            alert('Vui lòng chọn chuyên khoa.');
                            return;
                        }
                        $.ajax({
                            url: '/system/schedules/create',
                            type: 'POST',
                            data: {
                                specialty_id: specialty,
                                day: daySelect,
                                user_id: userId,
                                sclinic: clinicId,
                                note: note,
                                status: status ? 1 : 0,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                // console.log(respone);
                                $('#addEventModal').modal('hide');
                                if (response.success) {
                                    toastr.success(response.message);
                                    calendar.refetchEvents();
                                } else if (response.error) {
                                    toastr.error(response.message);
                                }
                                // location.reload();
                            },
                            error: function(err) {
                                if (err.responseJSON && err.responseJSON
                                    .errors) {
                                    let errors = err.responseJSON.errors;

                                    $('.invalid-feedback').text('');
                                    $('.form-control').removeClass('is-invalid');
                                    $.each(errors, function(key, value) {
                                        $('#' + key).addClass('is-invalid');
                                        $('#' + key + '_error').text(value[
                                            0]);
                                    });
                                } else {
                                    console.error(error);
                                }
                            }
                        });
                    });
                }
            });
            calendar.render();
            $('#btn-edit').off('click').on('click', function() {
                var eventId = $('#editEventModal #shift_id').val();
                var daySelect = $('#editEventModal #daySelect').val();
                var userId = $('#editEventModal #userId').val();
                var clinicId = $('#editEventModal #clinicsId').val();
                var note = $('#editEventModal #noteEdit').val();
                var confirmationCheck = $('#editEventModal #cancelstatusCheckEdit').is(':checked');


                $.ajax({
                    url: '/system/schedules/update/' + eventId,
                    type: 'PATCH',
                    data: {
                        day: daySelect,
                        user_id: userId,
                        sclinic_id: clinicId,
                        note: note,
                        status: confirmationCheck ? 1 : 0,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#editEventModal').modal('hide');
                        if (response.success) {
                            toastr.success(response.message);
                            calendar.refetchEvents();
                        } else if (response.error) {
                            toastr.error(response.message);
                        }
                    },
                    error: function(err) {
                        console.error("Error updating data:", err);
                        alert('Có lỗi xảy ra: ' + (err.responseJSON.message ||
                            'Unknown error'));
                    }
                });
            });

            // Chức năng xóa event
            function showDeletePopup(eventId) {
                $(document).on('click', '.delete-event', function() {
                    var eventId = $(this).data('event-id');
                    Swal.fire({
                        title: "Bạn có chắc muốn xóa?",
                        text: "Bạn sẽ không thể hoàn tác lại",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Đồng ý"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '/system/schedules/delete/' + eventId,
                                type: "DELETE",
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    if (response.success) {
                                        toastr.success(response.message);
                                        calendar.refetchEvents();
                                    } else {
                                        toastr.error(response.message);
                                    }
                                },
                                error: function(err) {
                                    alert('Có lỗi xảy ra: ' + (err.responseJSON
                                        .message ||
                                        'Không thấy lỗi'));
                                }
                            });
                        }
                    });
                });
            }

            document.getElementById('specialty-filter').addEventListener('change', function() {
                calendar.refetchEvents();
            });
        });
    </script>
@endsection
