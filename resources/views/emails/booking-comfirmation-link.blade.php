<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận đường dẫn cuộc họp</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRlBeZHcZl2R77xKpG1gaJ5ppJ6DW2aegeOEP8nMR" crossorigin="anonymous">
</head>

<body class="bg-light">
    <div class="container my-5">
        <div class="card shadow-sm">
            <div class="card-body p-4" style="width: 70%">
                <img src="{{ $message->embed(public_path('backend/assets/images/backgrounds/email_bg.png')) }}"
                    alt="" style="width: 100%">
                <h1 class="text-center text-primary mb-4" style="color: #048647; text-align: center">Thông báo hình thức</h1>
                <p>Xin chào <strong>{{ $book->name }}</strong>,</p>
                <p>Bạn đã đặt lịch khám thành công vào ngày <strong>{{ $book->day }}</strong> lúc
                    <strong>{{ $book->hour }}</strong>. Hãy <a href="{{ $book->url }}">Nhấp vào đây</a> để tham
                    gia cuộc hẹn vào lúc {{ $book->hour }}.
                </p>
                <p>Xin cảm ơn Quý khách đã tin tưởng và lựa chọn Vietcare.</p>
                <p>Chúng tôi đã nhận được yêu cầu của Quý khách và đã xác nhận lịch hẹn. Xin lưu ý rằng
                    lịch khám <strong>ĐÃ ĐƯỢC XÁC NHẬN</strong>. Nếu có bất kỳ thay đổi gì xin hãy liên hệ đường dây
                    nóng.</p>
                <p>Hotline: 02923 917 355</p>
                <p class="text-center">Cảm ơn bạn đã tin tưởng và sử dụng dịch vụ của chúng tôi!</p>
                <img src="{{ $message->embed(public_path('backend/assets/images/backgrounds/email_footer.png')) }}"
                    alt="" style="width: 100%">
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS (optional for interactivity) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-8rbFvFYTZFBwTEQq7kJjS4URCpO7fu95aDqxIw5ElhFtyYPTEFz5vJ4VxF8CAB7S" crossorigin="anonymous">
    </script>
</body>

</html>
