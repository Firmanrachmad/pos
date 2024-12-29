<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index() {
        $category = Category::orderBy('name', 'asc')->get();
        return response()->json([
            'status' => 'success',
            'data' => $category
        ]);
    }

    public function store(Request $request) {

        $request->validate([
            'name' => 'required|max:255',
        ]);

        try {
            
            $category = Category::create($request->all());
            return response()->json([
                'message' => 'Category added successfully', 
                'data' => $category
            ]);

        } catch (\Exception $e) {
            
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ]);

        }
    }

    public function update(Request $request, $id) {
        
        $request->validate([
            'name' => 'required|max:255',
        ]);
    
        try {

            $category = Category::find($id);

            if(!$category){
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Category not found'
                ]);
            }

            $category->update($request->all());
    
            return response()->json([
                'status' => 'success', 
                'message' => 'Category updated successfully',
                'data' => $category
            ]);

        } catch (\Exception $e) {
            
            return response()->json([
                'status' => 'failed', 
                'message' => $e->getMessage()]);

        }
    }

    public function destroy($id) {
        try {

            $category = Category::find($id);

            if(!$category){
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Category not found'
                ]);
            }

            $category->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Category deleted'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed', 
                'message' => $e->getMessage()]);
        }
    }
}
