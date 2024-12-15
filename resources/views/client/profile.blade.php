@extends('layouts.client.app')

@section('meta_title', 'Trang hồ sơ')

@section('content')

    <div class="main-body">
        <div class="breadcrumbs">
            <div class="container">
                <div class="breadcrumbs-nav">
                    <div class="item"><a href="" title="Trang chủ">Trang chủ</a>
                    </div>
                    <div class="item sep">/</div>
                    <div class="item">Thông tin cá nhân</div>
                </div>
            </div>
        </div>
        <div class="profile__page">
            <div class="container">
                <div class="profile__page--frame">
                    <div class="row gap-y-40">

                        <div class="col l-4 mc-12 c-12">
                            <div class="profile__info">
                                <div class="profile__avatar">

                                    @if (empty(auth()->user()->avatar))
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png"
                                            alt="Avatar" />
                                    @else
                                        @if (auth()->user()->google_id || auth()->user()->zalo_id || auth()->user()->facebook_id)
                                            <img src="{{ auth()->user()->avatar }}" alt="Default Avatar" />
                                        @else
                                            @if (auth()->user()->avatar ===
                                                    'https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png')
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png"
                                                    alt="Avatar" />
                                            @else
                                                <img src="{{ asset('storage/uploads/avatars/' . auth()->user()->avatar) }}"
                                                    alt="Avatar" />
                                            @endif
                                        @endif
                                    @endif

                                    <!-- Icon máy ảnh -->
                                    @if (auth()->user()->google_id || auth()->user()->zalo_id || auth()->user()->facebook_id)
                                        <!-- Nếu trường hợp đăng nhập mạng xã hội thì không cho đổi ảnh đại diện -->
                                    @else
                                        <div class="camera-icon" onclick="openPopup()">
                                            <i class="fas fa-camera"></i>
                                        </div>
                                    @endif

                                </div>
                                <script>
                                    function openPopup() {
                                        document.getElementById("uploadPopup").style.display = "flex"; // Hiển thị popup
                                    }

                                    function closePopup() {
                                        document.getElementById("uploadPopup").style.display = "none"; // Ẩn popup
                                        // Xóa preview khi đóng popup
                                        document.getElementById("previewImg").src = "";
                                        document.getElementById("previewImg").style.display = "none";
                                    }


                                    function previewImage(event) {
                                        const input = event.target;
                                        const previewImg = document.getElementById("previewImg");

                                        if (input.files && input.files[0]) {
                                            const reader = new FileReader();

                                            reader.onload = function(e) {
                                                previewImg.src = e.target.result; // Gán đường dẫn cho ảnh preview
                                                previewImg.style.display = "block"; // Hiển thị ảnh
                                            }

                                            reader.readAsDataURL(input.files[0]); // Đọc file hình ảnh
                                        }
                                    }
                                </script>
                                <!-- Popup form upload ảnh -->



                                <h1 class="text-center">Thông tin cá nhân</h1>
                                <div class="profile__details">
                                    <p><strong>Họ tên:</strong> {{ auth()->user()->firstname }}
                                        {{ auth()->user()->lastname }}</p>
                                    <p><strong>Số điện thoại:</strong>
                                        @if (empty(auth()->user()->phone))
                                            Chưa cập nhật
                                        @else
                                            {{ auth()->user()->phone }}
                                        @endif
                                    </p>
                                    <p><strong>Email:</strong>{{ auth()->user()->email }}</p>
                                    <p><strong>Ngày sinh:</strong>
                                        @if (empty(auth()->user()->birthday))
                                            Chưa cập nhật
                                        @else
                                            {{ \Carbon\Carbon::parse(auth()->user()->birthday)->format('d/m/Y') }}
                                        @endif
                                    </p>
                                </div>
                                <div class="button-container">
                                    <a href="{{ route('client.logout') }}" class="button btn-small btn-cta">Đăng xuất</a>
                                    <button class="button btn-small btn-cta" onclick="openTab(event, 'update_info')">Cập
                                        nhật thông tin</button>
                                    <button class="button btn-small btn-cta" onclick="openTab(event, 'change_password')">Đổi
                                        mật khẩu</button>
                                    <a href="{{ route('shop.cart') }}" class="button btn-small btn-cta">Đơn hàng</a>
                                </div>
                            </div>

                        </div>
                        <div class="col l-8 mc-12 c-12">
                            <div class="tabs">
                                <button
                                    class="tab-btn {{ session('active_tab') === null || session('active_tab') === 'history' ? 'active' : '' }}"
                                    onclick="openTab(event, 'history')">Lịch sử khám bệnh</button>
                                <button class="tab-btn" onclick="openTab(event, 'medical_record')">Lịch sử bệnh
                                    án</button>
                                <button class="tab-btn {{ session('active_tab') === 'order' ? 'active' : '' }}"
                                    onclick="openTab(event, 'order')">Đơn hàng</button>
                            </div>
                            <div class="tab-content">
                                <!-- Tab Lịch sử khám bệnh -->
                                <div id="history"
                                    class="tab {{ $errors->any() ? '' : (session('info_success') || session('info_error') || session('change_password_success') || session('change_password_error') ? '' : 'active') }}">

                                    <div class="profile__medical-history">
                                        <h1 class="text-center">Lịch sử khám bệnh</h1>
                                        <table class="medical-history__table">
                                            <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Ngày</th>
                                                    <th>Nội dung</th>
                                                    <th>Trạng thái</th>
                                                    <th>Hình thức khám</th>
                                                    <th>Link khám trực tuyến</th>
                                                    <th>Thao tác</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @if ($medicalHistory->isEmpty())
                                                    <tr>
                                                        <td colspan="7" class="text-center">Chưa có lịch khám nào</td>
                                                    </tr>
                                                @else
                                                    @foreach ($medicalHistory as $key => $history)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($history->day)->format('d/m/Y') }}
                                                            </td>
                                                            <td>{{ $history->symptoms ?? 'Không có triệu chứng' }}</td>
                                                            <td>
                                                                @if ($history->status == 0)
                                                                    Chưa xác nhận
                                                                @elseif ($history->status == 1)
                                                                    Đã xác nhận
                                                                @elseif ($history->status == 2)
                                                                    Đang khám
                                                                @elseif ($history->status == 3)
                                                                    Đã khám
                                                                @elseif ($history->status == 4)
                                                                    Đã hủy
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($history->role == 0)
                                                                    Trực tiếp
                                                                @else
                                                                    Trực tuyến
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($history->role != 0)
                                                                    <a style="text-decoration: underline;"
                                                                        href="{{ $history->url }}" target="_blank">[Nhấn
                                                                        vào đây]</a>
                                                                @else
                                                                    (Trống)
                                                                @endif
                                                            </td>
                                                            <td colspan="2" style="display: flex">
                                                                <!-- Nút Chi tiết -->
                                                                <button style="border:none" class="button btn-small btn-cta"
                                                                    onclick="openDetailsModal('{{ $history->user_id }}')">Chi
                                                                    tiết</button>

                                                                <!-- Kiểm tra trạng thái và ẩn nút Hủy lịch nếu trạng thái là 3 -->
                                                                @if ($history->status == 0)
                                                                    <button style="margin: 5px"
                                                                        class="button btn-small btn-cta"
                                                                        onclick="openCancelModal('{{ $history->book_id }}')">
                                                                        Hủy lịch
                                                                    </button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>


                                        </table>
                                        <div id="confirmModal" class="modal" style="display: none;" style="width: 50%">
                                            <div class="modal-content">
                                                <h3 style="text-align: center">Bạn có chắc chắn muốn hủy lịch khám không?
                                                </h3>
                                                <br>
                                                <div class="btn-container" style="display: flex">
                                                    <button id="confirmCancel" class="button btn-small btn-cta">Đồng
                                                        ý</button>
                                                    <button id="cancelCancel" class="button btn-small">Hủy</button>
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                            function openCancelModal(bookId) {

                                                document.getElementById('confirmModal').style.display = 'block';


                                                document.getElementById('confirmCancel').onclick = function() {

                                                    window.location.href = 'ho-so/huy-lich/' + bookId;
                                                };


                                                document.getElementById('cancelCancel').onclick = function() {
                                                    document.getElementById('confirmModal').style.display = 'none';
                                                };
                                            }
                                        </script>
                                        <script>
                                            console.log('Script has been loaded');

                                            function openDetailsModal(userId) {
                                                var details = @json($medicalHistory);

                                                var record = details.find(h => h.user_id === userId);

                                                if (record) {
                                                    // Cập nhật nội dung modal
                                                    document.getElementById('modal-book-id').textContent = record.book_id;
                                                    // Định dạng ngày
                                                    var date = new Date(record.day);
                                                    var day = String(date.getDate()).padStart(2, '0');
                                                    var month = String(date.getMonth() + 1).padStart(2, '0');
                                                    var year = date.getFullYear();
                                                    var formattedDate = `${day}/${month}/${year}`;
                                                    document.getElementById('modal-day').textContent = formattedDate;
                                                    document.getElementById('modal-hour').textContent = record.hour;
                                                    document.getElementById('modal-name').textContent = record.name;
                                                    document.getElementById('modal-phone').textContent = record.phone;
                                                    document.getElementById('modal-email').textContent = record.email;
                                                    document.getElementById('modal-symptoms').textContent = record.symptoms ?? 'Không có triệu chứng';
                                                    document.getElementById('modal-specialty-id').textContent = record.specialty['name'];
                                                    document.getElementById('modal-status').textContent = record.status === 0 ? 'Chưa xác nhận' : 'Đã xác nhận';
                                                    document.getElementById('modal-role').textContent = record.role === 0 ? 'Trực tiếp' : 'Trực tuyến';
                                                    if (record.role == 0) {
                                                        document.getElementById('modal-url').textContent = '(Trống)'; // Để trống nếu role == 0
                                                    } else {
                                                        document.getElementById('modal-url').textContent = record.url; // Hiển thị url nếu role khác 0
                                                    }

                                                    // Hiển thị modal
                                                    document.getElementById('detailsModal').style.display = 'block';
                                                }
                                            }

                                            function closeDetailsModal() {
                                                document.getElementById('detailsModal').style.display = 'none';
                                            }
                                        </script>
                                    </div>

                                </div>

                                <!-- Tab bệnh án -->
                                <div id="medical_record" class="tab">
                                    <div class="profile__medical-history" style="overflow-x: auto;">
                                        <h1 class="text-center">Bệnh án</h1>
                                        <table class="medical-history__table">
                                            <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Mã bệnh án</th>
                                                    <th>Chẩn đoán</th>
                                                    <th>Ngày tái khám</th>
                                                    <th>Lời khuyên</th>

                                                    <th>Bệnh nhân</th>
                                                    <th>Chi tiết</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($medicalRecordHistory->isEmpty())
                                                    <tr>
                                                        <td colspan="7" class="text-center">Chưa có bệnh án nào</td>
                                                    </tr>
                                                @else
                                                    @foreach ($medicalRecordHistory as $key => $history)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $history->medical_id }}</td>
                                                            <td>{{ $history->diaginsis }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($history->re_examination_date)->format('d/m/Y') }}
                                                            </td>
                                                            <td>{{ $history->advice ?? 'Không có lời khuyên' }}</td>

                                                            <td>{{ $history->first_name }} {{ $history->last_name }}</td>
                                                            <td>
                                                                <button style="border:none" class="button btn-small btn-cta"
                                                                    onclick="openDetailsMediaRecordModal({{ json_encode($history) }})">Chi
                                                                    tiết</button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <script>
                                    function openDetailsMediaRecordModal(history) {
                                        document.getElementById("modal-medical-id").textContent = history.medical_id;
                                        document.getElementById("modal-diagnosis").textContent = history.diaginsis;
                                        if (history.re_examination_date) {
                                            const date = new Date(history.re_examination_date);
                                            const day = String(date.getDate()).padStart(2, '0'); // Đảm bảo có 2 chữ số
                                            const month = String(date.getMonth() + 1).padStart(2, '0'); // Tháng bắt đầu từ 0
                                            const year = date.getFullYear();

                                            // Định dạng theo d-m-Y
                                            document.getElementById("modal-re-exam-date").textContent = `${day}/${month}/${year}`;
                                        } else {
                                            document.getElementById("modal-re-exam-date").textContent = 'Không có thông tin';
                                        }
                                        document.getElementById("modal-advice").textContent = history.advice || 'Không có lời khuyên';
                                        document.getElementById("modal-blood-pressure").textContent = history.blood_pressure;
                                        document.getElementById("modal-respiratory-rate").textContent = history.respiratory_rate;
                                        document.getElementById("modal-weight").textContent = history.weight;
                                        document.getElementById("modal-height").textContent = history.height;
                                        document.getElementById("modal-patient-name").textContent = `${history.first_name} ${history.last_name}`;



                                        // Tạo bảng cho danh sách dịch vụ
                                        let servicesList = document.getElementById("modal-services");
                                        servicesList.innerHTML = ""; // Xóa nội dung cũ

                                        let servicesTable = document.createElement("table");
                                        servicesTable.classList.add("table", "table-bordered");

                                        // Tạo tiêu đề cho bảng dịch vụ
                                        let servicesThead = document.createElement("thead");
                                        let servicesHeaderRow = document.createElement("tr");

                                        let servicesHeaders = ["Tên dịch vụ", "Giá"];
                                        servicesHeaders.forEach(headerText => {
                                            let th = document.createElement("th");
                                            th.textContent = headerText;
                                            servicesHeaderRow.appendChild(th);
                                        });
                                        servicesThead.appendChild(servicesHeaderRow);
                                        servicesTable.appendChild(servicesThead);

                                        // Tạo phần thân cho bảng dịch vụ
                                        let servicesTbody = document.createElement("tbody");

                                        history.services.forEach(service => {
                                            let row = document.createElement("tr");

                                            let serviceData = [
                                                service.name,
                                                service.price + '.000 VNĐ'
                                            ];

                                            serviceData.forEach(data => {
                                                let td = document.createElement("td");
                                                td.textContent = data;
                                                row.appendChild(td);
                                            });

                                            servicesTbody.appendChild(row);
                                        });

                                        servicesTable.appendChild(servicesTbody);
                                        servicesList.appendChild(servicesTable); // Thêm bảng dịch vụ vào modal

                                        // Cập nhật tổng giá
                                        document.getElementById("modal-total-price").textContent = history.total_price + '.000 VNĐ';

                                        let medicinesList = document.getElementById("modal-medicines");
                                        medicinesList.innerHTML = ""; // Xóa nội dung cũ

                                        // Tạo tiêu đề cho bảng thuốc
                                        let table = document.createElement("table");
                                        table.classList.add("table", "table-bordered");
                                        let thead = document.createElement("thead");
                                        let headerRow = document.createElement("tr");

                                        let headers = ["Tên thuốc", "Liều dùng", "Số lượng", "Cách dùng", "Lúc uống"];
                                        headers.forEach(headerText => {
                                            let th = document.createElement("th");
                                            th.textContent = headerText;
                                            headerRow.appendChild(th);
                                        });
                                        thead.appendChild(headerRow);
                                        table.appendChild(thead);

                                        // Tạo phần thân cho bảng thuốc
                                        let tbody = document.createElement("tbody");

                                        history.medicines.forEach(medicine => {
                                            let row = document.createElement("tr");

                                            let medicineData = [
                                                medicine.name,
                                                medicine.dosage,
                                                medicine.quantity,
                                                medicine.usage,
                                                medicine.note
                                            ];

                                            medicineData.forEach(data => {
                                                let td = document.createElement("td");
                                                td.textContent = data;
                                                row.appendChild(td);
                                            });

                                            tbody.appendChild(row);
                                        });

                                        table.appendChild(tbody);
                                        medicinesList.appendChild(table);

                                        document.getElementById("detailsMediaRecordModal").style.display = "block";
                                    }
                                </script>



                                <!-- Tab Đơn thuốc -->
                                <div id="order" class="tab">
                                    <div class="profile__medical-history">
                                        <h1 class="text-center">Đơn hàng</h1>
                                        <table class="medical-history__table">
                                            <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Mã đơn hàng</th>
                                                    <th>Ngày đặt hàng</th>
                                                    <th>Giá trị đơn hàng</th>
                                                    <th>Phương thức thanh toán</th>
                                                    <th>Địa chỉ giao hàng</th>
                                                    <th>Trạng thái đơn hàng</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $index = 1; @endphp
                                                @foreach ($order_user as $item)
                                                    @php
                                                        // Xác định phương thức thanh toán
                                                        $methodText = match ($item->payment_method) {
                                                            0 => 'Thanh toán khi nhận hàng',
                                                            1 => 'Thanh toán bằng VNPAY',
                                                            2 => 'Thanh toán bằng MOMOPAY',
                                                            default => 'Thanh toán bằng ZaloPay',
                                                        };

                                                     if($item->order_status == 0){
                                                        $orderStatus = 'Đang chờ xử lý';
                                                     }elseif($item->order_status == 1){
                                                        $orderStatus = 'Đã xác nhận';
                                                     }elseif($item->order_status == 2){
                                                        $orderStatus = 'Đang giao';
                                                     }else{
                                                        $orderStatus = 'Đã xác nhận';
                                                     }
                                                         
                                                        

                                                        // Xác định giá trị đơn hàng
                                                        $orderValue =
                                                            number_format($item->price_sale ?? $item->price_old) . 'đ';
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $index++ }}</td>
                                                        <td>{{ $item->order_id }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('H:i d/m/Y') }}
                                                        </td>
                                                        <td>{{ $orderValue }}</td>
                                                        <td>{{ $methodText }}</td>
                                                        <td>{{ $item->order_address }}</td>
                                                        <td>{{ $orderStatus }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <br>
                                        <div class="pagination">
                                            @if (is_object($order_user) && method_exists($order_user, 'count') && $order_user->count() > 0)
                                                {{ $order_user->links() }}
                                            @else
                                                <p>Không có đơn hàng nào.</p>
                                            @endif
                                        </div>
                                    </div>


                                </div>
                                <!-- Form Cập nhật thông tin -->
                                <div id="update_info"
                                    class="tab {{ $errors->has('firstname') || $errors->has('lastname') || $errors->has('phone') || $errors->has('birthday') || $errors->has('email') || session('info_success') || session('info_error') ? 'active' : '' }}">
                                    <h1 class="text-center">Cập nhật thông tin</h1>
                                    <form class="profile__form" action="{{ route('client.profile.update') }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')

                                        <div class="form-group row">
                                            <div class="col">
                                                <label for="firstname">Họ</label>
                                                <input type="text" id="firstname" name="firstname"
                                                    value="{{ auth()->user()->firstname }}" />
                                                @error('firstname')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col">
                                                <label for="lastname">Tên</label>
                                                <input type="text" id="lastname" name="lastname"
                                                    value="{{ auth()->user()->lastname }}" />
                                                @error('lastname')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col">
                                                <label for="phone">Số điện thoại</label>
                                                <input type="text" id="phone" name="phone"
                                                    value="{{ auth()->user()->phone }}" />
                                                @error('phone')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col">
                                                <label for="birthday">Ngày sinh</label>
                                                <input type="date" id="birthday" name="birthday"
                                                    value="{{ auth()->check() && auth()->user()->birthday ? auth()->user()->birthday->format('Y-m-d') : '' }}" />
                                                @error('birthday')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" id="email" name="email"
                                                value="{{ auth()->user()->email }}" />
                                            @error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <button type="submit" class="button btn-cta">Cập nhật</button>
                                    </form>

                                </div>




                                <!-- Form Đổi mật khẩu -->
                                <div id="change_password"
                                    class="tab {{ $errors->has('current_password') || $errors->has('new_password') || session('change_password_success') || session('change_password_error') ? 'active' : '' }}">
                                    <h1 class="text-center">Đổi mật khẩu</h1>
                                    <form method="POST" action="{{ route('client.profile.change-password') }}"
                                        class="profile__form">
                                        @csrf
                                        @method('PATCH')

                                        <!-- Mật khẩu hiện tại -->
                                        <div class="form-group">
                                            <label for="current_password">Mật khẩu hiện tại</label>
                                            <input type="password" id="current_password" name="current_password" />
                                            @error('current_password')
                                                <div class="error-message" style="color: red;">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Mật khẩu mới -->
                                        <div class="form-group">
                                            <label for="new_password">Mật khẩu mới</label>
                                            <input type="password" id="new_password" name="new_password" />
                                            @error('new_password')
                                                <div class="error-message" style="color: red;">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Xác nhận mật khẩu mới -->
                                        <div class="form-group">
                                            <label for="new_password_confirmation">Xác nhận mật khẩu mới</label>
                                            <input type="password" id="new_password_confirmation"
                                                name="new_password_confirmation" />
                                            @error('new_password_confirmation')
                                                <div class="error-message" style="color: red;">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Nút submit -->
                                        <button type="submit" class="button btn-cta">Đổi mật khẩu</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal 1: Chi tiết lịch sử khám bệnh -->
        <div id="detailsModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeDetailsModal()">&times;</span>
                <h2>Chi tiết lịch sử khám bệnh</h2>
                <p><strong>Mã đơn:</strong> <span id="modal-book-id"></span></p>
                <p><strong>Ngày khám:</strong> <span id="modal-day"></span></p>
                <p><strong>Giờ khám:</strong> <span id="modal-hour"></span></p>
                <p><strong>Họ tên:</strong> <span id="modal-name"></span></p>
                <p><strong>Số điện thoại:</strong> <span id="modal-phone"></span></p>
                <p><strong>Email:</strong> <span id="modal-email"></span></p>
                <p><strong>Triệu chứng:</strong> <span id="modal-symptoms"></span></p>
                <p><strong>Chuyên khoa:</strong> <span id="modal-specialty-id"></span></p>
                <p><strong>Hình thức khám:</strong> <span id="modal-role"></span></p>
                <p><strong>Trạng thái:</strong> <span id="modal-status"></span></p>
                <p><strong>Link khám trực tuyến:</strong> <a id="modal-url" href="" target="_blank">Khám trực
                        tuyến</a></p>
            </div>
        </div>

        <!-- Modal 2: Chi tiết bệnh án -->
        <div id="detailsMediaRecordModal" class="modal" style="display: none;">
            <div class="modal-content">
                <span class="close" onclick="closeDetailsMediaRecordModal()">&times;</span>
                <h2>Chi tiết bệnh án</h2>

                <div class="modal-body">
                    <!-- Phần bên trái: Chi tiết bệnh án -->
                    <div class="left-column">
                        <p><strong>Mã bệnh án:</strong> <span id="modal-medical-id"></span></p>
                        <p><strong>Chẩn đoán:</strong> <span id="modal-diagnosis"></span></p>
                        <p><strong>Ngày tái khám:</strong> <span id="modal-re-exam-date"></span></p>
                        <p><strong>Lời khuyên:</strong> <span id="modal-advice"></span></p>
                        <p><strong>Huyết áp:</strong> <span id="modal-blood-pressure"></span></p>
                        <p><strong>Nhịp thở:</strong> <span id="modal-respiratory-rate"></span></p>
                        <p><strong>Cân nặng:</strong> <span id="modal-weight"></span> kg</p>
                        <p><strong>Chiều cao:</strong> <span id="modal-height"></span> cm</p>
                        <p><strong>Bệnh nhân:</strong> <span id="modal-patient-name"></span></p>
                    </div>

                    <!-- Phần bên phải: Dịch vụ -->
                    <div class="right-column">
                        <p><strong>Dịch vụ:</strong></p>
                        <div id="modal-services"></div>
                        <p><strong>Tổng chi phí:</strong> <span id="modal-total-price"></span></p>
                    </div>
                </div>

                <!-- Bảng thuốc nằm dưới cùng -->
                <div class="medicines-section">
                    <p><strong>Đơn thuốc:</strong></p>
                    <ul id="modal-medicines"></ul>
                </div>
            </div>
        </div>
        <div class="modal_upload" id="uploadPopup" style="display: none;">
            <div class="modal-content">
                <span class="close" onclick="closePopup()">&times;</span>
                <h2>Tải lên ảnh đại diện</h2>

                <div class="modal-body">
                    <div class="form-group">
                        <form class="profile__form" action="{{ route('client.profile.change-avatar') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <label for="avatar">Chọn ảnh mới:</label>
                            <input type="file" id="avatar" name="avatar" accept="image/*" required
                                onchange="previewImage(event)">
                            @error('avatar')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <button class="button btn-cta" type="submit">Tải lên</button>
                        </form>
                    </div>

                    <div id="imagePreview" style="width: 30%">
                        <img id="previewImg" src="" alt="Image Preview"
                            style="display: none; max-width: 100%; border-radius: 5px">
                    </div>
                </div>
            </div>
        </div>


        <script>
            // Function to close the details modal for booking history
            function closeDetailsModal() {
                document.getElementById("detailsModal").style.display = "none";
            }

            // Function to close the details modal for medical record
            function closeDetailsMediaRecordModal() {
                document.getElementById("detailsMediaRecordModal").style.display = "none";
            }

            document.addEventListener('DOMContentLoaded', function() {
                const activeTab = "{{ session('active_tab') }}";
                if (activeTab) {
                    openTab(null, activeTab); // Mở tab từ session
                }
            });
        </script>

    @endsection
