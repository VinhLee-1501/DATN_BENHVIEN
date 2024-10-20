<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Phòng Khám</title>
    <link rel="shortcut icon" type="text/css" href="{{ asset('frontend/assets/image/logo.png') }}" />
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
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets/css/profile.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets/css/login.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets/css/introduce.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets/css/meeting.css') }}" />

    <script type="text/javascript" src="{{ asset('frontend/library/jQuery/jquery-3.4.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/library/accounting/accounting.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/library/fancybox-master/dist/jquery.fancybox.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/library/jQueryUI/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/library/slick/slick/slick.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/library/wow/wow.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/library/select2/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/library/simple-notify-master/dist/simple-notify.min.js') }}">
    </script>

    <!-- Import external JS libraries -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@0.20.0/dist/axios.min.js"></script>
    <script src="https://cdn.stringee.com/sdk/web/2.2.1/stringee-web-sdk.min.js"></script>
    <script type="text/javascript" src="{{ asset('frontend/assets/js/main.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
        integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="{{ asset('frontend/assets/js/app.js') }}"></script>
</head>

<body>
    <div class="page home">
        <x-client.header></x-client.header>
        <div class="meeting-container-main">
            <div class="meeting-container has-text-centered" v-cloak id="app">
                <h1 class="header-title">
                    Cuộc Họp
                    <span class="highlight">VietCare</span>
                </h1>
                <h4 style="color: #fff; text-align:center">Tính năng họp và gọi video dành cho tất cả mọi người</h4>

                <div class="button-container-main">
                    @php
                        $user = auth()->user();
                    @endphp

                    @if (auth()->check() && $user->role != 0)
                        <button class="action-button is-primary" v-if="!room" @click="createRoom">
                            Tạo Cuộc Họp <i class="fa-solid fa-video"></i>
                        </button>
                    @endif

                    <button class="action-button is-info" v-if="!room" @click="joinWithId">
                        Tham Gia Cuộc Họp <i class="fa-solid fa-user-plus"></i>
                    </button>

                    <button class="action-button is-info" v-if="room" @click="publish(true)">
                        Chia sẻ màn hình <i class="fa-duotone fa-solid fa-square-arrow-up-right"></i>
                    </button>

                    <button class="action-button is-danger" v-if="room" @click="endCall">
                        Kết Thúc Cuộc Họp <i class="fa-solid fa-right-from-bracket"></i>
                    </button>

                    <button class="action-button is-warning" v-if="room" @click="toggleScreenRecording">
                        <span v-if="isRecording">Dừng Ghi Màn Hình</span>
                        <span v-else>Ghi Màn Hình</span> <i class="fa-solid fa-record-vinyl"></i>
                    </button>
                </div>

                <div v-if="roomId" class="info-box">
                    <p>Bạn đang ở trong room <strong>@{{ roomId }}</strong>
                        <i class="fas fa-copy" @click="copyToClipboard(roomId, 'roomIdCopied')"
                            style="cursor: pointer;"></i>
                        <span v-if="roomIdCopied" class="copy-notification">Đã copy</span>
                        <!-- Thông báo copy cho roomId -->
                    </p>
                    <p>
                        Link tham gia
                        <code><a :href="roomUrl" target="_blank">@{{ roomUrl }}</a></code>
                        <i class="fas fa-copy" @click="copyToClipboard(roomUrl, 'roomUrlCopied')"
                            style="cursor: pointer;"></i>
                        <span v-if="roomUrlCopied" class="copy-notification">Đã copy</span>
                        <!-- Thông báo copy cho roomUrl -->
                    </p>
                    <p>Hoặc bạn cũng có thể copy <code>@{{ roomId }}</code> để share.</p>
                </div>
            </div>

            <div class="meeting-container">
                <div class="video-wrapper" id="videos"></div>
            </div>
        </div>
    </div>
    <x-client.fixed></x-client.fixed>
    <x-client.footer></x-client.footer>

    <!-- Include local JS files -->
    <script src="{{ asset('frontend/assets/js/api.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/meeting.js') }}"></script>
</body>

</html>
