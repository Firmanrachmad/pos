<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index() {
        $product = Product::with('category')->get();
        $category = Category::all();
        return view('products', compact('product', 'category'));
    }

    public function store(Request $request) {
        
        $request->validate([
            'category_id' => 'required|max:255',
            'name' => 'required|max:255',
            'price' => 'required|max:255',
            'desc' => 'required|max:255',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $path = $request->file('foto')->store('public/images');

            
            $product = new Product;
            $product->category_id = $request->category_id;
            $product->name = $request->name;
            $product->price = $request->price;
            $product->desc = $request->desc;
            $product->foto = Storage::url($path);

            $product->save();

            // Berhasil menyimpan, kirim respon JSON
            return response()->json(['success' => true, 'msg' => 'Product added successfully']);
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
            $product = Product::find($id);
            $product->name = $request->name;
            $product->save();
    
            // Berhasil diperbarui, kirim respon JSON
            return response()->json(['success' => true, 'msg' => 'Category updated successfully']);
        } catch (\Exception $e) {
            // Gagal diperbarui, kirim respon JSON dengan pesan kesalahan
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    public function destroy($id) {
        try {
            $product = Product::find($id);
            if ($product) {
                $product->delete();
                return response()->json(['success' => true, 'msg' => 'Product deleted successfully']);
            } else {
                return response()->json(['success' => false, 'msg' => 'Product not found']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }
}
