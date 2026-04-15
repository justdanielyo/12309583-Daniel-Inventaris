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
    public function index()
    {
        $lendings = Lending::with(['item', 'user'])->latest()->get();
        return view('staff.lendings.index', compact('lendings'));
    }

    public function create()
    {
        $items = Item::all()->filter(function ($item) {
            return ($item->total - ($item->repair + $item->lending)) > 0;
        });

        return view('staff.lendings.create', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'items' => 'required|array',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.total' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        try {
            DB::transaction(function () use ($request) {
                foreach ($request->items as $itemData) {
                    $item = Item::lockForUpdate()->find($itemData['item_id']);

                    // Hitung Avalaible
                    $available = $item->total - ($item->repair + $item->lending);

                    if ($itemData['total'] > $available) {
                        throw new \Exception("Total item more than available!");
                    }

                    Lending::create([
                        'name' => $request->name,
                        'item_id' => $itemData['item_id'],
                        'total' => $itemData['total'],
                        'notes' => $request->notes,
                        'date' => now(),
                        'user_id' => Auth::id(),
                    ]);

                    // Tambah jumlah lending pada item
                    $item->increment('lending', $itemData['total']);
                }
            });

            return redirect()->route('lendings.index')->with('success', 'Peminjaman berhasil dicatat!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function returnItem($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $lending = Lending::findOrFail($id);

                if ($lending->returned_at) {
                    throw new \Exception('Item is already returned!');
                }

                // Kurangi angka lending pada item (Available otomatis naik)
                $item = Item::lockForUpdate()->find($lending->item_id);
                $item->decrement('lending', $lending->total);

                $lending->update(['returned_at' => now()]);
            });

            return redirect()->back()->with('success', 'Item is returned!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $lending = Lending::findOrFail($id);

                // Jika dihapus tapi BELUM dikembalikan, dikembalikan stoknya
                if (!$lending->returned_at) {
                    $item = Item::lockForUpdate()->find($lending->item_id);
                    if ($item) {
                        $item->decrement('lending', $lending->total);
                    }
                }

                $lending->delete();
            });

            return redirect()->back()->with('success', 'Data peminjaman dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    public function export()
    {
        return Excel::download(new LendingExport, 'lendings.xlsx');
    }
}