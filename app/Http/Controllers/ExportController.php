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
        
        // Get the products from detailSales relationship
        $selectedProducts = [];
        foreach ($sale->detailSales as $detail) {
            $selectedProducts[] = [
                'id' => $detail->product_id,
                'name' => $detail->product->name,
                'price' => $detail->product->price,
                'quantity' => $detail->amount,
                'total' => $detail->sub_total,
            ];
        }
    
        // Calculate necessary values
        $totalHargaAwal = $sale->detailSales->sum('sub_total');
        $totalHarga = $sale->total_price;
        $totalBayar = $sale->total_pay;
        $kembalian = $sale->total_return;
        $pointsEarned = floor($totalHarga * 0.01);
    
        $pdf = PDF::loadView('exports.invoice', compact(
            'sale', 
            'selectedProducts',
            'totalHargaAwal',
            'totalHarga',
            'totalBayar',
            'kembalian',
            'pointsEarned'
        ));
    
        return $pdf->download('bukti-penjualan-' . $id . '.pdf');
    }
    // Export Excel untuk User
public function exportUsersExcel()
{
    return Excel::download(new \App\Exports\UsersExport(), 'data-user.xlsx');
}
}
