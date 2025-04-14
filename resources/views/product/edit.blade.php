@extends('layout')

@section('content')
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 d-flex align-items-center">
                      <li class="breadcrumb-item"><a href="#" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                      <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
                    </ol>
                  </nav>
                <h1 class="mb-0 fw-bold">Edit Product</h1> 
            </div>
        </div>
    </div>
    
<h4>Edit Product</h4>

<form action="#" method="post">
    
    <label>Nama</label>
    <input type="text" name="name" value="#" class="form-control mb-2">
    <label>Foto</label>
    <input type="text" name="foto" value="#" class="form-control mb-2">
    <label>Harga</label>
    <input type="number" name="price" value="#" class="form-control mb-2">
    <label>Stock</label>
    <input type="number" name="stock" value="#" class="form-control mb-2">
    
    <button class="btn btn-primary">Edit Product</button>
</form>

</div>

@endsection