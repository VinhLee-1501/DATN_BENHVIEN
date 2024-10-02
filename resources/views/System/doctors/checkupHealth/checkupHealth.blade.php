@extends('layouts.admin.master')

@section('content')
    <style>
        .card,
        .table,
        .form-control, .form-select {
            padding: 0.4rem;
            /* Giảm padding */
            border-radius: 0;
            /* Bo góc vuông */
        }

        .card,
        .table,
        .form-control {
            font-size: 0.9rem;
        }

        .card-header {}
    </style>
    <div class="container my-4">
        <div class="card mb-3">
            <div class="card-header">Thông tin bệnh nhân</div>
            <div class="card-body">
                @if (!$patient)
                    <form>
                        <div class="row">
                            <div class="col-md-2">
                                <label for="patient_id">Mã bệnh nhân</label>
                                <input type="text" class="form-control" id="patient_id"
                                    value="{{ strtoupper(Str::random(10)) }}" readonly>
                            </div>
                            <div class="col-md-3">
                                <label for="patient_name">Họ </label>
                                <input type="text" class="form-control" id="patient_name" value="{{ $user->name }}">
                            </div>
                            <div class="col-md-3">
                                <label for="patient_name">Tên</label>
                                <input type="text" class="form-control" id="patient_name" value="{{ $user->name }}">
                            </div>
                            <div class="col-md-2">
                                <label for="gender">Giới tính</label>
                                <select class="form-select" id="gender" name="gender">
                                    <option value="1">Nam</option>
                                    <option value="0">Nữ</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="age">Năm sinh</label>
                                <input type="date" class="form-control" id="age" >
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label for="address">Địa chỉ</label>
                                <input type="text" class="form-control" id="address" value="">
                            </div>
                            <div class="col-md-3">
                                <label for="phone">Số điện thoại</label>
                                <input type="text" class="form-control" id="phone" value="0{{ $user->phone }}"
                                    readonly>
                            </div>
                            <div class="col-md-3">
                                <label for="admission_date">Ngày khám</label>
                                <input type="text" class="form-control" id="admission_date"
                                    value="{{ Carbon\Carbon::parse($user->day)->format('d/m/Y') }}" readonly>
                            </div>
                        </div>
                    </form>
                @else
                    <form>
                        <div class="row">
                            <div class="col-md-2">
                                <label for="patient_id">Mã bệnh nhân</label>
                                <input type="text" class="form-control" id="patient_id"
                                    value="{{ $user['patient']->patient_id }}" readonly>
                            </div>
                            <div class="col-md-3">
                                <label for="patient_name">Họ</label>
                                <input type="text" class="form-control" id="patient_name"
                                    value="{{ $user['patient']->last_name }}" readonly>
                            </div>
                            <div class="col-md-3">
                                <label for="patient_name">Tên</label>
                                <input type="text" class="form-control" id="patient_name"
                                    value="{{ $user['patient']->first_name }}" readonly>
                            </div>
                            <div class="col-md-2">
                                <label for="gender">Giới tính</label>
                                <select class="form-select" id="gender" name="gender" disabled>
                                    <option value="1" {{ $user['patient']->gender == 1 ? 'selected' : '' }}>Nam</option>
                                    <option value="0" {{ $user['patient']->gender == 0 ? 'selected' : '' }}>Nữ</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="age">Ngày sinh</label>
                                <input type="text" class="form-control" id="age"
                                value="{{ Carbon\Carbon::parse($user['patient']->birthday)->format('d/m/Y') }}">

                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label for="address">Địa chỉ</label>
                                <input type="text" class="form-control" id="address"
                                    value="{{ $user['patient']->address }}" readonly>
                            </div>
                            <div class="col-md-3">
                                <label for="phone">Số điện thoại</label>
                                <input type="text" class="form-control" id="phone"
                                    value="0{{ $user['book']->phone }}" readonly>
                            </div>
                            <div class="col-md-3">
                                <label for="admission_date">Ngày khám</label>
                                <input type="text" class="form-control" id=""
                                    value="{{ Carbon\Carbon::parse($user['book']->day)->format('d/m/Y') }}" readonly>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
        <div class="d-flex col-md-12">
            <!-- Patient History -->
            @if(!$patient)
            <div class="card mb-3 me-2 col-md-6">
                <div class="card-header">Lịch sử bệnh</div>
                <div class="card-body">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th>Ngày khám</th>
                                <th>Chẩn đoán</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            @else
            <div class="card mb-3 me-2 col-md-6">
                <div class="card-header">Lịch sử bệnh</div>
                <div class="card-body">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th>Ngày khám</th>
                                <th>Chẩn đoán</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user['medicalRecord'] as $data)
                            <tr>
                                <td class="border-bottom-0">{{ Carbon\Carbon::parse($data->date)->format('d/m/Y') }}</td>
                                <td class="border-bottom-0">{{$data->diaginsis}}</td>
                                <td class="border-bottom-0"></td>
                                <td class="border-bottom-0"> <button type="button" class="btn btn-success btn-sm">Xem</button></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            <!-- Vitals -->
            <div class="card mb-3 col-md-6">
                <div class="card-header">Chỉ số sinh hiệu</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <label for="pulse">Mạch</label>
                            <input type="text" class="form-control" id="pulse">
                        </div>
                        <div class="col">
                            <label for="temperature">Nhiệt độ</label>
                            <input type="text" class="form-control" id="temperature">
                        </div>
                        <div class="col">
                            <label for="bloodPressure">Huyết áp</label>
                            <input type="text" class="form-control" id="bloodPressure">
                        </div>
                        <div class="col">
                            <label for="respiration">Nhịp thở</label>
                            <input type="text" class="form-control" id="respiration">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <label for="height">Chiều cao</label>
                            <input type="text" class="form-control" id="height">
                        </div>
                        <div class="col">
                            <label for="weight">Cân nặng</label>
                            <input type="text" class="form-control" id="weight">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex col-md-12">
            <!-- New Diagnosis Section (Bảng chẩn đoán bệnh) -->
            <div class="card mb-3 me-2 col-md-6">
                <div class="card-header">Chẩn đoán bệnh</div>
                <div class="card-body">
                    <form action="">
                        <div class="col mb-2">
                            <label for="pulse">Triệu chứng</label>
                            <textarea class="form-control" id="pulse">{{$user['book']->symptoms}}</textarea>
                        </div>
                        <div class="col">
                            <label for="temperature">Chuẩn đoán</label>
                            <textarea class="form-control" id="temperature"></textarea>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Clinical Tests -->
            <div class="card mb-3 col-md-6">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="row ">
                        <label for="testSelect">Chọn cận lâm sàng:</label>
                        <select id="testSelect" class="form-control right" onchange="addTest()">
                            <option value="">Chọn một cận lâm sàng</option>
                            @foreach($service as $data)
                                <option value="{{$data->service_id}}" data-price="{{$data->price}}">{{$data->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <form id="labForm">
                        <table class="table table-bordered" id="selectedTestsTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tên cận lâm sàng</th>
                                    <th>Thành tiền</th>

                                </tr>
                            </thead>
                            <tbody>
                                <!-- Đây là nơi các mục đã chọn sẽ được thêm vào -->
                            </tbody>
                        </table>

                        <div class="float-xxl-end">
                            <button class="btn btn-primary btn-sm" type="submit">IN</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Prescription Section -->
        <div class="card mb-3">
            <div class="card-header row col-md-12 justify-content-around align-items-center">
                <div class="col-md-4">Chỉ định dùng thuốc: 12/09/24 20:26</div>
                <div class="mb-3 col-md-8 d-flex mt-3">
                    <label for="days" class="form-label fw-bold mt-2">Ngày uống: </label>
                    <div class="d-flex align-items-center">
                        <span class="me-2" id="selectedDay">3 ngày</span>
                        <!-- Days Selection -->
                        <div class="btn-group" role="group" aria-label="Select days">
                            <input type="radio" class="btn-check" name="days" id="btnradio1" autocomplete="off"
                                value="3" checked>
                            <label class="btn btn-outline-primary rounded-0" for="btnradio1"
                                onclick="updateSelectedDay(3)">3</label>

                            <input type="radio" class="btn-check" name="days" id="btnradio2" autocomplete="off"
                                value="5">
                            <label class="btn btn-outline-primary" for="btnradio2"
                                onclick="updateSelectedDay(5)">5</label>

                            <input type="radio" class="btn-check" name="days" id="btnradio3" autocomplete="off"
                                value="7">
                            <label class="btn btn-outline-primary" for="btnradio3"
                                onclick="updateSelectedDay(7)">7</label>

                            <input type="radio" class="btn-check" name="days" id="btnradio4" autocomplete="off"
                                value="10">
                            <label class="btn btn-outline-primary" for="btnradio4"
                                onclick="updateSelectedDay(10)">10</label>

                            <input type="radio" class="btn-check" name="days" id="btnradio5" autocomplete="off"
                                value="14">
                            <label class="btn btn-outline-primary" for="btnradio5"
                                onclick="updateSelectedDay(14)">14</label>

                            <input type="radio" class="btn-check" name="days" id="btnradio6" autocomplete="off"
                                value="15">
                            <label class="btn btn-outline-primary rounded-0" for="btnradio6"
                                onclick="updateSelectedDay(15)">15</label>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên thuốc</th>
                        <th>DVT</th>
                        <th>Ngày uống</th>
                        <th>Lúc</th>
                        <th>SL</th>
                        <th>Cách dùng</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Atorhasan 20 (Atorvastatin 20mg)</td>
                        <td>Viên</td>
                        <td><input type="number" class="form-control" id="day_drink" value="3"></td>
                        <td>
                            <select class="form-control">
                                <option value="Sau ăn" selected>Sau ăn</option>
                                <option value="Trước ăn">Trước ăn</option>
                            </select>
                        </td>
                        <td> <span id="total_day_drink"></span></td>
                        <td>
                            <input type="text" class="form-control" value="Uống sáng 1 viên chiều 1 viên">
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>NOKLOT (Clopidogrel 75mg)</td>
                        <td>Viên</td>
                        <td><input type="number" class="form-control" value="3"></td>
                        <td>
                            <select class="form-control">
                                <option value="Sốt > 38 độ" selected>Sốt > 38 độ</option>
                                <option value="Khác">Khác</option>
                            </select>
                        </td>
                        <td><input type="number" class="form-control" value="12"></td>
                        <td>
                            <input type="text" class="form-control"
                                value="Uống sáng 1 viên | chiều 1 viên | tối 1 viên | Sốt > 38 độ">
                        </td>
                    </tr>
                </tbody>

            </table>
        </div>
    </div>
    <script>
        // JavaScript to update the selected day
        function updateSelectedDay(day) {
            document.getElementById('selectedDay').innerText = day + ' ngày';
            const drink = document.getElementById('day_drink').value;
            const ngay = document.getElementById('selectedDay').innerText;
            const total_day_drink = parseInt(drink) + parseInt(ngay);
            document.getElementById('total_day_drink').innerText = total_day_drink;
            console.log(total_day_drink);
        }
    </script>


    <div class="card mt-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div class="d-flex">
                <span class="badge bg-danger me-2">CLS</span>
                <span class="me-3">220.000</span>
                <span class="badge bg-success me-2">TH</span>
                <span class="me-3">33.000</span>
                <span class="badge bg-danger me-2">TC</span>
                <span class="me-3">253.000</span>
            </div>

            <div class="d-flex align-items-center">
                <input type="checkbox" id="reexam" class="me-2">
                <label for="reexam" class="me-3">Tái khám</label>

                <input type="text" class="form-control me-2" value="15/09/2024" style="width: 150px;">
                <select class="form-select me-3" style="width: 200px;">
                    <option selected>Nghỉ ngơi nhiều</option>
                    <option value="1">Chế độ ăn uống</option>
                    <option value="2">Vận động nhẹ nhàng</option>
                </select>

                <button type="button" class="btn btn-success me-2">Lưu</button>
                <button type="button" class="btn btn-secondary">Hủy</button>
            </div>
        </div>
    </div>

    </div>
@endsection
<script>
    function updatePrice(selectElement, priceId) {
        // Lấy giá từ thuộc tính data-price của tùy chọn đã chọn
        var price = selectElement.options[selectElement.selectedIndex].getAttribute('data-price');

        // Cập nhật giá vào ô tương ứng
        document.getElementById(priceId).innerText = price.replace(/\B(?=(\d{3})+(?!\d))/g, ".") + " đ"; // Format giá
    }

    function updateDetails(selectElement, formId, priceId) {
        // Cập nhật dạng thuốc
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const formValue = selectedOption.getAttribute('data-form');
        document.getElementById(formId).value = formValue;

        // Cập nhật giá
        const price = selectedOption.getAttribute('data-price');
        document.getElementById(priceId).textContent = new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }).format(price);
    }
</script>
<script>
    function addClinicalTest() {
        // Logic để thêm cận lâm sàng mới
        alert("Chức năng thêm cận lâm sàng chưa được thực hiện.");
    }
    function addTest() {
        const select = document.getElementById("testSelect");
        const selectedOption = select.options[select.selectedIndex];

        if (selectedOption.value === "") return; // Không làm gì nếu không có lựa chọn nào

        const testName = selectedOption.value;
        const testPrice = selectedOption.getAttribute("data-price");

        const tableBody = document.querySelector("#selectedTestsTable tbody");

        // Kiểm tra xem đã chọn chưa
        const existingRow = Array.from(tableBody.rows).find(row => row.cells[1].innerText === testName);
        if (existingRow) {
            alert("Cận lâm sàng này đã được thêm!");
            return;
        }

        const newRow = tableBody.insertRow();
        newRow.innerHTML = `
            <td>${tableBody.rows.length + 1}</td>
            <td>${testName}</td>
            <td>${new Intl.NumberFormat('vi-VN').format(testPrice)} VNĐ</td>
            <td><button class="btn btn-danger btn-sm" onclick="removeTest(this)">x</button></td>
        `;

        // Reset lại lựa chọn
        select.selectedIndex = 0;
    }

    function removeTest(button) {
        const row = button.closest("tr");
        row.parentNode.removeChild(row);

        // Cập nhật lại số thứ tự
        const tableBody = document.querySelector("#selectedTestsTable tbody");
        Array.from(tableBody.rows).forEach((row, index) => {
            row.cells[0].innerText = index + 1; // Cập nhật lại số thứ tự
        });
    }
</script>
