<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index() {
        $product = Product::with('category')->get();
        return response()->json([
            'status' => 'success',
            'data' => $product
        ]);
    }

    public function store(Request $request) {

        $request->validate([
            'category_id' => 'required|integer',
            'name' => 'required|string|max:255',
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
                'data' => $product
            ]);

        } catch(\Exception $e){

            return response()->json([
                'status' => 'failed', 
                'message' => $e->getMessage()
            ]);

        }
        
    }

    public function update(Request $request, $id) {
        
         
         $validator = Validator::make($request->all(), [
            'category_id' => 'nullable|integer',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'desc' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $product = Product::find($id);

        if ($request->hasFile('foto')) {

            $image = $request->file('foto');
            $image->storeAs('public/images', $image->hashName());

            Storage::delete('public/images/' . basename($product->foto));

            $product->update([
                'foto'     => $image->hashName(),
                'category_id' => $request->category_id,
                'name'   => $request->name,
                'price'   => $request->price,
                'desc'   => $request->desc,
            ]);

            return response()->json([
                'status' => 'success',
                'data' => $product
            ]);

        } else {

            $product->update([
                'category_id' => $request->category_id,
                'name'   => $request->name,
                'price'   => $request->price,
                'desc'   => $request->desc,
            ]);

            return response()->json([
                'status' => 'success',
                'data' => $product
            ]);
        }
    }

    public function destroy($id) {
        try {
            $product = Product::find($id);

            if(!$product){

                return response()->json([
                    'status' => 'failed',
                    'message' => 'Product not found'
                ]);
            }

            $product->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Product deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed', 
                'message' => $e->getMessage()
            ]);
        }
    }
}
