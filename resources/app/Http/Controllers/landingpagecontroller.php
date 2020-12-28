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

    public function trynotif() {
        $this->notification('New', 2);
    }

    protected function notification($status, $pesanan_id) {
        if ($status == 'New') {
            $to = 'admin_device';
            $title = 'Pesanan Baru';
            $body = 'Pesanan baru masuk, mohon diperiksa';
        } else if ($status == 'Accept') {
            $to = 'admin_device';
            $title = 'Bukti Pembayaran';
            $body = 'Pelanggan telah mengirimkan bukti pembayaran';
        } else if ($status == 'Proccess') {
            $to = 'kitchen_device';
            $title = 'Pesanan Baru';
            $body = 'Terdapat pesanan baru yang harus di proses';
        } else if ($status == 'Delivery') {
            $to = 'driver_device';
            $title = 'Pesanan Siap Diantar';
            $body = 'Terdapat pesanan yang harus di antar';
        } else if ($status == 'Arrived') {
            $to = 'admin_device';
            $title = 'Pesanan Sampai';
            $body = 'Pesanan telah sampai di tujuan';
        } else if ($status == 'Taking') {
            $to = 'driver_device';
            $title = 'Pesanan Selseai';
            $body = 'Pesanan telah selesai dan siap di jemput kembali';
        } else if ($status == 'Done') {
            $to = 'admin_device';
            $title = 'Pesanan Selesai';
            $body = 'Satu pesanan telah selesai';
        } else {
            return;
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://kesiniku-default-rtdb.firebaseio.com/device_token/'.$to.'.json',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ['Content-Type:application/json'],
            CURLOPT_ENCODING => 'json',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = json_decode(curl_exec($curl), true);
        $firebaseToken = [];
        foreach ($response as $key => $value) {
            if (isset($value['token'])) {
                $firebaseToken[] = $value['token'];
            }
        }

        curl_close($curl);

        $SERVER_API_KEY = 'AAAA0eQ6FxQ:APA91bH4GjxST2iA14lp29LpvtJafU9C_IDfvX7tmPQ5YmyoOsbZmDxtm9M2XJsJfpVANtUFUNdqx8y-_VMLsvv5BfUrapkNjL2LjnrPF8XnpPCNTQxFVdR3ZJH2pda71tzSLEZPeQLm';

        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $title,
                "body" => $body,  
            ],
            "webpush" => [
                "headers" => [
                    "Urgency" => "high"
                ]
            ],
            "android" => [
                "priority" => "high"
            ],
            "data" => [
                "needfood.technest.com.KEY_SYNC_REQUEST" => "sync",
                'pesanan_id' => $pesanan_id
            ],
            "priority" => 10
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

        dd($response);
    }
}
