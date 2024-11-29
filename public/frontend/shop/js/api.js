function saveSelection(name, value) {
    localStorage.setItem(name, value);
}

function loadSelection(name) {
    return localStorage.getItem(name);
}

fetch("https://provinces.open-api.vn/api/?depth=1")
    .then((response) => response.json())
    .then((data) => {
        let provinces = data;
        let provincesSelect = document.getElementById("provinces");

        provinces.map((value) => {
            provincesSelect.innerHTML += `<option value='${value.code}'>${value.name}</option>`;
        });

        const savedProvince = loadSelection("province");
        if (savedProvince) {
            provincesSelect.value = savedProvince;
            fetchDistricts(savedProvince);
        }
    })
    .catch((error) => {
        console.error("Lỗi khi gọi API provinces:", error);
    });

function fetchDistricts(provinceCode) {
    fetch(`https://provinces.open-api.vn/api/p/${provinceCode}?depth=2`)
        .then((response) => response.json())
        .then((data) => {
            let districts = data.districts || [];
            let districtsSelect = document.getElementById("districts");

            // Đảm bảo luôn có option mặc định cho quận/huyện
            districtsSelect.innerHTML = `<option value=''>-- Quận/huyện --</option>`;

            districts.map((value) => {
                districtsSelect.innerHTML += `<option value='${value.code}'>${value.name}</option>`;
            });

            const savedDistrict = loadSelection("district");
            if (savedDistrict) {
                districtsSelect.value = savedDistrict;
                fetchWards(savedDistrict);
            }
        })
        .catch((error) => {
            console.error("Lỗi khi gọi API districts:", error);
        });
}

function fetchWards(districtCode) {
    fetch(`https://provinces.open-api.vn/api/d/${districtCode}?depth=2`)
        .then((response) => response.json())
        .then((data) => {
            let wards = data.wards || [];
            let wardsSelect = document.getElementById("wards");

            // Luôn hiển thị option mặc định -- Phường/xã --
            wardsSelect.innerHTML = `<option value=''>-- Phường/xã --</option>`;

            wards.map((value) => {
                wardsSelect.innerHTML += `<option value='${value.code}'>${value.name}</option>`;
            });

            const savedWard = loadSelection("ward");
            if (savedWard) {
                wardsSelect.value = savedWard;
            }
        })
        .catch((error) => {
            console.error("Lỗi khi gọi API wards:", error);
        });
}

function getProvinces(event) {
    const selectedProvince = event.target.value;
    saveSelection("province", selectedProvince);
    fetchDistricts(selectedProvince);
    
    // Sau khi chọn tỉnh mới, giữ lại option mặc định cho quận/huyện
    const districtsSelect = document.getElementById("districts");
    districtsSelect.innerHTML = `<option value=''>-- Quận/huyện --</option>`;
    
    // Cập nhật phường/xã nếu có
    const wardsSelect = document.getElementById("wards");
    wardsSelect.innerHTML = `<option value=''>-- Phường/xã --</option>`;
}

function getDistricts(event) {
    const selectedDistrict = event.target.value;
    saveSelection("district", selectedDistrict);
    fetchWards(selectedDistrict);
}

function getWards(event) {
    const selectedWard = event.target.value;
    saveSelection("ward", selectedWard);
}



document.addEventListener("DOMContentLoaded", function () {
    const savedProvince = loadSelection("province");
    if (savedProvince) {
        fetchDistricts(savedProvince);
    }

    const savedDistrict = loadSelection("district");
    if (savedDistrict) {
        fetchWards(savedDistrict);
    }

    const savedWard = loadSelection("ward");
    if (savedWard) {
        const wardsSelect = document.getElementById("wards");
        wardsSelect.value = savedWard;
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const savedProvince = loadSelection("province");
    if (savedProvince) {
        fetchDistricts(savedProvince);
    }

    const savedDistrict = loadSelection("district");
    if (savedDistrict) {
        fetchWards(savedDistrict);
    }

    const savedWard = loadSelection("ward");
    if (savedWard) {
        const wardsSelect = document.getElementById("wards");
        wardsSelect.value = savedWard;
    }
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
