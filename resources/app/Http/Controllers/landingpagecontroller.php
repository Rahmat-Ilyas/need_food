<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class landingpagecontroller extends Controller
{
    public function index(){
        return view('page.index');
    }

    public function orderindex(){
        return view('page.order.index');
    }

    public function keranjang_index(Request $request){ 
        if ($request->session()->has('paket')) {
            return view('page.keranjang.index');   
        }else{
            return 'None';
        }
        
    }

    public function paket_pesanan(Request $request){
        // $request->session()->forget('paket');
        $paket = json_decode($request['tampung'], true);
        $request->session()->put('paket', $paket);
    }

    public function paket_get(Request $request){
        if ($request->session()->has('paket')) {
            return $request->session()->get('paket','nama');
        }else{
            return 'Tidak ada session';
        }
    }

    public function detail_alat(){
        return view('page.keranjang.alat');
    }

    public function pengantaran(){
        return view('page.pengantaran.index');
    }

    public function getpaket(Request $request){
        $paket = $request['paket'];
        $qty = $request['qty'];

        dd($paket);
    }
}
