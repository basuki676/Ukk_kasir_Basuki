<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class UsersExport implements FromCollection, WithHeadings, WithCustomStartCell, WithEvents
{
    public function collection()
    {
        return User::all()->map(function ($user) {
            return [
                'ID' => $user->id,
                'Nama' => $user->name,
                'Email' => $user->email,
                'Role' => $user->role,
                'Tanggal Dibuat' => $user->created_at->format('Y-m-d H:i:s'),
                'Tanggal Diupdate' => $user->updated_at->format('Y-m-d H:i:s'),
            ];
        });
    }

    public function headings(): array
    {
        return ['ID', 'Nama', 'Email', 'Role', 'Tanggal Dibuat', 'Tanggal Diupdate'];
    }

    public function startCell(): string
    {
        return 'A2';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Gabungkan A1 sampai F1 untuk judul
                $event->sheet->mergeCells('A1:F1');
                $event->sheet->setCellValue('A1', 'Data User BASS Strore');

                // Styling judul
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

                // Styling header kolom
                $event->sheet->getStyle('A2:F2')->applyFromArray([
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
            },
        ];
    }
}