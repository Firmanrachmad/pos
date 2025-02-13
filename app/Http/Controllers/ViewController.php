<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function customer(){
        return view('pages.customers');
    }
    
    public function category(){
        return view('pages.categories');
    }

    public function product(){
        return view('pages.products');
    }

    public function pos(){
        return view('pages.pos');
    }

    public function transaction(){
        return view('pages.transactions');
    }

    public function payment(){
        return view('pages.payments');
    }

    public function reporting(){
        return view('pages.reports');
    }
}
