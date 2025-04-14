@extends('layout')

@section('content')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 d-flex align-items-center">
                            <li class="breadcrumb-item"><a href="" class="link"><i
                                        class="mdi mdi-home-outline fs-4"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Penjualan</li>
                        </ol>
                    </nav>
                    <h1 class="mb-0 fw-bold">Penjualan</h1>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-between mb-3">
                        <div class="col-md-6">
                            <a href="" class="btn btn-info">
                                <i class="fas fa-file-export"></i> Export Penjualan (.xlsx)
                            </a>
                        </div>
                        <div class="col-md-6 text-md-end mt-3 mt-md-0">
                           
                                <a href="" class="btn btn-primary me-2">
                                    <i class="fas fa-plus"></i> Tambah Penjualan
                                </a>
                           
                            <div class="d-inline-block">
                                <input type="text" id="searchInput" class="form-control form-control-sm"
                                       placeholder="Search...">
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="saleTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Tanggal Penjualan</th>
                                    <th>Total Harga</th>
                                    <th>Dibuat Oleh</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                

                                                    <div class="row text-center mt-3">
                                                        <div class="col-9 text-end"><b>Total</b></div>
                                                        <div class="col-3"><b>Rp
                                                               </b></div>
                                                    </div>

                                                    <div class="row mt-3">
                                                        <center>
                                                            Dibuat pada: <br>
                                                            Oleh: 
                                                        </center>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                               
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection