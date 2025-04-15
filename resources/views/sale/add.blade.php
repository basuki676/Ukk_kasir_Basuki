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
                            <li class="breadcrumb-item active" aria-current="page">Penjualan</li>
                            <li class="breadcrumb-item active" aria-current="page">Pilih Produk</li>
                        </ol>
                    </nav>
                    <h1 class="mb-0 fw-bold">Pilih Produk</h1>
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
                                        @foreach ($products as $data)
                                            <div class="col-lg-4 col-md-6">
                                                <div class="card">
                                                    <div
                                                        class="bg-image hover-zoom ripple ripple-surface ripple-surface-light">
                                                        @if ($data->foto)
                                                            <img src="{{ asset('storage/' . $data->foto) }}" width="50%">
                                                        @else
                                                            Tidak ada gambar
                                                        @endif
                                                    </div>
                                                    <div class="card-body">
                                                        <h5 class="card-title mb-3">{{ $data->name }}</h5>
                                                        <p>Stok <span
                                                                id="stock_{{ $data->id }}">{{ $data->stock }}</span>
                                                        </p>
                                                        <h6 class="mb-3">Rp.
                                                            {{ number_format($data->price, 0, ',', '.') }}
                                                        </h6>
                                                        <p id="price_{{ $data->id }}" hidden>{{ $data->price }}</p>
                                                        <center>
                                                            <table>
                                                                <tbody>
                                                                    <tr>
                                                                        <td style="padding: 0px 10px 0px 10px; cursor: pointer;"
                                                                            class="minus-button"
                                                                            data-id="{{ $data->id }}">
                                                                            <b>-</b>
                                                                        </td>
                                                                        <td style="padding: 0px 10px 0px 10px;"
                                                                            class="num"
                                                                            id="quantity_{{ $data->id }}">
                                                                            0</td>
                                                                        <td style="padding: 0px 10px 0px 10px; cursor: pointer;"
                                                                            class="plus-button"
                                                                            data-id="{{ $data->id }}">
                                                                            <b>+</b>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </center>
                                                        <br>
                                                        <p>Sub Total <b><span id="total_{{ $data->id }}">Rp.
                                                                    0</span></b></p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
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
            <form id="sale-form" action="{{ route('sale.create.post') }}" method="POST">
                @csrf
                <div id="shop"></div>
                <button type="submit" class="btn btn-primary">Checkout</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".card").forEach(function(card) {
                const minusButton = card.querySelector(".minus-button");
                const plusButton = card.querySelector(".plus-button");
                const quantityElement = card.querySelector(".num");
                const totalElement = card.querySelector("[id^='total_']");
                const priceElement = card.querySelector("[id^='price_']");
                const stockElement = card.querySelector("[id^='stock_']");
                const productId = plusButton.dataset.id;
                const productName = card.querySelector(".card-title").innerText;

                const price = parseInt(priceElement.innerText);
                const stock = parseInt(stockElement.innerText);
                let quantity = 0;

                plusButton.addEventListener("click", () => {
                    if (quantity < stock) {
                        quantity++;
                        updateQuantity();
                    } else {
                        alert(`Stok ${productName} tidak mencukupi! Stok tersisa: ${stock}`);
                    }
                });

                minusButton.addEventListener("click", () => {
                    if (quantity > 0) {
                        quantity--;
                        updateQuantity();
                    }
                });

                function updateQuantity() {
                    quantityElement.innerText = quantity;
                    totalElement.innerText = "Rp. " + (price * quantity).toLocaleString("id-ID");
                    updateShopInput();

                    // Disable plus button if stock is reached
                    if (quantity >= stock) {
                        plusButton.style.color = "gray";
                        plusButton.style.cursor = "not-allowed";
                    } else {
                        plusButton.style.color = "";
                        plusButton.style.cursor = "pointer";
                    }

                    // Disable minus button if quantity is 0
                    if (quantity <= 0) {
                        minusButton.style.color = "gray";
                        minusButton.style.cursor = "not-allowed";
                    } else {
                        minusButton.style.color = "";
                        minusButton.style.cursor = "pointer";
                    }
                }

                function updateShopInput() {
                    let shopInput = document.querySelector(`#shop-${productId}`);

                    if (quantity > 0) {
                        if (!shopInput) {
                            shopInput = document.createElement("input");
                            shopInput.type = "hidden";
                            shopInput.name = "shop[]";
                            shopInput.id = `shop-${productId}`;
                            document.getElementById("shop").appendChild(shopInput);
                        }
                        shopInput.value =
                            `${productId};${productName};${price};${quantity};${price * quantity}`;
                    } else {
                        if (shopInput) {
                            shopInput.remove();
                        }
                    }
                }

                // Initialize button states
                updateQuantity();
            });

            // Add validation before form submission
            document.getElementById("sale-form").addEventListener("submit", function(e) {
                const selectedProducts = document.querySelectorAll("[name='shop[]']");
                if (selectedProducts.length === 0) {
                    e.preventDefault();
                    alert("Silakan pilih minimal satu produk sebelum checkout!");
                    return false;
                }

                // Additional validation can be added here
                return true;
            });
        });
    </script>
@endsection
