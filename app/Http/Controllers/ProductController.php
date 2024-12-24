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
            'description' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {

            $path = $request->file('image')->store('public/images');

            $product = Product::create([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'price' => $request->price,
                'description' => $request->description,
                'image' => Storage::url($path),
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
        // dd($request->all());
        // return response()->json([
        //     'all_data' => $request->all(),
        //     'file_data' => $request->file('image'),
        // ]);
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
    
        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $path = $image->store('public/images');

            Storage::delete('public/images/' . basename($product->image));

            $product->update([
                'image'           => Storage::url($path),
                'category_id'     => $request->category_id,
                'name'            => $request->name,
                'price'           => $request->price,
                'description'     => $request->description,
            ]);

        } else {

            $product->update([
                'category_id'     => $request->category_id,
                'name'   => $request->name,
                'price'   => $request->price,
                'description'   => $request->description,
            ]);

        }
    
        return response()->json([
            'status' => 'success',
            'data' => $product
        ]);
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
