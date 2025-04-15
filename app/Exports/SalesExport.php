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
                
                $productText = sprintf(
                    "%s\nRp %s x%d = Rp %s",
                    $detail->product->name,
                    number_format($hargaSatuan, 0, ',', '.'),
                    $detail->amount,
                    number_format($totalHarga, 0, ',', '.')
                );
                
                if ($firstProduct) {
                    // First product - add all sale info
                    $salesData[] = [
                        'ID' => $sale->id,
                        'Pelanggan' => $sale->customer ? $sale->customer->name : 'Non Member',
                        'Tanggal' => $sale->created_at->format('Y-m-d'),
                        'Total Harga' => 'Rp ' . number_format($sale->total_price, 0, ',', '.'),
                        'Kasir' => $sale->user->name,
                        'Produk Dibeli' => $productText,
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
                        'Produk Dibeli' => $productText,
                    ];
                }
            }
            
            // If no products at all (shouldn't happen but just in case)
            if ($firstProduct) {
                $salesData[] = [
                    'ID' => $sale->id,
                    'Pelanggan' => $sale->customer ? $sale->customer->name : 'Non Member',
                    'Tanggal' => $sale->created_at->format('Y-m-d'),
                    'Total Harga' => 'Rp ' . number_format($sale->total_price, 0, ',', '.'),
                    'Kasir' => $sale->user->name,
                    'Produk Dibeli' => '',
                ];
            }
        });
        
        return collect($salesData);
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
                // Merge cells for store title
                $event->sheet->mergeCells('A1:F1');
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
                
                // Set wrap text and alignment for product cells
                $event->sheet->getStyle('F2:F' . ($event->sheet->getHighestRow()))
                    ->applyFromArray([
                        'alignment' => [
                            'wrapText' => true,
                            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                        ]
                    ]);
                
                // Auto size columns
                $columns = ['A', 'B', 'C', 'D', 'E', 'F'];
                foreach ($columns as $column) {
                    $event->sheet->getColumnDimension($column)->setAutoSize(true);
                }
                
                // Set borders for all cells
                $event->sheet->getStyle('A2:F' . ($event->sheet->getHighestRow()))
                    ->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ],
                        ],
                    ]);
                
                // Set specific width for product column
                $event->sheet->getColumnDimension('F')->setWidth(30);
            },
        ];
    }
}