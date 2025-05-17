<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @font-face {
            font-family: 'Amiri';
            src: url('{{ storage_path('fonts/Amiri-Regular.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
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
        <h1>Détails de la commande #{{ $order->id }}</h1>
        <p>Date de commande : {{ $order->created_at->format('d/m/Y') }}</p>
    </div>

    <div class="section">
        <div class="section-title">Informations client</div>
        <div class="item">Nom : {{ $order->user->name }} {{ $order->user->surname }}</div>
        <div class="item">Email : {{ $order->user->email }}</div>
    </div>

    <div class="section">
        <div class="section-title">Adresse de livraison</div>
        <div class="item">{{ $order->shipping_address }}</div>
    </div>

    <div class="section">
        <div class="section-title">Détails de la commande</div>
        <table>
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Prix</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->price }} DH</td>
                    <td>{{ $item->price * $item->quantity }} DH</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="total">
        Total : {{ $order->total_amount }} DH
    </div>
</body>
</html>