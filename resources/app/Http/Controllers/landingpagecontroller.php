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
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://kesiniku-default-rtdb.firebaseio.com/device_token.json',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
      ));

        $response = curl_exec($curl);

        curl_close($curl);

        $firebaseToken = ['erDQ-F-fIxbhfeiJsg0nG7:APA91bEeqYIIArAOEOmafZHAtY-nVREmdCo1z_Z4lZFZm27andxWb3w5HwCR330sm4HlJzYIlAwczybfiqhitlN6oj-toSS5YMDaKXfbi0aBsBxgPqUjTPoOquFcMaR70DYaqvfOcsx3', 'fMY_P90ACnc:APA91bHC5xhaStEwX9v8nD29pNVLykbtqGGkl_Bt5VgnyKaGtNRacOkLjwdDalBZzPmLZ08xomjdZANaxF78fiWupua6WKEGY99fl8PLhSGEo0oiTPO6WsHSCRuaSKm15nWZ7Qd4KXBb'];

        $SERVER_API_KEY = 'AAAA0eQ6FxQ:APA91bH4GjxST2iA14lp29LpvtJafU9C_IDfvX7tmPQ5YmyoOsbZmDxtm9M2XJsJfpVANtUFUNdqx8y-_VMLsvv5BfUrapkNjL2LjnrPF8XnpPCNTQxFVdR3ZJH2pda71tzSLEZPeQLm';

        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => "Tes Notif Dong",
                "body" => "Hey, Selamat Natal",  
            ],
            "webpush" => [
                "headers" => [
                    "Urgency" => "high"
                ]
            ],
            "android" => [
                "priority" => "high"
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
