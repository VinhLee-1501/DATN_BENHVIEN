<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Phiếu Chỉ Định Cận Lâm Sàng</title>
    <style>
        @font-face {
            font-family: 'DejaVu Sans';
            src: url('{{ storage_path('fonts/DejaVuSans.ttf') }}');
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            width: 100%;
            height: 600px;
        }

        .header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .header img {
            width: 100px;
            height: auto;
            margin-right: 10px;
        }

        .header .hospital-info {
            text-align: left;
            position: absolute;
        }

        .header h4,
        .header p {
            margin: 2px 0;
        }

        .header h4 {
            font-size: 18px;
            text-transform: uppercase;
        }

        h2 {
            text-align: center;
        }

        .patient-info p,
        .footer p {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        .note {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .total_price {
            font-weight: bold;
            text-align: right;
            right: 0;
            position: absolute;
        }

        .footer {
            position: absolute;
            right: 0;
            text-align: right;
        }

        .codeService {
           
            margin-top: 0;
            position: absolute;
            right: 0;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ base_path('public/backend/assets/images/logos/logo.png') }}" alt="Hospital Logo">
        <div class="hospital-info">
            <h4>Bệnh Viện VietCare</h4>
            <p><strong>Địa chỉ: </strong>315, Nguyễn Văn Linh, An Khánh, Ninh Kiều</p>
            <p><strong>SĐT: </strong> 0292.382.0071 - 0292.382.3167</p>
        </div>
        <div class="codeService">
            {{-- <h5>Mã: </h5> --}}
            {!! $barcode !!}
            {{ $data['order_id'] }}
        </div>
    </div>


    <h2>PHIẾU CHỈ ĐỊNH CẬN LÂM SÀNG</h2>
    <div class="patient-info">
        <p><strong>Họ tên người bệnh:</strong> {{ $data['medical'][0]->last_name }}
            {{ $data['medical'][0]->first_name }}</p>
        <p><strong>Ngày sinh:</strong> 2004</p>
        <p><strong>Địa chỉ:</strong> {{ $data['medical'][0]->address }}</p>
        @if ($data['medical'][0]->gender == 1)
            <p><strong>Giới tính:</strong> Nam</p>
        @else
            <p><strong>Giới tính:</strong> Nữ</p>
        @endif
        <p><strong>Khoa khám bệnh:</strong> {{ $data['specialty'][0]->name }}</p>
    </div>

    <h3>Nội Dung Chỉ Định</h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Tên cận lâm sàng</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            @php $count = 1; @endphp
            @foreach ($data['services'] as $item)
                @php $int = $count++ @endphp
                <tr>
                    <td>{{ $int }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ number_format($item->price, 0, ',', '.') }} VNĐ</td>
                </tr>
            @endforeach
            <tr>
                <td></td>
                <td>Phí dịch vụ</td>
                <td>{{ number_format(20000, 0, ',', '.') }} VNĐ</td>
            </tr>
        </tbody>
    </table>
    <div class="note">
        <p class="total_price">Tổng cộng: {{ number_format($data['total'], 0, ',', '.') }} VNĐ</p>
        <p class="notes"><strong>Ghi chú:</strong> </p>
    </div>

    <div class="footer">
        <p><strong>Ngày:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
        <p><strong>Bác sĩ điều trị:</strong> {{ $data['medical'][0]->lastname }} {{ $data['medical'][0]->firstname }}
        </p>

    </div>
</body>

</html>
