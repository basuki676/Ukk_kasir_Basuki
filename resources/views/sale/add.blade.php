@extends('layout')

@section('content')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 d-flex align-items-center">
                            <li class="breadcrumb-item"><a href="#" class="link"><i
                                        class="mdi mdi-home-outline fs-4"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Penjualan</li>
                        </ol>
                    </nav>
                    <h1 class="mb-0 fw-bold">Penjualan</h1>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <section>
                                <div class="text-center container">
                                    <div class="row" id="product-list">
                                        
                                    </div>
                                </div>
                            </section>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>

    <div class="row fixed-bottom d-flex justify-content-end align-content-center"
        style="margin-left: 18%; width: 83%; height: 70px; border-top: 3px solid #EEE4B1; background-color: white;">
        <div class="col text-center" style="margin-right: 50px;">
            <form id="sale-form" action="#" method="POST">
                <div id="shop"></div>
                <button type="submit" class="btn btn-primary">Checkout</button>
            </form>
        </div>
    </div>

    
@endsection
