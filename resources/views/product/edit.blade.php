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
                            <li class="breadcrumb-item active" aria-current="page">Data Product</li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
                        </ol>
                    </nav>
                    <h1 class="mb-0 fw-bold">Edit Product</h1>
                </div>
            </div>
        </div>

        <h4>Edit Product</h4>

        <form action="{{ route('product.update', $product->id) }}" method="post">
            @csrf
            <label>Nama</label>
            <input type="text" name="name" value="{{ $product->name }}" class="form-control mb-2">
            <label>Foto</label>
            <input type="file" name="foto" value="{{ $product->foto }}" class="form-control mb-2">
            <label>Harga</label>
            <input type="number" name="price" value="{{ $product->price }}" class="form-control mb-2">
            <label>Stock</label>
            <input type="number" name="stock" value="{{ $product->stock }}" class="form-control mb-2">

            <button class="btn btn-primary">Edit Product</button>
        </form>

    </div>
@endsection
