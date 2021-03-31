<?php

namespace App\Console;

use App\Model\Pemesanan;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $pesanan = Pemesanan::where('status', 'New')->get();
            foreach ($pesanan as $dta) {
                $this_day = strtotime(date('Y-m-d H:i:s'));
                $day_plus1 = strtotime($dta->created_at)+(86400*1);
                $day_plus2 = strtotime($dta->created_at)+(86400*2);

                if ($dta->metode_bayar == 'transfer') {
                    if (date('dmY H:i', $this_day) == date('dmY H:i', $day_plus1)) {
                        $this->sendMessageWhatsApp($dta->id);
                    } else if (date('dmY H:i', $this_day) == date('dmY H:i', $day_plus2)) {
                        $this->sendMessageWhatsApp($dta->id);
                    }
                }

                if ($this_day > strtotime($dta->created_at)+(86400*3)) {
                    $update = Pemesanan::where('id', $dta->id)->first();
                    $update->status = 'Cancel';
                    $update->save();
                }
            }
        })->everyMinute();
    }

    // SEND MESSAGE WHATSAPP
    protected function sendMessageWhatsApp($id) 
    {
        $pesanan = Pemesanan::where('id', $id)->first();

        $no_whatsapp = $pesanan->no_wa;
        $key = '553709ba9cca8ff2d35acbbd3f4e7e07c77267da14eefb11';
        $message = 'Hai, Kak *'.$pesanan->nama.'*\nAnda belum mengkonfirmasi pembayan, silahkan di konfirmasi segera sebelum pesanan anda dibatalkan!';

        $url = 'http://116.203.191.58/api/send_message';
        $data = array(
            "phone_no"=> $no_whatsapp,
            "key"     => $key,
            "message" => $message
        );

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
        $res=curl_exec($ch);
        curl_close($ch);
    } 

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
