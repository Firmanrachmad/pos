<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index() {
        $category = Category::all();
        return view('categories', compact('category'));
    }

    public function store(Request $request) {
        // Validasi input
        $request->validate([
            'name' => 'required|max:255',
        ]);

        try {
            // Simpan data ke database
            $category = new Category;
            $category->name = $request->name;
            $category->save();

            // Berhasil menyimpan, kirim respon JSON
            return response()->json(['success' => true, 'msg' => 'Category added successfully']);
        } catch (\Exception $e) {
            // Gagal menyimpan, kirim respon JSON dengan pesan kesalahan
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id) {
        // Validasi input
        $request->validate([
            'name' => 'required|max:255',
        ]);
    
        try {
            // Perbarui data di database
            $category = Category::find($id);
            $category->name = $request->name;
            $category->save();
    
            // Berhasil diperbarui, kirim respon JSON
            return response()->json(['success' => true, 'msg' => 'Category updated successfully']);
        } catch (\Exception $e) {
            // Gagal diperbarui, kirim respon JSON dengan pesan kesalahan
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }
}
