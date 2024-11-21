// Lưu giá trị lựa chọn vào localStorage
function saveSelection(name, value) {
    localStorage.setItem(name, value);
}

// Lấy giá trị đã lưu từ localStorage
function loadSelection(name) {
    return localStorage.getItem(name);
}

// Hàm để load các tỉnh, quận, xã đã được chọn khi trang tải lại
function loadSavedSelections() {
    const savedProvinceCode = loadSelection("province");
    const savedDistrictCode = loadSelection("district");
    const savedWardCode = loadSelection("ward");
    // const savedprovinceName = loadSelection("provinceName");
    // const saveddistrictName = loadSelection("districtName");
    // const savedwardName = loadSelection("wardName");

    if (savedProvinceCode) {
        document.getElementById("provinces").value = savedProvinceCode;
        fetchDistricts(savedProvinceCode, savedProvinceCode); // Truyền thêm mã quận đã lưu
    }
    if (savedprovinceName) {
        document.getElementById("provinceName").value = savedprovinceName;
        fetchDistricts(savedprovinceName, savedprovinceName); // Truyền thêm mã quận đã lưu
    }

    if (savedDistrictCode) {
        document.getElementById("districts").value = savedDistrictCode;
        fetchWards(savedDistrictCode, savedDistrictCode); // Truyền thêm mã xã/phường đã lưu
    }
    if (saveddistrictName) {
        document.getElementById("districtName").value = saveddistrictName;
        fetchWards(saveddistrictName, saveddistrictName); // Truyền thêm mã xã/phường đã lưu
    }

    if (savedWardCode) {
        document.getElementById("wards").value = savedWardCode;
    }
    if (savedwardName) {
        document.getElementById("wardName").value = savedwardName;
    }
}

// Fetch các tỉnh
fetch("https://vn-public-apis.fpo.vn/provinces/getAll?limit=-1")
    .then((response) => response.json())
    .then((data) => {
        let provinces = data.data.data;
        provinces.forEach((value) => {
            const option = `<option value='${value.code}'>${value.name}</option>`;
            document.getElementById("provinces").innerHTML += option;
        });
        loadSavedSelections(); // Load các lựa chọn đã lưu
    })
    .catch((error) => {
        console.error("Lỗi khi gọi API:", error);
    });

// Fetch quận/huyện theo tỉnh
function fetchDistricts(provincesID, selectedDistrictCode = "") {
    fetch(`https://vn-public-apis.fpo.vn/districts/getByProvince?provinceCode=${provincesID}&limit=-1`)
        .then((response) => response.json())
        .then((data) => {
            let districts = data.data.data;
            document.getElementById("districts").innerHTML = `<option value=''>-- Chọn Quận/huyện --</option>`;
            if (districts && Array.isArray(districts)) {
                districts.forEach((value) => {
                    const isSelected = value.code === selectedDistrictCode ? "selected" : "";
                    document.getElementById("districts").innerHTML += `<option value='${value.code}' ${isSelected}>${value.name}</option>`;
                });
            }
        })
        .catch((error) => {
            console.error("Lỗi khi gọi API:", error);
        });
}

// Fetch xã/phường theo quận/huyện
function fetchWards(districtsID, selectedWardCode = "") {
    fetch(`https://vn-public-apis.fpo.vn/wards/getByDistrict?districtCode=${districtsID}&limit=-1`)
        .then((response) => response.json())
        .then((data) => {
            let wards = data.data.data;
            document.getElementById("wards").innerHTML = `<option value=''>-- Chọn Phường/xã --</option>`;
            if (wards) {
                wards.forEach((value) => {
                    const isSelected = value.code === selectedWardCode ? "selected" : "";
                    document.getElementById("wards").innerHTML += `<option value='${value.code}' ${isSelected}>${value.name}</option>`;
                });
            }
        })
        .catch((error) => {
            console.error("Lỗi khi gọi API:", error);
        });
}

// Hàm được gọi khi người dùng chọn tỉnh
function getProvinces(event) {
    const provinceCode = event.target.value; // Mã của tỉnh
    const provinceName = event.target.options[event.target.selectedIndex].text; // Tên tỉnh
    document.getElementById('provinceName').value = provinceName;
    saveSelection("province", provinceCode);
    saveSelection("provinceName", provinceName);
    fetchDistricts(provinceCode);
}

// Hàm được gọi khi người dùng chọn quận/huyện
function getDistricts(event) {
    const districtCode = event.target.value; // Mã của quận/huyện
    const districtName = event.target.options[event.target.selectedIndex].text; // Tên quận/huyện
    document.getElementById('districtName').value = districtName;
    saveSelection("district", districtCode);
    saveSelection("districtName", districtName);
    fetchWards(districtCode);
}

// Hàm được gọi khi người dùng chọn xã/phường
function getWards(event) {
    const wardCode = event.target.value; // Mã xã/phường
    const wardName = event.target.options[event.target.selectedIndex].text; // Tên xã/phường
    document.getElementById('wardName').value = wardName;

    saveSelection("ward", wardCode);
    saveSelection("wardName", wardName);
}

// Hàm kiểm tra nếu đã đủ thông tin (tỉnh, quận/huyện, xã/phường)
function checkAndCalculateShipping() {
    const provinceCode = document.getElementById("provinces").value;
    const districtCode = document.getElementById("districts").value;
    const wardCode = document.getElementById("wards").value;

    // Kiểm tra nếu đã chọn đủ thông tin
    if (provinceCode && districtCode && wardCode) {
        // Gọi route tính phí vận chuyển
        calculateShippingFee(provinceCode, districtCode, wardCode);
    } else {
        console.log("Chưa đủ thông tin tỉnh, quận, xã để tính phí vận chuyển.");
    }
}

// Hàm gọi route để tính phí vận chuyển (ví dụ gửi request tới server)
function calculateShippingFee(provinceCode, districtCode, wardCode) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch('http://127.0.0.1:8000/cua-hang/ship', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },


        body: JSON.stringify({
            province: provinceCode,
            district: districtCode,
            ward: wardCode
        })

    })
        .then(response => response.json())
        .then(data => {
            const formattedShippingFee = data.shippingFee.toLocaleString('vi-VN') + ' ₫';
            document.getElementById('shipping-fee').textContent = formattedShippingFee;
            const shippingFee = parseFloat(data.shippingFee);
            updateTotalSale(shippingFee);
        })
        .catch(error => {
            console.error("Lỗi khi tính phí vận chuyển:", error);
        });
}

function updateTotalSale(shippingFee) {
   
    const total = parseFloat(document.getElementById('total').textContent.replace(/[^\d.-]/g, '')) || 0;
    const sale = parseFloat(document.getElementById('sale').textContent.replace(/[^\d.-]/g, '')) || 0;

  
    let totalSale;
    if (shippingFee !== undefined && shippingFee !== null) {
        totalSale = total - sale + shippingFee;
    }else if(sale = 0 ) {
        totalSale = total - sale;
    }else{
        totalSale = total;
    }

   
    const formattedTotalSale = totalSale.toLocaleString('vi-VN') + ' ₫';

 
    document.getElementById('total_sale').textContent = formattedTotalSale;
    document.getElementById('total_final').value = totalSale;
}

// Đăng ký các sự kiện cho các lựa chọn
document.getElementById("provinces").addEventListener("change", function (event) {
    getProvinces(event);
    checkAndCalculateShipping(); // Kiểm tra và gọi tính phí
});
document.getElementById("districts").addEventListener("change", function (event) {
    getDistricts(event);
    checkAndCalculateShipping(); // Kiểm tra và gọi tính phí
});
document.getElementById("wards").addEventListener("change", function (event) {
    getWards(event);
    checkAndCalculateShipping(); // Kiểm tra và gọi tính phí
});



