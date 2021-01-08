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
            $crypt = '17'.$dta->id.'-'.$dta->no_wa.'_'.$dta->kd_pemesanan;
            $this_token = crypt($dta->id+14, $crypt);
            $this_token = str_replace('/', 'R', $this_token);
            $this_token = str_replace('?', 'M', $this_token);
            $this_token = str_replace('=', 'T', $this_token);
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
            $crypt = '17'.$dta->id.'-'.$dta->no_wa.'_'.$dta->kd_pemesanan;
            $this_token = crypt($dta->id+14, $crypt);
            $this_token = str_replace('/', 'R', $this_token);
            $this_token = str_replace('?', 'M', $this_token);
            $this_token = str_replace('=', 'T', $this_token);
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

    public function trynotif() {
        $this->notification('New', 2);
    }

    public function tryapiwa() {
        $this->sendMessageWhatsApp('order_detail', 2);
    }


    protected function sendMessageWhatsApp($tipe, $id) 
    {
        $rek = DataRekening::first();
        $pemesanan = Pemesanan::where('id', $id)->first();
        $psn = $this->getDataPesanan($pemesanan, $id);
        
        $no_whatsapp = $psn->no_wa;
        $wa_admin = $rek->telepon;
        $key = '553709ba9cca8ff2d35acbbd3f4e7e07c77267da14eefb11';

        // Generet Token 
        $crypt = '17'.$id.'-'.$psn->no_wa.'_'.$psn->kd_pemesanan;
        $token = crypt($id+14, $crypt);
        $token = str_replace('/', 'R', $token);
        $token = str_replace('?', 'M', $token);
        $token = str_replace('=', 'T', $token);

        if ($tipe == 'order_detail') {
            $paket = '';
            $additional = '';
            foreach ($psn->paket as $pkt) {
                $paket .= '*'.$pkt['nama_paket'].' '.$pkt['jumlah'].' Pax\n';
            }

            foreach ($psn->additional as $adt) {
                $additional .= '*'.$adt['nama_daging'].' '.$adt['berat'].'\n';
            }

            $message = 'Selamat datang di Kesiniku Kak *'.$psn->nama.'*\n🙏🙏😊\nKami sudah terima pesanan anda dengan rincian sebagai berikut: \n\nPaket Pesanan:\n'.$paket.'\nAdditional Daging:\n'.$additional.'\nHarga Paket: Rp. '.number_format($psn->transaksi->harga_paket).'\nHarga Additional: Rp. '.number_format($psn->transaksi->harga_additional).'\nOngkir: Rp. '.number_format($psn->transaksi->biaya_pengiriman).'\nTotal: Rp. '.number_format($psn->transaksi->total_harga).'\n\nDikirim ke: '.$psn->deskripsi_lokasi.'\n\nSilahkan transfer ke rekening dibawah ini:\n'.$rek->nama_bank.'\nNo. Rek: '.$rek->no_rekening.'\nAtas Nama: '.$rek->nama.'\n\nUpload bukti pembayaran di link berikut:\nhttps://kesiniku.com/konfirmasi/'.$token.'\n\n_*Jika link tidak aktif, balas pesan ini untuk mengaktifkan link dan buka kembali_';

            $url = 'http://116.203.191.58/api/send_message';
            $data = array(
                "phone_no"=> $no_whatsapp,
                "key"     => $key,
                "message" => $message
            );
        } else if ($tipe == 'order_accept') {
            $message = 'Hai, Kak *'.$psn->nama.'*\nTerima kasih telah menyelesaikan pembayaran. Pesanan anda telah di konfirmasi, kami akan segara memproses pesanan anda!';

            $url = 'http://116.203.191.58/api/send_message';
            $data = array(
                "phone_no"=> $no_whatsapp,
                "key"     => $key,
                "message" => $message
            );
        } else if ($tipe == 'order_refuse') {
            $message = 'Hai, Kak *'.$psn->nama.'*\nMohon maaf, pesanan anda tidak dapat kami proses, silahkan kunjungi https://kesiniku.com untuk pemesanan ulang!';

            $url = 'http://116.203.191.58/api/send_message';
            $data = array(
                "phone_no"=> $no_whatsapp,
                "key"     => $key,
                "message" => $message
            );
        } else if ($tipe == 'order_done') {
            $message = 'Hai, Kak *'.$psn->nama.'*\nPesanan anda telah siap diantar, driver kami telah menuju ke lokasi yang anda daftarkan. Mohon untuk menunggu 🙏🙏\n\nSilahkan menikmati pesanan anda, semoga layanan kami memuaskan😊😊\n\nMohon untuk mengklik link berikut apabila telah selesa:\nhttps://kesiniku.com/done/'.$token;

            $url = 'http://116.203.191.58/api/send_image_url';
            $img_url = 'https://kesiniku.com/assets/images/pesanan/'.$psn->foto_pesanan;
            $data = array(
                "phone_no" => $no_whatsapp,
                "key"      => $key,
                "url"      => $img_url,
                "message"  => $message
            );
        } else if ($tipe == 'upload_payment') {
            $message = 'Bukti pembayaran telah di uplaod\n\nKode Pesanan: '.$psn->kd_pemesanan.'\nNama: '.$psn->nama.'\nTotal: Rp. '.number_format($psn->transaksi->total_harga).'\n\nSilahkan buka aplikasi mobile Kesiniku atau Website Admin Panel Kesiniku untuk mengkonfirmasi pesanan.';

            $url = 'http://116.203.191.58/api/send_image_url';
            $img_url = 'https://kesiniku.com/assets/images/konfirmasi/'.$psn->bukti_pembayaran;
            $data = array(
                "phone_no" => $wa_admin,
                "key"      => $key,
                "url"      => $img_url,
                "message"  => $message
            );
        }

        $data_string = json_encode($data);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 360);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string)
        ]);
        echo $res=curl_exec($ch);
        curl_close($ch);
    }
    
    protected function getDataPesanan($pemesanan, $id = null)
    {
        if ($pemesanan) {
            // Data Paket Pesanan
            $getPaket = PaketPesanan::where('pemesanan_id', $id)->get();
            foreach ($getPaket as $i => $pkt) {
                $getPkt = Paket::where('id', $pkt->paket_id)->first();
                $paket[$i]['pemesanan_id'] = $pkt->pemesanan_id;
                $paket[$i]['paket_id'] = $pkt->paket_id;
                $paket[$i]['nama_paket'] = $getPkt ? $getPkt->nama : null;
                $paket[$i]['harga'] = $getPkt ? $getPkt->harga : null;
                $paket[$i]['jumlah'] = $pkt->jumlah;
                $paket[$i]['total_harga'] = $pkt->total_harga;
            }

            // Data Additional Pesanan
            $getAdditional = AdtPesanan::where('pemesanan_id', $id)->get();
            $additional = [];
            if ($getAdditional) {
                foreach ($getAdditional as $i => $adt) {
                    $getAdt = Additional::where('id', $adt->additional_id)->first();
                    $additional[$i]['pemesanan_id'] = $adt->pemesanan_id;
                    $additional[$i]['additional_id'] = $adt->additional_id;
                    $additional[$i]['nama_daging'] = $getAdt->nama_daging;
                    $additional[$i]['harga'] = $getAdt->harga;
                    $additional[$i]['berat'] = $getAdt->berat;
                    $additional[$i]['jumlah'] = $adt->jumlah;
                    $additional[$i]['total_harga'] = $adt->total_harga;
                }
            }

            // Data Transaksi Pesanan
            $transaksi = Transaksi::where('pemesanan_id', $id)->first();
            unset($transaksi['created_at']);
            unset($transaksi['updated_at']);

            $pemesanan['paket'] = $paket;
            $pemesanan['additional'] = $additional;
            $pemesanan['transaksi'] = $transaksi;
        }
        return $pemesanan;
    }

    protected function notification($status, $pesanan_id) 
    {
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
