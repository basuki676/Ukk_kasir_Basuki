@extends('layout')

@section('content')
    @php
        $totalHarga = 0;
        foreach ($selectedProducts as $product) {
            $totalHarga += $product['price'] * $product['quantity'];
        }
        $totalBayar = $sale->total_pay;
        $kembalian = $totalBayar - $totalHarga;
        $currentPoints = $sale->customer ? $sale->customer->point : 0;
        $potentialPoints = floor($totalHarga * 0.01);
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
                            <li class="breadcrumb-item active" aria-current="page">Transaksi Member</li>
                        </ol>
                    </nav>
                    <h1 class="mb-0 fw-bold">Transaksi Member</h1>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('sale.member.post', ['id' => $sale->id]) }}" method="POST">
                                @csrf
                                <div class="row">
                                    <!-- Product Column -->
                                    <div class="col-lg-6 col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Nama Produk</th>
                                                        <th>Qty</th>
                                                        <th>Harga</th>
                                                        <th>Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($selectedProducts as $product)
                                                        @php
                                                            $subTotal = $product['price'] * $product['quantity'];
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $product['name'] }}</td>
                                                            <td>{{ $product['quantity'] }}</td>
                                                            <td>Rp {{ number_format($product['price'], 0, ',', '.') }}</td>
                                                            <td>Rp {{ number_format($subTotal, 0, ',', '.') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="3">Total Harga Awal</th>
                                                        <th>Rp {{ number_format($totalHarga, 0, ',', '.') }}</th>
                                                    </tr>
                                                    <tr id="discount-row" style="display: none;">
                                                        <th colspan="3">Diskon Poin</th>
                                                        <th id="discount-amount">-Rp 0</th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="3">Total Harga Akhir</th>
                                                        <th id="total-price-display">Rp
                                                            {{ number_format($totalHarga, 0, ',', '.') }}</th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="3">Total Bayar</th>
                                                        <th>Rp {{ number_format($totalBayar, 0, ',', '.') }}</th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="3">Poin Didapat</th>
                                                        <th id="points-earned-display">{{ floor($totalHarga * 0.01) }}</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Member Form Column -->
                                    <div class="col-lg-6 col-md-12">
                                        <input type="hidden" name="sale_id" value="{{ $sale->id }}">
                                        @if ($sale->customer)
                                            <input type="hidden" name="customer_id" value="{{ $sale->customer->id }}">
                                            <input type="hidden" id="current_points" value="{{ $currentPoints }}">
                                        @endif

                                        <div class="form-group mb-3">
                                            <label for="name" class="form-label">Nama Member</label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ old('name', $sale->customer ? $sale->customer->name : '') }}"
                                                required>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="form-label">Poin Saat Ini</label>
                                            <input type="text" class="form-control" value="{{ $currentPoints }}"
                                                disabled>
                                        </div>



                                        <div class="form-check mb-3">
                                            <input type="checkbox" name="check_poin" value="Ya" id="check_poin"
                                                class="form-check-input">
                                            <label for="check_poin" class="form-check-label">Gunakan Semua Poin</label>
                                        </div>

                                        <div class="form-group mb-3" id="point_use_container" style="display: none;">
                                            <label for="points_to_use" class="form-label">Jumlah Poin Digunakan</label>
                                            <input type="number" name="points_to_use" id="points_to_use"
                                                class="form-control" readonly>
                                        </div>

                                        <div class="text-end mt-4">
                                            <button type="submit" class="btn btn-primary">Proses Transaksi</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkBox = document.getElementById('check_poin');
            const pointContainer = document.getElementById('point_use_container');
            const pointsInput = document.getElementById('points_to_use');
            const currentPoints = {{ $currentPoints }};
            const initialPrice = {{ $totalHarga }};

            function updatePriceDisplay() {
                let pointsUsed = checkBox.checked ? currentPoints : 0;
                pointsInput.value = pointsUsed;

                const discount = pointsUsed; // Perubahan di sini (tidak dikali 100)
                const finalPrice = Math.max(initialPrice - discount, 0);
                const pointsEarned = Math.floor(finalPrice * 0.01);

                // Update tampilan
                document.getElementById('discount-amount').textContent = `-Rp ${discount.toLocaleString('id-ID')}`;
                document.getElementById('total-price-display').textContent =
                    `Rp ${finalPrice.toLocaleString('id-ID')}`;
                document.getElementById('points-earned-display').textContent = pointsEarned;

                // Toggle discount row visibility
                document.getElementById('discount-row').style.display = discount > 0 ? 'table-row' : 'none';
            }

            // Initialize
            if (checkBox.checked) {
                pointContainer.style.display = 'block';
                updatePriceDisplay();
            }

            // Event listener
            checkBox.addEventListener('change', function() {
                pointContainer.style.display = this.checked ? 'block' : 'none';
                updatePriceDisplay();
            });
        });
    </script>
@endsection
