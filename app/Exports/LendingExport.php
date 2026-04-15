<?php

namespace App\Exports;

use App\Models\Lending;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class LendingExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $startDate;
    protected $endDate;

    /**
     * Konstruktor menerima rentang tanggal dari Controller
     */
    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * Ambil data dari database berdasarkan rentang tanggal
     */
    public function collection()
    {
        $query = Lending::with(['item', 'user']);

        // Jika user memilih rentang tanggal
        if ($this->startDate && $this->endDate) {
            // Kita gunakan whereBetween untuk mencakup data dari awal hari pertama sampai akhir hari terakhir
            $query->whereBetween('date', [
                $this->startDate . ' 00:00:00', 
                $this->endDate . ' 23:59:59'
            ]);
        } 
        // Jika hanya isi Start Date (sejak tanggal X sampai sekarang)
        elseif ($this->startDate) {
            $query->whereDate('date', '>=', $this->startDate);
        }
        // Jika hanya isi End Date (sampai tanggal X)
        elseif ($this->endDate) {
            $query->whereDate('date', '<=', $this->endDate);
        }

        return $query->orderBy('date', 'desc')->get();
    }

    /**
     * Header tabel Excel
     */
    public function headings(): array
    {
        return [
            'Item Name',
            'Total Borrowed',
            'Borrower Name',
            'Role',
            'Class/Agency',
            'Lending Date',
            'Due Date',
            'Returned At',
            'Notes',
            'Staff In Charge',
        ];
    }

    /**
     * Mapping data agar rapi di setiap baris Excel
     */
    public function map($lending): array
    {
        return [
            $lending->item->name ?? 'N/A',
            $lending->total,
            $lending->name,
            $lending->borrower_role,
            $lending->class ?? '-',
            Carbon::parse($lending->date)->format('d/m/Y'),
            Carbon::parse($lending->due_date)->format('d/m/Y'),
            $lending->returned_at 
                ? Carbon::parse($lending->returned_at)->format('d/m/Y H:i') 
                : 'Not Returned Yet',
            $lending->notes ?? '-',
            $lending->user->name ?? 'System',
        ];
    }

    /**
     * Styling Header (Warna Background Indigo & Teks Putih)
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true, 
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F46E5']
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ],
        ];
    }
}