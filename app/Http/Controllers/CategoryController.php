<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Mengambil categories sekaligus hitung jumlah itemsnya
        $categories = Category::withCount('items')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'division_pj' => 'required'
        ]);

        Category::create($request->all());
        return redirect('/categories')->with('success', 'Kategori berhasil ditambah!');
    }

    // Menampilkan form edit dengan data lama
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    // Memproses perubahan data
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'division_pj' => 'required'
        ]);

        $category = Category::findOrFail($id);
        $category->update($request->all());

        return redirect('/categories')->with('success', 'Kategori berhasil diubah!');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        
        // Cek apakah kategori masih memiliki barang
        if ($category->items()->count() > 0) {
            return redirect('/categories')->with('error', 'Kategori tidak bisa dihapus karena masih memiliki barang!');
        }

        $category->delete();

        return redirect('/categories')->with('success', 'Kategori berhasil dihapus!');
    }
}