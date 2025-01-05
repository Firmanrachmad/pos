<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function customer(){
        return view('customers');
    }
    
    public function category(){
        return view('categories');
    }

    public function product(){
        return view('products');
    }

    public function pos(){
        return view('pos');
    }

    public function transaction(){
        return view('transactions');
    }
}
