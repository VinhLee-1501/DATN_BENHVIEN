// --- Tìm thuốc start ---
$(document).ready(function () {
    $("#myAjaxSelect").select2();
});

function addSelectedMidicine() {
    const select = document.getElementById("myAjaxSelect");
    const selectedOption = select.options[select.selectedIndex];

    if (!selectedOption || selectedOption.value === "") return;

    const MedicineId = selectedOption.value;
    const MedicineName = selectedOption.getAttribute("data-name");
    const MedicineUnit = selectedOption.getAttribute("data-unit");

    addMedicineFromDropdown(MedicineId, MedicineName, MedicineUnit);

    select.selectedIndex = 0;
}

let selectedMedicines = [];

function addMedicineFromDropdown(MedicineId, MedicineName, MedicineUnit) {
    const tableBody = document.querySelector("#tableMedicine tbody");

    const existingRow = Array.from(tableBody.rows).find(
        (row) => row.getAttribute("data-select2-id") === MedicineId
    );

    if (existingRow) {
        alert("Thuốc này đã được thêm!");
        return;
    }

    const newRow = tableBody.insertRow();
    newRow.setAttribute("data-select2-id", MedicineId);
    const rowIndex = tableBody.rows.length;
    const uniqueId = `row-${MedicineId}`;

    newRow.innerHTML = `
        <td>${rowIndex}</td>
        <td>${MedicineName}</td>
        <td style="width:15%"><input type="number" class="form-control" min="1" value="3" id="day_drink_${uniqueId}" oninput="updateRowDrink('${uniqueId}')"></td>
        <td>
            <select class="form-control" id="time_${uniqueId}" onchange="updateRowDrink('${uniqueId}')">
                <option value="Sau ăn" selected>Sau ăn</option>
                <option value="Trước ăn">Trước ăn</option>
            </select>
        </td>
        <td>
            <p class="form-control" id="total_day_drink_${uniqueId}" ></p>
        </td>
        <td style="width:15%">
            <input type="number" class="form-control" value="1"  id="usage_${uniqueId}" oninput="updateRowDrink('${uniqueId}')" min="1">
        </td>
        <td class="margin-top:5px;">${MedicineUnit}</td>
        <td><button class="btn btn-danger btn-sm" onclick="removeMedicine(this)">x</button></td>
    `;

    selectedMedicines.push({
        id: MedicineId,
        name: MedicineName,
        unit: MedicineUnit, 
        usage: 1,
        dosage: 3,
        note: "Sau ăn",
        quantity:
            3 *
            (parseInt(
                document
                    .getElementById("selectedDay")
                    .innerText.replace(" ngày", "")
            ) || 0),
    });

    updateRowDrink(uniqueId); 
    updateHiddenInput(); 
    console.log("Selected medicines:", selectedMedicines);
}


function removeMedicine(button) {
    const row = button.closest("tr");
    const MedicineId = row.getAttribute("data-select2-id");
    selectedMedicines = selectedMedicines.filter(
        (medicine) => medicine.id !== MedicineId
    );
    row.parentNode.removeChild(row);

    const tableBody = document.querySelector("#tableMedicine tbody");
    Array.from(tableBody.rows).forEach((row, index) => {
        row.cells[0].innerText = index + 1; // Cập nhật lại số thứ tự
    });

    updateHiddenInput(); // Cập nhật input ẩn sau khi xóa thuốc
}

function updateRowDrink(uniqueId) {
    const dayInput = document.querySelector(`#day_drink_${uniqueId}`);
    const usageInput = document.querySelector(`#usage_${uniqueId}`);
    const timeSelect = document.querySelector(`#time_${uniqueId}`);
    const totalElement = document.querySelector(`#total_day_drink_${uniqueId}`);
    const selectedDayElement = document.getElementById("selectedDay");

    if (!dayInput || !usageInput || !timeSelect || !totalElement || !selectedDayElement) {
        console.error("Không tìm thấy phần tử cần thiết.");
        return;
    }

    const day = parseInt(dayInput.value) || 0;
    const selectedDay = parseInt(selectedDayElement.innerText.replace(" ngày", "")) || 0;
    const usage = parseInt(usageInput.value) || 0;
    const totalDrink = day * selectedDay * usage;

    // Cập nhật số lượng hiển thị
    totalElement.innerText = totalDrink;

    // Tìm hàng tương ứng trong mảng selectedMedicines
    const row = document.querySelector(`[data-select2-id="${uniqueId.split("-")[1]}"]`);
    if (!row) {
        console.error("Không tìm thấy hàng cho uniqueId:", uniqueId);
        return;
    }

    const medicine = selectedMedicines.find(
        (medicine) => medicine.id === uniqueId.split("-")[1]
    );
    if (medicine) {
        medicine.dosage = day;
        medicine.note = timeSelect.value;
        medicine.usage = usage;
        medicine.quantity = totalDrink;
    }

    updateHiddenInput(); // Cập nhật giá trị trong input ẩn
}


function updateHiddenInput() {
    const hiddenInput = document.getElementById("selectedMedicines");
    hiddenInput.value = JSON.stringify(selectedMedicines);
}


function updateSelectedDay(day) {
    // Cập nhật ngày uống hiển thị
    document.getElementById("selectedDay").innerText = day + " ngày";

    // Cập nhật số lượng thuốc cho từng dòng
    const tableBody = document.querySelector("#tableMedicine tbody");
    Array.from(tableBody.rows).forEach((row) => {
        const uniqueId = row.getAttribute("data-select2-id");
        if (uniqueId) {
            updateRowDrink(`row-${uniqueId}`);
        }
    });

    // Cập nhật ngày tái khám dựa trên ngày uống thuốc
    const today = new Date();
    today.setDate(today.getDate() + day);

    const dayOfMonth = String(today.getDate()).padStart(2, "0");
    const month = String(today.getMonth() + 1).padStart(2, "0");
    const year = today.getFullYear();
    const reexamDate = `${dayOfMonth}/${month}/${year}`;
    document.querySelector("#reexamDateInput").value = reexamDate;
}


// --- Tìm thuốc end ---

//--- Cận lâm sàng start ---
$(document).ready(function () {
    $("#myAjaxSelectService").select2({
        placeholder: "Tìm cận lâm sàng",
        allowClear: true,
        minimumInputLength: 1 // Người dùng phải nhập ít nhất 1 ký tự để tìm kiếm
    });
});

function addSelectService() {
    const select = document.getElementById("myAjaxSelectService");
    const selectedOption = select.options[select.selectedIndex];

    if (!selectedOption || selectedOption.value === "") return;

    const serviceId = selectedOption.value;
    const serviceName = selectedOption.getAttribute("data-name");
    const servicePrice = selectedOption.getAttribute("data-price"); // Lấy giá dịch vụ

    // Gọi hàm để thêm dịch vụ đã chọn
    addTestFromDropdown(serviceId, serviceName, servicePrice); // Truyền giá dịch vụ

    // Đặt lại lựa chọn
    select.selectedIndex = 0;
}

let totalAmount = 0;
let selectService = [];

function addTestFromDropdown(serviceId, serviceName, servicePrice) {
    const tableBody = document.querySelector("#selectedTestsTable tbody");

    const existingRow = Array.from(tableBody.rows).find(
        (row) => row.dataset.serviceId === serviceId
    );
    if (existingRow) {
        alert("Cận lâm sàng này đã được thêm!");
        return;
    }

    const newRow = tableBody.insertRow();
    newRow.setAttribute("data-service-id", serviceId);
    const rowIndex = tableBody.rows.length;
    newRow.innerHTML = `
        <td>${rowIndex}</td>
        <td>${serviceName}</td>
        <td>${new Intl.NumberFormat("vi-VN").format(servicePrice)} VNĐ</td>
        <td><button class="btn btn-danger btn-sm" onclick="removeTest(this, ${servicePrice})">x</button></td>
    `;

    totalAmount += Number(servicePrice);
    updateTotalAmount();

    if (!selectService.includes(serviceId)) {
        selectService.push(serviceId);
    }
    console.log(selectService);
    updateHiddenInputService();
}

function removeTest(button, servicePrice) {
    const row = button.closest("tr");
    const serviceId = row.getAttribute("data-service-id");
    row.remove();

    totalAmount -= Number(servicePrice);
    updateTotalAmount();

    // Xóa serviceId khỏi mảng selectService
    const index = selectService.indexOf(serviceId);
    if (index > -1) {
        selectService.splice(index, 1);
    }
    console.log("xóa", selectService);
    updateHiddenInputService();
}

function updateTotalAmount() {
    document.getElementById("totalAmout").innerText =
        "Tổng tiền: " +
        new Intl.NumberFormat("vi-VN").format(totalAmount) +
        " VNĐ";
    // document.getElementById("total_service").innerText =
    //     new Intl.NumberFormat("vi-VN").format(totalAmount) + " .000 VNĐ";
    // document.getElementById("cost").innerText = "30.000 VNĐ";

    // const total_end = totalAmount + 30;
    // document.getElementById("total_fullcost").innerText =
    //     new Intl.NumberFormat("vi-VN").format(total_end) + " .000 VNĐ";
}

function updateHiddenInputService() {
    const hiddenInput = document.getElementById("selectService");
    hiddenInput.value = JSON.stringify(selectService);
}


function Chose() {
    let serviceSelect = [];
    if (serviceSelect.length === 0) {
        alert("Bạn chưa xác định cận lâm sàng");
    
    
   }
}




// --- Cận lâm sàng end ---

// --- Thêm lời dặn  start----
function toggleCustomInput() {
    const select = document.getElementById("modeSelect");
    const customInput = document.getElementById("customInput");
    const finalAdvice = document.getElementById("finalAdvice");

    if (select.value === "custom") {
        customInput.style.display = "block";
        customInput.focus();
        select.style.display = "none";
    } else {
        customInput.style.display = "none";
        customInput.value = "";
        select.style.display = "block";
        finalAdvice.value = select.value;
    }
}

function updateSelectValue() {
    const select = document.getElementById("modeSelect");
    const customInput = document.getElementById("customInput");
    const finalAdvice = document.getElementById("finalAdvice");

    if (customInput.value) {
        finalAdvice.value = customInput.value;
    } else {
        finalAdvice.value = select.value;
    }
}

// --- Thêm lời dặn  end----



