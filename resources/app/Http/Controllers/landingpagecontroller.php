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
        $firebaseToken = ['c2Odh6uQiFjeAQjLE4TsjP:APA91bEYwkx1hBXu3ouImfu8G8s-4QWmxpsw3cUa5V7FFaihil_d9j5AyjpZo9wfg704lZ7OyGbwzYo1sav0ga3eWBbNIv6BD7Dl2eExp63L8q7MDI3wLz951Wc2rGOA5olUZdLajvD-'];

        $SERVER_API_KEY = 'AAAA0eQ6FxQ:APA91bH4GjxST2iA14lp29LpvtJafU9C_IDfvX7tmPQ5YmyoOsbZmDxtm9M2XJsJfpVANtUFUNdqx8y-_VMLsvv5BfUrapkNjL2LjnrPF8XnpPCNTQxFVdR3ZJH2pda71tzSLEZPeQLm';

        $data = [
            "registration_ids" => $firebaseToken,
            "collapse_key" => "campaign_collapse_key_1906931572571814209",
            "notification" => [
                "title" => "Tes Notif Dong",
                "body" => "Hey Cika",  
            ],
            "priority" => "high"
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
