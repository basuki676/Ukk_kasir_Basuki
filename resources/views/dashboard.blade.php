@extends('layout')

@section('content')
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 d-flex align-items-center">
                      <li class="breadcrumb-item"><a href="#" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                      <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                  </nav>
                <h1 class="mb-0 fw-bold">Dashboard</h1> 
            </div>
        </div>
    </div>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-md-flex align-items-center">
                        <div>
                            <h4 class="card-title">Sales Summary</h4>
                            <h6 class="card-subtitle">Ample admin Vs Pixel admin</h6>
                        </div>
                        <div class="ms-auto d-flex no-block align-items-center">
                            <ul class="list-inline dl d-flex align-items-center m-r-15 m-b-0">
                                <li class="list-inline-item d-flex align-items-center text-info"><i class="fa fa-circle font-10 me-1"></i> Ample
                                </li>
                                <li class="list-inline-item d-flex align-items-center text-primary"><i class="fa fa-circle font-10 me-1"></i> Pixel
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="amp-pxl mt-4" style="height: 350px;">
                        <div class="chartist-tooltip"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
<div class="card-body">
    <div class="card d-block m-auto text-center">
        <div class="card-header">
            Total Penjualan Hari Ini
        </div>
        <div class="card-body">
            <h3 class="card-title">0</h3>
            <p class="card-text">Jumlah total penjualan yang terjadi hari ini.</p>
        </div>
        <div class="card-footer text-muted">
            Terakhir diperbarui: 10 mei 2020
        </div>
    </div>
</div>


</div>
@endsection