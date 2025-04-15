@extends('layout')

@section('content')
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 d-flex align-items-center">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.view') }}" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
                <h1 class="mb-0 fw-bold">Dashboard</h1>
            </div>
        </div>
    </div>

    @if(auth()->user()->role == 'admin')
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

@stack('scripts')
