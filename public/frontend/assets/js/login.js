$(document).ready(function () {
    var $popupLogin = $('#popupLogin');
    var $popupRegister = $('#popupRegister');
    var $popupForgotPassword = $('#popupForgotPassword');

    var $btnLoginToRegister = $('.openPopup[data-popup="#popupRegister"]');
    var $btnLoginToForgotPassword = $('.openPopup[data-popup="#popupForgotPassword"]');
    var $btnRegisterToLogin = $('.openPopup[data-popup="#popupLogin"]');
    var $closePopupButtons = $('.closePopup');

    function showPopup($popup, state) {
        $popup.addClass('active');
        removeScrollbar();
        history.pushState(state, '', '?popup=' + state); // Cập nhật URL
    }

    function hidePopup($popup) {
        $popup.removeClass('active');
        removeScrollbar();
        history.pushState(null, '', window.location.pathname); // Quay lại URL cũ
    }

    $btnLoginToRegister.on('click', function (e) {
        e.stopPropagation();
        hidePopup($popupLogin);
        showPopup($popupRegister, 'register');
    });

    $btnRegisterToLogin.on('click', function (e) {
        e.stopPropagation();
        hidePopup($popupRegister);
        showPopup($popupLogin, 'login');
    });

    $btnLoginToForgotPassword.on('click', function (e) {
        e.stopPropagation();
        hidePopup($popupLogin);
        showPopup($popupForgotPassword, 'forgot-password');
    });

    $closePopupButtons.on('click', function (e) {
        e.stopPropagation();
        hidePopup($popupLogin);
        hidePopup($popupRegister);
        hidePopup($popupForgotPassword);
    });

    function removeScrollbar() {
        $("body").css("overflow", "hidden");
    }

    // Xử lý khi người dùng quay lại trang
    $(window).on('popstate', function (e) {
        var state = e.originalEvent.state;
        if (state === 'register') {
            showPopup($popupRegister, 'register');
        } else if (state === 'forgot-password') {
            showPopup($popupForgotPassword, 'forgot-password');
        } else {
            hidePopup($popupLogin);
            hidePopup($popupRegister);
            hidePopup($popupForgotPassword);
        }
    });

    // Kiểm tra URL khi trang được tải lại
    var urlParams = new URLSearchParams(window.location.search);
    var popupParam = urlParams.get('popup');
    if (popupParam === 'register') {
        showPopup($popupRegister, 'register');
    } else if (popupParam === 'forgot-password') {
        showPopup($popupForgotPassword, 'forgot-password');
    }
});
