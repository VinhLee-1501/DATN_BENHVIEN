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
        <td>${MedicineUnit}</td>
        <td style="width:15%"><input type="number" class="form-control" value="3" id="day_drink_${uniqueId}" oninput="updateRowDrink('${uniqueId}')"></td>
        <td>
            <select class="form-control" id="time_${uniqueId}" onchange="updateRowDrink('${uniqueId}')">
                <option value="Sau ăn" selected>Sau ăn</option>
                <option value="Trước ăn">Trước ăn</option>
            </select>
        </td>
        <td id="total_day_drink_${uniqueId}"></td>
        <td>
            <input type="text" class="form-control" id="usage_${uniqueId}" value="Mỗi lần uống 1 viên" oninput="updateRowDrink('${uniqueId}')">
        </td>
        <td><button class="btn btn-danger btn-sm" onclick="removeMedicine(this)">x</button></td>
    `;

    selectedMedicines.push({
        id: MedicineId,
        usage: "Mỗi lần uống 1 viên",
        dosage: 3,
        note: "Sau ăn",
        quantity: 3 * (parseInt(document.getElementById("selectedDay").innerText.replace(" ngày", "")) || 0)
    });

    updateRowDrink(uniqueId); // Cập nhật ngay sau khi thêm thuốc
    updateHiddenInput(); // Cập nhật input ẩn
    console.log("Selected medicines:", selectedMedicines);
}

function removeMedicine(button) {
    const row = button.closest("tr");
    const MedicineId = row.getAttribute("data-select2-id");
    selectedMedicines = selectedMedicines.filter(medicine => medicine.id !== MedicineId);
    row.parentNode.removeChild(row);

    const tableBody = document.querySelector("#tableMedicine tbody");
    Array.from(tableBody.rows).forEach((row, index) => {
        row.cells[0].innerText = index + 1; // Cập nhật lại số thứ tự
    });

    updateHiddenInput(); // Cập nhật input ẩn sau khi xóa thuốc
}

function updateRowDrink(uniqueId) {
    const dayInput = document.querySelector(`#day_drink_${uniqueId}`);
    const selectedDayElement = document.getElementById("selectedDay");
    const usageInput = document.querySelector(`#usage_${uniqueId}`);
    const timeSelect = document.querySelector(`#time_${uniqueId}`);
console.log(selectedDayElement);


    if (!dayInput || !selectedDayElement || !usageInput || !timeSelect) {
        console.error("Không tìm thấy phần tử cho uniqueId:", uniqueId);
        return;
    }

    const day = parseInt(dayInput.value) || 0;
    const selectedDay = parseInt(selectedDayElement.innerText.replace(" ngày", "")) || 0;
    const totalDrink = day * selectedDay;
    console.log(totalDrink);
    
    document.querySelector(`#total_day_drink_${uniqueId}`).innerText = totalDrink;

    const row = document.querySelector(`[data-select2-id="${uniqueId.split('-')[1]}"]`);
    if (!row) {
        console.error("Không tìm thấy hàng cho uniqueId:", uniqueId);
        return;
    }

    // Cập nhật lại thông tin thuốc trong mảng selectedMedicines
    const medicine = selectedMedicines.find(medicine => medicine.id === uniqueId.split('-')[1]);
    if (medicine) {
        medicine.dosage = day;
        medicine.note = timeSelect.value;
        medicine.usage = usageInput.value;
        medicine.quantity = totalDrink;
    }

    updateHiddenInput(); // Cập nhật input ẩn sau khi thay đổi thông tin thuốc
}

function updateHiddenInput() {
    const hiddenInput = document.getElementById("selectedMedicines");
    hiddenInput.value = JSON.stringify(selectedMedicines);
}

function updateSelectedDay(day) {
    document.getElementById('selectedDay').innerText = day + " ngày";
    const tableBody = document.querySelector("#tableMedicine tbody");
    Array.from(tableBody.rows).forEach((row, index) => {
        const uniqueId = `row-${index + 1}`;
        updateRowDrink(uniqueId);
    });



   // -- Cập nhật ngày tái khám theo ngày uống thuốc --
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

function addSelectedTest() {
    const select = document.getElementById("serviceSelect");
    const selectedOption = select.options[select.selectedIndex];

    if (selectedOption.value === "") return;

    const serviceId = selectedOption.value;
    const serviceName = selectedOption.getAttribute("data-name");
    const servicePrice = selectedOption.getAttribute("data-price");

    addTestFromDropdown(serviceId, serviceName, servicePrice);

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
        <td>${new Intl.NumberFormat("vi-VN").format(servicePrice)}.000 VNĐ</td>
        <td><button class="btn btn-danger btn-sm" onclick="removeTest(this, ${servicePrice})">x</button></td>
    `;

    totalAmount += Number(servicePrice);

    const total1 = new Intl.NumberFormat("vi-VN").format(totalAmount);
    document.getElementById('totalAmout').innerText = 'Tổng tiền: ' + new Intl.NumberFormat("vi-VN").format(totalAmount) + '.000 VNĐ';
    document.getElementById('total_service').innerText = new Intl.NumberFormat("vi-VN").format(totalAmount) + '.000';
    document.getElementById('cost').innerText = 30 + ".000";

    const total_end = Number(total1) + Number(30);
    document.getElementById('total_fullcost').innerText = new Intl.NumberFormat("vi-VN").format(total_end) + '.000 VNĐ';

    if (!selectService.includes(serviceId)) {
        selectService.push(
         serviceId );
    }
    console.log(selectService);
    updateHiddenInputService();

}


function removeTest(button, servicePrice) {
    const row = button.closest("tr");
    const serviceId = row.getAttribute("data-service-id");
    row.remove();

    totalAmount -= Number(servicePrice);

    document.getElementById('totalAmout').innerText = 'Tổng tiền: ' + new Intl.NumberFormat("vi-VN").format(totalAmount) + '.000 VNĐ';
    document.getElementById('total_service').innerText = new Intl.NumberFormat("vi-VN").format(totalAmount) + '.000';
    document.getElementById('total_fullcost').innerText = new Intl.NumberFormat("vi-VN").format(totalAmount + 30) + '.000 VNĐ';

    // Xóa serviceId khỏi mảng selectService
    const index = selectService.indexOf(serviceId);
    if (index > -1) {
        selectService.splice(index, 1);
    }
    console.log('xóa',selectService);
    updateHiddenInputService();
}
function updateHiddenInputService() {
    const hiddenInput = document.getElementById("selectService");
    hiddenInput.value = JSON.stringify(selectService);
    // console.log(hiddenInput);

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

