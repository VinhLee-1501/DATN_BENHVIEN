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
                                <input type="text" id="inputName" class="form-control" placeholder="Họ tên"
                                    name="name">
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
                        @foreach ($book as $item)
                            <tr>
                                <td class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">{{ $count++ }}</h6>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-semibold">{{ $item->name }}</p>
                                </td>
                                <td class="border-bottom-0">
                                    <span class="fw-semibold mb-0">{{ '0' . $item->phone }}</span>
                                </td>
                                <td class="border-bottom-0">
                                    <span class="fw-semibold mb-0">
                                        @if ($item->status === 0)
                                            <span class="badge bg-danger">Đã đặt</span>
                                        @elseif($item->status === 1)
                                            <span class="badge bg-success">Xác nhận</span>
                                        @elseif ($item->status === 2)
                                            <span class="badge bg-success">Đã khám</span>
                                        @else
                                            <span class="badge bg-warning">Đã hủy</span>
                                        @endif
                                    </span>
                                </td>
                                <td class="border-bottom-0 d-flex">

                                    <a href="javascript:void(0)" class="btn btn-primary me-1"
                                        onclick="openModal('{{ $item->book_id }}')"><i class="ti ti-pencil"></i></a>
                                    <form action="{{ route('system.deleteAppointmentSchedule', $item->book_id) }}"
                                        id="form-delete{{ $item->book_id }}" method="post">
                                        @method('delete')
                                        @csrf
                                    </form>
                                    <button type="submit" class="btn btn-danger btn-delete" data-id="{{ $item->book_id }}">
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
                                                    <img src="{{ $item->avatar ? $item->avatar : asset('backend/assets/images/profile/user-1.jpg') }}"
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
                                                            {{ Carbon\Carbon::parse($item->day)->format('d/m/Y') }}
                                                            {{ Carbon\Carbon::parse($item->day)->format('H:i:s') }}
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-md-4 text-start">
                                                    <ul class="list-unstyled mb-0">
                                                        <li><strong>Trạng thái:</strong>
                                                            @if ($item->status === 0)
                                                                <span class="badge bg-danger">Chưa khám</span>
                                                            @elseif($item->status === 2)
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
                        console.log(response);
                        $('#createMeetingBtn').remove();
                        if (response.role === 1) {
                            $('#btnRole').append(
                                `
                            <button type="button" class="btn btn-success" id="createMeetingBtn">Tạo Cuộc Họp</button>`);

                            $('#createMeetingBtn').on('click', function() {
                                createRoom();
                            })
                        } else {
                            $('#urlMeeting')
                        }

                        // Chuyển đổi từ định dạng ISO (nếu là chuỗi ISO)
                        var appointmentTime = new Date(response.appointment_time);
                        var formattedDate = appointmentTime.toISOString().split('T')[
                            0]; // Lấy phần ngày trong định dạng 'Y-m-d'

                        $('#selectedDay').val(formattedDate);
                        $('#hour').val(response.hour);


                        $('#specialty_id').val(response.specialty_id);
                        $('#emailUser').val(response.email);
                        updateDoctors(response.appointment_time, response.specialty_id);
                        $('#confirmation-check').prop('checked', response.status === 1);
                        $('#cancelstatus-check').prop('checked', response.status === 2);
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
                $.ajax({
                    url: '/system/appointmentSchedules/doctors',
                    type: 'GET',
                    data: {
                        date: date,
                        specialty_id: specialty_id
                    },
                    success: function(response) {
                        $('#doctor_name').empty();
                        response.doctors.forEach(function(doctor) {
                            $('#doctor_name').append(
                                $('<option>', {
                                    value: doctor.user_id,
                                    text: doctor.lastname + ' ' + doctor.firstname
                                })
                            );
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
                // console.log(id);
                var appointmentTime = $('#selectedDay').val();
                var hour = $('#hour').val();
                var doctorName = $('#doctor_name').val();
                var confirmation = $('#confirmation-check').is(':checked');
                var cancel = $('#cancelstatus-check').is(':checked');
                var email = $('#emailUser').val();
                var status = cancel ? 2 : (confirmation ? 1 : 0);
                var url = $('#urlMeeting').val() ? $('#urlMeeting').val() : null;


                // break;

                $.ajax({
                    url: '/system/appointmentSchedules/update/' + id,
                    type: 'patch',
                    data: {
                        appointment_time: appointmentTime,
                        hour: hour,
                        doctor_name: doctorName,
                        status: status,
                        email: email,
                        url: url,
                        _token: '{{ csrf_token() }}'
                    },

                    success: function(response) {
                        $('#exampleModal').modal('hide');

                        if (response.success) {
                            toastr.success(response.message);
                        } else if (response.error) {
                            toastr.error(response.message);
                        }
                        // location.reload();

                    },
                    error: function(err) {
                        console.error("Error updating data:", err);
                        alert('Có lỗi xảy ra: ' + err.responseJSON.error);
                    }
                });
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios@0.20.0/dist/axios.min.js"></script>
        <script src="https://cdn.stringee.com/sdk/web/2.2.1/stringee-web-sdk.min.js"></script>
    @endsection
