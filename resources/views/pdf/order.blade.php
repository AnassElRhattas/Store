<!DOCTYPE html>
<html dir="rtl">
<head>
    <meta charset="utf-8">
    <style>
        @font-face {
            font-family: 'Amiri';
            src: url('{{ public_path('fonts/Amiri-Regular.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        body {
            font-family: 'Amiri', Arial, sans-serif;
            padding: 20px;
            direction: rtl;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            font-weight: bold;
            margin-bottom: 10px;
        }
        .item {
            margin-bottom: 5px;
        }
        .total {
            margin-top: 20px;
            font-weight: bold;
            text-align: left;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: right;
        }
        th {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>تفاصيل الطلب #{{ $order->id }}</h1>
        <p>تاريخ الطلب: {{ $order->created_at->format('Y/m/d') }}</p>
    </div>

    <div class="section">
        <div class="section-title">معلومات العميل</div>
        <div class="item">الاسم: {{ $order->user->name }} {{ $order->user->surname }}</div>
        <div class="item">البريد الإلكتروني: {{ $order->user->email }}</div>
    </div>

    <div class="section">
        <div class="section-title">عنوان التوصيل</div>
        <div class="item">{{ $order->shipping_address }}</div>
    </div>

    <div class="section">
        <div class="section-title">تفاصيل الطلب</div>
        <table>
            <thead>
                <tr>
                    <th>المنتج</th>
                    <th>الكمية</th>
                    <th>السعر</th>
                    <th>المجموع</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->price }} درهم</td>
                    <td>{{ $item->price * $item->quantity }} درهم</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="total">
        المجموع الكلي: {{ $order->total_amount }} درهم
    </div>
</body>
</html>