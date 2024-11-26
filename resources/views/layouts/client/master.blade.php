<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Phòng Khám</title>
    <link rel="shortcut icon" type="text/css" href="{{ asset('frontend/assets/image/logo-icon.png') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/library/fontawesome-6/css/all.min.css') }}" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('frontend/library/fancybox-master/dist/jquery.fancybox.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/library/jQueryUI/jquery-ui.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/library/hint/hint.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/library/slick/slick/slick.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/library/animate/animate.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/library/library/select2/select2.min.css') }}" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('frontend/library/simple-notify-master/dist/simple-notify.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets/css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets/css/login.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets/css/introduce.css') }}" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">



    <script type="text/javascript" src="{{ asset('frontend/library/jQuery/jquery-3.4.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/library/accounting/accounting.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/library/fancybox-master/dist/jquery.fancybox.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/library/jQueryUI/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/library/slick/slick/slick.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/library/wow/wow.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/library/select2/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/library/simple-notify-master/dist/simple-notify.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('frontend/assets/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
        integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="{{ asset('frontend/assets/js/app.js') }}"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>

<body>


    <div class="page home">
        {{-- header start --}}
        <x-client.header></x-client.header>
        {{-- header end --}}
        @yield('content')


    </div>

    {{-- footer start --}}
    <x-client.footer></x-client.footer>
    {{-- footer end --}}
    </div>

    {{-- popupSuccess start --}}
    <x-client.popupSuccess></x-client.popupSuccess>
    {{-- popupSuccess end --}}

    <x-client.fixed></x-client.fixed>
    {{-- popup start --}}
    <x-client.popupBooking :specialties="$specialties"/>
    <x-client.popupLogin></x-client.popupLogin>
    <x-client.popupResetPassword></x-client.popupResetPassword>

    {{-- popup end --}}


    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script>
        $(".form.booking .btn-booking").click(function() {
            var form = ".form.booking";
            var param = new Object();
            param.branch_name = $(form + " #select2-select-branch-container").attr(
                "title"
            );
            param.time = $(form + " #time").val();
            param.date = $(form + " #date").val();
            param.fullname = $(form + " #fullname").val();
            param.phone = $(form + " #phone").val();
            param.email = $(form + " #email").val();
            param.content = $(form + " #content").val();
            param.website = $(form + " #webiste").val();
            send_booking(form, param);
        });
    </script>
    <script>
        $(document).ready(function() {
            var $popupLogin = $('#popupLogin');
            var $popupRegister = $('#popupRegister');
            var $popupForgotPassword = $('#popupForgotPassword');
            var $popupBooking = $('#popupBooking');
            var $popupResetPassword = $('#popupResetPassword');
            



            var showPopup = "{{ $showPopup ?? '' }}";

            // Hiển thị popup nếu biến showPopup có giá trị 'login'
            if (showPopup === 'login') {
                $popupLogin.addClass('active');
                console.log('Popup should now be visible');
            }

            if (showPopup === 'register') {
                $popupRegister.addClass('active');
                console.log('Popup should now be visible');
            }

            if (showPopup === 'forgot-password') {
                $popupForgotPassword.addClass('active');
                console.log('Popup should now be visible');
            }
            if (showPopup === 'booking') {
                $popupBooking.addClass('active');
                console.log('Popup should now be visible');
            }
            if (showPopup === 'reset-password') {
                $popupResetPassword.addClass('active');
                console.log('Popup should now be visible');
            }


            // Đóng popup
            $('.closePopup').on('click', function() {
                $(this).closest('.popup').removeClass('active');
            });
        });
    </script>
    <script src="{{ asset('frontend/assets/js/login.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <x-message.message></x-message.message>


</body>

</html>
