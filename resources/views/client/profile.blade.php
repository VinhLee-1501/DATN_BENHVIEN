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
                    <div class="item">Lịch sử</div>
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
                                    <img src="{{ auth()->user()->avatar }}" alt="Avatar" />
                                </div>
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
                                    <p><strong>Địa chỉ:</strong>
                                        @if (empty(auth()->user()->address))
                                            Chưa cập nhật
                                        @else
                                            {{ auth()->user()->address }}
                                        @endif
                                    </p>
                                </div>
                                <div class="button-container">
                                    <a href="{{ route('client.logout') }}" class="button btn-small btn-cta">Đăng xuất</a>
                                    <button class="button btn-small btn-cta" onclick="openTab(event, 'update_info')">Cập
                                        nhật thông tin</button>
                                    <button class="button btn-small btn-cta" onclick="openTab(event, 'change_password')">Đổi
                                        mật khẩu</button>
                                    <a href="{{ route('client.logout') }}" class="button btn-small btn-cta">Khác</a>
                                </div>


                            </div>

                        </div>
                        <div class="col l-8 mc-12 c-12">
                            <div class="tabs">
                                <button class="tab-btn active" onclick="openTab(event, 'history')">Lịch sử khám
                                    bệnh</button>
                                <button class="tab-btn" onclick="openTab(event, 'medical_record')">Lịch sử bệnh
                                    án</button>
                                <button class="tab-btn" onclick="openTab(event, 'prescription')">Đơn thuốc</button>
                            </div>
                            <div class="tab-content">
                                <!-- Tab Lịch sử khám bệnh -->
                                <div id="history"
                                    class="tab {{ $errors->any() ? '' : (session('success') || session('error') ? '' : 'active') }}">

                                    <div class="profile__medical-history">
                                        <h1 class="text-center">Lịch sử khám bệnh</h1>
                                        <table class="medical-history__table">
                                            <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Ngày</th>
                                                    <th>Nội dung</th>
                                                    <th>Trạng thái</th>
                                                    <th>Chi tiết</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <tbody>
                                                @if ($medicalHistory->isEmpty())
                                                    <tr>
                                                        <td colspan="5" class="text-center">Chưa có lịch khám nào</td>
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
                                                                @else
                                                                    Đã xác nhận
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <!-- Nút Chi tiết -->
                                                                <button style="border:none" class="button btn-small btn-cta"
                                                                    onclick="openDetailsModal('{{ $history->user_id }}')">Chi
                                                                    tiết</button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>

                                            </tbody>
                                        </table>
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
                                    <div class="profile__medical-history">
                                        <h1 class="text-center">Bệnh án</h1>
                                        <table class="medical-history__table">
                                            <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Ngày</th>
                                                    <th>Nội dung</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>20/08/2024</td>
                                                    <td>Paracetamol</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>20/08/2024</td>
                                                    <td>Vitamin C</td>
                                                </tr>
                                            </tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Tab Đơn thuốc -->
                                <div id="prescription" class="tab">
                                    <div class="profile__medical-history">
                                        <h1 class="text-center">Đơn thuốc</h1>
                                        <table class="medical-history__table">
                                            <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Ngày</th>
                                                    <th>Nội dung</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>20/08/2024</td>
                                                    <td>Paracetamol</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>20/08/2024</td>
                                                    <td>Vitamin C</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                <!-- Form Cập nhật thông tin -->
                                <div id="update_info"
                                    class="tab {{ $errors->any() ? 'active' : (session('success') || session('error') ? 'active' : '') }}">
                                    <h1 class="text-center">Cập nhật thông tin</h1>
                                    <form class="profile__form" action="{{ route('client.profile.update') }}"
                                        method="POST">
                                        @csrf
                                        @method('PATCH');
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
                                                    value="{{ \Carbon\Carbon::parse(auth()->user()->birthday)->format('Y-m-d') }}" />
                                                @error('birthday')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" id="email" name="email"
                                                value="{{ old('email', auth()->user()->email) }}" />
                                            @error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <button type="submit" class="button btn-cta">Cập nhật</button>
                                    </form>
                                </div>




                                <!-- Form Đổi mật khẩu -->
                                <div id="change_password" class="tab">
                                    <h1 class="text-center">Đổi mật khẩu</h1>
                                    <form class="profile__form">
                                        <div class="form-group">
                                            <label for="current_password">Mật khẩu hiện tại</label>
                                            <input type="password" id="current_password" name="current_password" />
                                        </div>
                                        <div class="form-group">
                                            <label for="new_password">Mật khẩu mới</label>
                                            <input type="password" id="new_password" name="new_password" />
                                        </div>
                                        <div class="form-group">
                                            <label for="confirm_password">Xác nhận mật khẩu mới</label>
                                            <input type="password" id="confirm_password" name="confirm_password" />
                                        </div>
                                        <button type="submit" class="button btn-cta">Đổi mật khẩu</button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Chi tiết -->
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
                <p><strong>Trạng thái:</strong> <span id="modal-status"></span></p>
            </div>
        </div>
    </div>

@endsection
