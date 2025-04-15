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
                        </ol>
                    </nav>
                    <h1 class="mb-0 fw-bold">Penjualan</h1>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row justify-content-between mb-4 gap-3">
                        <div>
                            <a href="{{ route('sale.export') }}" class="btn btn-info">
                                <i class="fas fa-file-export me-2"></i>Export Excel
                            </a>
                        </div>
                        <div class="d-flex flex-column flex-md-row gap-2">
                            @if (auth()->user()->role !== 'admin')
                                <a href="{{ route('sale.add') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Tambah Penjualan
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="saleTable" class="table table-striped table-bordered nowrap w-100">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Nama Pelanggan</th>
                                    <th width="15%">Tanggal</th>
                                    <th width="15%">Total Harga</th>
                                    <th width="15%">Kasir</th>
                                    <th width="15%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sale as $S)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $S->customer ? $S->customer->name : 'Non Member' }}</td>
                                        <td>{{ $S->created_at->format('d/m/Y H:i') }}</td>
                                        <td>Rp {{ number_format($S->total_price, 0, ',', '.') }}</td>
                                        <td>{{ $S->user->name }}</td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                                    data-bs-target="#saleModal{{ $S->id }}" title="Lihat Detail">
                                                    <i class="fas fa-eye me-1"></i>Detail
                                                </button>
                                                <a href="{{ route('sale.export.pdf', $S->id) }}" 
                                                   class="btn btn-primary" title="Unduh PDF">
                                                    <i class="fas fa-file-pdf me-1"></i>PDF
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    @foreach ($sale as $S)
    <div class="modal fade" id="saleModal{{ $S->id }}" tabindex="-1" aria-labelledby="saleModalLabel{{ $S->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title">Detail Penjualan - #{{ $S->id }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="mb-1"><small class="text-muted">Kasir</small></p>
                            <p class="fw-bold">{{ $S->user->name }}</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <p class="mb-1"><small class="text-muted">Tanggal</small></p>
                            <p class="fw-bold">{{ $S->created_at->format('d F Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th width="40%">Produk</th>
                                    <th width="20%" class="text-end">Harga</th>
                                    <th width="15%" class="text-center">Qty</th>
                                    <th width="25%" class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($S->detailSales as $detail)
                                    <tr>
                                        <td>{{ $detail->product->name }}</td>
                                        <td class="text-end">Rp {{ number_format($detail->product->price, 0, ',', '.') }}</td>
                                        <td class="text-center">{{ $detail->amount }}</td>
                                        <td class="text-end">Rp {{ number_format($detail->sub_total, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-md-6">
                            <div class="border p-3 rounded">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Total Awal:</span>
                                    <span>Rp {{ number_format($S->total_price + $S->poin, 0, ',', '.') }}</span>
                                </div>
                                @if($S->poin > 0)
                                    <div class="d-flex justify-content-between mb-2 text-danger">
                                        <span>Potongan Poin:</span>
                                        <span>- Rp {{ number_format($S->poin, 0, ',', '.') }}</span>
                                    </div>
                                @endif
                                <div class="d-flex justify-content-between mb-2 fw-bold">
                                    <span>Total Akhir:</span>
                                    <span>Rp {{ number_format($S->total_price, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Total Bayar:</span>
                                    <span>Rp {{ number_format($S->total_pay, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span>Kembalian:</span>
                                    <span>Rp {{ number_format($S->total_pay - $S->total_price, 0, ',', '.') }}</span>
                                </div>
                                
                                @if ($S->customer)
                                    <hr>
                                    <div class="mb-2">
                                        <p class="mb-1"><small class="text-muted">Pelanggan</small></p>
                                        <p class="fw-bold">{{ $S->customer->name }} ({{ $S->customer->no_hp }})</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Poin Didapat:</span>
                                        <span>{{ floor($S->total_price * 0.01) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Total Poin:</span>
                                        <span>{{ $S->customer->point }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('sale.export.pdf', $S->id) }}" class="btn btn-primary me-2">
                        <i class="fas fa-file-pdf me-2"></i>Unduh PDF
                    </a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@endsection

@section('scripts')
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    
    <script>
        $(document).ready(function() {
            var table = $('#saleTable').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json",
                    searchPlaceholder: "Cari penjualan..."
                },
                responsive: true,
                dom: '<"top"f>rt<"bottom"lip><"clear">',
                initComplete: function() {
                    $('#searchInput').on('keyup', function() {
                        table.search(this.value).draw();
                    });
                }
            });
        });
    </script>

    <style>
        /* Table styling */
        #saleTable thead th {
            background-color: #f8f9fa;
            font-weight: 600;
            vertical-align: middle;
        }
        
        #saleTable td {
            vertical-align: middle;
        }
        
        /* Button group styling */
        .btn-group {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .btn-group .btn {
            border-radius: 0.25rem !important;
        }
        
        /* Modal styling */
        .modal-header {
            border-bottom: 1px solid #dee2e6;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .d-flex.flex-md-row {
                flex-direction: column !important;
                gap: 1rem;
            }
            
            .input-group {
                width: 100% !important;
            }
            
            .btn-group .btn {
                padding: 0.25rem 0.5rem;
                font-size: 0.8rem;
            }
            
            .btn-group .btn i {
                margin-right: 0 !important;
            }
        }
    </style>
@endsection