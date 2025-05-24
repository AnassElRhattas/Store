<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <style>
        @font-face {
            font-family: 'Amiri';
            src: url('{{ storage_path('fonts/Amiri-Regular.ttf') }}') format('truetype');
        }

        body {
            font-family: 'Amiri', sans-serif;
            padding: 30px;
            color: #333;
            background: #fff;
            font-size: 12px;
            line-height: 1.6;
        }

        .footer {
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 22px;
            margin-bottom: 5px;
        }

        .store-info p, .invoice-info p {
            margin: 3px 0;
        }

        .section-title {
            font-size: 15px;
            font-weight: bold;
            margin: 15px 0 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 4px;
        }

        .details p {
            margin: 2px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px 10px;
        }

        th {
            background-color: #f5f5f5;
            font-weight: bold;
            text-align: left;
        }

        td.amount, th.amount {
            text-align: right;
        }

        tbody tr:nth-child(even) {
            background-color: #fafafa;
        }

        .total-section {
            width: 100%;
            margin-top: 20px;
        }

        .total-section td {
            padding: 8px 10px;
            border: none;
        }

        .total-section td:first-child {
            text-align: left;
            font-weight: bold;
        }

        .total-section td:last-child {
            text-align: right;
        }

        .total-border {
            border-top: 2px solid #374151;
        }

        .footer {
            text-align: center;
            font-size: 10px;
            color: #6B7280;
            padding-top: 12px;
            margin-top: 30px;
        }

        /* ✅ Supprimer les bordures du tableau de header */
        .no-border-table, .no-border-table th, .no-border-table td {
            border: none;
        }
    </style>
</head>
<body>
<div style="text-align: center; margin-bottom: 15px;">
    <img src="{{ public_path('images/logo.png') }}" alt="Store Hamid" style="height: 80px;">
</div>

<div class="header">
    <table class="no-border-table" style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
        <tr>
            <td style="vertical-align: top; width: 50%;">
                <h1 style="font-size: 22px; margin-bottom: 5px;">Store Hamid</h1>
                <p>123 Rue du Commerce</p>
                <p>El Jadida, Maroc</p>
                <p>Tél : +212 654-918565</p>
                <p>Email : hamid@storehamid.com</p>
            </td>
            <td style="vertical-align: top; width: 50%; text-align: right;">
                <h1 style="font-size: 22px; margin-bottom: 5px;">Facture</h1>
                <p>Facture N° : #{{ $order->id }}</p>
                <p>Date : {{ $order->created_at->format('d/m/Y') }}</p>
                <p>Référence : CMD-{{ $order->id }}</p>
            </td>
        </tr>
    </table>
</div>

<div>
    <div class="section-title">Client :</div>
    <div class="details">
        <p>Nom : {{ $order->customer_name }}</p>
        <p>Téléphone : {{ $order->customer_phone }}</p>
        <p>Adresse : {{ $order->shipping_address }}</p>
        <p>Mode de paiement : {{ $order->payment_method === 'cash' ? 'Paiement à la livraison' : 'Carte bancaire' }}</p>
    </div>
</div>

<div>
    <div class="section-title">Détails de la commande :</div>
    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th class="amount">Quantité</th>
                <th class="amount">Prix unitaire</th>
                <th class="amount">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td class="amount">{{ $item->quantity }}</td>
                <td class="amount">{{ number_format($item->price, 2) }} DH</td>
                <td class="amount">{{ number_format($item->price * $item->quantity, 2) }} DH</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="total-section">
        <tr class="total-border">
            <td>Total :</td>
            <td>{{ number_format($order->total_amount, 2) }} DH</td>
        </tr>
    </table>
</div>

<div class="footer">
    <p>Merci pour votre commande.</p>
    <p>Store Hamid - SARL au capital de XXXXX DH - RC : XXXXXX - IF : XXXXXX</p>
</div>

</body>
</html>
