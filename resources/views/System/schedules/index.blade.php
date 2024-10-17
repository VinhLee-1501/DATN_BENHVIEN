@extends('layouts.admin.master')
@section('content')
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
                <div id="calendar"></div>
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
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="check" id="cancelstatusCheck">
                                    <label class="form-check-label" for="cancelstatus-check">
                                        Xác nhận
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
                                text: user.lastname + '' + user.firstname
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
        function loadClinic(selectedClinicId) {
            return $.ajax({
                url: '/system/schedules/clinic',
                type: 'GET',
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
                    $('#editEventModal #noteEdit').val(note);
                    $('#editEventModal #cancelstatusCheck').prop(':checked', status);

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

                    $('#editEventModal #noteEdit').val(note);
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
                var confirmationCheck = $('#editEventModal #cancelstatusCheck').is(':checked');

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

                },
                // validRange: {
                //     start: new Date().toISOString().split('T')[0]
                // },

                // Event cập nhật dữ liệu
                eventDrop: function(info) {
                    if (info.event.start < new Date()) {
                        info.revert();
                        alert('Bạn không thể thêm sự kiện vào ngày trước ngày hiện tại.');
                        return false;
                    }

                    var userId = info.event.extendedProps.user_id;
                    var newDay = formatDate(info.event.start);
                    var sclinicId = info.event.extendedProps.sclinic_id;
                    // console.log(userId, newDay, sclinicId);

                    var eventsOnSameDay = calendar.getEvents().filter(function(event) {
                        return formatDate(event.start) === newDay && event.id !== info.event.id;
                    });

                    if (eventsOnSameDay.length > 0) {
                        // If there is already an event on the same day, revert the drop and show an error
                        info.revert();
                        alert('Đã có bác sĩ được lên lịch vào ngày này. Vui lòng chọn ngày khác.');
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
                    info.el.querySelector('.fc-title').innerHTML =
                        '<b class="delete-event" data-event-id="' + info.event.id + '">' + info.event
                        .title + '</b><br>' +
                        'SDT: ' + info.event.extendedProps.phone + '<br>' +
                        'CK: ' + info.event.extendedProps.specialty_name;
                },
                // Event thêm dữ liệu
                dateClick: function(info) {
                    if (new Date(info.dateStr) < new Date()) {
                        alert('Bạn không thể thêm sự kiện vào ngày trước ngày hiện tại.');
                        return;
                    }


                    $('#addEventModal').modal('show');
                    $('#daySelect').val(info.dateStr);
                    $('#btn-save').off('click').click(function() {
                        var daySelect = $('#daySelect').val();
                        var userId = $('#username').val();
                        var clinicId = $('#clinicsId').val();
                        console.log(clinicId);
                        var note = $('#note').val();
                        var confirmationCheck = $('#cancelstatusCheck').is(
                            ':checked');

                        var eventsOnSameDay = calendar.getEvents().filter(function(event) {
                            return formatDate(event.start) === daySelect;
                        });

                        if (eventsOnSameDay.length > 0) {
                            alert(
                                'Đã có bác sĩ được lên lịch vào ngày này. Vui lòng chọn ngày khác.'
                            );
                            return;
                        }
                        $.ajax({
                            url: '/system/schedules/create',
                            type: 'POST',
                            data: {
                                day: daySelect,
                                user_id: userId,
                                sclinic: clinicId,
                                note: note,
                                status: confirmationCheck ? 1 : 0,
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
                                console.error("Error updating data:",
                                    err);
                                alert('Có lỗi xảy ra: ' + err
                                    .responseJSON.error);
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
                var confirmationCheck = $('#editEventModal #cancelstatusCheck').is(':checked');

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
                                if(response.success){
                                    toastr.success(response.message);
                                    calendar.refetchEvents();
                                }else{
                                    toastr.error(response.message);
                                }
                            },error: function(err){
                                alert('Có lỗi xảy ra: ' + (err.responseJSON.message || 'Không thấy lỗi'));
                            }
                        });
                    } else {
                        return false;
                    }
                });

            })
            document.getElementById('specialty-filter').addEventListener('change', function() {
                calendar.refetchEvents();
            });
        });
    </script>
@endsection
