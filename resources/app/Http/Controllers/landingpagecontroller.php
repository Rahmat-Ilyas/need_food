<?php

namespace App\Http\Controllers;

use App\Model\DataRekening;
use App\Model\PaketPesanan;
use App\Model\AdtPesanan;
use App\Model\Pemesanan;
use App\Model\Additional;
use App\Model\Transaksi;
use App\Model\Paket;

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
        $paket = json_decode($request['tampung'], true);
        $request->session()->put('paket', $paket);
    }

    public function paket_delivery(Request $request){
        $request->session()->forget('paket');
        $data = json_decode($request['data'], true); 
        $request->session()->put('paket_to_delivery', $data);
    }

    public function paket_get(Request $request){
        if ($request->session()->has('paket')) {
            return $request->session()->get('paket','nama');
        }else{
            return 'Tidak ada session';
        }
    }

    public function paket_get_delivery(Request $request){
        if ($request->session()->has('paket_to_delivery')) {
            return $request->session()->get('paket_to_delivery','nama');
        }else{
            return 'Tidak ada session';
        }
    }

    public function detail_alat(){
        return view('page.keranjang.alat');
    }

    public function pengantaran(Request $request){
        if ($request->session()->has('paket_to_delivery')) {
            return view('page.pengantaran.index');   
        }else{
            return 'None';
        }
    }

    public function gettoken($id) {
        $data = Pemesanan::where('id', $id)->first();
        if ($data) {
            $crypt = '17'.$id.'-'.$data->no_wa.'_'.$data->kd_pemesanan;
            $token = crypt($id+14, $crypt);
            $token = str_replace('/', 'R', $token);
            $token = str_replace('?', 'M', $token);
            $token = str_replace('=', 'T', $token);

            dd($token);
        } else {
            echo "id not found";
        }
    }

    public function konfirmasi($token) {
        $pemesanan_id = null;
        $data = Pemesanan::all();
        foreach ($data as $dta) {
            $hash = '17'.$dta->id.'-'.$dta->no_wa.'_'.$dta->kd_pemesanan;
            $this_token = hash('crc32', $hash);
            if ($token == $this_token) {
                $pemesanan_id = $dta->id;
            }
        }

        $pesanan = Pemesanan::where('id', $pemesanan_id)->first();
        if ($pesanan && $pesanan->status == 'New') {
            return view('konfirmasi', compact('pesanan'));
        } else {
            abort('403');
        }
    }

    public function pesananselesai($token) {
        $pemesanan_id = null;
        $data = Pemesanan::all();
        foreach ($data as $dta) {
            $hash = '17'.$dta->id.'-'.$dta->no_wa.'_'.$dta->kd_pemesanan;
            $this_token = hash('crc32', $hash);
            if ($token == $this_token) {
                $pemesanan_id = $dta->id;
            }
        }

        $pesanan = Pemesanan::where('id', $pemesanan_id)->first();
        if ($pesanan && $pesanan->status == 'Arrived') {
            return view('pesananselesai', compact('pesanan'));
        } else {
            abort('403');
        }
    }
}
