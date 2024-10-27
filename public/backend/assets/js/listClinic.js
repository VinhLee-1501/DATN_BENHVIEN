$(document).ready(function () {
    $('#seclectSpecialty').on('change', function () {
        var specialtyId = $(this).val();

        $.ajax({
            url: '/system/sclinics/filter-clinics/',
            type: 'GET',
            data: { specialty_id: specialtyId },
            success: function (response) {
    console.log('Response:', response); // Log toàn bộ response
    console.log('Active Clinics:', response.activeClinics);
    console.log('Inactive Clinics:', response.inactiveClinics);

    // Cập nhật bảng "Hoạt động"
    var activeTable = $('#activeTable tbody');
    activeTable.empty(); // Xóa dữ liệu cũ

    // Kiểm tra xem activeClinics có tồn tại và có độ dài > 0 không
    if (response.activeClinics && response.activeClinics.length > 0) {
        response.activeClinics.forEach(function (clinic, index) {
            activeTable.append(`
                <tr class="text-center">
                    <td class="border-bottom-0">${index + 1}</td>
                    <td class="border-bottom-0">${clinic.sclinic_id}</td>
                    <td class="border-bottom-0">${clinic.name}</td>
                    <td class="border-bottom-0">${clinic.specialtyName}</td>
                    <td class="border-bottom-0">
                        <a href="javascript:void(0)" class="btn btn-primary" onclick="openModalEdit('${clinic.specialty_id}')">
                            <i class="ti ti-pencil"></i>
                        </a>
                    </td>
                </tr>
            `);
        });
    } else {
        activeTable.append('<tr><td colspan="5" class="text-center">Không có phòng khám hoạt động</td></tr>');
    }

    // Cập nhật bảng "Ngừng hoạt động"
    var inactiveTable = $('#inactiveTable tbody');
    inactiveTable.empty();

    // Kiểm tra xem inactiveClinics có tồn tại và có độ dài > 0 không
    if (response.inactiveClinics && response.inactiveClinics.length > 0) {
        response.inactiveClinics.forEach(function (clinic, index) {
            inactiveTable.append(`
                <tr class="text-center">
                    <td class="border-bottom-0">${index + 1}</td>
                    <td class="border-bottom-0">${clinic.sclinic_id}</td>
                    <td class="border-bottom-0">${clinic.name}</td>
                    <td class="border-bottom-0">${clinic.specialtyName}</td>
                    <td class="border-bottom-0">
                        <a href="javascript:void(0)" class="btn btn-primary" onclick="openModalEdit('${clinic.specialty_id}')">
                            <i class="ti ti-pencil"></i>
                        </a>
                    </td>
                </tr>
            `);
        });
    } else {
        inactiveTable.append('<tr><td colspan="5" class="text-center">Không có phòng khám không hoạt động</td></tr>');
    }
},
            error: function (err) {
                console.error("Lỗi khi lấy dữ liệu:", err);
            }
        });
    });
});
