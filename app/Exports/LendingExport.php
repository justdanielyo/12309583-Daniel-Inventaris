<?php

namespace App\Exports;

use App\Models\Lending;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LendingExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        return Lending::with(['item', 'user'])->get();
    }

    public function headings(): array
    {
        return [
            'Item',
            'Total',
            'Name',
            'Ket.',
            'Date',
            'Return Date',
            'Edited By',
        ];
    }

    /**
    * Memetakan data ke dalam kolom Excel
    */
    public function map($lending): array
    {
        return [
            $lending->item->name,           // Kolom Item
            $lending->total,                // Kolom Total
            $lending->name,                 // Kolom Name (Peminjam)
            $lending->notes ?? '-',         // Kolom Ket.
            \Carbon\Carbon::parse($lending->date)->format('M d, Y'), // Kolom Date
            
            // Logika: Jika returned_at null, isi " - ", jika ada isi tanggalnya
            $lending->returned_at 
                ? \Carbon\Carbon::parse($lending->returned_at)->format('M d, Y') 
                : ' - ',
                
            $lending->user->name ?? 'System', // Kolom Edited By 
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // HEADER BOLD
            1 => ['font' => ['bold' => true]],
        ];
    }
}