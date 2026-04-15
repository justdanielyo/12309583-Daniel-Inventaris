<?php

namespace App\Exports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ItemsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        // Mengambil data item beserta kategorinya
        return Item::with('category')->get();
    }

    // Menentukan Judul Kolom (Baris Pertama)
    public function headings(): array
    {
        return [
            'Category',
            'Name Item',
            'Total',
            'Repair Total',
            'Last Updated',
        ];
    }

    // Menentukan Data & Format Per Kolom
    public function map($item): array
    {
        return [
            $item->category->name,
            $item->name,
            $item->total,
            // LOGIKA: Jika 0 maka diisi "-", jika tidak tampilkan angkanya
            $item->repair == 0 ? '-' : $item->repair,
            // FORMAT TANGGAL: Jan 14, 2023
            $item->updated_at->format('M d, Y'),
        ];
    }
}