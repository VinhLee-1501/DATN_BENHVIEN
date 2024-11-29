function saveSelection(name, value) {
    localStorage.setItem(name, value);
}

function loadSelection(name) {
    return localStorage.getItem(name);
}

// Lấy danh sách tỉnh/thành phố
fetch("https://provinces.open-api.vn/api/?depth=1")
    .then((response) => response.json())
    .then((data) => {
        const provincesSelect = document.getElementById("provinces");
        const provincesName = document.getElementById("provinceName");

        data.forEach((province) => {
            provincesSelect.innerHTML += `<option value="${province.code}" data-name="${province.name}">${province.name}</option>`;
        });

        const savedProvince = loadSelection("province");
        if (savedProvince) {
            provincesSelect.value = savedProvince;
            provincesName.value = provincesSelect.options[provincesSelect.selectedIndex].getAttribute("data-name");
            fetchDistricts(savedProvince);
        }
    })
    .catch((error) => console.error("Lỗi khi gọi API provinces:", error));

// Lấy danh sách quận/huyện
function fetchDistricts(provinceCode) {
    fetch(`https://provinces.open-api.vn/api/p/${provinceCode}?depth=2`)
        .then((response) => response.json())
        .then((data) => {
            const districtsSelect = document.getElementById("districts");
            const districtName = document.getElementById("districtName");

            districtsSelect.innerHTML = `<option value="">-- Quận/huyện --</option>`;
            data.districts.forEach((district) => {
                districtsSelect.innerHTML += `<option value="${district.code}" data-name="${district.name}">${district.name}</option>`;
            });

            const savedDistrict = loadSelection("district");
            if (savedDistrict) {
                districtsSelect.value = savedDistrict;
                districtName.value = districtsSelect.options[districtsSelect.selectedIndex].getAttribute("data-name");
                fetchWards(savedDistrict);
            }
        })
        .catch((error) => console.error("Lỗi khi gọi API districts:", error));
}

// Lấy danh sách phường/xã
function fetchWards(districtCode) {
    fetch(`https://provinces.open-api.vn/api/d/${districtCode}?depth=2`)
        .then((response) => response.json())
        .then((data) => {
            const wardsSelect = document.getElementById("wards");
            const wardName = document.getElementById("wardName");

            wardsSelect.innerHTML = `<option value="">-- Phường/xã --</option>`;
            data.wards.forEach((ward) => {
                wardsSelect.innerHTML += `<option value="${ward.code}" data-name="${ward.name}">${ward.name}</option>`;
            });

            const savedWard = loadSelection("ward");
            if (savedWard) {
                wardsSelect.value = savedWard;
                wardName.value = wardsSelect.options[wardsSelect.selectedIndex].getAttribute("data-name");
            }
        })
        .catch((error) => console.error("Lỗi khi gọi API wards:", error));
}

// Sự kiện khi thay đổi tỉnh
document.getElementById("provinces").addEventListener("change", (event) => {
    const provincesSelect = event.target;
    const selectedOption = provincesSelect.options[provincesSelect.selectedIndex];
    const provincesName = document.getElementById("provinceName");

    provincesName.value = selectedOption.getAttribute("data-name");
    saveSelection("province", provincesSelect.value);

    document.getElementById("districts").innerHTML = `<option value="">-- Quận/huyện --</option>`;
    document.getElementById("wards").innerHTML = `<option value="">-- Phường/xã --</option>`;
    fetchDistricts(provincesSelect.value);
});

// Sự kiện khi thay đổi quận
document.getElementById("districts").addEventListener("change", (event) => {
    const districtsSelect = event.target;
    const selectedOption = districtsSelect.options[districtsSelect.selectedIndex];
    const districtName = document.getElementById("districtName");

    districtName.value = selectedOption.getAttribute("data-name");
    saveSelection("district", districtsSelect.value);

    document.getElementById("wards").innerHTML = `<option value="">-- Phường/xã --</option>`;
    fetchWards(districtsSelect.value);
});

// Sự kiện khi thay đổi phường
document.getElementById("wards").addEventListener("change", (event) => {
    const wardsSelect = event.target;
    const selectedOption = wardsSelect.options[wardsSelect.selectedIndex];
    const wardName = document.getElementById("wardName");

    wardName.value = selectedOption.getAttribute("data-name");
    saveSelection("ward", wardsSelect.value);
});

// Khôi phục giá trị đã lưu khi tải trang
document.addEventListener("DOMContentLoaded", () => {
    const savedProvince = loadSelection("province");
    if (savedProvince) fetchDistricts(savedProvince);

    const savedDistrict = loadSelection("district");
    if (savedDistrict) fetchWards(savedDistrict);

    const savedWard = loadSelection("ward");
    if (savedWard) document.getElementById("wards").value = savedWard;
});


// Hàm kiểm tra nếu đã đủ thông tin (tỉnh, quận/huyện, xã/phường)
function checkAndCalculateShipping() {
    const provinceCode = document.getElementById("provinces").value;
    const districtCode = document.getElementById("districts").value;
    const wardCode = document.getElementById("wards").value;
    
    if (provinceCode && districtCode && wardCode) {
        calculateShippingFee(provinceCode, districtCode, wardCode);
    } else {
        document.getElementById("shipping-fee").textContent =
            "Vui lòng chọn đầy đủ thông tin địa chỉ.";
        document.getElementById("shipping-fee").style.color = "red";
    }
}

// Hàm gọi route để tính phí vận chuyển (gửi request tới server)
function calculateShippingFee(provinceCode, districtCode, wardCode) {
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    fetch("http://127.0.0.1:8000/cua-hang/ship", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
        },
        body: JSON.stringify({
            province: provinceCode,
            district: districtCode,
            ward: wardCode,
        }),
    })
        .then((response) => {
            console.log(response);
            return response.json();
        })
        .then((data) => {
            if (data.shippingFee) {
                const formattedShippingFee =
                    data.shippingFee.toLocaleString("vi-VN") + " ₫";
                document.getElementById("shipping-fee").textContent =
                    formattedShippingFee;

                const shippingFee = parseFloat(data.shippingFee);
                saveSelection("shippingFee", shippingFee);
                updateTotalSale(shippingFee);
            } else {
            
                console.error("Lỗi: Không nhận được phí vận chuyển từ server.");
            }
        })
        .catch((error) => {
            console.error("Lỗi khi tính phí vận chuyển:", error);
            document.getElementById("shipping-fee").textContent =
                "Lỗi khi tính phí vận chuyển.";
        });
}

// Hàm cập nhật tổng tiền sau khi tính phí vận chuyển
function updateTotalSale(shippingFee) {
    const total =
        parseFloat(
            document.getElementById("total").textContent.replace(/[^\d.-]/g, "")
        ) || 0;
    const sale =
        parseFloat(
            document.getElementById("sale").textContent.replace(/[^\d.-]/g, "")
        ) || 0;

    let totalSale;

    if (shippingFee !== undefined && shippingFee !== null) {
        totalSale = total - sale + shippingFee;
    } else if (sale === 0) {
        totalSale = total - sale;
    } else {
        totalSale = total;
    }

    const formattedTotalSale = totalSale.toLocaleString("vi-VN") + " ₫";

    document.getElementById("total_sale").textContent = formattedTotalSale;
    document.getElementById("total_final").value = totalSale;
}

document
    .getElementById("provinces")
    .addEventListener("change", function (event) {
        getProvinces(event);
        checkAndCalculateShipping();
    });
document
    .getElementById("districts")
    .addEventListener("change", function (event) {
        getDistricts(event);
        checkAndCalculateShipping();
    });
document.getElementById("wards").addEventListener("change", function (event) {
    checkAndCalculateShipping();
});

document.addEventListener("DOMContentLoaded", () => {
    const savedShippingFee = loadSelection("shippingFee");

    // Kiểm tra và chuyển đổi giá trị nếu có
    if (savedShippingFee) {
        // Chuyển đổi giá trị string sang số (float)
        const shippingFee = parseFloat(savedShippingFee);

        // Kiểm tra xem giá trị có phải là một số hợp lệ không
        if (!isNaN(shippingFee)) {
            const formattedShippingFee = shippingFee.toLocaleString("vi-VN") + " ₫";
            document.getElementById("shipping-fee").textContent = formattedShippingFee;

            // Cập nhật tổng tiền khi có phí vận chuyển
            updateTotalSale(shippingFee); // Truyền số vào hàm tính toán tổng tiền
        }
    }
});

