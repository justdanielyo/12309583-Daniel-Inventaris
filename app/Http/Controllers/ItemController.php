<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Category;
use App\Exports\ItemsExport;
use Maatwebsite\Excel\Facades\Excel;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with('category')->get();

        // Kirim ke view staff/operator jika rolenya bukan admin
        if (Auth::user()->role == 'staff') {
            return view('staff.items', compact('items'));
        }

        return view('admin.items.index', compact('items'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'total' => 'required|numeric',
        ]);

        Item::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'total' => $request->total,
            'repair' => 0,
            'lending' => 0,
        ]);

        return redirect('/items')->with('success', 'Item berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $item = Item::findOrFail($id);
        $categories = Category::all();
        return view('admin.items.edit', compact('item', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'total' => 'required|numeric',
            'new_repair' => 'nullable|numeric|min:0'
        ]);

        $item = Item::findOrFail($id);
        $item->name = $request->name;
        $item->category_id = $request->category_id;
        $item->total = $request->total;

        if ($request->new_repair > 0) {
            $item->repair = $item->repair + $request->new_repair;
        }

        $item->save();
        return redirect('/items')->with('success', 'Item berhasil diperbarui!');
    }

    public function export()
    {
        return Excel::download(new ItemsExport, 'items.xlsx');
    }

    public function lendingDetail($id)
    {
        $item = Item::with(['lendings.user'])->findOrFail($id);
        return view('admin.items.lending_detail', compact('item'));
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        
        // Opsional: Cek jika item sedang dipinjam
        if ($item->lending > 0) {
            return redirect('/items')->with('error', 'Item tidak bisa dihapus karena sedang dipinjam!');
        }

        $item->delete();
        return redirect('/items')->with('success', 'Item berhasil dihapus!');
    }
}