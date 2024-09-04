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

        $end_date_membership = DB::table('memberships')
            ->select('memberships.user_id', 'users.name as user_name', 'users.phone_number', 'memberships.end_date as end_date')
            ->join('users', 'memberships.user_id', '=', 'users.id')
            ->where('memberships.end_date', '=', $today->addDays(4))
            ->where('memberships.is_active', 1)
            ->get();

        $client = new Client();
        // foreach ($users as $user) {
        foreach ($end_date_membership as $user) {
            // Buat pesan yang dipersonalisasi

            // $message = "Hallo {$user->name}, selamat siang\n\n";
            $message = "Hallo {$user->user_name}, selamat siang\n\n";
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
