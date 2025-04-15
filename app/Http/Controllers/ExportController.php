<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Exports\SalesExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class ExportController extends Controller
{
    // Export Excel
    public function exportExcel()
    {
        return Excel::download(new SalesExport(), 'penjualan.xlsx');
    }

    // Export PDF
    public function exportPDF($id)
    {
        $sale = Sale::with(['customer', 'user', 'detailSales.product'])->findOrFail($id);
        $pdf = PDF::loadView('exports.invoice', compact('sale'));

        return $pdf->download('bukti-penjualan-' . $id . '.pdf');
    }
}
