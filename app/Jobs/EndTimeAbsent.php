<?php

namespace App\Jobs;

use App\Models\AbsentMember;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class EndTimeAbsent implements ShouldQueue
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
        $time = Carbon::now()->format('H:i:s');

        // Memeriksa apakah waktu saat ini adalah 23:59:59
        if ($time == '23:59:59') {
            // Mengupdate semua member yang start_date atau end_date kosong
            AbsentMember::whereNull('start_date')
                ->orWhereNull('end_date')
                ->update([
                    'start_date' => Carbon::now()->format('H:i:s'), // Mengisi dengan format waktu saja
                    'end_date' => Carbon::now()->format('H:i:s')    // Mengisi dengan format waktu saja
                ]);
        }
    }
}
