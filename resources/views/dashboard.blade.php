@extends('layout')

@section('content')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 d-flex align-items-center">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.view') }}" class="link"><i
                                        class="mdi mdi-home-outline fs-4"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </nav>
                    <h1 class="mb-0 fw-bold">Dashboard</h1>
                </div>
            </div>
        </div>

        @if (auth()->user()->role == 'admin')
            <!-- Charts untuk Admin -->
            <div class="row mt-4">
                <!-- Bar Chart Column -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Sales Trend (Bar Chart)</h4>
                            <div class="chart-container" style="position: relative; height: 400px;">
                                <canvas id="salesChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pie Chart Column -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Product Distribution (Pie Chart)</h4>
                            <div class="chart-container" style="position: relative; height: 400px;">
                                <canvas id="productChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif(auth()->user()->role == 'employe')
            <!-- Employee View -->
            <div class="card-body">
                <div class="card d-block m-auto text-center">
                    <div class="card-header">
                        Total Penjualan Hari Ini
                    </div>
                    <div class="card-body">
                        <h3 class="card-title">{{ $todayTransactionCount }}</h3>
                        <p class="card-text">Jumlah total penjualan yang terjadi hari ini.</p>
                    </div>
                    <div class="card-footer text-muted">
                        Terakhir diperbarui: {{ $lastUpdated }}
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('styles')
    <style>
        .chart-container {
            width: 100%;
            min-height: 400px;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (auth()->user()->role == 'admin')
                // Sales Bar Chart
                const salesCtx = document.getElementById('salesChart')?.getContext('2d');
                if (salesCtx) {
                    const salesChart = new Chart(salesCtx, {
                        type: 'bar',
                        data: {
                            labels: @json($chartData['dates']),
                            datasets: [{
                                label: 'Total Penjualan',
                                data: @json($chartData['totals']),
                                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1,
                                barThickness: 40
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 1
                                    }
                                }
                            }
                        }
                    });
                } else {
                    console.warn("Canvas #salesChart tidak ditemukan");
                }

                // Product Pie Chart
                // Product Pie Chart
                const productCtx = document.getElementById('productChart')?.getContext('2d');
                if (productCtx) {
                    const productChart = new Chart(productCtx, {
                        type: 'pie',
                        data: {
                            labels: {!! json_encode($productData['products']) !!},
                            datasets: [{
                                data: {!! json_encode($productData['quantities']) !!},
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.7)',
                                    'rgba(54, 162, 235, 0.7)',
                                    'rgba(255, 206, 86, 0.7)',
                                    'rgba(75, 192, 192, 0.7)',
                                    'rgba(153, 102, 255, 0.7)',
                                    'rgba(255, 159, 64, 0.7)'
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'right',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            const label = context.label || '';
                                            const value = context.raw || 0;
                                            const total = context.dataset.data.reduce((a, b) => a + b,
                                                0);
                                            const percentage = Math.round((value / total) * 100);
                                            return `${label}: ${value} (${percentage}%)`;
                                        }
                                    }
                                }
                            }
                        }
                    });
                } else {
                    console.warn("Canvas #productChart not found");
                }
            @endif
        });
    </script>
@endpush

@stack('scripts')
