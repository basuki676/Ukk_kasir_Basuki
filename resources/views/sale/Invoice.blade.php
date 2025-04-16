@extends('layout')

@section('content')
    @php
        // Calculate initial total price
        $totalHargaAwal = 0;
        foreach ($selectedProducts as $product) {
            $totalHargaAwal += $product['price'] * $product['quantity'];
        }

        // Calculate final price after point deduction
        $totalHarga = max($totalHargaAwal - $sale->poin, 0);

        $totalBayar = $sale->total_pay;
        $kembalian = $totalBayar - $totalHarga;

        // Calculate points earned (1% of final price)
        $pointsEarned;
    @endphp

    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 d-flex align-items-center">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard.view') }}" class="link">
                                    <i class="mdi mdi-home-outline fs-4"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Penjualan</li>
                            <li class="breadcrumb-item active" aria-current="page">Plilih Produk</li>
                            <li class="breadcrumb-item active" aria-current="page">Verivikasi Member</li>
                            <li class="breadcrumb-item active" aria-current="page">Invoice</li>
                        </ol>
                    </nav>
                    <h1 class="mb-0 fw-bold">Invoice</h1>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row bg-light px-3 py-4 gutters">
                <div class="col-xl-12">
                    <div class="card p-4">
                        <div class="card-body">
                            <!-- Header dalam Card -->
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h4 class="fw-bold">Detail Penjualan</h4>
                                </div>
                                <div class="text-end mt-">
                                    <div><strong>Invoice - #{{ $sale->id }}</strong></div>
                                    <div>{{ $sale->created_at->format('d-M-Y') }}</div>
                                </div>
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="mb-4">
                                <a href="{{ route('sale.export.pdf', $sale->id) }}" class="btn btn-primary me-2">
                                    <i class="icon-download"></i> Unduh
                                </a>
                                <a href="{{ route('sale.view') }}" class="btn btn-secondary">
                                    <i class="icon-printer"></i> Kembali
                                </a>
                            </div>

                            <!-- Tabel Produk -->
                            <div class="table-responsive mb-4">
                                <table class="table custom-table m-0">
                                    <thead>
                                        <tr>
                                            <th>Produk</th>
                                            <th>Harga</th>
                                            <th>Quantity</th>
                                            <th>Sub Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($selectedProducts as $product)
                                            @php
                                                $subTotal = $product['price'] * $product['quantity'];
                                            @endphp
                                            <tr class="service">
                                                <td>{{ $product['name'] }}</td>
                                                <td>Rp. {{ number_format($product['price'], 0, ',', '.') }}</td>
                                                <td>{{ $product['quantity'] }}</td>
                                                <td>Rp. {{ number_format($subTotal, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Rangkuman Total -->
                            <div class="card bg-light p-3">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <small class="text-muted">POIN DIGUNAKAN</small>
                                        <div class="fw-bold">{{ $sale->poin }} Poin (Rp.
                                            {{ number_format($sale->poin, 0, ',', '.') }})</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <small class="text-muted">KASIR</small>
                                        <div class="fw-bold">{{ $sale->user->name }}</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <small class="text-muted">POIN DIDAPAT</small>
                                        <div class="fw-bold">{{ $pointsEarned }} Poin</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <small class="text-muted">TOTAL POIN SEKARANG</small>
                                        <div class="fw-bold">{{ $sale->customer ? $sale->customer->point : 0 }} Poin</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <small class="text-muted">KEMBALIAN</small>
                                        <div class="fw-bold">Rp. {{ number_format(max($kembalian, 0), 0, ',', '.') }}</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <small class="text-muted">TOTAL HARGA AWAL</small>
                                        <div class="fw-bold">Rp. {{ number_format($totalHargaAwal, 0, ',', '.') }}</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <small class="text-muted">Total Bayar</small>
                                        <div class="fw-bold">Rp. {{ number_format($totalBayar, 0, ',', '.') }}</div>
                                    </div>
                                    @if ($sale->poin > 0)
                                        <div class="col-md-6 mb-3">
                                            <small class="text-muted">POTONGAN POIN</small>
                                            <div class="fw-bold text-danger">- Rp.
                                                {{ number_format($sale->poin, 0, ',', '.') }}</div>
                                        </div>
                                    @endif
                                    <div class="col-md-6 mb-3">
                                        <small class="text-muted">TOTAL HARGA AKHIR</small>
                                        <div class="fw-bold text-success fs-5">Rp.
                                            {{ number_format($totalHarga, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                            </div>

                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                </div>
            </div>
        </div>
    </div>
@endsection
