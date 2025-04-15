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
                             <a href="{{ route('sale.export') }}" class="btn btn-info">
                                 <i class="fas fa-file-export"></i> Export Penjualan (.xlsx)
                             </a>
                         </div>
                         <div class="col-md-6 text-md-end mt-3 mt-md-0">
                             @if (auth()->user()->role !== 'admin')
                                 <a href="{{ route('sale.add') }}" class="btn btn-primary me-2">
                                     <i class="fas fa-plus"></i> Tambah Penjualan
                                 </a>
                             @endif
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
                                 @foreach ($sale as $S)
                                     <tr>
                                         <td>{{ $loop->iteration }}</td>
                                         <td>{{ $S->customer ? $S->customer->name : 'Non Member' }}</td>
                                         <td>{{ $S->created_at->format('Y-m-d') }}</td>
                                         <td>Rp {{ number_format($S->total_price, 0, ',', '.') }}</td>
                                         <td>{{ $S->user->name }}</td>
                                         <td>
                                             <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                                 data-bs-target="#saleModal{{ $S->id }}">
                                                 <i class="fas fa-eye"></i> Detail
                                             </button>
                                             <a href="{{ route('sale.export.pdf', $S->id) }}"
                                                 class="btn btn-sm btn-primary">
                                                 <i class="fas fa-file-pdf"></i> Unduh Bukti
                                             </a>
                                         </td>
                                     </tr>

                                     <!-- Modal for each sale -->
                                     <div class="modal fade" id="saleModal{{ $S->id }}" tabindex="-1"
                                         aria-labelledby="saleModalLabel{{ $S->id }}" aria-hidden="true">
                                         <div class="modal-dialog modal-dialog-scrollable">
                                             <div class="modal-content">
                                                 <div class="modal-header">
                                                     <h5 class="modal-title" id="saleModalLabel{{ $S->id }}">Detail
                                                         Penjualan #{{ $S->id }}</h5>
                                                     <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                         aria-label="Close"></button>
                                                 </div>
                                                 <div class="modal-body">
                                                     <div class="row">
                                                         <div class="col-6">
                                                             <small>
                                                                 Member Status:
                                                                 {{ $S->customer ? 'Member' : 'Non Member' }}<br>
                                                                 @if ($S->customer)
                                                                     No. HP: {{ $S->customer->no_hp }}<br>
                                                                     Poin Member: {{ $S->customer->point }}
                                                                 @endif
                                                             </small>
                                                         </div>
                                                         <div class="col-6">
                                                             <small>
                                                                 @if ($S->customer)
                                                                     Bergabung Sejak:<br>
                                                                     {{ $S->customer->created_at->format('d F Y') }}
                                                                 @endif
                                                             </small>
                                                         </div>
                                                     </div>

                                                     <div class="row mb-3 text-center mt-5">
                                                         <div class="col-3"><b>Nama Produk</b></div>
                                                         <div class="col-3"><b>Qty</b></div>
                                                         <div class="col-3"><b>Harga</b></div>
                                                         <div class="col-3"><b>Sub Total</b></div>
                                                     </div>

                                                     @foreach ($S->detailSales as $detail)
                                                         <div class="row mb-1">
                                                             <div class="col-3 text-center">{{ $detail->product->name }}
                                                             </div>
                                                             <div class="col-3 text-center">{{ $detail->amount }}</div>
                                                             <div class="col-3 text-center">Rp
                                                                 {{ number_format($detail->product->price, 0, ',', '.') }}
                                                             </div>
                                                             <div class="col-3 text-center">Rp
                                                                 {{ number_format($detail->sub_total, 0, ',', '.') }}</div>
                                                         </div>
                                                     @endforeach

                                                     <div class="row text-center mt-3">
                                                         <div class="col-9 text-end"><b>Total</b></div>
                                                         <div class="col-3"><b>Rp
                                                                 {{ number_format($S->total_price, 0, ',', '.') }}</b>
                                                         </div>
                                                     </div>

                                                     <div class="row mt-3">
                                                         <center>
                                                             Dibuat pada: {{ $S->created_at->format('Y-m-d H:i:s') }}<br>
                                                             Oleh: {{ $S->user->name }}
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
                                 @endforeach
                             </tbody>
                         </table>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 @endsection

 @section('scripts')
     <!-- DataTables -->
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
     <!-- Font Awesome for icons -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
     <script>
         $(document).ready(function() {
             var table = $('#saleTable').DataTable({
                 "language": {
                     "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
                 },
                 "dom": '<"top"f>rt<"bottom"lip><"clear">',
                 "initComplete": function() {
                     // Move search input to our custom location
                     $('.dataTables_filter').appendTo('#searchInput').parent();
                     $('.dataTables_filter input').addClass('form-control form-control-sm');
                     $('.dataTables_filter label').contents().unwrap();
                 }
             });

             // Custom search functionality
             $('#searchInput').keyup(function() {
                 table.search($(this).val()).draw();
             });
         });
     </script>
     <style>
         .btn-info {
             background-color: #17a2b8;
             border-color: #17a2b8;
             color: white;
         }

         .btn-info:hover {
             background-color: #138496;
             border-color: #117a8b;
         }

         .btn-sm {
             padding: 0.25rem 0.5rem;
             font-size: 0.875rem;
             line-height: 1.5;
             border-radius: 0.2rem;
         }

         .dataTables_filter {
             display: none;
             /* Hide default search */
         }

         #searchInput {
             width: 200px;
             display: inline-block;
         }

         @media (max-width: 767px) {
             #searchInput {
                 width: 100%;
                 margin-top: 10px;
             }

             .text-md-end {
                 text-align: left !important;
             }
         }
     </style>
 @endsection
