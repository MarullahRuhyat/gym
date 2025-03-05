<?php

namespace App\Jobs;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessNotifMemberExpired implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        // 
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $tanggal_berakhir = Carbon::today()->addDays(4)->format('Y-m-d');
        // Mendapatkan tanggal 1 tahun yang lalu dari hari ini, kemudian menambah 4 hari
        $targetDate = Carbon::today()->subYear()->addDays(4);

        // Mendapatkan data dengan end_date lebih dari 4 hari dari hari ini
        $users = DB::table('users')
            ->select('name', 'phone_number', 'end_date')
            ->where('end_date', '=',  $targetDate)
            ->where('role', 'member')
            ->get();
        $client = new Client();
        foreach ($users as $user) {
            // Buat pesan yang dipersonalisasi
            Log::info('process_notif_member_expired queue', [$user->name]);

            $message = "Hallo {$user->name}, selamat siang\n\n";
            $message .= "Saat ini masa aktif akun Anda tinggal 4 hari lagi berakhir pada tanggal {$tanggal_berakhir}. ";
            $message .= "Segera aktifkan member Anda untuk dapat menikmati fasilitas gym kami.";

            // Hit API endpoint untuk mengirim pesan
            $response = $client->request('GET', 'https://jogja.wablas.com/api/send-message', [
                'query' => [
                    'phone' => $user->phone_number,
                    'message' => $message,
                    'token' => 'zX8x2FOfZW203UptysmQsDccJHyQofZyrN6JWRSZc55qK6uBf6S7ZSdLkMq07YFN.afcch63i',
                ],
            ]);
        }
    }
}
