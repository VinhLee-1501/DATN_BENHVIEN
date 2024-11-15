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
    const savedprovinceName = loadSelection("provinceName");
    const saveddistrictName = loadSelection("districtName");
    const savedwardName = loadSelection("wardName");

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

// Đăng ký các sự kiện cho các lựa chọn
document.getElementById("provinces").addEventListener("change", getProvinces);
document.getElementById("districts").addEventListener("change", getDistricts);
document.getElementById("wards").addEventListener("change", getWards);
