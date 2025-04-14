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
                            <li class="breadcrumb-item active" aria-current="page">Penjualan</li>
                        </ol>
                    </nav>
                    <h1 class="mb-0 fw-bold">Penjualan</h1>
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
                                    <div><strong>Invoice - #122</strong></div>
                                    <div>1 bulan 2025</div>
                                </div>
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="mb-4">
                                <a href="#" class="btn btn-primary me-2">
                                    <i class="icon-download"></i> Unduh
                                </a>
                                <a href="#" class="btn btn-secondary">
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
                                    
                                </table>
                            </div>

                            <!-- Rangkuman Total -->
                            <div class="card bg-light p-3">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <small class="text-muted">POIN DIGUNAKAN</small>
                                        <div class="fw-bold">100</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <small class="text-muted">KASIR</small>
                                        <div class="fw-bold">petugas</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <small class="text-muted">POIN DIDAPAT</small>
                                        <div class="fw-bold">110 Poin</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <small class="text-muted">TOTAL POIN SEKARANG</small>
                                        <div class="fw-bold">200 Poin</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <small class="text-muted">KEMBALIAN</small>
                                        <div class="fw-bold">Rp. 200,200 </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <small class="text-muted">TOTAL HARGA AWAL</small>
                                        <div class="fw-bold">Rp.100</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <small class="text-muted">Total Bayar</small>
                                        <div class="fw-bold">Rp. 100</div>
                                    </div>
                                   
                                    <div class="col-md-6 mb-3">
                                        <small class="text-muted">POTONGAN POIN</small>
                                        <div class="fw-bold text-danger">- Rp. 100</div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <small class="text-muted">TOTAL HARGA AKHIR</small>
                                        <div class="fw-bold text-success fs-5">Rp. 100</div>
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