<!DOCTYPE html>
<html>

<head>
    <title>Bukti Penjualan #{{ $sale->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .text-right {
            text-align: right;
        }

        .mt-5 {
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>FlexyLite</h1>
        <h2>Bukti Penjualan</h2>
        <p>No: {{ $sale->id }}</p>
    </div>

    <div class="customer-info">
        <p><strong>Pelanggan:</strong> {{ $sale->customer ? $sale->customer->name : 'Non Member' }}</p>
        <p><strong>Tanggal:</strong> {{ $sale->created_at->format('d/m/Y H:i') }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sale->detailSales as $detail)
                <tr>
                    <td>{{ $detail->product->name }}</td>
                    <td>{{ $detail->amount }}</td>
                    <td>Rp {{ number_format($detail->product->price, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($detail->sub_total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-right"><strong>Total:</strong></td>
                <td><strong>Rp {{ number_format($sale->total_price, 0, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
    </table>

    <div class="mt-5">
        <p>Terima kasih telah berbelanja!</p>
        <p>Kasir: {{ $sale->user->name }}</p>
    </div>
</body>

</html>
