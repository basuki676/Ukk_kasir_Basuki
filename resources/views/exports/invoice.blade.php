<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Bukti Penjualan #{{ $sale->id }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            color: #333;
            background-color: #fff;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
        }

        .header h2 {
            margin: 5px 0 10px;
            font-size: 20px;
            color: #555;
        }

        .header p {
            font-size: 14px;
            color: #777;
        }

        .customer-info {
            margin-bottom: 25px;
            font-size: 14px;
        }

        .customer-info p {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
        }

        th {
            background-color: #f4f4f4;
            text-align: left;
        }

        .summary {
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 20px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin: -10px;
        }

        .col-md-6 {
            flex: 0 0 50%;
            padding: 10px;
        }

        .summary .small {
            font-size: 13px;
            color: #888;
        }

        .fw-bold {
            font-weight: bold;
            font-size: 15px;
        }

        .text-danger {
            color: #dc3545;
        }

        .text-success {
            color: #28a745;
        }

        .text-center {
            text-align: center;
        }

        .fs-5 {
            font-size: 18px;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 14px;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>BASS Store</h1>
        <h2>Bukti Penjualan</h2>
        <p>No: #{{ $sale->id }} | {{ $sale->created_at->format('d-M-Y') }}</p>
    </div>

    <div class="customer-info">
        <p><strong>Pelanggan:</strong> {{ $sale->customer ? $sale->customer->name : 'Non Member' }}</p>
        <p><strong>Kasir:</strong> {{ $sale->user->name }}</p>
        <p><strong>Tanggal:</strong> {{ $sale->created_at->format('d/m/Y H:i') }}</p>
    </div>

    <table>
        <tbody>
            @foreach ($selectedProducts as $product)
                @php
                    $subTotal = $product['price'] * $product['quantity'];
                @endphp
                <tr>
                    <td>{{ $product['name'] }}</td>
                    <td>Rp. {{ number_format($product['price'], 0, ',', '.') }}</td>
                    <td>{{ $product['quantity'] }}</td>
                    <td>Rp. {{ number_format($subTotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <div class="row">
            <div class="col-md-6">
                <div class="small">POIN DIGUNAKAN</div>
                <div class="fw-bold">{{ $sale->poin }} Poin (Rp. {{ number_format($sale->poin, 0, ',', '.') }})</div>
            </div>
            <div class="col-md-6">
                <div class="small">POIN DIDAPAT</div>
                <div class="fw-bold">{{ $pointsEarned }} Poin</div>
            </div>
            <div class="col-md-6">
                <div class="small">TOTAL POIN SEKARANG</div>
                <div class="fw-bold">{{ $sale->customer ? $sale->customer->point : 0 }} Poin</div>
            </div>
            <div class="col-md-6">
                <div class="small">KEMBALIAN</div>
                <div class="fw-bold">Rp. {{ number_format(max($kembalian, 0), 0, ',', '.') }}</div>
            </div>
            <div class="col-md-6">
                <div class="small">TOTAL HARGA AWAL</div>
                <div class="fw-bold">Rp. {{ number_format($totalHargaAwal, 0, ',', '.') }}</div>
            </div>
            <div class="col-md-6">
                <div class="small">TOTAL BAYAR</div>
                <div class="fw-bold">Rp. {{ number_format($totalBayar, 0, ',', '.') }}</div>
            </div>
            @if ($sale->poin > 0)
                <div class="col-md-6">
                    <div class="small">POTONGAN POIN</div>
                    <div class="fw-bold text-danger">- Rp. {{ number_format($sale->poin, 0, ',', '.') }}</div>
                </div>
            @endif
            <div class="col-md-6">
                <div class="small">TOTAL HARGA AKHIR</div>
                <div class="fw-bold text-success fs-5">Rp. {{ number_format($totalHarga, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>Terima kasih telah berbelanja!</p>
    </div>
</body>

</html>
