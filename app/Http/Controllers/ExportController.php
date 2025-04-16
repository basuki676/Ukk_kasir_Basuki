<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Exports\SalesExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class ExportController extends Controller
{
    // Export Excel for Sales
    public function exportExcel()
    {
        return Excel::download(new SalesExport(), 'penjualan.xlsx');
    }

    // Export PDF for a specific sale
    public function exportPDF($id)
    {
        $sale = Sale::with(['customer', 'user', 'detailSales.product'])->findOrFail($id);
        
        // Prepare products data
        $selectedProducts = $sale->detailSales->map(function ($detail) {
            return [
                'id' => $detail->product_id,
                'name' => $detail->product->name,
                'price' => $detail->product->price,
                'quantity' => $detail->amount,
                'total' => $detail->sub_total,
            ];
        })->toArray();

        // Calculate values
        $originalTotal = $sale->detailSales->sum('sub_total'); // Total before any discounts
        $pointsEarned = floor($originalTotal * 0.01); // Points from original total
        
        // For member customers, calculate current points (without subtracting used points)
        $currentPoints = 0;
        if ($sale->customer) {
            $currentPoints = $sale->customer->point + $pointsEarned;
        }

        $pdf = PDF::loadView('exports.invoice', [
            'sale' => $sale,
            'selectedProducts' => $selectedProducts,
            'totalHargaAwal' => $originalTotal,
            'totalHarga' => $sale->total_price,
            'totalBayar' => $sale->total_pay,
            'kembalian' => $sale->total_return,
            'pointsEarned' => $pointsEarned,
            'currentPoints' => $currentPoints
        ]);

        return $pdf->download('bukti-penjualan-' . $id . '.pdf');
    }

    // Export Excel for Users
    public function exportUsersExcel()
    {
        return Excel::download(new \App\Exports\UsersExport(), 'data-user.xlsx');
    }
}