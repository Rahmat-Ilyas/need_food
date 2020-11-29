<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class landingpagecontroller extends Controller
{
    public function index(){
        return view('page.index');
    }

    public function orderindex(){
        return view('page.order.index');
    }

    public function keranjang_index(){
        return view('page.keranjang.index');
    }

    public function detail_alat(){
        return view('page.keranjang.alat');
    }

    public function pengantaran(){
        return view('page.pengantaran.index');
    }
}
