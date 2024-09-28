$(document).ready(function () {
    $("#myInput").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
$(() => {
    function confirmDelete() {
        return new Promise((resolve, reject) => {
            Swal.fire({
                title: "Bạn có chắc muốn xóa?",
                text: "Bạn sẽ không thể hoàn tác lại",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Đồng ý"
            }).then((result) => {
                if (result.isConfirmed) {
                    resolve(true);
                } else {
                    reject(false);
                }
            });
        });
    }

    $(document).on('click', '.btn-delete', function (e) {
        let item_id = $(this).data('id');
        confirmDelete().then(function () {
            $(`#form-delete${item_id}`).submit();
        }).catch();
    });
});