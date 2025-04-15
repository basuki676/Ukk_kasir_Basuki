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
                        </ol>
                    </nav>
                    <h1 class="mb-0 fw-bold">Data Product</h1>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row justify-content-end">
                                @if (auth()->user()->role == 'admin')
                                    <div class="col text-end">
                                        <a href="{{ route('product.add') }}" class="btn btn-primary">
                                            Tambah Produk
                                        </a>
                                    </div>
                                @endif
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col"></th>
                                            <th scope="col">Nama Produk</th>
                                            <th scope="col">Harga</th>
                                            <th scope="col">Stok</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    @if (auth()->user()->role == 'admin')
                                        <tbody>
                                            @foreach ($product as $no => $data)
                                                <tr>
                                                    <td>{{ $no + 1 }}</td>
                                                    <td>
                                                        @if ($data->foto)
                                                            <img src="{{ asset('storage/' . $data->foto) }}" width="100">
                                                        @else
                                                            Tidak ada gambar
                                                        @endif
                                                    </td>
                                                    <td>{{ $data->name }}</td>
                                                    <td>Rp{{ number_format($data->price, 0, ',', '.') }}</td>
                                                    <td>{{ $data->stock }}</td>
                                                    <td>
                                                        <div class="d-flex justify-content-around">
                                                            <a href="{{ route('product.edit', $data->id) }}"
                                                                class="btn btn-warning">Edit</a>
                                                            <button type="button" class="btn btn-info"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#modal-update-{{ $data->id }}">Update
                                                                Stok</button>
                                                            <form action="{{ route('product.delete', $data->id) }}"
                                                                method="post">
                                                                @csrf
                                                                <input type="hidden" name="_method" value="DELETE">
                                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                                            </form>
                                                            <div class="modal fade" id="modal-update-{{ $data->id }}"
                                                                tabindex="-1" role="dialog" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLabel">
                                                                                Update
                                                                                Stok Product</h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        </div>
                                                                        <form method="POST"
                                                                            action="{{ route('product.updateStock', $data->id) }}">
                                                                            @csrf
                                                                            @method('PATCH')
                                                                            <div class="modal-body">
                                                                                <div class="row">
                                                                                    <input type="text" value="update"
                                                                                        name="ket" hidden="">
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label class="col-md-12">Nama
                                                                                                Product
                                                                                                <span
                                                                                                    class="text-danger">*</span></label>
                                                                                            <div class="col-md-12">
                                                                                                <input type="text"
                                                                                                    name="name"
                                                                                                    value="{{ $data->name }}"
                                                                                                    disabled=""
                                                                                                    class="form-control form-control-line ">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label class="col-md-12">Stok
                                                                                                <span
                                                                                                    class="text-danger">*</span></label>
                                                                                            <div class="col-md-12">
                                                                                                <input type="number"
                                                                                                    name="stock"
                                                                                                    value="{{ $data->stock }}"
                                                                                                    class="form-control form-control-line ">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-bs-dismiss="modal">Batal</button>
                                                                                <button type="submit"
                                                                                    class="btn btn-primary">Update</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    @elseif(auth()->user()->role == 'employe')
                                        <tbody>
                                            @foreach ($product as $no => $data)
                                                <tr>
                                                    <td>{{ $no + 1 }}</td>
                                                    <td>
                                                        @if ($data->foto)
                                                            <img src="{{ asset('storage/' . $data->foto) }}"
                                                                width="100">
                                                        @else
                                                            Tidak ada gambar
                                                        @endif
                                                    </td>
                                                    <td>{{ $data->name }}</td>
                                                    <td>Rp{{ number_format($data->price, 0, ',', '.') }}</td>
                                                    <td>{{ $data->stock }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const priceInput = document.getElementById('price');

        priceInput.addEventListener('input', function (e) {
            let value = this.value.replace(/[^,\d]/g, '').toString();
            let split = value.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            this.value = 'Rp ' + rupiah;
        });

        // Remove "Rp " prefix before submit
        const form = priceInput.closest('form');
        form.addEventListener('submit', function () {
            priceInput.value = priceInput.value.replace(/[^0-9]/g, '');
        });
    });
</script>
@endpush

