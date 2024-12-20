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
        return response()->json([
            'status' => 'successs',
            'data' => $product
        ]);
    }

    public function store(Request $request) {
        
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'desc' => 'required|max:255',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $path = $request->file('foto')->store('public/images');

            $product = Product::create([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'price' => $request->price,
                'desc' => $request->desc,
                'foto' => Storage::url($path),
            ]);

            return response()->json([
                'status' => 'success', 
                'message' => 'Product added successfully',
                'data' => $product
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed', 
                'message' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id) {
        
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'desc' => 'required|max:255',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

    
        try {
            
            $product = Product::find($id);

            if(!$product){
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Product not found'
                ]);
            }


            if($request->foto){
                $path = $request->file('foto')->store('public/images');
                $product->update($request->all());
            }

            $product->update($request->all());
    
            return response()->json([
                'status' => 'success', 
                'message' => 'Product updated successfully',
                'data' => $product
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed', 
                'message' => $e->getMessage()]);
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
