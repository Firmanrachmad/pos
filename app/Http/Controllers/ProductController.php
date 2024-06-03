<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index() {
        $product = Product::with('category')->get();
        return view('products', compact('product'));
    }

    public function store(Request $request) {
        // Validasi input
        $request->validate([
            'category_id' => 'required|max:255',
            'name' => 'required|max:255',
            'price' => 'required|max:255',
            'desc' => 'required|max:255',
            'foto' => 'required|max:255',
        ]);

        try {
            // Simpan data ke database
            $product = new Product;
            $product->category_id = $request->category_id;
            $product->name = $request->name;
            $product->price = $request->price;
            $product->desc = $request->desc;
            $product->foto = $request->foto;

            $product->save();

            // Berhasil menyimpan, kirim respon JSON
            return response()->json(['success' => true, 'msg' => 'Product added successfully']);
        } catch (\Exception $e) {
            // Gagal menyimpan, kirim respon JSON dengan pesan kesalahan
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }
}
