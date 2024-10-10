$(document).ready(function () {
    var $popupLogin = $("#popupLogin");
    var $popupRegister = $("#popupRegister");
    var $popupForgotPassword = $("#popupForgotPassword");
    var $popupBooking = $("#popupBooking");

    var $btnLoginToRegister = $('.openPopup[data-popup="#popupRegister"]');
    var $btnLoginToForgotPassword = $(
        '.openPopup[data-popup="#popupForgotPassword"]'
    );
    var $btnRegisterToLogin = $('.openPopup[data-popup="#popupLogin"]');
    var $btnOpenBooking = $('.openPopup[data-popup="#popupBooking"]');
    var $closePopupButtons = $(".closePopup");

    function showPopup($popup, state) {
        $popup.addClass("active");
        removeScrollbar();
        history.pushState(state, "", "?popup=" + state); // Cập nhật URL
    }

    function hidePopup($popup) {
        $popup.removeClass("active");
        addScrollbar(); // Không làm mất thanh cuộn khi đóng popup
        history.pushState(null, "", window.location.pathname); // Quay lại URL cũ
    }

    $btnLoginToRegister.on("click", function (e) {
        e.stopPropagation();
        hidePopup($popupLogin);
        showPopup($popupRegister, "register");
    });

    $btnRegisterToLogin.on("click", function (e) {
        e.stopPropagation();
        hidePopup($popupRegister);
        showPopup($popupLogin, "login");
    });

    $btnLoginToForgotPassword.on("click", function (e) {
        e.stopPropagation();
        hidePopup($popupLogin);
        showPopup($popupForgotPassword, "forgot-password");
    });

    $btnOpenBooking.on("click", function (e) {
        e.stopPropagation();
        showPopup($popupBooking, "booking");
    });

    $closePopupButtons.on("click", function (e) {
        e.stopPropagation();
        hidePopup($popupLogin);
        hidePopup($popupRegister);
        hidePopup($popupForgotPassword);
        hidePopup($popupBooking);
    });

    function removeScrollbar() {
        $("body").css("overflow", "hidden");
    }

    function addScrollbar() {
        $("body").css("overflow", "auto"); // Phục hồi thanh cuộn khi đóng popup
    }

    // Xử lý khi người dùng quay lại trang
    $(window).on("popstate", function (e) {
        var state = e.originalEvent.state;
        if (state === "register") {
            showPopup($popupRegister, "register");
        } else if (state === "forgot-password") {
            showPopup($popupForgotPassword, "forgot-password");
        } else if (state === "booking") {
            showPopup($popupBooking, "booking");
        } else {
            hidePopup($popupLogin);
            hidePopup($popupRegister);
            hidePopup($popupForgotPassword);
            hidePopup($popupBooking);
        }
    });

    // Kiểm tra URL khi trang được tải lại
    var urlParams = new URLSearchParams(window.location.search);
    var popupParam = urlParams.get("popup");
    if (popupParam === "register") {
        showPopup($popupRegister, "register");
    } else if (popupParam === "forgot-password") {
        showPopup($popupForgotPassword, "forgot-password");
    } else if (popupParam === "booking") {
        showPopup($popupBooking, "booking");
    }
});
