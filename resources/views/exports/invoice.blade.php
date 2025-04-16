<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Bukti Penjualan #{{ $sale->id }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            background-color: #fff;
            line-height: 1.5;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #dee2e6;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
            color: #333;
        }

        .header h2 {
            margin: 5px 0 10px;
            font-size: 18px;
            color: #555;
            font-weight: 500;
        }

        .header p {
            font-size: 14px;
            color: #777;
            margin: 0;
        }

        .customer-info {
            margin-bottom: 25px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }

        .customer-info p {
            margin: 5px 0;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            font-size: 14px;
        }

        th {
            background-color: #f8f9fa;
            font-weight: 600;
            text-align: left;
            padding: 12px 15px;
            border: 1px solid #dee2e6;
        }

        td {
            padding: 10px 15px;
            border: 1px solid #dee2e6;
        }

        .text-end {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .summary {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin: -10px;
        }

        .col-md-6 {
            flex: 0 0 50%;
            max-width: 50%;
            padding: 10px;
        }

        .small {
            font-size: 13px;
            color: #6c757d;
            margin-bottom: 5px;
        }

        .fw-bold {
            font-weight: 600;
            font-size: 15px;
            margin-bottom: 15px;
        }

        .text-danger {
            color: #dc3545;
        }

        .text-success {
            color: #28a745;
        }

        .fs-5 {
            font-size: 16px;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 14px;
            color: #6c757d;
            padding-top: 15px;
            border-top: 1px solid #dee2e6;
        }

        .d-flex {
            display: flex;
        }

        .justify-content-between {
            justify-content: space-between;
        }

        .mb-1 {
            margin-bottom: 5px;
        }

        .mb-2 {
            margin-bottom: 10px;
        }

        .mb-3 {
            margin-bottom: 15px;
        }

        .mb-4 {
            margin-bottom: 20px;
        }

        hr {
            margin: 15px 0;
            border: 0;
            border-top: 1px solid #dee2e6;
        }
    </style>
</head>

<body>
    @php
        $originalTotal = array_reduce($selectedProducts, function($carry, $product) {
            return $carry + ($product['price'] * $product['quantity']);
        }, 0);

        $pointsEarned = $sale->customer ? floor($originalTotal * 0.01) : 0;

        $totalHarga = max($originalTotal - $sale->poin, 0);
        $kembalian = $sale->total_pay - $totalHarga;

        $currentPoints = $pointsEarned;
        if ($sale->customer && $sale->poin == 0) {
            $currentPoints = $sale->customer->point + $pointsEarned;
        }
    @endphp

    <div class="header">
        <h1>BASS Store</h1>
        <h2>Bukti Penjualan</h2>
        <p>No: #{{ $sale->id }} | {{ $sale->created_at->format('d-M-Y') }}</p>
    </div>

    <div class="customer-info">
        <p><strong>Pelanggan:</strong> {{ $sale->customer ? $sale->customer->name : 'Non Member' }}</p>
        <p><strong>Kasir:</strong> {{ $sale->user->name }}</p>
        <p><strong>Tanggal:</strong> {{ $sale->created_at->format('d F Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="40%">Produk</th>
                <th width="20%" class="text-end">Harga</th>
                <th width="15%" class="text-center">Qty</th>
                <th width="25%" class="text-end">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($selectedProducts as $product)
                @php
                    $subTotal = $product['price'] * $product['quantity'];
                @endphp
                <tr>
                    <td>{{ $product['name'] }}</td>
                    <td class="text-end">Rp {{ number_format($product['price'], 0, ',', '.') }}</td>
                    <td class="text-center">{{ $product['quantity'] }}</td>
                    <td class="text-end">Rp {{ number_format($subTotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="row justify-content-end">
        <div class="col-md-6">
            <div class="summary">
                @if ($sale->customer)
                    @if ($sale->poin > 0)
                        <div class="d-flex justify-content-between mb-2">
                            <span class="small">POIN DIGUNAKAN</span>
                            <span class="fw-bold">{{ $sale->poin }} Poin (Rp. {{ number_format($sale->poin, 0, ',', '.') }})</span>
                        </div>
                    @endif

                    <div class="d-flex justify-content-between mb-2">
                        <span class="small">POIN DIDAPAT</span>
                        <span class="fw-bold">{{ $pointsEarned }} Poin</span>
                    </div>

                    <div class="col-md-6 mb-3">
                        <small class="text-muted">TOTAL POIN SEKARANG</small>
                        <div class="fw-bold">{{ $sale->customer ? $sale->customer->point : 0 }} Poin</div>
                    </div>
                @endif

                <div class="d-flex justify-content-between mb-2">
                    <span class="small">TOTAL HARGA AWAL</span>
                    <span class="fw-bold">Rp. {{ number_format($originalTotal, 0, ',', '.') }}</span>
                </div>

                @if ($sale->poin > 0)
                    <div class="d-flex justify-content-between mb-2 text-danger">
                        <span class="small">POTONGAN POIN</span>
                        <span class="fw-bold">- Rp. {{ number_format($sale->poin, 0, ',', '.') }}</span>
                    </div>
                @endif

                <div class="d-flex justify-content-between mb-2">
                    <span class="small">TOTAL BAYAR</span>
                    <span class="fw-bold">Rp. {{ number_format($sale->total_pay, 0, ',', '.') }}</span>
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <span class="small">KEMBALIAN</span>
                    <span class="fw-bold">Rp. {{ number_format(max($kembalian, 0), 0, ',', '.') }}</span>
                </div>

                <div class="d-flex justify-content-between mb-1">
                    <span class="small">TOTAL HARGA AKHIR</span>
                    <span class="fw-bold text-success fs-5">Rp. {{ number_format($totalHarga, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>Terima kasih telah berbelanja!</p>
    </div>
</body>

</html>
