<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lending;
use App\Models\Item;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Exports\LendingExport;
use Maatwebsite\Excel\Facades\Excel;

class LendingController extends Controller
{
    public function index(Request $request)
    {
        $query = Lending::with(['item', 'user']);

        // Filter Range Tanggal
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('date', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        } elseif ($request->start_date) {
            $query->whereDate('date', '>=', $request->start_date);
        } elseif ($request->end_date) {
            $query->whereDate('date', '<=', $request->end_date);
        }

        $lendings = $query->latest()->get();
        return view('staff.lendings.index', compact('lendings'));
    }

    public function create()
    {
        // Hanya menampilkan item yang stoknya tersedia (Total - Repair - Lending > 0)
        $items = Item::all()->filter(function ($item) {
            return ($item->total - ($item->repair + $item->lending)) > 0;
        });

        return view('staff.lendings.create', compact('items'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input sesuai dengan kolom baru di Migration
        $request->validate([
            'name' => 'required|string|max:255',
            'borrower_role' => 'required|in:Siswa,Guru/Staff,Tamu',
            'class' => 'required_if:borrower_role,Siswa,Tamu|nullable|string|max:100',
            'due_date' => 'required|date|after_or_equal:today',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.total' => 'required|integer|min:1',
            'notes' => 'nullable|string',
            'staff_signature' => 'required|string',
            'borrower_signature' => 'required|string',
        ], [
            'due_date.after_or_equal' => 'Tanggal kembali tidak boleh di masa lalu.',
            'staff_signature.required' => 'Tanda tangan staff wajib diisi.',
            'borrower_signature.required' => 'Tanda tangan peminjam wajib diisi.',
            'class.required_if' => 'Kolom Kelas/Instansi wajib diisi untuk siswa atau tamu.'
        ]);

        try {
            DB::transaction(function () use ($request) {
                foreach ($request->items as $itemData) {
                    $item = Item::lockForUpdate()->find($itemData['item_id']);

                    $available = $item->total - ($item->repair + $item->lending);

                    if ($itemData['total'] > $available) {
                        throw new \Exception("Stok item '{$item->name}' tidak mencukupi! (Tersedia: {$available})");
                    }

                    Lending::create([
                        'name' => $request->name,
                        'borrower_role' => $request->borrower_role,
                        'class' => $request->class,
                        'item_id' => $itemData['item_id'],
                        'total' => $itemData['total'],
                        'date' => now(),
                        'due_date' => $request->due_date,
                        'notes' => $request->notes,
                        'user_id' => Auth::id(),
                        'staff_signature' => $request->staff_signature,
                        'borrower_signature' => $request->borrower_signature,
                    ]);

                    $item->increment('lending', $itemData['total']);
                }
            });

            return redirect()->route('lendings.index')->with('success', 'Peminjaman berhasil dicatat!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function returnItem(Request $request, $id)
    {
        $request->validate([
            'repair_count' => 'required|integer|min:0'
        ]);

        try {
            DB::transaction(function () use ($request, $id) {
                $lending = Lending::findOrFail($id);
                $item = Item::lockForUpdate()->find($lending->item_id);

                if ($lending->returned_at) {
                    throw new \Exception("Barang ini sudah dikembalikan sebelumnya.");
                }

                $lending->update([
                    'returned_at' => now()
                ]);

                $item->decrement('lending', $lending->total);

                if ($request->repair_count > 0) {
                    $actualRepair = min($request->repair_count, $lending->total);
                    $item->increment('repair', $actualRepair);
                }
            });

            return redirect()->route('lendings.index')->with('success', 'Barang berhasil dikembalikan dan stok diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memproses pengembalian: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $lending = Lending::findOrFail($id);

                // Jika data dihapus tapi barang belum balik, kembalikan stok item dulu
                if (!$lending->returned_at) {
                    $item = Item::lockForUpdate()->find($lending->item_id);
                    if ($item) {
                        $item->decrement('lending', $lending->total);
                    }
                }

                $lending->delete();
            });

            return redirect()->back()->with('success', 'Data peminjaman berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }
    public function export(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        return Excel::download(new LendingExport($startDate, $endDate), 'lending_report.xlsx');
    }
}
