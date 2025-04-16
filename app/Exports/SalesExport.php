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
        $salesData = [];
        
        Sale::with(['customer', 'user', 'detailSales.product'])->get()->each(function ($sale) use (&$salesData) {
            $firstProduct = true;
            
            foreach ($sale->detailSales as $detail) {
                $hargaSatuan = $detail->amount > 0 ? $detail->sub_total / $detail->amount : 0;
                $totalHarga = $hargaSatuan * $detail->amount;
                
                if ($firstProduct) {
                    // First product - add all sale info
                    $salesData[] = [
                        'ID' => $sale->id,
                        'Pelanggan' => $sale->customer ? $sale->customer->name : 'Non Member',
                        'Tanggal' => $sale->created_at->format('Y-m-d H:i'),
                        'Total Harga' => 'Rp ' . number_format($sale->total_price, 0, ',', '.'),
                        'Kasir' => $sale->user->name,
                        'Produk' => $detail->product->name,
                        'Qty' => $detail->amount,
                        'Harga Satuan' => 'Rp ' . number_format($hargaSatuan, 0, ',', '.'),
                    ];
                    $firstProduct = false;
                } else {
                    // Subsequent products - only show product info
                    $salesData[] = [
                        'ID' => '',
                        'Pelanggan' => '',
                        'Tanggal' => '',
                        'Total Harga' => '',
                        'Kasir' => '',
                        'Produk' => $detail->product->name,
                        'Qty' => $detail->amount,
                        'Harga Satuan' => 'Rp ' . number_format($hargaSatuan, 0, ',', '.'),
                    ];
                }
            }
            
            // If no products at all (shouldn't happen but just in case)
            if ($firstProduct) {
                $salesData[] = [
                    'ID' => $sale->id,
                    'Pelanggan' => $sale->customer ? $sale->customer->name : 'Non Member',
                    'Tanggal' => $sale->created_at->format('Y-m-d H:i'),
                    'Total Harga' => 'Rp ' . number_format($sale->total_price, 0, ',', '.'),
                    'Kasir' => $sale->user->name,
                    'Produk' => '',
                    'Qty' => '',
                    'Harga Satuan' => '',
                    
                ];
            }
        });
        
        return collect($salesData);
    }

    public function headings(): array
    {
        return ['ID', 'Pelanggan', 'Tanggal', 'Total Harga', 'Kasir', 'Produk', 'Qty', 'Harga Satuan',];
    }

    public function startCell(): string
    {
        return 'A2';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Merge cells for store title
                $event->sheet->mergeCells('A1:H1');
                $event->sheet->setCellValue('A1', 'BASS Store');

                // Style store title
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
                
                // Style header row
                $event->sheet->getStyle('A2:H2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'FFD9D9D9',
                        ],
                    ],
                ]);
                
                // Auto size columns
                $columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I'];
                foreach ($columns as $column) {
                    $event->sheet->getColumnDimension($column)->setAutoSize(true);
                }
                
                // Set specific widths for certain columns if needed
                $event->sheet->getColumnDimension('F')->setWidth(25); // Produk
                $event->sheet->getColumnDimension('G')->setWidth(10); // Qty
                $event->sheet->getColumnDimension('H')->setWidth(15); // Harga Satuan
            },
        ];
    }
}