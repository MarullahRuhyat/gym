<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class ProcessNotifMemberActive implements ShouldQueue
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
        // Mendapatkan tanggal hari ini
        $today = Carbon::today();

        // Mendapatkan data dengan end_date lebih dari 4 hari dari hari ini
        $users = DB::table('users')
            ->select('name', 'phone_number', 'end_date')
            ->where('end_date', '=', $today->addDays(4))
            ->where('role', 'member')
            ->get();

        $client = new Client();
        foreach ($users as $user) {
            // Buat pesan yang dipersonalisasi
            Log::info('process_notif_member_inactive queue', [$user->name]);

            $message = "Hallo {$user->name}, selamat siang\n\n";
            $message .= "Saat ini masa aktif member Anda tinggal 4 hari lagi berakhir pada tanggal {$user->end_date}. ";
            $message .= "Segera perpanjang member Anda untuk dapat menikmati fasilitas gym kami.";

            // Hit API endpoint untuk mengirim pesan
            $response = $client->request('GET', 'https://jogja.wablas.com/api/send-message', [
                'query' => [
                    'phone' => $user->phone_number,
                    'message' => $message,
                    'token' => 'SujEXjKi5MEvVWebuRK17sG4H69mKzZwFD4Uca7HPrPwNiQawGLJ4ShA5uCCaUtv',
                ],
            ]);
        }
    }
}
