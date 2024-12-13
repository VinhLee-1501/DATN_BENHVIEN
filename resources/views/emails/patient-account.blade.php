<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin tài khoản bệnh nhânnhân</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRlBeZHcZl2R77xKpG1gaJ5ppJ6DW2aegeOEP8nMR" crossorigin="anonymous">
</head>

<body class="bg-light">
    <div class="container my-5">
        <div class="card shadow-sm">
            <div class="card-body p-4" style="width: 100%; max-width: 800px; margin: 0 auto;">
                <!-- Header Image -->
                <img src="{{ $message->embed(public_path('backend/assets/images/backgrounds/email_bg.png')) }}"
                    alt="Background Image" style="width: 100%;">

                <!-- Title -->
                <h1 class="text-center text-primary mb-4" style="color: #048647; text-align: center">Thông tin tài khoản bệnh nhân</h1>

                <!-- Body Content -->
                <p>Xin chào <strong>{{ $lastname }} {{ $firstname }}</strong>,</p>
                <p>Chúc mừng bạn đã đăng ký tài khoản bệnh nhân thành công tại Vietcare. Dưới đây là thông tin tài khoản của bạn:</p>
                
                <ul>
                    <li><strong>Tên:</strong> {{ $firstname }} {{ $lastname }}</li>
                    <li><strong>Email:</strong> {{ $email }}</li>
                    <li><strong>Số điện thoại:</strong> {{ $phone }}</li>
                    <li><strong>Mật khẩu tạm thời:</strong> {{ $firstname . $user_id }}</li>
                </ul>

                <p>Vui lòng sử dụng số điện thoại vàvà mật khẩu tạm thời trên để đăng nhập vào hệ thống. Bạn có thể thay đổi mật khẩu sau khi đăng nhập.</p>
                <p>Xin cảm ơn bạn đã tin tưởng và lựa chọn Vietcare.</p>

                <p>Trân trọng,</p>
                <p>Đội ngũ Vietcare</p>

                <img src="{{ $message->embed(public_path('backend/assets/images/backgrounds/email_footer.png')) }}"
                    alt="Footer Image" style="width: 100%;">
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS (optional for interactivity) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-8rbFvFYTZFBwTEQq7kJjS4URCpO7fu95aDqxIw5ElhFtyYPTEFz5vJ4VxF8CAB7S" crossorigin="anonymous">
    </script>
</body>

</html>
