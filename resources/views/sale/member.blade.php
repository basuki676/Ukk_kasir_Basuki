@extends('layout')

@section('content')

<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 d-flex align-items-center">
                        <li class="breadcrumb-item">
                            <a href="#" class="link">
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
                        <form action="#" method="POST">
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
                                                
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="3">Total Harga Awal</th>
                                                    <th>Rp </th>
                                                </tr>
                                                <tr id="discount-row" style="display: none;">
                                                    <th colspan="3">Diskon Poin</th>
                                                    <th id="discount-amount">-Rp 0</th>
                                                </tr>
                                                <tr>
                                                    <th colspan="3">Total Harga Akhir</th>
                                                    <th id="total-price-display">Rp </th>
                                                </tr>
                                                <tr>
                                                    <th colspan="3">Total Bayar</th>
                                                    <th>Rp</th>
                                                </tr>
                                                <tr>
                                                    <th colspan="3">Poin Didapat</th>
                                                    <th id="points-earned-display"></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                
                                <!-- Member Form Column -->
                                <div class="col-lg-6 col-md-12">
                                    <input type="hidden" name="sale_id" value="#">
                                    
                                        <input type="hidden" name="customer_id" value="#">
                                        <input type="hidden" id="current_points" value="#">
                                    
                                    
                                    <div class="form-group mb-3">
                                        <label for="name" class="form-label">Nama Member</label>
                                        <input type="text" class="form-control" name="name" 
                                               value="#" required>
                                    </div>
                                    
                                    <div class="form-group mb-3">
                                        <label class="form-label">Poin Saat Ini</label>
                                        <input type="text" class="form-control" value="#" disabled>
                                    </div>
                                    
                                    
                                    
                                    <div class="form-check mb-3">
                                        <input type="checkbox" name="check_poin" value="Ya" 
                                               id="check_poin" class="form-check-input">
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


@endsection