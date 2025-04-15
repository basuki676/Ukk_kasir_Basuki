<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class SalesExport implements FromCollection, WithHeadings, WithCustomStartCell, WithEvents
{
    public function collection()
    {
        return Sale::with(['customer', 'user', 'detailSales.product'])->get()->map(function ($sale) {
            $produkList = $sale->detailSales->map(function ($detail) {
                $hargaSatuan = $detail->amount > 0 ? $detail->sub_total / $detail->amount : 0;
                return $detail->product->name . ' x' . $detail->amount . ' Rp' . number_format($hargaSatuan, 0, ',', '.');
            })->implode(', ');

            return [
                'ID' => $sale->id,
                'Pelanggan' => $sale->customer ? $sale->customer->name : 'Non Member',
                'Tanggal' => $sale->created_at->format('Y-m-d'),
                'Total Harga' => 'Rp ' . number_format($sale->total_price, 0, ',', '.'),
                'Kasir' => $sale->user->name,
                'Produk Dibeli' => $produkList,
            ];
        });
    }

    public function headings(): array
    {
        return ['ID', 'Pelanggan', 'Tanggal', 'Total Harga', 'Kasir', 'Produk Dibeli'];
    }

    public function startCell(): string
    {
        return 'A2';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Gabungkan A1 sampai F1 untuk judul toko
                $event->sheet->mergeCells('A1:N1');
                $event->sheet->setCellValue('A1', 'FlexyLite');

                // Styling judul toko
                $event->sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 16,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ]);
            },
        ];
    }
}
