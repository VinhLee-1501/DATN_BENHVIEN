<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận đặt lịch</title>
</head>

<body>
    <h1>Xác nhận đặt lịch thành công</h1>
    <p>Xin chào {{ $book->name }},</p>
    <p>Bạn đã đặt lịch khám thành công vào ngày {{ $book->day }} lúc {{ $book->hour }}. Dưới đây là thông tin chi
        tiết của bạn:</p>
    <ul>
        <li>Họ và tên: {{ $book->name }}</li>
        <li>Số điện thoại: {{ $book->phone }}</li>
        <li>Email: {{ $book->email }}</li>
        <li>Chuyên khoa: {{ $specialty->name }}</li>
        <li>Triệu chứng: {{ $book->symptoms }}</li>
        <li>Thời gian: {{ $book->day }} lúc {{ $book->hour }}</li>
    </ul>
    <p>Cảm ơn bạn đã tin tưởng và sử dụng dịch vụ của chúng tôi!</p>
</body>

</html>
