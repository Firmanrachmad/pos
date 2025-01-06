<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(){
        $customers = Customer::orderBy('name', 'asc')->get();;
        return response()->json([
            'status' => 'success',
            'data' => $customers
        ], 200);
    }

    public function store(Request $request){

        try {
            
            $customer = Customer::create($request->all());

            return response()->json([
                'status' => 'success',
                'data' => $customer
            ], 201);

        } catch (\Exception $e) {
            
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ]);

        }
        
    }

    public function update(Request $request, $id){

        try {

            $customer = Customer::find($id);

            if(!$customer){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Customer not found'
                ], 404);
            }
            
            $customer->update($request->all());

            return response()->json([
                'status' => 'success',
                'data' => $customer
            ], 200);

        } catch (\Exception $e) {
            
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function destroy($id){

        try {

            $customer = Customer::find($id);

            if(!$customer){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Customer not found'
                ], 404);
            }

            $customer->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Customer deleted'
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ]);

        }
    }
}
