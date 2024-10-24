<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận đặt lịch</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRlBeZHcZl2R77xKpG1gaJ5ppJ6DW2aegeOEP8nMR" crossorigin="anonymous">
</head>

<body class="bg-light">
    <div class="container my-5">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h1 class="text-center text-primary mb-4">Xác nhận đặt lịch thành công</h1>
                <p>Xin chào <strong>{{ $book->name }}</strong>,</p>
                <p>Bạn đã đặt lịch khám thành công vào ngày <strong>{{ $book->day }}</strong> lúc
                    <strong>{{ $book->hour }}</strong>. Dưới đây là thông tin chi tiết của bạn:
                </p>
                <ul class="list-group mb-4">
                    <li class="list-group-item"><strong>Họ và tên:</strong> {{ $book->name }}</li>
                    <li class="list-group-item"><strong>Số điện thoại:</strong> {{ $book->phone }}</li>
                    <li class="list-group-item"><strong>Email:</strong> {{ $book->email }}</li>
                    @if ($specialty->isNotEmpty())
                        <li class="list-group-item"><strong>Chuyên khoa:</strong>

                            @foreach ($specialty as $item)
                                {{ $item->name }}
                            @endforeach

                        </li>
                    @else
                        <li class="list-group-item"><strong>Chuyên khoa:</strong> Không có chuyên khoa</li>
                    @endif
                    <li class="list-group-item"><strong>Triệu chứng:</strong> {{ $book->symptoms }}</li>
                    <li class="list-group-item"><strong>Thời gian:</strong> {{ $book->day }} lúc {{ $book->hour }}
                    </li>
                </ul>
                <p class="text-center">Cảm ơn bạn đã tin tưởng và sử dụng dịch vụ của chúng tôi!</p>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS (optional for interactivity) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-8rbFvFYTZFBwTEQq7kJjS4URCpO7fu95aDqxIw5ElhFtyYPTEFz5vJ4VxF8CAB7S" crossorigin="anonymous">
    </script>
</body>

</html>
