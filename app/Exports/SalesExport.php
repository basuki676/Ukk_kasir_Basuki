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
        return Sale::all()->map(function ($sale) {
            return [
                'ID' => $sale->id,
                'Pelanggan' => $sale->customer ? $sale->customer->name : 'Non Member',
                'Tanggal' => $sale->created_at->format('Y-m-d'),
                'Total Harga' => 'Rp ' . number_format($sale->total_price, 0, ',', '.'),
                'Kasir' => $sale->user->name,
            ];
        });
    }

    public function headings(): array
    {
        return ['ID', 'Pelanggan', 'Tanggal', 'Total Harga', 'Kasir'];
    }

    public function startCell(): string
    {
        return 'A2';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Gabungkan kolom A sampai E untuk baris 1
                $event->sheet->mergeCells('A1:E1');

                // Tulis nama toko di sel gabungan
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
