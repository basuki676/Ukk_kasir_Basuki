@extends('layout')

@section('content')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 d-flex align-items-center">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard.view') }}" class="link">
                                    <i class="mdi mdi-home-outline fs-4"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Penjualan</li>
                            <li class="breadcrumb-item active" aria-current="page">Pilih Produk</li>
                            <li class="breadcrumb-item active" aria-current="page">Verivikasi Member</li>
                        </ol>
                    </nav>
                    <h1 class="mb-0 fw-bold">Verivikasi Member</h1>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('sale.create') }}" method="Post">
                            @csrf
                            <div class="row">
                                <!-- Kolom Produk yang dipilih -->
                                <div class="col-lg-6 col-md-12">
                                    <h2>Produk yang Dipilih</h2>
                                    <table class="table">
                                        <tbody>
                                            @php $totalHarga = 0; @endphp
                                            @foreach ($selectedProducts as $product)
                                                @php
                                                    $subTotal = $product['price'] * $product['quantity'];
                                                    $totalHarga += $subTotal;
                                                @endphp
                                                <tr>
                                                    <td>{{ $product['name'] }}</td>
                                                    <td>
                                                        <small>
                                                            Rp. {{ number_format($product['price'], 0, ',', '.') }} x
                                                            {{ $product['quantity'] }}
                                                        </small>
                                                    </td>
                                                    <td><b>Rp. {{ number_format($subTotal, 0, ',', '.') }}</b></td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td style="padding-top: 20px; font-size: 20px;"><b>Total</b></td>
                                                <td colspan="2" class="text-end"
                                                    style="padding-top: 20px; font-size: 20px;">
                                                    <b>Rp. {{ number_format($totalHarga, 0, ',', '.') }}</b>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <input type="hidden" name="total" id="total" value="{{ $totalHarga }}">
                                </div>

                                <!-- Kolom Form Pembayaran -->
                                <div class="col-lg-6 col-md-12">
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="member" class="form-label">Member Status</label>
                                            <small class="text-danger">Dapat juga membuat member</small>
                                            <select name="member" id="member" class="form-select"
                                                onchange="memberDetect()">
                                                <option value="Bukan Member">Bukan Member</option>
                                                <option value="Member">Member</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div id="member-wrap" class="d-none">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-12">No Telepon
                                                        <small class="text-danger">(daftar/gunakan member)</small>
                                                    </label>
                                                    <div class="col-md-12">
                                                        <input type="text" name="no_hp"
                                                            class="form-control form-control-line"
                                                            onkeypress="if(this.value.length==13) return false;"
                                                            oninput="formatPhoneNumberWithDash(this)">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group">
                                            <label for="total_pay" class="form-label">Total Bayar</label>
                                            <input type="text" name="total_pay" id="total_pay" class="form-control"
                                                oninput="formatRupiah(this); checkTotalPay()" spellcheck="false">
                                            <small id="error-message" class="text-danger d-none">
                                                Jumlah bayar kurang.
                                            </small>
                                        </div>
                                    </div>

                                    <div class="row text-end">
                                        <div class="col-md-12">
                                            <button class="btn btn-primary" id="submit-button" type="submit">Pesan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
       function formatPhoneNumberWithDash(input) {
    let raw = input.value.replace(/[^0-9]/g, '');

    if (raw.startsWith('0')) {
        raw = '62' + raw.substring(1);
    } else if (!raw.startsWith('62')) {
        raw = '62' + raw;
    }

    let formatted = '+' + raw;
    if (raw.length > 2) {
        formatted = '+' + raw.substring(0, 2);
        if (raw.length > 5) {
            formatted += '-' + raw.substring(2, 5);
            if (raw.length > 9) {
                formatted += '-' + raw.substring(5, 9);
                formatted += '-' + raw.substring(9, 13);
            } else if (raw.length > 5) {
                formatted += '-' + raw.substring(5);
            }
        } else {
            formatted += '-' + raw.substring(2);
        }
    }

    input.value = formatted;
}


        function formatRupiah(element) {
            let value = element.value.replace(/\D/g, "");
            element.value = "Rp. " + new Intl.NumberFormat("id-ID").format(value);
        }

        function checkTotalPay() {
            let totalHarga = {{ $totalHarga }};
            let totalPay = document.getElementById("total_pay").value.replace(/\D/g, "");
            let errorMessage = document.getElementById("error-message");
            let submitButton = document.getElementById("submit-button");

            if (parseInt(totalPay) < totalHarga) {
                errorMessage.classList.remove("d-none");
                submitButton.disabled = true;
            } else {
                errorMessage.classList.add("d-none");
                submitButton.disabled = false;
            }
        }

        function memberDetect() {
            let memberSelect = document.getElementById("member");
            let memberWrap = document.getElementById("member-wrap");

            if (memberSelect.value === "Member") {
                memberWrap.classList.remove("d-none");
            } else {
                memberWrap.classList.add("d-none");
            }
        }
    </script>
@endsection
