<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa Đơn</title>
    <style>
        @font-face {
            font-family: 'DejaVu Sans';
            src: url('{{ storage_path('fonts/DejaVuSans.ttf') }}');
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            color: #333;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .invoice-container {
            width: 800px;
            /* Hoặc chiều rộng mong muốn */
            background: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            line-height: 1.6;
            page-break-inside: avoid;
            margin: 20px auto;
            /* Căn giữa và thêm khoảng cách trên/bên dưới */
        }

        .header {
            width: 100%;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
            overflow: hidden;
        }

        .header-left p {
            font-size: 14px;
            margin: 0;
        }

        .header-left p:first-child {
            font-size: 16px;
            font-weight: bold;
        }



        .header img {
            width: 60px;
            float: left;
            margin-right: 15px;
            margin-bottom: 10px;
        }

        .title,
        .subtitle {
            text-align: center;
            margin: 0;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #666;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .info-section {
            font-size: 14px;
            width: 100%;
            margin-bottom: 50px;
        }

        .info-section p {
            float: left;
            margin: 0 1%;
            box-sizing: border-box;
        }

        .table-container {
            width: 100%;
            margin-bottom: 10px;
        }

        table {
            margin-top: 10px;
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            border: 1px solid #ddd;
            page-break-inside: avoid;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .payment-method {
            width: 60%;
            float: left;
            font-size: 14px;
            page-break-inside: avoid;
        }

        .total-section {
            font-size: 14px;
            text-align: right;
            margin-top: 12px;
            padding-right: 15px;
            page-break-inside: avoid;
        }

        .total-section p {
            margin: 3px 0;
        }

        .total-section p span {
            font-weight: bold;
        }

        /* Responsive design for smaller screens */
        @media (max-width: 768px) {
            body {
                width: 100%;
            }

            .info-section {
                text-align: left;
                float: none;
            }

        }

        /* Styles for print */
        @media print {
            body {
                margin: 0;
                /* Xóa margin của body */
                padding: 0;
                /* Xóa padding của body */
            }

            .invoice-container {
                width: 1000px;
                /* Kích thước cố định cho in ấn */
                margin: 0 auto;
                /* Căn giữa */
            }
        }
    </style>
</head>

<body>

    <div class="invoice-container">
        <div class="header">
            <div class="header-left">
                {{-- <img src="{{ asset('backend/assets/images/logos/logo.png') }}" alt="Logo"> --}}
                <p>Bệnh Viện VietCare</p>
                <p>Địa chỉ: 315, Nguyễn Văn Linh, An Khánh, Ninh Kiều</p>
                <p>SDT: 0292.382.0071 - 0292.382.3167</p>
            </div>
        </div>

        <div class="title">Chi tiết hóa đơn</div>
        <div class="subtitle">{{ \Carbon\Carbon::parse($orders->created_at)->format('s:i:h d/m/Y') }}</div>

        <div class="info-section">
            <p><strong>Mã hóa đơn:</strong> {{ $orders->order_id }}</p>
            <p><strong>Họ tên:</strong>
        
                    {{ $orders->book_name }}
            </p>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Dịch vụ</th>
                        <th>Đơn giá</th>
                    </tr>
                </thead>
                <tbody>
                <tbody>
                    <tr>
                        <td>{{ 1 }}</td>
                        <td>Khám online</td>
                        <td>{{ number_format($orders->total_price, 0, ',', '.') }} VND</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="footer">
            <div class="payment-method">
                <p><strong>Hình thức thanh toán:</strong> {{ $orders->payment == 0 ? 'Tiền mặt' : 'Chuyển khoản' }}</p>
            </div>

            <div class="total-section">
                <p><span>Tổng tiền:</span> {{ number_format($orders->total_price, 0, ',', '.') }} VND</p>
                @if ($orders->payment == 0)
                    <p><span>Khách đưa</span> {{ number_format($orders->cash_received, 0, ',', '.') }} VND</p>
                    <p><span>Tiền thừa</span>{{ number_format($orders->change_amount, 0, ',', '.') }} VND</p>
                @endif
                <p><span>Người thu ngân:</span> {{ $orders->user_lastname }} {{$orders->user_firstname}}</p>
            </div>
        </div>
    </div>

</body>

</html>
