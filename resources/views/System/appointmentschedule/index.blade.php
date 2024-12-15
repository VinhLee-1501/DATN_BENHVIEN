@extends('layouts.admin.master')

@section('content')
<div class="card w-100">
    <div class="card-body p-4">
        <div class="col-md-4">
            <h5 class="card-title fw-semibold mb-4">Quản lý lịch khám</h5>
        </div>

        <!-- Tab Navigation -->
        <nav class="mb-3">
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link {{ $activeTab == 'nav-home' ? 'active' : '' }}" id="nav-home-tab" data-bs-toggle="tab"
                    data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true"
                    data-tab="nav-home">Khám Offline
                </button>
                <button class="nav-link {{ $activeTab == 'nav-contact' ? 'active' : '' }}" id="nav-contact-tab"
                    data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact"
                    aria-selected="false" data-tab="nav-contact">Khám Online
                </button>
            </div>
        </nav>

        <!-- Tab Content -->
        <div class="tab-content" id="nav-tabContent">
            <form id="searchForm" method="GET" class="row gx-3 gy-3 align-items-center">
                <input type="hidden" name="tab" value="{{ request('tab', 'nav-home') }}">

                <!-- Họ tên và SĐT -->
                <div class="col-lg-5 col-md-6">
                    <div class="row g-2">
                        <div class="col-sm-12 col-md-6">
                            <input type="text" id="inputName" class="form-control" placeholder="Họ tên" name="name"
                                value="{{ request('name') }}">
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <input type="text" id="inputPhone" class="form-control" placeholder="SĐT" name="phone"
                                value="{{ request('phone') }}">
                        </div>
                    </div>
                </div>

                <!-- Trạng thái và ngày -->
                <div class="col-lg-5 col-md-6">
                    <div class="row g-2">
                        <div class="col-sm-12 col-md-4">
                            <select id="inputStatus" class="form-select" name="status">
                                <option value="">Trạng thái</option>
                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Đã đặt</option>
                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Xác nhận</option>
                                <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Đang xử lý</option>
                                <option value="3" {{ request('status') == '3' ? 'selected' : '' }}>Hoàn tất</option>
                                <option value="4" {{ request('status') == '4' ? 'selected' : '' }}>Hủy</option>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <input type="date" class="form-control" name="date_from" value="{{ request('date_from') }}">
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <input type="date" class="form-control" name="date_to" value="{{ request('date_to') }}">
                        </div>
                    </div>
                </div>

                <!-- Nút tìm kiếm -->
                <div class="col-lg-2 col-md-12">
                    <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
                </div>
            </form>

            <!-- Tab Contents -->
            <div class="tab-pane fade show {{ $activeTab == 'nav-home' ? 'show active' : '' }}" id="nav-home" role="tabpanel"
                aria-labelledby="nav-home-tab">
                @include('System.appointmentschedule.offline', ['book' => $booksOffline]) <!-- Truyền biến admin vào view -->
            </div>

            <div class="tab-pane fade {{ $activeTab == 'nav-contact' ? 'show active' : '' }}" id="nav-contact" role="tabpanel"
                aria-labelledby="nav-contact-tab">
                @include('System.appointmentschedule.online', ['book' => $booksOnline]) <!-- Truyền biến users vào view -->
            </div>
        </div>






    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Chi tiết lịch khám</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="col-md-12 d-flex">
                            <div class="mb-3 col-md-6 pe-1">
                                <label for="recipient-name" class="col-form-label">Thời gian khám:</label>
                                <input type="date" name="selectedDay" class="form-control" id="selectedDay"
                                    value="">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="recipient-name" class="col-form-label">Giờ khám:</label>
                                <input type="time" name="hour" class="form-control" id="hour"
                                    value="">
                            </div>
                        </div>
                        <div class="mb-3" id="shiftOption">

                        </div>
                        <div class="mb-3">
                            <label for="doctor_name" class="col-form-label">Bác sĩ:</label>
                            <select class="form-control" id="doctor_name" name="doctor_name"></select>
                            <input type="text" name="specialty_id" id="specialty_id" hidden>
                        </div>
                        <div class="mb-3">
                            <label for="" class="col-form-lable">Link</label>
                            <input type="text" name="url" id="urlMeeting" readonly class="form-control">
                            <input type="text" name="email" id="emailUser" hidden class="form-control">
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="check" id="confirmation-check"
                                checked>
                            <label class="form-check-label" for="confirmation-check">
                                Xác nhận
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="check" id="cancelstatus-check">
                            <label class="form-check-label" for="cancelstatus-check">
                                Hủy
                            </label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" id="btnRole">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="save-btn">Lưu</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        function openModal(id) {
            // console.log(id);

            $.ajax({
                url: '/system/appointmentSchedules/edit/' + id,
                type: 'GET',
                success: function(response) {
                    $('#exampleModal').data('role', response.role);
                    $('#exampleModal').data('row_id', response.row_id);
                    console.log(response);

                    $('#createMeetingBtn').remove();
                    if (response.role == 1) {
                        $('#btnRole').append(
                            `
                            <button type="button" class="btn btn-success" id="createMeetingBtn">Tạo Cuộc Họp</button>`);

                        $('#createMeetingBtn').on('click', function() {
                            createRoom();
                        });
                    } else {
                        $('#urlMeeting')
                        $('#shiftOption').empty();
                    }

                    var appointmentTime = new Date(response.appointment_time);

                    // Điều chỉnh thời gian để khớp múi giờ Asia/Ho_Chi_Minh
                    appointmentTime.setMinutes(appointmentTime.getMinutes() - appointmentTime
                        .getTimezoneOffset() + 420); // 420 phút = 7 giờ

                    // Lấy ngày, tháng và năm để định dạng lại theo Y-m-d
                    var year = appointmentTime.getFullYear();
                    var month = (appointmentTime.getMonth() + 1).toString().padStart(2,
                        '0'); // tháng bắt đầu từ 0 nên +1
                    var day = appointmentTime.getDate().toString().padStart(2, '0');

                    // Định dạng ngày thành 'Y-m-d'
                    var formattedDate = `${year}-${month}-${day}`;

                    $('#selectedDay').val(formattedDate);
                    $('#hour').val(response.hour);

                    $('#specialty_id').val(response.specialty_id);
                    $('#emailUser').val(response.email);
                    updateDoctors(formattedDate, response.specialty_id);
                    $('#confirmation-check').prop('checked', response.status == 1);
                    $('#cancelstatus-check').prop('checked', response.status == 4);
                    $('#exampleModal').data('id', id);
                    $('#exampleModal').modal('show');
                },
                error: function(err) {
                    console.error("Lỗi khi lấy dữ liệu:", err);
                }
            });
        }
        const appState = {
            userToken: "",
            roomId: "",
            roomToken: "",
            callClient: undefined,
            isRecording: false,
            mediaRecorder: null,
            recordedChunks: [],
        };

        function generateRoomUrl(roomId) {
            return `http://127.0.0.1:8000/meeting/?room=${roomId}`;
        }

        async function createRoom() {
            try {
                await api.setRestToken();
                const room = await api.createRoom();
                const roomId = room.roomId;
                const roomToken = await api.getRoomToken(roomId);


                const roomUrl = generateRoomUrl(roomId);
                document.getElementById('urlMeeting').value = roomUrl;

                // Xác thực và xuất bản video
                // await authen();
                // await publish(roomToken);

                appState.roomId = roomId; // Lưu roomId
                appState.roomToken = roomToken; // Lưu roomToken


            } catch (error) {
                console.error("Lỗi khi tạo phòng họp:", error);
                if (error.response) {
                    console.error("Chi tiết lỗi:", error.response.data);
                }
            }
        }

        async function authen() {
            const userId = `${(Math.random() * 100000).toFixed(6)}`;
            const userToken = await api.getUserToken(userId);
            appState.userToken = userToken;

            if (!appState.callClient) {
                const client = new StringeeClient();
                client.on("authen", function(res) {
                    // console.log("on authen: ", res);
                });
                appState.callClient = client;
            }
            await appState.callClient.connect(userToken);
        }

        async function publish(roomToken, screenSharing = false) {
            const localTrack = await StringeeVideo.createLocalVideoTrack(appState.callClient, {
                audio: true,
                video: true,
                screen: screenSharing,
                videoDimensions: {
                    width: 640,
                    height: 360
                }
            });

            const videoElement = localTrack.attach();

            document.querySelector("#videos").appendChild(videoElement);

            const roomData = await StringeeVideo.joinRoom(appState.callClient, roomToken);
            const room = roomData.room;
            await room.publish(localTrack);
        }

        function addVideo(videoElement) {
            const videoContainer = document.querySelector("#videos");
            videoContainer.appendChild(videoElement);
        }

        function updateDoctors(date, specialty_id) {
            const role = $('#exampleModal').data('role');
            $.ajax({
                url: '/system/appointmentSchedules/doctors',
                type: 'GET',
                data: {
                    date: date,
                    specialty_id: specialty_id,
                    role: role
                },
                success: function(response) {
                    $('#doctor_name').empty();
                    console.log(response);
                    if (role == 1) {
                        $('#shiftOption').empty(); // Đảm bảo không trùng lặp các option
                        $('#shiftOption').append(`
                            <label for="shift_id">Chọn ca:</label>
                                <select id="shift_id" name="rowId" class="form-control">
                                ${response.shifts.map(function(shift) {
                            return `<option value="${shift.row_id}">${shift.name} - (${shift.note ?? ""})</option>`;
                                }).join('')}
                            </select>
                                `);
                    } else {
                        $('#shiftOption').empty(); // Xóa nếu role khác 1
                    }

                    response.doctors.forEach(function(doctor) {

                        $('#doctor_name').append(
                            $('<option>', {
                                value: doctor.user_id,
                                text: doctor.lastname + ' ' + doctor.firstname
                            })
                        );
                        if (doctor.shiftStatus == 1) {
                            $('#doctor_name option[value="' + doctor.user_id + '"]').prop('disabled',
                                true)
                        } else {
                            // Nếu shiftStatus = 0 (còn trống), cho chọn
                            $('#doctor_name option[value="' + doctor.user_id + '"]').prop('disabled',
                                false);
                        }

                    });
                },
                error: function(err) {
                    console.error("Error fetching doctors:", err);
                }
            });
        }

        $('#selectedDay').change(function() {
            var selectedDate = $(this).val();
            var specialtyId = $('#specialty_id').val();
            updateDoctors(selectedDate, specialtyId);

        });

        $('#save-btn').click(function() {
            var id = $('#exampleModal').data('id');
            var row_id = $('#shift_id').val();
            console.log(row_id);
            var appointmentTime = $('#selectedDay').val();
            var hour = $('#hour').val();
            var doctorName = $('#doctor_name').val();
            var confirmation = $('#confirmation-check').is(':checked');
            var cancel = $('#cancelstatus-check').is(':checked');
            var email = $('#emailUser').val();
            var status = cancel ? 4 : (confirmation ? 1 : 0);
            var url = $('#urlMeeting').val() ? $('#urlMeeting').val() : null;


            console.log(appointmentTime, hour, doctorName, email, status, url);

            // break;

            $.ajax({
                url: '/system/appointmentSchedules/update/' + id,
                type: 'PATCH',
                data: {
                    appointment_time: appointmentTime,
                    hour: hour,
                    doctor_name: doctorName,
                    status: status,
                    email: email,
                    url: url,
                    row_id: row_id,
                    _token: '{{ csrf_token() }}'
                },

                success: function(response) {
                    $('#exampleModal').modal('hide');

                    if (response.success) {
                        toastr.success(response.message);
                    } else if (response.error) {
                        toastr.error(response.message);
                    }
                    setTimeout(function() {
                        location.reload();
                    }, 3000);

                },
                error: function(err) {
                    console.error("Error updating data:", err);
                    alert('Có lỗi xảy ra: ' + err.responseJSON.error);
                }
            });
        });
    </script>

    <!-- AJAX Script -->
    <script>
        $(document).ready(function() {
            // Khi thay đổi tab
            $('.nav-link').click(function(e) {
                e.preventDefault();
                var activeTab = $(this).attr('id'); // Lấy id của tab đang chọn, ví dụ 'nav-home' hoặc 'nav-contact'
                var formData = $('#searchForm').serialize(); // Lấy tất cả dữ liệu trong form

                // Gửi AJAX request
                $.ajax({
                    url: "{{ route('system.appointmentSchedule') }}",
                    type: 'GET',
                    data: formData + '&tab=' + activeTab, // Gửi thêm tab vào dữ liệu
                    success: function(response) {
                        // Cập nhật lại nội dung tab content sau khi nhận phản hồi
                        $('#nav-home').html(response.navHome);
                        $('#nav-contact').html(response.navContact);
                    }
                });
            });


            // Khi tìm kiếm
            $('#searchForm').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize(); // Lấy dữ liệu form
                var activeTab = $("button.nav-link.active").data('tab'); // Lấy tab đang active

                // Gửi AJAX request
                $.ajax({
                    url: "{{ route('system.appointmentSchedule') }}",
                    type: 'GET',
                    data: formData + '&tab=' + activeTab, // Gửi dữ liệu tìm kiếm và tab
                    success: function(response) {
                        // Cập nhật nội dung tab content với dữ liệu trả về từ server
                        $('#nav-home').html(response.navHome);
                        $('#nav-contact').html(response.navContact);
                    }
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@0.20.0/dist/axios.min.js"></script>
    <script src="https://cdn.stringee.com/sdk/web/2.2.1/stringee-web-sdk.min.js"></script>
    @endsection